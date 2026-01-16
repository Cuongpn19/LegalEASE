@extends('layouts.client')

@section('main')
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm p-3 mb-4 sticky-top" style="top: 90px; border-radius: 15px;">
                    <h5 class="fw-bold mb-3"><i class="fas fa-filter me-2 text-primary"></i>Filters</h5>

                    <form action="{{ route('client.lawyers.index') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Lawyer Name</label>
                            <input type="text" name="search" class="form-control form-control-sm border-0 bg-light"
                                placeholder="Search name..." value="{{ request('search') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Specialty</label>
                            <select name="specialization" class="form-select form-select-sm border-0 bg-light">
                                <option value="">All Specialties</option>
                                @foreach ($specializations as $item)
                                    <option value="{{ $item }}"
                                        {{ request('specialization') == $item ? 'selected' : '' }}>
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Location</label>
                            <select name="location" class="form-select form-select-sm border-0 bg-light">
                                <option value="">All Locations</option>
                                @foreach ($locations as $loc)
                                    <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>
                                        {{ $loc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-primary w-100 fw-bold rounded-3">Apply Filters</button>
                        <a href="{{ route('client.lawyers.index') }}"
                            class="btn btn-link btn-sm w-100 mt-2 text-decoration-none text-muted">Reset</a>
                    </form>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row g-4">
                    @forelse($lawyers as $lawyer)
                        <div class="col-md-6 col-xl-4">
                            <div class="card h-100 border-0 shadow-sm lawyer-card border-bottom border-primary border-3">
                                <div class="card-body p-4 text-center">
                                    <div class="avatar-lg bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                        style="width: 80px; height: 80px;">
                                        <i class="fas fa-user-tie fa-3x text-secondary"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1">{{ $lawyer->name }}</h5>
                                    <p class="text-primary small mb-3 fw-medium">
                                        <i class="fas fa-certificate me-1"></i>
                                        {{ $lawyer->lawyerProfile->specialization ?? 'General Lawyer' }}
                                    </p>
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                                        {{ $lawyer->lawyerProfile->location ?? 'N/A' }}
                                    </p>
                                    <div class="d-flex justify-content-between mb-3 bg-light p-2 rounded-3 small">
                                        <span><i class="fas fa-star text-warning">
                                                {{ $lawyer->lawyerProfile->rating ?? '4.8' }}</i></span>
                                        <span><i class="fas fa-briefcase text-muted">
                                                {{ $lawyer->lawyerProfile->experience_years ?? '5+ Years' }}</i>+
                                            years</span>
                                    </div>
                                    <a href="{{ route('client.lawyers.book', $lawyer->id) }}"
                                        class="btn btn-outline-primary w-100 rounded-pill fw-bold">View
                                        Profile</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <img src="https://illustrations.popsy.co/white/search-not-found.svg" style="height: 200px;"
                                alt="">
                            <h5 class="mt-4 text-muted">No lawyers found matching your criteria.</h5>
                        </div>
                    @endforelse
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $lawyers->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .lawyer-card {
            transition: transform 0.3s ease, shadow 0.3s ease;
        }

        .lawyer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection
