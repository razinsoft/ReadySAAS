<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function details(){
        $user = auth()->user();
        return $this->json('User details', [
            'user' => UserResource::make($user),
        ]);
    }

    public function profileUpdate(UserRequest $request){
        $user = auth()->user();
        UserRepository::updateByRequest($request,$user);
        return $this->json('User profile successfully updated', [
            'user' => UserResource::make($user),
        ]);
    }

    public function passwordChange(ChangePasswordRequest $request){
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return $this->json('Your current password was wrong.', [], 422);
        }

        UserRepository::updateByPassword($request,$user);
        return $this->json('User profile successfully updated', [
            'user' => UserResource::make($user),
        ]);
    }
}
