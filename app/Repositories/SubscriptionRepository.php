<?php

namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository extends Repository
{
    public static function model()
    {
        return Subscription::class;
    }
}
