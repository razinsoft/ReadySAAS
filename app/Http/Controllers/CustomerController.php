<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\User;
use App\Repositories\CustomerGroupRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $customers = CustomerRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->get();
        return view('customer.index', compact('customers'));
    }
    public function create()
    {
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $customerGroups = CustomerGroupRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->get();
        return view('customer.create', compact('customerGroups'));
    }
    public function store(CustomerRequest $request)
    {
        $user = UserRepository::storeByRequest($request);
        CustomerRepository::storeByRequest($request, $user);
        return back()->with('success', 'Customer is created successfully!');
    }
    public function edit(Customer $customer)
    {
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $customerGroups = CustomerGroupRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->get();
        return view('customer.edit', compact('customer', 'customerGroups'));
    }
    public function update(CustomerRequest $request, Customer $customer)
    {
        CustomerRepository::updateByRequest($request, $customer);
        return back()->with('success', 'Customer is updated successfully!');
    }
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back()->with('success', 'Customer is deleted successfully!');
    }

    public function downloadCustomerSample()
    {
        return response()->download(public_path('import/sample_customer.csv'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);
        $authUser = auth()->user();
        $file = $request->file('file');
        $csvData = array_map('str_getcsv', file($file));
        try {
            foreach ($csvData as $key => $row) {
                if ($key > 0) {
                    $customerGroup = CustomerGroupRepository::query()->where('name', $row[0])->first();
                    $user = User::create([
                        'name' => $row[1],
                        'email' => $row[3],
                        'phone' => $row[4],
                        'company_name' => $row[2],
                        'password' => Hash::make($row[10]),
                    ]);
                    Customer::create([
                        'created_by' => $authUser->id,
                        'shop_id' => $authUser->shop->id,
                        'customer_group_id' => $customerGroup?->id,
                        'user_id' => $user?->id,
                        'name' => $row[1],
                        'company_name' => $row[2],
                        'email' => $row[3],
                        'phone_number' => $row[4],
                        'address' => $row[5],
                        'city' => $row[6],
                        'state' => $row[7],
                        'postal_code' => $row[8],
                        'country' => $row[9],
                    ]);
                }
            }
            return back()->with('success', 'Customer import successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Please provide valid data in the csv file!');
        }
    }
}
