@extends('layout.app')
@section('title', __('payment_gateway'))
@section('content')
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="list-title">{{ __('money_transfers') }}</span>
                    <button class="btn common-btn" data-toggle="modal" data-target="#create-money-transfer-modal"><i
                            class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('send_money') }}</button>
                </div>
                <div class="card-body">
                    @foreach ($paymentGateways as $paymentGateway)
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">{{ __(lcfirst($paymentGateway->name)) }}</h2>
                            </div>
                            <form method="post" action="{{ route('payment-gateway.update', $paymentGateway->id) }}">
                                @csrf
                                @method('put')
                                <div class="card-body">
                                    <div class="row">
                                        @foreach (json_decode($paymentGateway->value) as $key => $credential)
                                            <div class="col-lg-12">
                                                <x-inputGroup type="text" name="{{ $key }}"
                                                    placeholder="{{ __('enter_your_' . $key) }}" value="{{ $credential }}"
                                                    title="{{ __($key) }}" :required="true"></x-inputGroup>
                                            </div>
                                        @endforeach
                                        <div class="col-lg-12">
                                            <x-select name="status" :required="true"
                                                title="{{ __('status') }}"
                                                placeholder="{{ __('select_a_option') }}">
                                                @foreach ($statuses as $status)
                                                    <option
                                                        {{ $paymentGateway->status->value == $status->value ? 'selected' : '' }}
                                                        value="{{ $status->value }}">{{ $status->value }}</option>
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit"class="btn common-btn">{{ __('submit') }}</button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
