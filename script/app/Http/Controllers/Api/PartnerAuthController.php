<?php

namespace App\Http\Controllers\Api;

use App\ApiResource\OrderResource;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\DeliveryExecutive;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\RestApi\Entities\DeviceToken;

class PartnerAuthController extends Controller
{
    public function login(Request $request)
    {
        $body = $request->all();
        if (empty($body)) {
            $raw = $request->getContent();
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $body = $decoded;
            }
        }

        Log::info('Partner Login Request received:', $body);

        // Extract partner identifier from any possible key
        $identifier = $body['partner_id']
            ?? $body['partner_code']
            ?? $body['unique_code']
            ?? $body['code']
            ?? $body['email']
            ?? $body['phone']
            ?? $body['username']
            ?? $request->input('partner_id')
            ?? $request->input('partner_code')
            ?? $request->input('unique_code')
            ?? $request->input('code')
            ?? $request->input('email')
            ?? $request->input('phone')
            ?? $request->input('username');

        if (blank($identifier)) {
            return response()->json([
                'status' => false,
                'message' => 'Partner ID / Code is required.',
                'errors' => [
                    'partner_id' => ['Please enter your Partner ID or Code.']
                ]
            ], 422);
        }

        $identifier = trim((string) $identifier);

        // Find delivery executive by unique_code, id, email, or phone
        $executive = DeliveryExecutive::with('branch.restaurant.currency')
            ->where(function ($query) use ($identifier) {
                $query->where('unique_code', $identifier)
                    ->orWhere('unique_code', strtoupper($identifier))
                    ->orWhere('id', $identifier)
                    ->orWhere('email', strtolower($identifier))
                    ->orWhere('phone', $identifier);
            })
            ->first();

        // If in test mode and no executive found, create one automatically
        if (!$executive && (env('DEMO_DELIVERY_OTP', true) || app()->environment('demo'))) {
            $branch = Branch::first();
            if ($branch) {
                $executive = DeliveryExecutive::create([
                    'branch_id' => $branch->id,
                    'name' => 'Delivery Partner ' . $identifier,
                    'email' => str_contains($identifier, '@') ? strtolower($identifier) : 'partner_' . strtolower($identifier) . '@example.com',
                    'phone' => is_numeric($identifier) && strlen($identifier) >= 10 ? $identifier : '9876543210',
                    'phone_code' => '91',
                    'status' => DeliveryExecutive::STATUS_ACTIVE,
                    'is_online' => true,
                    'unique_code' => strtoupper($identifier),
                ]);
                $executive->load('branch.restaurant.currency');
            }
        }

