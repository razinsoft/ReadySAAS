@extends('layout.auth')
@section('title', __('signup'))
@section('content')
    <form action="{{ route('signup.request') }}" method="POST">
        @csrf
        <div class="logo-img text-center">
            <img src="{{ $general_settings->logo->file ?? asset('/logo/logo.png') }}" alt="">
        </div>
        <div class="page-content">
            <h2 class="pageTitle">{{ __('welcome_to') }} <span
                    style="color:#3BB2FB">{{ isset($general_settings->site_title) && $general_settings->site_title ? $general_settings->site_title : 'Ready POS' }}</span>
            </h2>
            <h1 class="signin-heading">{{ __('sign_up') }}</h1>
        </div>
        <div class="form-outline form-white mb-3 mb-md-4">
            <label class="mb-2" for="name">{{ __('enter_your_name') }}</label>
            <input type="text" name="name" id="name" class="form-control mb-1"
                placeholder="{{ __('name') }}">
            @error('name')
                <span class="text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline form-white mb-3 mb-md-4">
            <label class="mb-2" for="email">{{ __('enter_your_email') }}</label>
            <input type="email" name="email" id="email" class="form-control mb-1"
                placeholder="{{ __('email') }}">
            @error('email')
                <span class="text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline form-white mb-3 mb-md-4">
            <label class="mb-2" for="address">{{ __('enter_your_address') }}</label>
            <input type="text" name="address" id="address" class="form-control mb-1"
                placeholder="{{ __('address') }}">
            @error('address')
                <span class="text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline form-white mb-4 mb-md-5">
            <label class="mb-2">{{ __('enter_your_assword') }}</label>
            <div class="position-relative">
                <input type="password" id="password" name="password" class="form-control mb-1"
                    placeholder="{{ __('password') }}">
                <span class="eye" onclick="showHidePassword()">
                    <i class="far fa-eye fa-eye-slash" id="togglePassword"></i>
                </span>
            </div>
            @error('password')
                <span class="text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button class="btn loginButton" type="submit">{{ __('sign_up') }}</button>
        <span class="text-center w-100 d-block pt-2">{{ __('already_have_a_account') }} <a
                href="{{ route('signin.index') }}">{{ __('signin') }}</a></span>
    </form>
@endsection
@push('scripts')
    <script>
        function showHidePassword() {
            const toggle = document.getElementById("togglePassword");
            const password = document.getElementById("password");

            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            // toggle the icon
            toggle.classList.toggle("fa-eye");
        }
    </script>
@endpush
