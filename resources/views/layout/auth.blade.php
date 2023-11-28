<!doctype html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <!-- Meta-Link -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="">
    <meta name="mlapplication-tap-highlight" content="no">
    <!-- FaveIcon-Link -->
    <link rel="icon" type="image/png"
        href="{{ isset($general_settings->favicon->file) && $general_settings->favicon->file ? $general_settings->favicon->file : asset('/logo/small_logo.png') }}" />
    <!-- Title -->
    <title>
        {{ isset($general_settings->site_title) && $general_settings->site_title ? $general_settings->site_title : 'Ready POS' }}
        - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- Bootstrap-Min-Css-Link -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css">
    <!--Bootstrap-Icon-Css-Link -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    <!-- Font-Awesome--Min-Css-Link -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <!-- toastr css-->
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}" type="text/css">
    <!--Style--Css-Link -->
    <link rel="stylesheet" href="{{ asset('login/assets/css/style.css') }}">
</head>

<body>
    <!-- Login-Section -->
    <section class="login-section">
        <div class="leftSection">
            <img src="{{ asset('login/assets/images/loginBG.png') }}">
            <div class="hoverContent">
                <img src="{{ asset('login/assets/images/Credit_card.png') }}" class="credit-card" alt="">
                <img src="{{ asset('login/assets/images/Frame.png') }}" class="frame" alt="">
                <img src="{{ asset('login/assets/images/Cart.png') }}" class="cart" alt="">
                <img src="{{ asset('login/assets/images/shoping.png') }}" class="shoping" alt="">
                <h2 class="over-text2">{{ __('ready') }}!</h2>
            </div>
            <h2 class="over-text1">{{ __('streamline_sales_with') }}</h2>
        </div>
        <p class="bottom-text">{{ __('left_side_bottom_text') }}</p>
        <div class="loginCard">
            @yield('content')
        </div>
    </section>
    <!--End-Login-Section -->
    <!-- Jquery-link -->
    <script src="{{ asset('assets/scripts/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/sweetalert_modify.js') }}"></script>
    @if (session('success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            })
        </script>
    @endif

    @stack('scripts')
</body>

</html>
