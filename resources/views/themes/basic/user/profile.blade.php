@extends('themes.basic.user.layout')
@section('title', d_trans(':username Profile', ['username' => ucfirst($user->getName())]))
@section('header_title', d_trans('My Plan'))
@section('breadcrumbs', Breadcrumbs::render('user.profile', $user))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'user.profile', $user))
@section('content')
    @if ($plan)
        @include('themes.basic.plans.usage', [
            'subscription' => $subscription,
            'plan' => $plan,
            'userProductViewCount' => $userProductViewCount,
            'productViewed' => $productViewed,
            'user' => $user,
        ])
    @else
        @include('themes.basic.partials.empty-box', [
            'empty_image' => 'v2',
            'title' => d_trans('No Active Plan'),
            'description' => d_trans(
                "You don't have an active plan yet. Upgrade your plan to access premium features."),
        ])
    @endif

    <div class="card mt-4">
        <div class="card-header fw-medium">{{ d_trans('My Subscriptions') }}</div>
        <div class="card-body p-4">
            @if ($subscriptions->isNotEmpty())
                <div class="row g-3">
                    @foreach ($subscriptions as $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <div class="fw-semibold">
                                            {{ $item->plan?->trans->name ?? d_trans('Plan') }}
                                        </div>
                                        <div class="text-muted small">
                                            {{ $item->plan ? $item->plan->getIntervalName() : d_trans('N/A') }}
                                        </div>
                                    </div>
                                    @if ($item->isExpired())
                                        <span class="badge bg-danger">{{ d_trans('Expired') }}</span>
                                    @elseif ($item->isAboutToExpire())
                                        <span class="badge bg-warning text-dark">{{ d_trans('About to expire') }}</span>
                                    @else
                                        <span class="badge bg-success">{{ d_trans('Active') }}</span>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="text-muted">{{ d_trans('Started') }}</span>
                                        <span>{{ $item->started_at ? dateFormat($item->started_at) : d_trans('N/A') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <span class="text-muted">{{ d_trans('Expires') }}</span>
                                        <span>
                                            @if ($item->plan && $item->plan->isLifetime())
                                                {{ d_trans('Lifetime') }}
                                            @else
                                                {{ $item->expiry_at ? dateFormat($item->expiry_at) : d_trans('N/A') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-muted">{{ d_trans('No subscriptions found') }}</div>
            @endif
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header fw-medium">{{ d_trans('All Plans') }}</div>
        <div class="card-body p-4">
            @if ($plans->isNotEmpty())
                <div class="row g-3">
                    @foreach ($plans as $planItem)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="border rounded-3 p-3 h-100 position-relative">
                                @if ($planItem->isFeatured())
                                    <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                        {{ d_trans('Popular') }}
                                    </span>
                                @endif
                                <div class="fw-semibold">{{ $planItem->trans->name }}</div>
                                <div class="text-muted small">{{ $planItem->getIntervalName() }}</div>
                                <div class="mt-3">
                                    <div class="d-flex align-items-end">
                                        <div class="h4 mb-0">{{ $planItem->getFormatPrice() }}</div>
                                        <div class="text-muted ms-1">/{{ strtolower($planItem->getIntervalName()) }}</div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="text-muted">{{ d_trans('Products') }}</span>
                                        <span>
                                            @if (is_null($planItem->products_limit))
                                                {{ d_trans('Unlimited') }}
                                            @else
                                                {{ $planItem->products_limit }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <span class="text-muted">{{ d_trans('Categories') }}</span>
                                        <span>{{ $planItem->hasCategoriesFeature() ? d_trans('Included') : d_trans('No') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <span class="text-muted">{{ d_trans('Employees') }}</span>
                                        <span>{{ $planItem->hasEmployeesFeature() ? d_trans('Included') : d_trans('No') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-muted">{{ d_trans('No plans available') }}</div>
            @endif
        </div>
    </div>
@endsection
