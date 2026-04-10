<div class="row row-cols-auto align-items-center justify-content-between mb-3 g-2">
    <div class="col">
        <p class="text-muted mb-0">{{ $grid_title }}</p>
    </div>
    <div class="col">
        <div class="row row-cols-auto g-2">
            @if (!isset($hide_grid_buttons) || $hide_grid_buttons == false)
                <div class="col d-none d-md-block">
                    <div class="d-flex justify-content-end gap-2">
                        <button id="itemsGrid" class="btn btn-soft" disabled>
                            <i class="bi bi-grid-3x2-gap fa-lg"></i>
                        </button>
                        <button id="itemsList" class="btn btn-soft">
                            <i class="bi bi-list-task fa-lg"></i>
                        </button>
                    </div>
                </div>
            @endif
            <div class="col d-block d-lg-none">
                <button class="btn btn-soft" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"
                    aria-controls="offcanvas">
                    <i class="bi bi-funnel fa-lg"></i><span
                        class="d-inline d-lg-none ms-2">{{ d_trans('Filters') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>
