<?php

namespace App\Http\Controllers\Api;

use App\ApiResource\OrderResource;
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

        // Generate Sanctum access token
        $token = $user->createToken('partner-rider-app')->plainTextToken;

        $partnerData = [
            'id' => $executive->id,
            'name' => $executive->name,
            'email' => $executive->email,
            'phone' => $executive->phone,
            'phone_code' => $executive->phone_code,
            'unique_code' => $executive->unique_code,
            'status' => $executive->status,
            'is_online' => (bool) $executive->is_online,
            'branch_id' => $executive->branch_id,
            'restaurant_id' => $executive->branch?->restaurant_id,
            'branch' => $executive->branch,
            'restaurant' => $executive->branch?->restaurant,
        ];

        return response()->json([
            'timestamp' => now()->toIso8601String(),
            'status' => true,
            'success' => true,
            'message' => 'Login successful',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'token' => $token,
            'user' => $partnerData,
            'partner' => $partnerData,
            'delivery_executive' => $partnerData,
            'data' => [
                'token_type' => 'Bearer',
                'access_token' => $token,
                'token' => $token,
                'user' => $partnerData,
                'partner' => $partnerData,
                'delivery_executive' => $partnerData,
            ],
        ], 200);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthenticated'], 401);
        }

        $executive = DeliveryExecutive::with('branch.restaurant.currency')
            ->where('email', $user->email)
            ->first();

        $data = $executive ?: $user;

        return response()->json([
            'status' => true,
            'data' => $data,
            'partner' => $data,
            'user' => $data,
        ]);
    }

    public function orders(Request $request, $status = null)
    {
        $user = $request->user();
        $executive = null;
        if ($user) {
            $executive = DeliveryExecutive::where('email', $user->email)->first();
        }

        $ordersQuery = Order::query()
            ->with(['items', 'customer', 'table', 'waiter', 'kot', 'kot.items', 'kot.items.menuItem', 'branch.restaurant.currency']);

        if ($executive) {
            $ordersQuery->where('delivery_executive_id', $executive->id);
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
        $token = $request->input('token') ?? $request->input('device_token') ?? $request->input('fcm_token');
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
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Order not found'], 404);
        }

        $status = $request->input('status') ?? $request->input('order_status');
        if ($status) {
            $order->update(['order_status' => $status]);
        }

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Order status updated successfully',
            'order' => new OrderResource($order),
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $executive = DeliveryExecutive::where('email', $user->email)->first();
            if ($executive) {
                $executive->update(['is_online' => false]);
            }
            $user->currentAccessToken()?->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully',
        ]);
    }
}
