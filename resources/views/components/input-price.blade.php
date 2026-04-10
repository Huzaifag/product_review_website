@props([
    'label' => null,
    'size' => '',
    'id' => null,
    'name' => null,
    'value' => null,
    'integer' => false,
    'min' => null,
    'max' => null,
    'disabled' => false,
    'required' => false,
])

@if ($label)
    <label class="form-label">{{ $label }}</label>
@endif
<div class="input-group {{ $size ? 'input-group-' . $size : '' }}">
    @if (config('settings.currency.position') == \App\Models\Setting::CURRENCY_BEFORE_PRICE)
        <span class="input-group-text bg-white">{{ config('settings.currency.code') }}</span>
    @endif
    <input {{ $id ? "id=$id" : '' }} type="{{ $integer ? 'number' : 'text' }}" {{ $name ? "name=$name" : '' }}
        class="form-control {{ $size ? 'form-control-' . $size : '' }} {{ !$integer ? 'input-price' : '' }}"
        placeholder="0" value="{{ $value ?? ($name ? old($name) : '') }}" step="any" {{ $min ? "min=$min" : '' }}
        {{ $max ? "max=$max" : '' }} @disabled($disabled) @required($required)>
    @if (config('settings.currency.position') == \App\Models\Setting::CURRENCY_AFTER_PRICE)
        <span class="input-group-text bg-white">{{ config('settings.currency.code') }}</span>
    @endif
</div>
