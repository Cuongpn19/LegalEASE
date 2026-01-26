@extends('layouts.app')

@section('content')
    <div class="about-section py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold text-navy">Legal Ease</h1>
                    <p class="lead text-muted">Connecting you to justice, simplifying all legal procedures for you.</p>
                    <p>We built Legal Ease with the goal of breaking down barriers between clients and professional lawyers.
                        Here, all your legal issues are heard and resolved quickly and transparently.</p>
                </div>
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=600"
                        class="img-fluid rounded-shadow" alt="Legal background">
                </div>
            </div>

            <div class="row text-center py-4 bg-light rounded-4 mb-5">
                <div class="col-md-4">
                    <h2 class="fw-bold text-primary">500+</h2>
                    <p class="text-muted">Professional Lawyer</p>
                </div>
                <div class="col-md-4">
                    <h2 class="fw-bold text-primary">10k+</h2>
                    <p class="text-muted">Clients trust</p>
                </div>
                <div class="col-md-4">
                    <h2 class="fw-bold text-primary">98%</h2>
                    <p class="text-muted">Satisfaction rate</p>
                </div>
            </div>
        </div>
    </div>
@endsection
