<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Keygen\Keygen;
use App\Repositories\RolesRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $staffs = mainShop()->staffs;
        return view('user.index', compact('staffs'));
    }

    public function create()
    {
        $roles = RolesRepository::query()->where('shop_id', mainShop()->id)->orderByDesc('id')->get();
        return view('user.create', compact('roles'));
    }

    public function generatePassword()
    {
        $id = Keygen::numeric(6)->generate();
        return $id;
    }

    public function store(UserRequest $request)
    {
        if (Role::findByName(lcfirst($request->role_name))->permissions->isEmpty()) {
            return back()->with('error', 'Please assign role permission!');
        }
        $request['email_verified_at'] = now();
        $user = UserRepository::storeByRequest($request);
        $user->shopUser()->attach(mainShop()->id);
        WalletRepository::create([
            'user_id' => $user->id,
        ]);
        $user->assignRole(Str::lower($request->role_name));
        return back()->with('success', 'User is create successfully!');
    }

    public function edit(User $user)
    {
        $roles = RolesRepository::query()->where('id', '>', 1)->get();
        return view('user.edit', compact('roles', 'user'));
    }

    public function update(UserRequest $request, User $user)
    {
        if (Role::findByName(lcfirst($request->role_name))->permissions->isEmpty()) {
            return back()->with('error', 'Please assign role permission!');
        }
        UserRepository::userUpdate($request, $user);
        return back()->with('success', 'User is update successfully!');
    }

    public function profile(User $user)
    {
        return view('user.profile', compact('user'));
    }

    public function profileUpdate(UserRequest $request, User $user)
    {
        if (app()->environment('local')) {
            return back()->with('error', 'This section is not available for demo version!');
        }
        UserRepository::updateByRequest($request, $user);
        return back()->with('success', 'Profile is updated successfully!');
    }

    public function changePassword(ChangePasswordRequest $request, User $user)
    {
        if (app()->environment('local')) {
            return back()->with('error', 'This section is not available for demo version!');
        }
        if ($request->new_password != $request->confirm_password)
            return back()->with('error', 'Please Confirm your new password');

        if (Hash::check($request->current_password, $user->password)) {
            UserRepository::updateByPassword($request, $user);
            return back()->with('success', 'Password updated successfully!');
        }

        return back()->with("error", "Current Password doesn't match");
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User is deleted successfully!');
    }
}
