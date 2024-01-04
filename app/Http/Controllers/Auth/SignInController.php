<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SigninRequest;;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignInController extends Controller

{
    public function index()
    {
        return view('auth.login');
    }

    public function signin(SigninRequest $loginRequest)
    {
        $user = $this->isAuthenticate($loginRequest);
        $shop = $user?->userShop?->shop;
        $loginRequest->only('email', 'password');

        if (!$user) {
            return back()->with('error', 'Invalid credentials');
        }
        if (!$user->email_verified_at) {
            return back()->with('error', 'Please check your email and verify your email!');
        }
        if ($shop && $shop->status->value == 'Inactive') {
            return back()->with('error', 'Kindly get in touch with the administration as your shop is currently inactive!');
        }
        Auth::login($user);
        $token = $user->createToken('user token')->accessToken;
        if (isset($user->roles[0]->name) && ($user->roles[0]->name == 'store' || $user->roles[0]->name == 'customer')) {
            return to_route('sale.pos')->with('token', $token);
        }
        if (isset($user->roles[0]->name) && $user->roles[0]->name == 'super admin') {
            return to_route('dashboard')->with('token', $token);
        }
        return to_route('root')->with('token', $token);
    }

    private function isAuthenticate($loginRequest)
    {
        $user = UserRepository::findByEmail($loginRequest->email);
        if ($user && Hash::check($loginRequest->password, $user->password)) {
            return $user;
        }
        return false;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('signin.index')->with('success', 'You logout successfully');
    }

}
