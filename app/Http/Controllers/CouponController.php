<?php

namespace App\Http\Controllers;

use App\Enums\CouponType;
use App\Http\Requests\CouponRequest;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\CouponRepository;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = CouponRepository::query()->where('shop_id', $this->mainShop()->id)->orderByDesc('id')->get();
        $couponTypes = CouponType::cases();
        return view('coupon.index', compact('coupons', 'couponTypes'));
    }

    public function store(CouponRequest $request)
    {
        CouponRepository::storeByRequest($request);
        return back()->with('success', 'Coupon is created successfully!');
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        CouponRepository::updateByRequest($request, $coupon);
        return back()->with('success', 'Coupon is updated successfully!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'Coupon is deleted successfully!');
    }
}
