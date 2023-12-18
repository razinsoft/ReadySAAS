@extends('layout.app')
@section('title', __('shops'))
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #29aae1;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #29aae1;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
@section('content')
    <section>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span class="list-title">{{ __('shops') }}</span>
                <div>
                    <a href="{{ route('shop.create') }}" class="btn common-btn"><i
                            class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('add_shop_category') }}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover dataTable" style="width: 100%">
                        <thead class="table-bg-color">
                            <tr>
                                <th>{{ __('sl') }}</th>
                                <th>{{ __('name') }}</th>
                                <th>{{ __('shop_owner') }}</th>
                                <th>{{ __('shop_category') }}</th>
                                <th>{{ __('status') }}</th>
                                <th class="not-exported">{{ __('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shops as $shop)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $shop->name }}</td>
                                    <td>{{ $shop->user->name }}</td>
                                    <td>{{ $shop->shopCategory->name }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="shopStatus" data-id="{{ $shop->id }}"
                                                {{ $shop->status->value == 'Active' ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn common-btn py-0 px-1" href="#" role="button"
                                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="">
                                                <a href="#" class="dropdown-item" data-toggle="modal"
                                                    data-target="#edit_shop_{{ $shop->id }}"><i
                                                        class="fa fa-edit text-info"></i>&nbsp;&nbsp;
                                                    {{ __('edit') }}</a>
                                            </div>
                                        </div>
                                        <div id="edit_shop_{{ $shop->id }}" tabindex="-1" data-backdrop="static"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                                            class="modal fade text-left">
                                            <div role="document" class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('shop.update', $shop->id) }}" method="POST">
                                                        @method('put')
                                                        @csrf
                                                        <div class="modal-header card-header-color">
                                                            <span id="exampleModalLabel"
                                                                class="list-title modal-title text-white">{{ __('edit_shop') }}</span>
                                                            <button type="button" data-dismiss="modal" aria-label="Close"
                                                                class="close"><span aria-hidden="true"><i
                                                                        class="fa fa-times text-white"></i></span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-2">
                                                                    <x-input name="title" title="{{ __('name') }}"
                                                                        type="text" :required="true"
                                                                        value="{{ $shop->name }}"
                                                                        placeholder="{{ __('enter_your_shop_name') }}" />
                                                                </div>
                                                                <div class="col-md-12 mb-2">
                                                                    <x-select name="shop_category_id"
                                                                        title="{{ __('shop_category') }}"
                                                                        placeholder="{{ __('select_a_option') }}"
                                                                        :required="false">
                                                                        @foreach ($shopCategories as $shopCategory)
                                                                            <option value="{{ $shopCategory->id }}"
                                                                                {{ $shop->shop_category_id == $shopCategory->id ? 'selected' : '' }}>
                                                                                {{ $shopCategory->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </x-select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ __('close') }}</button>
                                                            <button type="submit"
                                                                class="btn common-btn">{{ __('update_and_Save') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
