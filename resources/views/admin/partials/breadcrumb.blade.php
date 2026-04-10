<nav class="mt-2" aria-label="breadcrumb">
    <ol class="breadcrumb custom mb-0">
        <?php $segments = ''; ?>
        @foreach (request()->segments() as $segment)
            <?php $segments .= '/' . $segment; ?>
            <li class="breadcrumb-item @if (request()->segment(count(request()->segments())) == $segment) active @endif">
                @php
                    $sg = !is_numeric($segment) ? d_trans(str_replace(['-', '_'], ' ', $segment)) : $segment;
                    $pageExists = urlExists(url($segments)) !== false;
                @endphp
                @if (request()->segment(count(request()->segments())) != $segment)
                    @if ($pageExists)
                        <a href="{{ url($segments) }}">
                            {{ $sg }}
                        </a>
                    @else
                        {{ $sg }}
                    @endif
                @else
                    {{ $sg }}
                @endif
            </li>
        @endforeach
    </ol>
</nav>
