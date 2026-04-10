@extends('themes.basic.business.layouts.app')
@section('container', 'dashboard-container-xl')
@section('title', d_trans('Integration'))
@section('header_title', d_trans('Integration'))
@section('breadcrumbs', Breadcrumbs::render('business.integration'))
@section('content')
    <div class="row g-3">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-body p-4">
                    <h5>{{ d_trans('Your business writing a review link') }}</h5>
                    <p>
                        {{ d_trans('Your customers can use it to write a review for your business. You can copy and share this URL to collect feedback and boost your credibility.') }}
                    </p>
                    <pre class="border rounded-2 mb-3"><code id="link" class="language-markup">{{ $currentBusiness->getWriteReviewLink() }}</code></pre>
                    <button class="btn btn-outline-primary btn-copy" data-clipboard-target="#link"><i
                            class="bi bi-copy me-2"></i>{{ d_trans('Copy to clipboard') }}</button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h4 class="mt-3">{{ d_trans('Ready made widgets') }}</h4>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="text-center border rounded-2 p-4 bg-custom mb-3">
                        <iframe src="{{ route('businesses.embed', hash_encode($currentBusiness->id)) }}" width="100%"
                            height="130" style="border:none; max-width: 300px; min-width: 300px; overflow:hidden;"
                            title="{{ d_trans(':website_name Widget', ['website_name' => m_trans(config('settings.general.site_name'))]) }}"
                            scrolling="no">
                        </iframe>
                    </div>
                    <pre class="border rounded-2 mb-3"><code id="v1" class="language-markup"><script type="prism-html-markup"><iframe loading="lazy" src="{{ route('businesses.embed', hash_encode($currentBusiness->id)) }}"
width="100%" height="130" style="border:none; max-width: 300px;
min-width: 300px; overflow:hidden;" title="{{ d_trans(':website_name Widget', ['website_name' => m_trans(config('settings.general.site_name'))]) }}" scrolling="no">
</iframe></script></code></pre>
                    <button class="btn btn-outline-primary btn-copy" data-clipboard-target="#v1"><i
                            class="bi bi-copy me-2"></i>{{ d_trans('Copy to clipboard') }}</button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-center border rounded-2 p-4 bg-custom mb-3">
                        <iframe loading="lazy"
                            src="{{ route('businesses.embed', [hash_encode($currentBusiness->id), 'v' => 2]) }}"
                            width="100%" height="130"
                            style="border:none; max-width: 320px; min-width: 320px; overflow:hidden;"
                            title="{{ d_trans(':website_name Widget', ['website_name' => m_trans(config('settings.general.site_name'))]) }}"
                            scrolling="no">
                        </iframe>
                    </div>
                    <pre class="border rounded-2 mb-3"><code id="v2" class="language-markup"><script type="prism-html-markup"><iframe loading="lazy" src="{{ route('businesses.embed', [hash_encode($currentBusiness->id), 'v' => 2]) }}"
width="100%" height="130" style="border:none; max-width: 320px; 
min-width: 320px; overflow:hidden;" title="{{ d_trans(':website_name Widget', ['website_name' => m_trans(config('settings.general.site_name'))]) }}" scrolling="no">
</iframe></script></code></pre>
                    <button class="btn btn-outline-primary btn-copy" data-clipboard-target="#v2"><i
                            class="bi bi-copy me-2"></i>{{ d_trans('Copy to clipboard') }}</button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-center border rounded-2 p-4 bg-custom mb-3">
                        <iframe loading="lazy"
                            src="{{ route('businesses.embed', [hash_encode($currentBusiness->id), 'v' => 3]) }}"
                            width="100%" height="310"
                            style="border:none; max-width: 320px; min-width: 320px; overflow:hidden;"
                            title="{{ d_trans(':website_name Widget', ['website_name' => m_trans(config('settings.general.site_name'))]) }}"
                            scrolling="no">
                        </iframe>
                    </div>
                    <pre class="border rounded-2 mb-3"><code id="v3" class="language-markup"><script type="prism-html-markup"><iframe loading="lazy" src="{{ route('businesses.embed', [hash_encode($currentBusiness->id), 'v' => 3]) }}"
width="100%" height="310" style="border:none; max-width: 320px; 
min-width: 320px; overflow:hidden;" title="{{ d_trans(':website_name Widget', ['website_name' => m_trans(config('settings.general.site_name'))]) }}" scrolling="no">
</iframe></script></code></pre>
                    <button class="btn btn-outline-primary btn-copy" data-clipboard-target="#v3"><i
                            class="bi bi-copy me-2"></i>{{ d_trans('Copy to clipboard') }}</button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-center border rounded-2 p-4 bg-custom mb-3">
                        <iframe loading="lazy"
                            src="{{ route('businesses.embed', [hash_encode($currentBusiness->id), 'v' => 4]) }}"
                            width="100%" height="310"
                            style="border:none; max-width: 320px; min-width: 320px; overflow:hidden;"
                            title="{{ d_trans(':website_name Widget', ['website_name' => m_trans(config('settings.general.site_name'))]) }}"
                            scrolling="no">
                        </iframe>
                    </div>
                    <pre class="border rounded-2 mb-3"><code id="v4" class="language-markup"><script type="prism-html-markup"><iframe loading="lazy" src="{{ route('businesses.embed', [hash_encode($currentBusiness->id), 'v' => 4]) }}"
width="100%" height="310" style="border:none; max-width: 320px; 
min-width: 320px; overflow:hidden;" title="{{ d_trans(':website_name Widget', ['website_name' => m_trans(config('settings.general.site_name'))]) }}" scrolling="no">
</iframe></script></code></pre>
                    <button class="btn btn-outline-primary btn-copy" data-clipboard-target="#v4"><i
                            class="bi bi-copy me-2"></i>{{ d_trans('Copy to clipboard') }}</button>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/prismjs/prism.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/prismjs/prism.min.js') }}"></script>
    @endpush
@endsection
