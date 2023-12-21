<?php

namespace App\Repositories;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;

class CustomerRepository extends Repository
{
    public static function model()
    {
        return Customer::class;
    }
    public static function storeByRequest(CustomerRequest $request, $user)
    {
        $authUser = auth()->user();
        return self::create([
            'created_by' => $authUser->id,
            'shop_id' => $authUser->shop->id,
            'customer_group_id' => $request->customer_group_id,
            'name' => $request->name,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'tax_no' => $request->tax_no,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->post_code,
            'country' => $request->country,
            'user_id' => $user->id
        ]);
    }

    public static function updateByRequest(CustomerRequest $request, Customer $customer)
    {
        $update = self::update($customer, [
            'customer_group_id' => $request->customer_group_id,
            'name' => $request->name,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'tax_no' => $request->tax_no,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
        ]);

        return $update;
    }

    public static function search($search)
    {
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $products = self::query()->where('shop_id', $shopId)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'Like', "%{$search}%");
                $query->orWhere('email', 'Like', "%{$search}%");
                $query->orWhere('phone_number', 'Like', "%{$search}%");
                $query->orWhere('company_name', 'Like', "%{$search}%");
                $query->orWhere('address', 'Like', "%{$search}%");
            })->get();

        return $products;
    }
}
