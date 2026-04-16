@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Ingredient Library'))
@section('title', d_trans('Ingredient Library'))
@section('header_title', $ingredient->name)
@section('back', route('admin.ingredients-library.index'))
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <div class="row g-4">
                <!-- Name -->
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold">{{ d_trans('Name') }}</label>
                    <p class="text-muted">{{ $ingredient->name }}</p>
                </div>

                <!-- INCI Name -->
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold">{{ d_trans('INCI Name') }}</label>
                    <p class="text-muted">{{ $ingredient->inci_name ?? d_trans('Not provided') }}</p>
                </div>

                <!-- CAS Number -->
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold">{{ d_trans('CAS Number') }}</label>
                    <p class="text-muted">{{ $ingredient->cas_number ?? d_trans('Not provided') }}</p>
                </div>

                <!-- Severity -->
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold">{{ d_trans('Severity') }}</label>
                    <p>
                        @if ($ingredient->severity)
                            @if ($ingredient->severity === 'avoid')
                                <span class="badge bg-danger">{{ d_trans(ucfirst($ingredient->severity)) }}</span>
                            @elseif ($ingredient->severity === 'concern')
                                <span class="badge bg-warning">{{ d_trans(ucfirst($ingredient->severity)) }}</span>
                            @else
                                <span class="badge bg-info">{{ d_trans(ucfirst($ingredient->severity)) }}</span>
                            @endif
                        @else
                            <span class="text-muted">{{ d_trans('Not provided') }}</span>
                        @endif
                    </p>
                </div>

                <!-- Concern Description -->
                <div class="col-12">
                    <label class="form-label fw-bold">{{ d_trans('Concern Description') }}</label>
                    <p class="text-muted">{{ $ingredient->concern_description ?? d_trans('Not provided') }}</p>
                </div>

                <!-- Health Effects -->
                <div class="col-12">
                    <label class="form-label fw-bold">{{ d_trans('Health Effects') }}</label>
                    <p class="text-muted">{{ $ingredient->health_effects ?? d_trans('Not provided') }}</p>
                </div>

                <!-- Regulatory Status -->
                <div class="col-12">
                    <label class="form-label fw-bold">{{ d_trans('Regulatory Status') }}</label>
                    <p class="text-muted">{{ $ingredient->regulatory_status ?? d_trans('Not provided') }}</p>
                </div>

                <!-- Published Status -->
                <div class="col-12">
                    <label class="form-label fw-bold">{{ d_trans('Status') }}</label>
                    <p>
                        @if ($ingredient->is_published)
                            <span class="badge bg-success">{{ d_trans('Published') }}</span>
                        @else
                            <span class="badge bg-secondary">{{ d_trans('Draft') }}</span>
                        @endif
                    </p>
                </div>

                <!-- Created Date -->
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold">{{ d_trans('Created Date') }}</label>
                    <p class="text-muted">{{ $ingredient->created_at->format('d M Y H:i') }}</p>
                </div>

                <!-- Updated Date -->
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold">{{ d_trans('Updated Date') }}</label>
                    <p class="text-muted">{{ $ingredient->updated_at->format('d M Y H:i') }}</p>
                </div>

                <!-- Found In Count -->
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold">{{ d_trans('Found In Products') }}</label>
                    <p class="text-muted">{{ $ingredient->found_in_count ?? 0 }}</p>
                </div>

                <div class="col-12">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.ingredients-library.edit', $ingredient->id) }}" class="btn btn-primary">
                            {{ d_trans('Edit') }}
                        </a>
                        <form action="{{ route('admin.ingredients-library.destroy', $ingredient->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('{{ d_trans('Are you sure?') }}')">
                                {{ d_trans('Delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
