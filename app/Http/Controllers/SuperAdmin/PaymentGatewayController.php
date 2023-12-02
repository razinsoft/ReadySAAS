<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Repositories\PaymentGatewayRepository;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $paymentGateways = PaymentGatewayRepository::getAll();
        $statuses = Status::cases();
        return view('paymentGateway.index', compact('paymentGateways', 'statuses'));
    }

    public function update(PaymentGateway $paymentGateway, Request $request)
    {
        PaymentGatewayRepository::updateByRequest($paymentGateway, $request);
        return back()->with('success', $paymentGateway->name.' payment gateway successfully updated');
    }
}
