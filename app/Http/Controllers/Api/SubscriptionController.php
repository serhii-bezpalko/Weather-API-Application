<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Mail\Subscribed;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request)
    {
        if (is_null(Subscription::firstWhere('email', $request->get('email')))) {
            $subscription = Subscription::store($request->all());
            Mail::to($subscription->email)->send(new Subscribed($subscription));
            return response()->json(['message' => 'Subscription successful. Confirmation email sent.']);
        }

        return response()->json(['error' => 'Email already subscribed.'], 409);
    }

    public function confirm(string $token)
    {
        if (strlen($token) != 40) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        $subscription = Subscription::firstWhere('token', $token);
        if (!is_null($subscription)) {
            $subscription->confirmed = true;
            $subscription->token = Str::random(40);
            $subscription->save();
            dump($subscription);
            return response()->json(['message' => 'Subscription confirmed successfully']);
        }

        return response()->json(['error' => 'Token not found'], 404);
    }

    public function unsubscribe(string $token)
    {
        if (strlen($token) != 40) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        $subscription = Subscription::firstWhere('token', $token);
        if (!is_null($subscription)) {
            $subscription->delete();
            return response()->json(['message' => 'Unsubscribed successfully']);
        }

        return response()->json(['error' => 'Token not found'], 404);
    }
}
