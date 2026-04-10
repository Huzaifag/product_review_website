@extends('themes.basic.business.layouts.app')
@section('container', 'dashboard-container-lg')
@section('title', d_trans('Pricing plans'))
@section('content')
    @if ($countPlans > 0)
        @php
            $plans = [
                [
                    'count' => $weeklyPlans->count(),
                    'id' => 'week-tab',
                    'target' => '#pills-week',
                    'label' => 'Weekly',
                ],
                [
                    'count' => $monthlyPlans->count(),
                    'id' => 'month-tab',
                    'target' => '#pills-month',
                    'label' => 'Monthly',
                ],
                [
                    'count' => $yearlyPlans->count(),
                    'id' => 'year-tab',
                    'target' => '#pills-year',
                    'label' => 'Yearly',
                ],
                [
                    'count' => $lifetimePlans->count(),
                    'id' => 'lifetime-tab',
                    'target' => '#pills-lifetime',
                    'label' => 'Lifetime',
                ],
            ];

            $availablePlans = array_filter($plans, function ($plan) {
                return $plan['count'] > 0;
            });

            $activePlan = $availablePlans ? reset($availablePlans) : null;
            $showSwitcher = count($availablePlans) > 1;
        @endphp
        <div class="plans">
            <h2 class="text-center mb-4">{{ d_trans('Choose your plan') }}</h2>
            @if ($showSwitcher)
                <div class="plan-switcher" role="tablist">
                    @foreach ($plans as $plan)
                        @if ($plan['count'] > 0)
                            <button class="btn {{ $activePlan && $activePlan['id'] === $plan['id'] ? 'active' : '' }}"
                                id="{{ $plan['id'] }}" data-bs-toggle="tab" data-bs-target="{{ $plan['target'] }}"
                                type="button" role="tab">
                                <span> {{ d_trans($plan['label']) }}</span>
                            </button>
                        @endif
                    @endforeach
                </div>
            @endif
            @php
                $firstAvailableTab = null;
                if ($weeklyPlans->count() > 0) {
                    $firstAvailableTab = 'pills-week';
                } elseif ($monthlyPlans->count() > 0) {
                    $firstAvailableTab = 'pills-month';
                } elseif ($yearlyPlans->count() > 0) {
                    $firstAvailableTab = 'pills-year';
                } elseif ($lifetimePlans->count() > 0) {
                    $firstAvailableTab = 'pills-lifetime';
                }
            @endphp
            <div class="tab-content">
                @if ($weeklyPlans->count() > 0)
                    <div class="tab-pane fade {{ $firstAvailableTab === 'pills-week' ? 'show active' : '' }}"
                        id="pills-week" role="tabpanel" tabindex="0">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3 justify-content-center g-3">
                            @foreach ($weeklyPlans as $plan)
                                <div class="col">
                                    @include('themes.basic.business.partials.plan', ['plan' => $plan])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($monthlyPlans->count() > 0)
                    <div class="tab-pane fade {{ $firstAvailableTab === 'pills-month' ? 'show active' : '' }}"
                        id="pills-month" role="tabpanel" tabindex="0">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3 justify-content-center g-3">
                            @foreach ($monthlyPlans as $plan)
                                <div class="col">
                                    @include('themes.basic.business.partials.plan', ['plan' => $plan])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($yearlyPlans->count() > 0)
                    <div class="tab-pane fade {{ $firstAvailableTab === 'pills-year' ? 'show active' : '' }}"
                        id="pills-year" role="tabpanel" tabindex="0">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3 justify-content-center g-3">
                            @foreach ($yearlyPlans as $plan)
                                <div class="col">
                                    @include('themes.basic.business.partials.plan', ['plan' => $plan])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($lifetimePlans->count() > 0)
                    <div class="tab-pane fade {{ $firstAvailableTab === 'pills-lifetime' ? 'show active' : '' }}"
                        id="pills-lifetime" role="tabpanel" tabindex="0">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3 justify-content-center g-3">
                            @foreach ($lifetimePlans as $plan)
                                <div class="col">
                                    @include('themes.basic.business.partials.plan', ['plan' => $plan])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
