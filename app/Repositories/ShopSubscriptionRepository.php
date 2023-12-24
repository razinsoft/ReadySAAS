<?php

namespace App\Repositories;

use App\Enums\IsHas;
use App\Enums\PaymentGateway;
use App\Enums\PaymentStatus;
use App\Models\ShopSubscription;
use App\Models\SubscriptionRequest as ModelsSubscriptionRequest;
use Carbon\Carbon;

class ShopSubscriptionRepository extends Repository
{
    public static function model()
    {
        return ShopSubscription::class;
    }

    public static function storeByRequest(ModelsSubscriptionRequest $subscriptionRequest)
    {
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $subscription = $subscriptionRequest->subscription;
        $date = now();
        if ($subscription->recurring_type->value == 'Onetime') {
            $expiredAt = now();
        } elseif ($subscription->recurring_type->value == 'Weekly') {
            $expiredAt = Carbon::parse($date)->addDays(7);
        } elseif ($subscription->recurring_type->value == 'Monthly') {
            $expiredAt = Carbon::parse($date)->addMonths(1);
        } elseif ($subscription->recurring_type->value == 'Yearly') {
            $expiredAt = Carbon::parse($date)->addYears(1);
        }
        return self::create([
            'shop_id' => $shopId,
            'subscription_id' => $subscriptionRequest->subscription_id,
            'is_current' => IsHas::YES->value,
            'payment_status' => PaymentStatus::PAID->value,
            'payment_gateway' => PaymentGateway::STRIPE->value,
            'expired_at' => $expiredAt
        ]);
    }
}