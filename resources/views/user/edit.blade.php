@extends('layout.app')
@section('title', __('user_edit'))
@section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between card-header-color">
                            <span class="list-title text-white">{{ __('user_edit') }}</span>
                            <a href="{{ route('user.index') }}" class="btn common-btn"><i class="fa fa-chevron-left "></i>
                                {{ __('back') }}</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.update', $user->id) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-2">
                                            <label class="mb-2">{{ __('name') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="name" required class="form-control"
                                                placeholder="{{ __('enter_your_user_name') }}" value="{{ $user->name }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="mb-2">{{ __('password') }} <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    placeholder="{{ __('enter_your_user_password') }}" name="password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="mb-2">{{ __('email_address') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email"
                                                placeholder="{{ __('enter_your_user_email_address') }}" required
                                                class="form-control" value="{{ $user->email }}">
                                            @error('email')
                                                <span class="text-danger">
                                                    {{ $errors->first('email') }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="mb-2">{{ __('role') }}<span
                                                    class="text-danger">*</span></label>
                                            <select name="role_name" class="form-control">
                                                <option selected disabled>{{ __('select_a_option') }}
                                                </option>
                                                @foreach ($roles as $role)
                                                    <option
                                                        {{ isset($user->roles[0]->name) && $user->roles[0]->name == $role->name ? 'selected' : '' }}
                                                        value="{{ $role->name }}">{{ ucfirst($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role_name')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="mb-2">{{ __('phone_number') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="phone" required class="form-control"
                                                placeholder="{{ __('enter_your_user_phone_number') }}"
                                                value="{{ $user->phone }}">
                                            @error('phone')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn common-btn">{{ __('update_and_Save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
