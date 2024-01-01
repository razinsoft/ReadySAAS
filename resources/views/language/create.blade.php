@extends('layout.app')
@section('content')
    <div class="container-fluid my-4">
        <div class="row">
            <div class="col-lg-7 mt-2 mx-auto ">
                <form action="{{ route('language.store') }}" method="POST">
                    @csrf
                    <div class="card border-0 shadow-sm">
                        <div class="card-header">
                            <h3 class="m-0">{{ __('Create_new_Language') }}</h3>
                        </div>
                        <div class="card-body">
                            <div>
                                <x-input type="text" name="title" placeholder="{{ __('Enter') . ' ' . __('Title') }}"
                                    title="Title" value="" />
                            </div>
                            <div class="mt-3">
                                <label class="mb-0">{{ __('short_name') }} <small>(only allow English
                                        characters)</small></label>
                                <input name="name" oninput="this.value=this.value.replace(/[^a-z]/gi,'')"
                                    class="form-control" placeholder="Exm: bn" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between flex-wrap gap-2 ">
                            <a href="{{ route('language.index') }}" class="btn btn-danger">{{ __('Back') }}</a>
                            <button type="submit" class="btn common-btn">{{ __('submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
