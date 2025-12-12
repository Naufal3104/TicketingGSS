<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    public function handleCustomerRegistration(Request $request)
    {
        // 1. Validate Secret Key
        $secretKey = $request->header('X-Webhook-Secret');
        $configuredSecret = env('N8N_WEBHOOK_SECRET');

        if (!$configuredSecret || $secretKey !== $configuredSecret) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // 2. Validate Data
        $validated = $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|string', // Format check can be added if needed
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // 3. Create or Update Customer
        // Using check based on phone_number as unique identifier for now
        $customer = Customer::updateOrCreate(
            ['phone_number' => $validated['phone_number']],
            [
                'customer_id' => 'CUST-' . strtoupper(Str::random(8)), // Or any logic to generate ID
                'customer_name' => $validated['name'],
                'address_primary' => $validated['address'],
                // 'latitude' => $validated['latitude'], // Model doesn't have latitude/longitude yet?
                // 'longitude' => $validated['longitude'],
            ]
        );

        // 4. Create User for Customer?
        // Requirement says "Integrasi simpan data ke Database via API Laravel". 
        // Usually Customers might not need a User account immediately unless they need to login.
        // For this MVP step, we just store the Customer data as requested for "Registrasi Auto".

        return response()->json([
            'message' => 'Customer registered successfully',
            'data' => $customer
        ], 200);
    }
}
