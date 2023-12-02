<?php

namespace App\Repositories;

use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentGatewayRepository extends Repository
{
    public static function model()
    {
        return PaymentGateway::class;
    }

    public static function updateByRequest(PaymentGateway $paymentGateway, Request $request)
    {
        if ($paymentGateway->name == 'Stripe') {
            return self::update($paymentGateway, [
                'value' => json_encode([
                    'public_key' => $request->public_key,
                    'secret_key' => $request->secret_key
                ]),
                'status' => $request->status,
            ]);
        }
    }
}
