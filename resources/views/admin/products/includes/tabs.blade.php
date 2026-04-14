<div class="dashboard-tabs mb-3">
    <a href="{{ route('admin.products.show', $product->id) }}"
        class="dashboard-tabs-item fs-6 {{ request()->routeIs('admin.products.show') ? 'current' : '' }}">
        {{ d_trans('Details') }}
    </a>
    <a href="{{ route('admin.products.edit', $product->id) }}"
        class="dashboard-tabs-item fs-6 {{ request()->routeIs('admin.products.edit') ? 'current' : '' }}">
        {{ d_trans('Edit') }}
    </a>
    <a href="{{ route('admin.products.lab-tests', $product->id) }}"
        class="dashboard-tabs-item fs-6 {{ request()->routeIs('admin.products.lab-tests*') ? 'current' : '' }}">
        {{ d_trans('Lab Tests') }}
    </a>
</div>
