<?php

namespace App\Repositories;

use App\Enums\PaymentStatus;
use App\Enums\SubscriptionRequestStatus;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Subscription;

class SubscriptionRequestRepository extends Repository
{
    public static function model()
    {
        return SubscriptionRequest::class;
    }

    public static function storeByRequest(Subscription $subscription)
    {
        return self::create([
            'user_id' => auth()->id(),
            'subscription_id' => $subscription->id,
            'payment_status' => PaymentStatus::UNPAID->value,
            'status' => SubscriptionRequestStatus::PENDING->value,
        ]);
    }
}
