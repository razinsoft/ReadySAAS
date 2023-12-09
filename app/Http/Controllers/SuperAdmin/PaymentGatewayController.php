<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StripeConfigureRequest;
use Illuminate\Http\Request;
use Stripe;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        return view('paymentGateway.index');
    }

    public function update(StripeConfigureRequest $request)
    {
        $environmentSet = array(
            'STRIPE_KEY' => $request->public_key,
            'STRIPE_SECRET' => $request->secret_key,
        );
        foreach ($environmentSet as $key => $value) {
            self::setEnv($key, $value);
        }
        return back()->with('success', 'Stripe payment gateway successfully configure');
    }

    public function payment()
    {
        return view('subscriptionPurchase.payment');
    }

    public function process(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            "amount" => 100 * 100,
            "currency" => "INR",
            "source" => $request->stripeToken,
            "description" => "This payment is testing purpose",
        ]);

        return back();
    }

    public static function setEnv($key, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            if ($key == 'MAIL_FROM_NAME' || $key == 'MAIL_FROM_ADDRESS') {
                file_put_contents($path, str_replace(
                    $key . '=' . '"' . env($key) . '"',
                    $key . '=' . "\"$value\"",
                    file_get_contents($path)
                ));
            } else {
                file_put_contents($path, str_replace(
                    $key . '=' . env($key),
                    $key . '=' . $value,
                    file_get_contents($path)
                ));
            }
        }
    }
}
