<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\IsHas;
use App\Http\Controllers\Controller;
use App\Http\Requests\StripeConfigureRequest;
use App\Models\SubscriptionRequest;
use App\Repositories\GeneralSettingRepository;
use App\Repositories\ShopSubscriptionRepository;
use App\Repositories\SubscriptionRequestRepository;
use Exception;
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

    public function process(Request $request, SubscriptionRequest $subscriptionRequest)
    {
        // $generalsettings = GeneralSettingRepository::query()->where('shop_id', mainShop()->id)->first();
        // try {
        //     Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        //     Stripe\Charge::create([
        //         "amount" => $subscriptionRequest->subscription->price * 100,
        //         "currency" => $generalsettings?->defaultCurrency?->code ?? 'USD',
        //         "source" => $request->stripeToken,
        //         "description" => $subscriptionRequest->subscription->description,
        //     ]);

        //     $shopSubscription = ShopSubscriptionRepository::query()->where(['is_current' => IsHas::YES->value, 'shop_id' => mainShop()->id])->first();

        //     if ($shopSubscription) {
        //         $shopSubscription->update([
        //             'is_current' => IsHas::NO->value,
        //         ]);
        //     }
            SubscriptionRequestRepository::updateByRequest($subscriptionRequest);
            ShopSubscriptionRepository::storeByRequest($subscriptionRequest);
            return to_route('root')->with('success', 'Stripe payment successfully done');
        // } catch (Exception $ex) {
        //     SubscriptionRequestRepository::requestFailed($subscriptionRequest);
        //     return to_route('subscription-purchase.index')->withError('Something is wrong please try again');;
        // }
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
