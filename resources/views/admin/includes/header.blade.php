<div class="mb-4">
    <div class="row g-3 align-items-center">
        <div class="col">
            <h3 class="mb-0 capitalize">@yield( d_trans('header_title') )</h3>
            @include('admin.partials.breadcrumb')
        </div>
        @hasSection('search')
            <div class="col-auto">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="form-search">
                        <input type="text" name="search" class="form-control form-control-md"
                            placeholder="{{ d_trans('Search...') }}" value="{{ request('search') }}">
                        <div class="icon">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </form>
            </div>
        @endif
        @hasSection('page_search')
            <div class="col-auto">
                <div class="form-search">
                    <input id="pageSearchInput" type="text" class="form-control form-control-md"
                        placeholder="{{ d_trans('Search...') }}">
                    <div class="icon">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </div>
        @endif
        @hasSection('back')
            <div class="col-auto">
                <a href="@yield('back')" class="btn btn-soft"><i
                        class="fas fa-arrow-left icon-rtl me-2"></i>{{ d_trans('Back') }}</a>
            </div>
        @endif
        @hasSection('create')
            <div class="col-auto">
                <a href="@yield('create')" class="btn btn-primary"><i class="fa fa-plus"></i></a>
            </div>
        @endif
        @hasSection('form')
            <div class="col-auto">
                <button form="submittedForm" class="btn btn-primary">{{ d_trans('Save') }}</button>
            </div>
        @endif
        @hasSection('upload')
            <div class="col-auto">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal"><i
                        class="fa-solid fa-arrow-up-from-bracket me-2"></i>{{ d_trans('Upload') }}</button>
            </div>
        @endif
        @if (request()->routeIs('admin.dashboard'))
            <div class="col-auto">
                <div class="dropdown">
                    <button class="btn quick-access-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-bolt-lightning me-2"></i>
                        {{ d_trans('Quick Access') }}
                    </button>
                    <ul class="dropdown-menu">
                        {{-- <li>
                            <a class="dropdown-item"
                                href="{{ route('admin.settings.themes.index') }}">{{ d_trans('Themes') }}</a>
                        </li> --}}
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('admin.settings.languages.index') }}">{{ d_trans('Languages') }}</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('admin.settings.mail-templates.index') }}">{{ d_trans('Mail Templates') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        @endif
        @if (request()->routeIs('admin.notifications.index'))
            @if ($notifications->count() > 0)
                <div class="col-auto">
                    <form action="{{ route('admin.notifications.read.all') }}" method="POST">
                        @csrf
                        <button class="action-confirm btn btn-outline-success">
                            <i class="fa-regular fa-bookmark"></i><span
                                class="d-none d-lg-inline ms-2">{{ d_trans('Make All as Read') }}</span>
                        </button>
                    </form>
                </div>
                <div class="col-auto">
                    <form action="{{ route('admin.notifications.delete.read') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="action-confirm btn btn-outline-danger">
                            <i class="fa-regular fa-trash-can"></i><span
                                class="d-none d-lg-inline ms-2">{{ d_trans('Delete All Read') }}</span>
                        </button>
                    </form>
                </div>
            @endif
        @endif
        @if (request()->routeIs('admin.businesses.index'))
            <div class="col-auto">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i
                        class="fa-solid fa-plus"></i></button>
            </div>
            <div class="col-auto">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal"><i
                        class="fa-solid fa-arrow-up-from-bracket me-2"></i>{{ d_trans('Bulk Upload') }}</button>
            </div>
        @endif
        @hasSection('business_view')
            @if ($business->isActive())
                <div class="col-auto">
                    <a href="{{ $business->getLink() }}" target="_blank" class="btn btn-secondary"><i
                            class="fas fa-external-link-alt me-2"></i>{{ d_trans('View Business') }}</a>
                </div>
            @endif
        @endif
        @if (request()->routeIs('admin.newsletter.subscribers.index'))
            @if ($hasSubscribers)
                <div class="col-auto">
                    <a href="{{ route('admin.newsletter.subscribers.sendmail') }}"
                        class="btn btn-outline-primary btn-md px-4"><i
                            class="far fa-paper-plane me-2"></i>{{ d_trans('Send Mail') }}</a>
                </div>
                <div class="col-auto">
                    <form action="{{ route('admin.newsletter.subscribers.export') }}" method="POST">
                        @csrf
                        <button class="btn btn-success btn-md px-4 action-confirm"><i
                                class="fa-solid fa-file-export me-2"></i>{{ d_trans('Export All') }}</button>
                    </form>
                </div>
            @endif
        @endif
        @if (request()->routeIs('admin.system.information.index'))
            <div class="col-auto">
                <a href="{{ config('system.author.profile') }}" target="_blank" class="btn btn-soft"><i
                        class="far fa-question-circle me-2"></i>{{ d_trans('Get Help') }}</a>
            </div>
        @endif
    </div>
</div>


<style>
    .quick-access-btn {
        position: relative;
        min-height: 44px;
        padding: 10px 18px;
        border: 0;
        border-radius: 999px;
        background: linear-gradient(135deg, #ffffff 0%, #fff5f5 100%);
        color: #991b1b;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 0.01em;
        box-shadow:
            0 12px 28px rgba(198, 40, 40, 0.16),
            inset 0 0 0 1px rgba(198, 40, 40, 0.14);
        transition: all 0.25s ease;
    }

    .quick-access-btn::before {
        content: "";
        position: absolute;
        inset: 2px;
        border-radius: inherit;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0));
        pointer-events: none;
    }

    .quick-access-btn:hover,
    .quick-access-btn:focus {
        color: #ffffff;
        background: linear-gradient(135deg, rgb(198, 40, 40), #991b1b);
        box-shadow:
            0 16px 34px rgba(198, 40, 40, 0.28),
            inset 0 0 0 1px rgba(255, 255, 255, 0.18);
        transform: translateY(-2px);
    }

    .quick-access-btn:active {
        transform: translateY(0) scale(0.98);
    }

    .quick-access-btn i {
        position: relative;
        z-index: 1;
    }

    .quick-access-btn.dropdown-toggle::after {
        position: relative;
        z-index: 1;
        margin-left: 10px;
        vertical-align: middle;
        border-top-color: currentColor;
    }

    .quick-access-btn {
        overflow: hidden;
    }

    .quick-access-btn * {
        position: relative;
        z-index: 1;
    }
</style>
