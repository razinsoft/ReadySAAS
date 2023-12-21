<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\StoreRequest;
use App\Models\Store;
use App\Repositories\StoreRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $stores = StoreRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->get();
        return view('store.index', compact('stores'));
    }

    public function create()
    {
        $statuses = Status::cases();
        return view('store.create', compact('statuses'));
    }

    public function store(StoreRequest $request)
    {
        $shop = auth()->user()?->shop;
        $request['email_verified_at'] = now();
        $shopManager = UserRepository::storeByRequest($request, $shop);
        StoreRepository::storeByRequest($request, $shopManager);
        $shopManager->assignRole('store');
        return back()->with('success', 'Store inserted successfully');
    }

    public function edit(Store $store)
    {
        return view('store.edit', compact('store'));
    }

    public function update(StoreRequest $request, Store $store)
    {
        StoreRepository::updateByRequest($request, $store);
        UserRepository::updateByRequest($request, $store->user);
        return back()->with('success', 'Store updated successfully');
    }
}