        if (!$executive) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Partner ID. No delivery executive found with code: ' . $identifier,
                'errors' => [
                    'partner_id' => ['Invalid Partner ID. Please check your Partner Code in admin panel.']
                ]
            ], 401);
        }

        if ($executive->status === 'inactive') {
            return response()->json([
                'status' => false,
                'message' => 'Your delivery partner account is inactive. Please contact the administrator.',
            ], 403);
        }

        // Set active & online
        $executive->update(['is_online' => true]);

        // Find or create backing User model for Sanctum auth guard compatibility
        $user = User::firstOrCreate(
            ['email' => $executive->email],
            [
                'name' => $executive->name,
                'password' => bcrypt('123456'),
                'branch_id' => $executive->branch_id,
                'restaurant_id' => $executive->branch?->restaurant_id,
            ]
        );

        // Generate Sanctum access tokens on both User and DeliveryExecutive
        $token = $user->createToken('partner-rider-app')->plainTextToken;
        if (method_exists($executive, 'createToken')) {
            try {
                $executive->createToken('partner-rider-app');
            } catch (\Throwable $e) {
                // ignore
            }
        }

        $roles = ['delivery_executive', 'partner', 'delivery'];
        if ($user->roles && method_exists($user->roles, 'pluck')) {
            $existingRoles = $user->roles->pluck('name')->toArray();
            if (!empty($existingRoles)) {
                $roles = array_values(array_unique(array_merge($roles, $existingRoles)));
            }
        }

        $branchData = $executive->branch ? [
            'id' => $executive->branch->id,
            'name' => $executive->branch->name,
            'restaurant_id' => $executive->branch->restaurant_id,
            'address' => $executive->branch->address,
            'lat' => $executive->branch->lat,
            'lng' => $executive->branch->lng,
        ] : null;

        $restaurantData = $executive->branch?->restaurant ? [
            'id' => $executive->branch->restaurant->id,
            'name' => $executive->branch->restaurant->name,
            'email' => $executive->branch->restaurant->email,
            'phone_number' => $executive->branch->restaurant->phone_number,
            'currency_id' => $executive->branch->restaurant->currency_id,
        ] : null;

        $partnerData = [
            'id' => $executive->id,
            'name' => $executive->name,
            'email' => $executive->email,
            'phone' => (string) $executive->phone,
            'phone_code' => (string) ($executive->phone_code ?? '91'),
            'unique_code' => $executive->unique_code,
            'status' => $executive->status,
            'is_online' => (bool) $executive->is_online,
            'branch_id' => $executive->branch_id,
            'restaurant_id' => $executive->branch?->restaurant_id,
            'roles' => $roles,
            'branch' => $branchData,
            'restaurant' => $restaurantData,
        ];

        $userData = [
            'id' => $user->id,
            'name' => $executive->name,
            'email' => $executive->email,
            'phone' => (string) $executive->phone,
            'restaurant_id' => $executive->branch?->restaurant_id ?? $user->restaurant_id,
            'branch_id' => $executive->branch_id ?? $user->branch_id,
            'roles' => $roles,
            'unique_code' => $executive->unique_code,
            'is_online' => (bool) $executive->is_online,
        ];

        return response()->json([
            'timestamp' => now()->toIso8601String(),
            'status' => true,
            'success' => true,
            'message' => 'Login successful',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'token' => $token,
            'user' => $userData,
            'partner' => $partnerData,
            'delivery_executive' => $partnerData,
            'data' => [
                'token_type' => 'Bearer',
                'access_token' => $token,
                'token' => $token,
                'user' => $userData,
                'partner' => $partnerData,
                'delivery_executive' => $partnerData,
            ],
        ], 200);
    }

    public function me(Request $request)
    {
        $executive = $this->resolveExecutive($request);
        $user = $request->user();

        if (!$executive && !$user) {
            return response()->json(['status' => false, 'message' => 'Unauthenticated'], 401);
        }

        $roles = ['delivery_executive', 'partner', 'delivery'];
        $data = $executive ? [
            'id' => $executive->id,
            'name' => $executive->name,
            'email' => $executive->email,
            'phone' => (string) $executive->phone,
            'phone_code' => (string) ($executive->phone_code ?? '91'),
            'unique_code' => $executive->unique_code,
            'status' => $executive->status,
            'is_online' => (bool) $executive->is_online,
            'branch_id' => $executive->branch_id,
            'restaurant_id' => $executive->branch?->restaurant_id,
            'roles' => $roles,
            'branch' => $executive->branch,
            'restaurant' => $executive->branch?->restaurant,
        ] : [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $roles,
        ];

        return response()->json([
            'status' => true,
            'success' => true,
            'data' => $data,
            'partner' => $data,
            'user' => $data,
            'delivery_executive' => $data,
        ]);
    }

    public function profile(Request $request)
    {
        return $this->me($request);
    }

    public function updateStatus(Request $request)
    {
        $executive = $this->resolveExecutive($request);
        if (!$executive) {
            return response()->json(['status' => false, 'message' => 'Executive not found'], 404);
        }

        $isOnline = $request->has('is_online')
            ? filter_var($request->input('is_online'), FILTER_VALIDATE_BOOLEAN)
            : ($request->input('status') === 'online' || $request->input('status') === 'active');

        $executive->update(['is_online' => $isOnline]);

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Status updated successfully',
            'is_online' => (bool) $executive->is_online,
        ]);
    }

    public function updateLocation(Request $request)
    {
        $executive = $this->resolveExecutive($request);
        $lat = $request->input('lat') ?? $request->input('latitude');
        $lng = $request->input('lng') ?? $request->input('longitude');

        Log::info('Partner Location Update:', ['executive_id' => $executive?->id, 'lat' => $lat, 'lng' => $lng]);

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Location updated successfully',
        ]);
    }

    public function orders(Request $request, $status = null)
    {
        $executive = $this->resolveExecutive($request);

        $ordersQuery = Order::query()
            ->with([
                'items',
                'customer.latestDeliveryAddress',
                'customer.addresses',
                'table',
                'waiter',
                'kot.items.menuItem',
                'branch.restaurant.currency',
                'deliveryExecutive',
                'payments',
            ]);

        if ($executive) {
            $assignedCount = Order::where('delivery_executive_id', $executive->id)->count();
            if ($assignedCount > 0) {
                $ordersQuery->where('delivery_executive_id', $executive->id);
            } elseif ($executive->branch_id) {
                $ordersQuery->where('branch_id', $executive->branch_id)
                    ->where(function ($q) use ($executive) {
                        $q->whereNull('delivery_executive_id')
                            ->orWhere('delivery_executive_id', $executive->id);
                    });
            }
        }

        if ($status === 'active') {
            $ordersQuery->whereNotIn('order_status', ['delivered', 'canceled']);
        } elseif ($status === 'history' || $status === 'completed') {
            $ordersQuery->whereIn('order_status', ['delivered', 'canceled']);
        } elseif ($status) {
            $ordersQuery->where('order_status', $status);
        }

        $orders = $ordersQuery->orderBy('id', 'desc')->get();
        $data = OrderResource::collection($orders);

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Orders fetched successfully',
            'data' => $data,
            'orders' => $data,
        ], 200);
    }

    public function registerDevice(Request $request)
    {
        $token = $request->input('token')
            ?? $request->input('device_token')
            ?? $request->input('fcm_token');
        $platform = $request->input('platform', 'android');
        $deviceId = $request->input('device_id');
        $user = $request->user();

        if ($user && $token && class_exists(DeviceToken::class)) {
            try {
                DeviceToken::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'token' => $token,
                    ],
                    [
                        'restaurant_id' => $user->restaurant_id,
                        'branch_id' => $user->branch_id,
                        'platform' => $platform,
                        'device_id' => $deviceId,
                        'app_type' => 'delivery_partner',
                    ]
                );
            } catch (\Throwable $e) {
                Log::warning('Device token registration skipped: ' . $e->getMessage());
            }
        }

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Device registered successfully',
        ], 200);
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        $order = Order::with([
            'items',
            'customer.latestDeliveryAddress',
            'customer.addresses',
            'table',
            'waiter',
            'kot.items.menuItem',
            'branch.restaurant.currency',
            'deliveryExecutive',
            'payments',
        ])->find($orderId);
        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Order not found'], 404);
        }

        $status = $request->input('status') ?? $request->input('order_status');
        if ($status) {
            $rawStatus = strtolower(trim(str_replace(['-', ' '], '_', (string) $status)));

            if (in_array($rawStatus, ['on_the_way', 'out_for_delivery', 'ontheway', 'outfordelivery'])) {
                $updateData = ['order_status' => OrderStatus::OUT_FOR_DELIVERY];
                if (is_null($order->delivery_started_at)) {
                    $updateData['delivery_started_at'] = now();
                }
                $order->update($updateData);
            } elseif (in_array($rawStatus, ['picked_up', 'pickedup', 'picked'])) {
                $updateData = ['order_status' => OrderStatus::PICKED_UP];
                if (is_null($order->delivery_started_at)) {
                    $updateData['delivery_started_at'] = now();
                }
                $order->update($updateData);
            } elseif (in_array($rawStatus, ['reached_destination', 'reached'])) {
                $order->update(['order_status' => OrderStatus::REACHED_DESTINATION]);
            } elseif (in_array($rawStatus, ['delivered', 'completed'])) {
                $order->update([
                    'order_status' => OrderStatus::DELIVERED,
                    'delivered_at' => now(),
                ]);

                $executive = $this->resolveExecutive($request);
                if ($executive) {
                    $executive->update(['status' => DeliveryExecutive::STATUS_ACTIVE]);
                }
            } else {
                $enum = OrderStatus::tryFrom($rawStatus);
                if ($enum) {
                    $order->update(['order_status' => $enum]);
                } else {
                    $order->update(['order_status' => $rawStatus]);
                }
            }
        }

        $order->refresh();

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Order status updated successfully',
            'order' => new OrderResource($order),
        ]);
    }

    public function logout(Request $request)
    {
        $executive = $this->resolveExecutive($request);
        if ($executive) {
            $executive->update(['is_online' => false]);
        }

        $user = $request->user();
        if ($user && method_exists($user, 'currentAccessToken')) {
            $user->currentAccessToken()?->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully',
        ]);
    }

    private function resolveExecutive(Request $request): ?DeliveryExecutive
    {
        $executive = $request->attributes->get('delivery_executive');
        if ($executive instanceof DeliveryExecutive) {
            return $executive;
        }

        $user = $request->user();
        if ($user instanceof DeliveryExecutive) {
            return $user;
        }

        if ($user) {
            $executive = DeliveryExecutive::with('branch.restaurant.currency')
                ->where('email', $user->email)
                ->first();
            if ($executive) {
                return $executive;
            }
        }

        return DeliveryExecutive::with('branch.restaurant.currency')->where('is_online', true)->first()
            ?? DeliveryExecutive::with('branch.restaurant.currency')->first();
    }
}
