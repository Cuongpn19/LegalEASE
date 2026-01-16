@extends('layouts.client')

@section('title', $lawyer->name)

@section('main')
    <div class="container py-4">

        {{-- PROFILE CARD --}}
        <div class="card border-0 shadow-sm mb-4 border-bottom border-primary border-3">
            <div class="card-body p-4">

                <div class="row align-items-center">
                    <div class="col-md-3 text-center mb-3 mb-md-0">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto"
                            style="width:100px;height:100px;">
                            <i class="fas fa-user-tie fa-3x text-secondary"></i>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <h3 class="fw-bold mb-1">{{ $lawyer->name }}</h3>

                        <div class="text-primary fw-medium mb-2">
                            <i class="fas fa-certificate me-1"></i>
                            {{ $lawyer->lawyerProfile->specialization ?? 'General Lawyer' }}
                        </div>

                        <div class="small text-muted mb-2">
                            <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                            {{ $lawyer->lawyerProfile->location ?? 'N/A' }}
                        </div>

                        <div class="d-flex gap-4 small text-muted">
                            <span>
                                <i class="fas fa-briefcase"></i>
                                {{ $lawyer->lawyerProfile->experience_years ?? 0 }}+ Years
                            </span>
                            <span>
                                <i class="fas fa-star text-warning"></i> 4.8 Rating
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">

            {{-- LEFT: DETAILS --}}
            <div class="col-lg-8">

                {{-- ABOUT --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-primary">
                            About the Lawyer
                        </h5>

                        <p class="text-muted">
                            {{ $lawyer->lawyerProfile->bio ?? 'No biography provided.' }}
                        </p>
                    </div>
                </div>

                {{-- SPECIALIZATIONS --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-primary">
                            Practice Areas
                        </h5>

                        <div class="d-flex flex-wrap gap-2">
                            @forelse($lawyer->lawyerProfile->specializations as $spec)
                                <span class="badge bg-light text-primary border">
                                    {{ $spec->name }}
                                </span>
                            @empty
                                <span class="text-muted small">Not specified</span>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT: ACTIONS --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm sticky-top" style="top:90px;">
                    <div class="card-body p-4 text-center">

                        <h6 class="fw-bold mb-3 text-primary">
                            Book a Consultation
                        </h6>

                        <p class="small text-muted mb-3">
                            Choose a suitable time to consult with this lawyer.
                        </p>

                        <a href="{{ route('lawyers.book', $lawyer->id) }}"
                            class="btn btn-primary w-100 rounded-pill fw-bold mb-2">
                            Book Appointment
                        </a>

                        <a href="{{ route('lawyers.index') }}" class="btn btn-outline-secondary w-100 rounded-pill">
                            Back to Lawyers
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
