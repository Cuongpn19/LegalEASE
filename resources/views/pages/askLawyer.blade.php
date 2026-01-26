@extends('layouts.app')

@section('title', 'Ask a Lawyer')

@section('content')
    <div class="container py-4">
        <div class="content-box mx-auto" style="max-width: 900px">

            {{-- Header --}}
            <div class="mb-4">
                <h3 class="fw-bold text-primary mb-1">Ask a Lawyer</h3>
                <p class="text-muted mb-0">
                    Browse legal questions or ask your own to receive guidance from qualified lawyers.
                </p>
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('ask.lawyer') }}" class="row g-2 mb-4">
                <div class="col-md-9">
                    <input type="text" name="keyword" class="form-control form-control-lg"
                        placeholder="Search by question title or keywords..." value="{{ request('keyword') }}">
                </div>

                <div class="col-md-3 d-grid gap-2">
                    <button class="btn btn-primary btn-lg">
                        🔍 Search
                    </button>
                    <a href="{{ route('ask.lawyer') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>

            {{-- Ask CTA --}}
            @guest
                <div class="alert alert-info d-flex justify-content-between align-items-center">
                    <span>You need to login to ask a legal question.</span>
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
                        Login
                    </a>
                </div>
            @else
                <div class="text-end mb-3">
                    <a href="{{ route('questions.create') }}" class="btn btn-success">
                        ➕ Ask a Question
                    </a>
                </div>
            @endguest

            {{-- Question list --}}
            @forelse ($updates as $item)
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-2">
                            {{ $item->title }}
                        </h5>

                        <p class="text-muted mb-3">

                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Asked on
                            </small>

                            <a href="{{ route('ask.lawyer.show', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                View details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">
                    <p class="mb-1">No legal questions found.</p>
                    <small>Try searching with different keywords.</small>
                </div>
            @endforelse

            {{-- Pagination --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $updates->links() }}
            </div>

        </div>
    </div>
@endsection
