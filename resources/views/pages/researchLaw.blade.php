@extends('layouts.app')

@section('title', 'Research the Law')

@section('content')
    <div class="container py-5">

        {{-- Header --}}
        <div class="text-center mb-5">
            <h1 class="fw-bold">Research the Law</h1>
            <p class="text-muted fs-5">
                Find laws, legal information, and legal resources.
            </p>
        </div>

        {{-- Search box (UI only) --}}
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="input-group input-group-lg shadow-sm">
                    <input type="text" class="form-control" placeholder="Search statutes, cases, legal topics...">
                    <button class="btn btn-primary">
                        🔍 Search
                    </button>
                </div>
            </div>
        </div>

        {{-- Categories --}}
        <div class="row g-4">

            {{-- Card --}}
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Statutes & Codes</h5>
                        <p class="text-muted">
                            Browse laws and statutes organized by jurisdiction and topic.
                        </p>
                        <ul class="list-unstyled">
                            <li>• Criminal Law</li>
                            <li>• Civil Law</li>
                            <li>• Business Law</li>
                            <li>• Family Law</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Card --}}
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Case Law</h5>
                        <p class="text-muted">
                            Research court decisions from federal and state courts.
                        </p>
                        <ul class="list-unstyled">
                            <li>• Supreme Court</li>
                            <li>• Appellate Courts</li>
                            <li>• District Courts</li>
                            <li>• Landmark Cases</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Card --}}
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Legal Topics</h5>
                        <p class="text-muted">
                            Learn about common legal issues and how the law applies.
                        </p>
                        <ul class="list-unstyled">
                            <li>• Personal Injury</li>
                            <li>• Immigration</li>
                            <li>• Employment Law</li>
                            <li>• Real Estate</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        {{-- Popular Topics --}}
        <div class="mt-5">
            <h4 class="fw-bold mb-3">Popular Legal Topics</h4>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-light text-dark border">Divorce</span>
                <span class="badge bg-light text-dark border">DUI</span>
                <span class="badge bg-light text-dark border">Bankruptcy</span>
                <span class="badge bg-light text-dark border">Tenant Rights</span>
                <span class="badge bg-light text-dark border">Workplace Discrimination</span>
            </div>
        </div>

    </div>
@endsection
