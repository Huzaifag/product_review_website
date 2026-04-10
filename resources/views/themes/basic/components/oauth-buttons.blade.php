@if ($oauthProviders->count() > 0)
    <div class="login-with mt-3">
        <div class="login-with-divider">
            <span>{{ d_trans('Or With') }}</span>
        </div>
        <div class="row row-cols-1 row-cols-sm-{{ $oauthProviders->count() > 1 ? 2 : 1 }} g-3">
            @foreach ($oauthProviders as $oauthProvider)
                <div class="col">
                    <a href="{{ route('oauth.login', [$oauthProvider->alias, $guard]) }}"
                        class="btn btn-social btn-md w-100 text-center">
                        <img src="{{ asset($oauthProvider->logo) }}">
                        {{ d_trans($oauthProvider->name) }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
