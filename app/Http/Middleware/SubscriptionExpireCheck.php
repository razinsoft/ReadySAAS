<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionExpireCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    private $whiteList = ['signout','root', 'dashboard','payment.process'];

    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $put = request()->isMethod('put');
        $post = request()->isMethod('Post');
        $subscription = mainShop()->currentSubscriptions();
        $requestRoute = request()->route()->getName();
        if ($user->roles[0]->name != 'super admin' && (!isset($subscription->expired_at) || (Carbon::parse($subscription->expired_at) <= now())) && ($put || $post) && !in_array($requestRoute,$this->whiteList)) {
            return to_route('root')->with('error', 'Sorry, Your subscription has been expired');
        }

        return $next($request);
    }
}
