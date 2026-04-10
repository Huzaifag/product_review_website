@include('themes.basic.business.partials.alerts')
<div class="mb-3">
    <div class="row g-3 align-items-center">
        <div class="col">
            <h3>@yield('header_title')</h3>
            @yield('breadcrumbs')
        </div>
        @hasSection('back')
            <div class="col-auto">
                <a href="@yield('back')" class="btn btn-soft btn-md"> <i
                        class="fa-solid fa-arrow-left icon-rtl me-2"></i>{{ d_trans('Back') }}</a>
            </div>
        @endif
        @hasSection('form')
            <div class="col-auto">
                <button form="submittedForm" class="btn btn-primary btn-md">{{ d_trans('Save') }}</button>
            </div>
        @endif
        @hasSection('add_modal')
            <div class="col-auto">
                <button class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#addModal"><i
                        class="fa fa-plus"></i></button>
            </div>
        @endif
        @if (request()->routeIs('business.subscription.transactions.show'))
            @if (isset($trx) && $trx->isPaid())
                <div class="col-auto">
                    <a href="{{ route('business.subscription.transactions.invoice', $trx->id) }}" target="_blank"
                        class="btn btn-primary btn-md">
                        <i class="fa-regular fa-file-lines me-2"></i>{{ d_trans('Invoice') }}
                    </a>
                </div>
            @endif
        @endif
        @if (request()->routeIs('business.reviews.index'))
            <div class="col-auto">
                <div class="row g-3 row-cols-auto">
                    <div class="col">
                        <select name="status" class="form-select form-select-md search-select">
                            <option value="" selected disabled>{{ d_trans('Status') }}</option>
                            <option value="all" @selected(request('status') == 'all')>{{ d_trans('All') }}</option>
                            <option value="replied" @selected(request('status') == 'replied')>{{ d_trans('Replied') }}</option>
                            <option value="not_replied" @selected(request('status') == 'not_replied')>{{ d_trans('Not replied') }}
                            </option>
                        </select>
                    </div>
                    <div class="col">
                        <select name="sort" class="form-select form-select-md search-select">
                            <option value="" selected disabled>{{ d_trans('Sort') }}</option>
                            <option value="all" @selected(request('sort') == 'all')>{{ d_trans('All') }}</option>
                            <option value="recent" @selected(request('sort') == 'recent')>{{ d_trans('Recent Reviews') }}
                            </option>
                            <option value="oldest" @selected(request('sort') == 'oldest')>{{ d_trans('Oldest Reviews') }}
                            </option>
                        </select>
                    </div>
                    @if (collect(request()->query())->except('page')->count() > 0)
                        <div class="col">
                            <a href="{{ url()->current() }}" class="btn btn-outline-primary btn-md w-100">
                                <i class="bi bi-arrow-repeat"></i><span
                                    class="ms-2 d-none d-lg-inline">{{ d_trans('Reset All') }}</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if (request()->routeIs('business.notifications.index'))
            @if ($notifications->count() > 0)
                <div class="col-auto">
                    <form action="{{ route('business.notifications.read.all') }}" method="POST">
                        @csrf
                        <button class="action-confirm btn btn-outline-success btn-md">
                            <i class="fa-regular fa-bookmark"></i><span
                                class="d-none d-lg-inline ms-2">{{ d_trans('Make All as Read') }}</span>
                        </button>
                    </form>
                </div>
                <div class="col-auto">
                    <form action="{{ route('business.notifications.delete.read') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="action-confirm btn btn-outline-danger btn-md">
                            <i class="fa-regular fa-trash-can"></i><span
                                class="d-none d-lg-inline ms-2">{{ d_trans('Delete All Read') }}</span>
                        </button>
                    </form>
                </div>
            @endif
        @endif
    </div>
</div>
