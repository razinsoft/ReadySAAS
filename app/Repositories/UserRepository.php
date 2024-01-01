<?php

namespace App\Repositories;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
{
    public static $path = "/users";
    
    public static function model()
    {
        return User::class;
    }

    public static function findByEmail($email)
    {
        return self::query()->where('email', $email)->first();
    }

    public static function getAccessToken(User $user)
    {
        $token = $user->createToken('user token');

        return [
            'auth_type' => 'Bearer',
            'token' => $token->accessToken,
            'expires_at' => $token->token->expires_at->format('Y-m-d H:i:s'),
        ];
    }

    //User create
    public static function storeByRequest($request, $shop = null)
    {
        $create = self::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'email_verified_at' => $request->email_verified_at,
            'password' => Hash::make($request->password),
        ]);
        return $create;
    }
    // User UPdate
    public static function userUpdate(UserRequest $request, User $user)
    {
        $userUpdate = self::update($user, [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $user->assignRole($request->role_name);

        if ($request->password) {
            self::update($user, [
                'password' => hash::make($request->password),
            ]);
        }
        return $userUpdate;
    }
    //User Profile update
    public static function updateByRequest($request, User $user)
    {
        $thumbnailId = $user->thumbnail_id;
        if ($request->hasFile('image')) {
            $thumbnail = MediaRepository::updateByRequest(
                $request->image,
                self::$path,
                'Image',
                $user->thumbnail,
            );
            $thumbnailId = $thumbnail->id;
        }
        return self::update($user, [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'thumbnail_id' => $thumbnailId,
        ]);
    }

    public static function updateByPassword(ChangePasswordRequest $request, User $user): bool
    {
        return self::update($user, [
            'password' => Hash::make($request->new_password)
        ]);
    }

    public static function resetPassword(ResetPasswordRequest $request, User $user)
    {
        return self::update($user, [
            'password' => Hash::make($request->password)
        ]);
    }
    public static function emailVarifyAt(User $user)
    {
        return self::update($user, [
            'email_verified_at' => now()
        ]);
    }
}
