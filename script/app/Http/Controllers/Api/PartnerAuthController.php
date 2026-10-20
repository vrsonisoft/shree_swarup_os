<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryExecutive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PartnerAuthController extends Controller
{
    public function login(Request $request)
    {
        Log::info('Partner Login Request received:', $request->all());

        // Extract partner identifier from any possible key
        $identifier = $request->input('partner_id')
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
            $branch = \App\Models\Branch::first();
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

        // Generate Sanctum access token
        $token = $executive->createToken('partner-rider-app')->plainTextToken;

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
        $executive = $request->user();

        if (!$executive) {
            return response()->json(['status' => false, 'message' => 'Unauthenticated'], 401);
        }

        return response()->json([
            'status' => true,
            'data' => $executive,
            'partner' => $executive,
            'user' => $executive,
        ]);
    }

    public function logout(Request $request)
    {
        $executive = $request->user();
        if ($executive) {
            $executive->update(['is_online' => false]);
            $executive->currentAccessToken()?->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully',
        ]);
    }
}
