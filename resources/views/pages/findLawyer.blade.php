@extends('layouts.app')

@section('title', 'Find a Lawyer')

@section('content')
    <div class="content-box">
        <h3 class="fw-bold text-primary mb-3">Find a Lawyer</h3>
        <p class="text-muted">
            Search and connect with qualified lawyers by practice area and location.
        </p>

        {{-- Search form --}}
        <form method="GET" action="{{ route('find.lawyer') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="keyword" class="form-control" placeholder="Lawyer name or keyword"
                    value="{{ request('keyword') }}">
            </div>

            <div class="col-md-4">
                <select name="specialization" class="form-select">
                    <option value="">All Specializations</option>
                    @if (isset($specializations))
                        @foreach ($specializations as $spec)
                            <option value="{{ $spec->id }}"
                                {{ request('specialization') == $spec->id ? 'selected' : '' }}>
                                {{ $spec->name }}
                            </option>
                        @endforeach
                    @endif

                </select>
            </div>

            <div class="col-md-3">
                <input type="text" name="location" class="form-control" placeholder="Location"
                    value="{{ request('location') }}">
            </div>

            <div class="col-md-2 d-grid gap-2">
                <button class="btn btn-primary" type="submit">Search</button>
                <a href="{{ route('find.lawyer') }}" class="btn btn-outline-secondary">
                    Reset
                </a>
            </div>
        </form>

        {{-- Lawyer list --}}
        @forelse ($lawyers as $lawyer)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ optional($lawyer->user)->name ?? 'Updating' }}
                    </h5>
                    <p class="text-muted mb-1">
                        {{ $lawyer->specializations?->pluck('name')->join(', ') ?? 'Updating' }}
                    </p>
                    <p class="text-muted small">
                        📍 {{ $lawyer->location ?? 'Updating' }}
                    </p>

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                            Login to view details
                        </a>
                    @endguest
                </div>
            </div>
        @empty
            <p class="text-muted">No lawyers found.</p>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $lawyers->links() }}
        </div>
    </div>
@endsection
