<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Repositories\CustomerRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function search()
    {
        $request = request();
        $search = $request->search;

        $customers = CustomerRepository::search($search);
        return $this->json('Search Customer', [
            'customers' => CustomerResource::collection($customers),
        ]);
    }
    public function store(CustomerRequest $request)
    {
        $user = UserRepository::storeByRequest($request);
        $customer = CustomerRepository::storeByRequest($request, $user);
        return $this->json('Customer successfully stored', [
            'customer' => CustomerResource::make($customer),
        ]);
    }
}
