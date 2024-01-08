@extends('layout.app')
@section('title', __('new_user'))
@section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between card-header-color">
                            <span class="list-title text-white">{{ __('new_user') }}</span>
                            <a href="{{ route('user.index') }}" class="btn common-btn"><i class="fa fa-chevron-left "></i>
                                {{ __('back') }}</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">{{ __('name') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="{{ __('enter_your_user_name') }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">{{ __('password') }} <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group mb-3">
                                                <input type="text" id="getPass" class="form-control"
                                                    placeholder="{{ __('enter_your_user_password') }}" name="password">
                                                @error('password')
                                                    <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                                <div class="input-group-append">
                                                    <button class="btn common-btn" type="button"
                                                        id="generatePass">{{ __('qenerate') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">{{ __('email_address') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email"
                                                placeholder="{{ __('enter_your_user_email_address') }}"
                                                class="form-control">
                                            @error('email')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">{{ __('role') }} <span
                                                    class="text-danger">*</span></label>
                                            <select name="role_name" class="form-control">
                                                <option selected disabled>{{ __('select_a_option') }}
                                                </option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}
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
                                        <div class="form-group mb-3">
                                            <label class="mb-2">{{ __('phone_number') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control"
                                                placeholder="{{ __('enter_your_user_phone_number') }}">
                                            @error('phone')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn common-btn">{{ __('submit') }}</button>
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
@push('scripts')
    <script>
        $(document).on("click", '#generatePass', function() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('generate.password') }}",
                success: function(res) {
                    if (res) {
                        $("#getPass").val(res);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: "Something is wrong"
                        })
                    }

                }
            });
        });
    </script>
@endpush
