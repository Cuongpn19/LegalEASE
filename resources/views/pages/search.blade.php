@extends('layouts.app')

@section('title', 'Search')

@section('content')
    <div class="content-box rounded-4">

        <h4 class="fw-bold text-primary mb-3">
            Search Results
        </h4>

        <p class="text-muted">
            Showing results for:
            <strong>{{ request('q') }}</strong>
        </p>

        <hr>

        {{-- KẾT QUẢ GIẢ --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="topic-title">Business Law</h5>
                <p class="topic-desc">
                    Corporate compliance, contracts, and legal risk management.
                </p>
                <a href="#" class="btn btn-sm btn-outline-primary">
                    Read more
                </a>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="topic-title">Family Law</h5>
                <p class="topic-desc">
                    Divorce, child custody, and family dispute resolution.
                </p>
                <a href="#" class="btn btn-sm btn-outline-primary">
                    Read more
                </a>
            </div>
        </div>

    </div>
@endsection
