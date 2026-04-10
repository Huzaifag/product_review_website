<div class="mb-4">
    <div class="row g-3 align-items-center">
        <div class="col">
            <h3 class="mb-0 capitalize">@yield('header_title')</h3>
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
                    <button class="btn btn-soft dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ d_trans('Quick Access') }}
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('admin.settings.themes.index') }}">{{ d_trans('Themes') }}</a>
                        </li>
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
