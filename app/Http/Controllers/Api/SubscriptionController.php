<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Mail\Subscribed;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;

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
}
