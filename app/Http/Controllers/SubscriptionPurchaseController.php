<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use Illuminate\Http\Request;

class SubscriptionPurchaseController extends Controller
{
    public function index()
    {
        $subscriptions = SubscriptionRepository::query()->where('id', '>', 1)->where('status', 'Active')->get();
        return view('subscriptionPurchase.index', compact('subscriptions'));
    }

    public function update(Subscription $subscription)
    {
        dd($subscription);
    }
}
