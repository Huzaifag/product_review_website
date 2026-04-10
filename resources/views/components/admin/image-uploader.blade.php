@if ($version == 'v1')
    <div {{ $attributes->merge(['class' => 'attach-img p-4 border bg-light rounded-2']) }}>
        <h5 class="mb-3">{{ $label }}</h5>
        <img class="attach-img-preview border p-2 rounded-2 {{ $background }} {{ $src ? '' : 'd-none' }} {{ $upload ? 'mb-3' : '' }}"
            src="{{ $src }}" {{ $width ? 'width=' . $width : '' }} {{ $height ? 'height=' . $height : '' }}>
        @if ($upload)
            <input type="file" name="{{ $name }}" class="form-control form-control-md attach-img-input"
                accept="{{ $accept }}" @required($required)>
            <div class="form-text mt-2">
                {{ $description }}
            </div>
        @endif
    </div>
@elseif($version == 'v2')
    <div {{ $attributes->merge(['class' => 'attach-img drag-box bg-light']) }}>
        <img src="{{ $src }}"
            class="attach-img-preview {{ $background }}  {{ $src ? '' : 'd-none' }} {{ !$upload ? 'mb-0' : '' }}"
            {{ $width ? 'width=' . $width : '' }} {{ $height ? 'height=' . $height : '' }}>
        @if ($upload)
            <div class="attach-img-action">
                <input type="file" name="{{ $name }}" class="attach-img-input" accept="{{ $accept }}"
                    @required($required) hidden>
                <button type="button" class="btn btn-soft bg-white attach-img-button">
                    <i class="fa fa-camera me-2"></i>{{ $label }}
                </button>
                <p class="text-muted small mt-2 mb-0">
                    {{ $description }}
                </p>
            </div>
        @endif
    </div>
@endif
