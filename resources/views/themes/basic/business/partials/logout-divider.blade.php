<div class="login-with mt-3">
    <div class="login-with-divider">
        <span>{{ d_trans('Or') }}</span>
    </div>
    <form action="{{ route('business.logout') }}" method="POST">
        @csrf
        <button class="btn btn-outline-secondary btn-md w-100">{{ d_trans('Logout') }}</button>
    </form>
</div>
