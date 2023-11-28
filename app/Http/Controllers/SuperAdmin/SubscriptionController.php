<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\RecurringType;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Repositories\SubscriptionRepository;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = SubscriptionRepository::getAll();
        $recurringTypes = RecurringType::cases();
        $statuses = Status::cases();
        return view('subscription.index', compact('subscriptions', 'recurringTypes', 'statuses'));
    }
}
