@extends('layout.app')
@section('title', __('payment'))
@section('content')
    <style>
        .heading {
            font-size: 23px;
            font-weight: 00
        }

        .text {
            font-size: 16px;
            font-weight: 500;
            color: #b1b6bd
        }

        .pricing {
            border: 2px solid #304FFE;
            background-color: #f2f5ff
        }

        .business {
            font-size: 20px;
            font-weight: 500;
            margin-left: 15px
        }

        .plan {
            color: #aba4a4
        }

        .dollar {
            font-size: 16px;
            color: #6b6b6f
        }

        .amount {
            font-size: 50px;
            font-weight: 500
        }

        .year {
            font-size: 20px;
            color: #6b6b6f;
            margin-top: 19px
        }

        .detail {
            font-size: 22px;
            font-weight: 500
        }

        .cvv {
            height: 44px;
            width: 73px;
            border: 2px solid #eee
        }

        .cvv:focus {
            box-shadow: none;
            border: 2px solid #304FFE
        }

        .email-text {
            height: 55px;
            border: 2px solid #eee
        }

        .email-text:focus {
            box-shadow: none;
            border: 2px solid #304FFE
        }

        .payment-button {
            height: 70px;
            font-size: 20px
        }
    </style>
    <section>
        <div class="subscription-container-fluid">
            <div class="card-body">
                <div class="container mt-5 mb-5 d-flex justify-content-center">
                    <div class="card p-5">
                        <div>
                            <h4 class="heading">Upgrade your plan</h4>
                            <p class="text">Please make the payment to start enjoying all the features of our premium
                                plan as soon as possible</p>
                        </div>
                        <div class="pricing p-3 rounded mt-4 d-flex justify-content-between">
                            <div class="images d-flex flex-row align-items-center">
                                <div class="d-flex flex-column ml-4"> <span class="business">Small Business</span> <span
                                        class="plan">CHANGE PLAN</span> </div>
                            </div> <!--pricing table-->
                            <div class="d-flex flex-row align-items-center"> <sup class="dollar font-weight-bold">$</sup>
                                <span class="amount ml-1 mr-1">8,350</span>
                                <span class="year font-weight-bold">/ year</span>
                            </div> <!-- /pricing table-->
                        </div> <span class="detail mt-5">Payment method</span>
                        <div class="credit rounded mt-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-row align-items-center w-100"> <img src="/icons/stripe.svg"
                                    class="rounded" width="70">
                                <div class="d-flex flex-column w-100"><span class="business">Stripe</span></div>
                            </div>
                        </div>

                        <form role="form" action="{{ route('payment.process') }}" method="post"
                            class="require-validation" data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                            @csrf
                            <div class='form-row row'>
                                <div class='col-xs-12 col-md-6 form-group required'>
                                    <label class='control-label'>Name on Card</label>
                                    <input class='form-control' size='4' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-6 form-group required'>
                                    <label class='control-label'>Card Number</label>
                                    <input autocomplete='off' class='form-control card-number' size='20'
                                        type='text'>
                                </div>
                            </div>
                            <div class='form-row row'>
                                <div class='col-xs-12 col-md-4 form-group cvc required'>
                                    <label class='control-label'>CVC</label>
                                    <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311'
                                        size='4' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>Expiration Month</label>
                                    <input class='form-control card-expiry-month' placeholder='MM' size='2'
                                        type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>Expiration Year</label>
                                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                        type='text'>
                                </div>
                            </div>
                            <div class="mt-3"><button class="btn btn-primary btn-block payment-button w-100">Proceed to
                                    payment
                                    <i class="fa fa-long-arrow-right"></i></button> </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ env('STRIPE_SECRET') }}');
        var elements = stripe.elements();
    </script>
@endpush
