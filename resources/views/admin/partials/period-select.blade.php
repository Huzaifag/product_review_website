@php
    $select_dates = generateMonthRangeFromDate($select_date);
@endphp
<div class="custom-select">
    <div class="custom-select-icon">
        <i class="fa fa-calendar-alt"></i>
    </div>
    <select class="form-select {{ $select_classes ?? '' }} period-select w-auto">
        @foreach ($select_dates as $select_date)
            <option value="{{ url()->current() . '?' . $select_key . '=' . $select_date['key'] }}"
                @selected(request($select_key) == $select_date['key'])>
                {{ $select_date['value'] }}
            </option>
        @endforeach
    </select>
</div>
