<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopOwnerRequest;
use App\Models\Shop;
use App\Repositories\GeneralSettingRepository;
use App\Repositories\ShopCategoryRepository;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = ShopRepository::getAll();
        $shopCategories = ShopCategoryRepository::query()->where('status', 'Active')->get();
        return view('shop.index', compact('shops', 'shopCategories'));
    }

    public function create()
    {
        $shopCategories = ShopCategoryRepository::query()->where('status', 'Active')->get();
        return view('shop.create', compact('shopCategories'));
    }

    public function store(ShopOwnerRequest $request)
    {
        $request['email_verified_at'] = now();
        $user = UserRepository::storeByRequest($request);
        $user->assignRole('admin');
        $shop = ShopRepository::storeByRequest($request, $user);
        GeneralSettingRepository::storeByRequest($request, $shop);
        return to_route('shop.index')->with('success', 'Shop and Shop owner successfully created');
    }

    public function statusChanage(Shop $shop, $status)
    {
        ShopRepository::statusChanageByRequest($shop, $status);
        return back()->with('success', 'Subscription successfully chanaged');
    }
}
