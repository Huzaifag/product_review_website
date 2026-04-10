@if ($code)
    @if ($alias != 'head_code')
        <div {{ $attributes }}>
            <div class="d-flex justify-content-center">
                {!! $code !!}
            </div>
        </div>
    @else
        {!! $code !!}
    @endif
@endif
