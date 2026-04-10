@if ($popularSearches->count() > 0)
    <div class="mt-5 text-center">
        <h4 class="mb-4">{{ d_trans('Popular searches') }}</h4>
        <div class="tags justify-content-center row g-3">
            @foreach ($popularSearches as $popularSearch)
                <div class="col-auto">
                    <a href="{{ $popularSearch->getLink(request()->all()) }}">
                        <div class="tag tag-primary"><i class="fa fa-search me-2"></i>{{ $popularSearch->trans->name }}
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
