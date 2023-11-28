<div class="form-group">
    <label class="mb-2" for="{{ $name }}">{{ __($title) }} @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="input-group">
        <input type="{{ $type }}" id="{{ $name }}" class="form-control" value="{{ old($name) ?? $value }}"
            name="{{ $name }}" placeholder="{{ $placeholder }}">

        <div class="input-group-append">
            <button id="genbutton" type="button" class="btn btn-sm common-btn py-2" title="{{ __('Generate') }}"><i
                    class="fa fa-refresh"></i></button>
        </div>
    </div>
    @error($name)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
