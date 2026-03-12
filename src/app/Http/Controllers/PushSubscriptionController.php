<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PushSubscriptionController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'endpoint' => 'required|url|unique:push_subscriptions,endpoint',
            'keys' => 'required|array',
        ]);


        $subscription = PushSubscription::updateOrCreate([
            'user_id' => auth()->user()->id,
            'endpoint' => $data['endpoint'],
            'keys' => json_encode($data['keys'])
        ]);

        return response()->json(['message' => 'Subscription created successfully'], 201);
    }

    public function fetchPublicKey (): JsonResponse
    {
        Log::info("Fetching VAPID keys");
        Log::info(config('services.vapid.public_key'));

        return response()->json([
            'publicKey' => config('services.vapid.public_key')
        ], 200);
    }
}
