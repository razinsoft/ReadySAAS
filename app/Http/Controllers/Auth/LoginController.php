<?php

namespace App\Http\Controllers\Auth;

use App\Events\MailSendEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\SigninRequest;
use App\Repositories\CustomerRepository;
use App\Repositories\EmailVerificationRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller

{
    public function index()
    {
        return view('auth.login');
    }
    public function signup()
    {
        return view('auth.registration');
    }
    public function signin(SigninRequest $loginRequest)
    {
        $user = $this->isAuthenticate($loginRequest);
        $loginRequest->only('email', 'password');

        if (!$user) {
            return back()->with('error', 'Invalid credentials');
        }
        if (!$user->email_verified_at) {
            return back()->with('error', 'Please check your email and verify your email!');
        }
        Auth::login($user);
        $token = $user->createToken('user token')->accessToken;
        if (isset($user->roles[0]->name) && ($user->roles[0]->name == 'store' || $user->roles[0]->name == 'customer')) {
            return to_route('sale.pos')->with('token', $token);
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
    public function signupRequest(CustomerRequest $request)
    {
        if(!env('MAIL_USERNAME') || !env('MAIL_PASSWORD')){
            return back()->with('error', 'Now you can not do signup because admin have not configured signup yet');
        }
        $user = UserRepository::storeByRequest($request);
        CustomerRepository::storeByRequest($request, $user);
        $varificationCode = EmailVerificationRepository::storeByRequest($user);
        MailSendEvent::dispatch($user, $varificationCode, 'signup');
        return to_route('signin.index')->with('success', 'Sign Up successfully done! Please check your email inbox or spam');
    }
    public function varification($token)
    {
        $varificationCode = EmailVerificationRepository::query()->where('token', $token)->first();
        if (!$varificationCode) {
            return to_route('signin.index')->with('error', 'This Email already varified!');
        }
        UserRepository::emailVarifyAt($varificationCode->user);
        $varificationCode->delete();
        return to_route('signin.index')->with('success', 'Email successfully varified!');
    }
}
