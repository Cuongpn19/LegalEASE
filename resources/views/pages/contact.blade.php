@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <div class="container py-5">

        {{-- PAGE TITLE --}}
        <div class="mb-5">
            <h2 class="fw-bold text-navy mb-2">Contact Legal Ease</h2>
            <p class="text-muted">
                Get in touch with our team or visit our office for legal consultation support.
            </p>
        </div>

        <div class="row g-4">

            {{-- CONTACT INFORMATION --}}
            <div class="col-md-5">
                <div class="content-box h-100">

                    <h5 class="fw-bold text-primary mb-4">Contact Information</h5>

                    <div class="d-flex mb-3">
                        <i class="fas fa-location-dot text-primary me-3 mt-1"></i>
                        <div>
                            <div class="fw-bold">Office Address</div>
                            <div class="text-muted small">
                                Aptech Computer Education – International Programmer Training System<br>
                                35/6 D5, Ward 25, District Binh Thanh,<br>
                                Ho Chi Minh City, Vietnam
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mb-3">
                        <i class="fas fa-phone text-primary me-3 mt-1"></i>
                        <div>
                            <div class="fw-bold">Phone</div>
                            <div class="text-muted small">
                                <a href="tel:+84123456789" class="text-decoration-none text-muted">
                                    +84 123 456 789
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <i class="fas fa-envelope text-primary me-3 mt-1"></i>
                        <div>
                            <div class="fw-bold">Email</div>
                            <div class="text-muted small">
                                <a href="mailto:support@legalease.vn" class="text-decoration-none text-muted">
                                    support@legalease.vn
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- BUSINESS HOURS --}}
                    <h6 class="fw-bold text-primary mb-2">Business Hours</h6>
                    <p class="small text-muted mb-4">
                        Monday – Friday: 8:30 AM – 6:00 PM<br>
                        Saturday: 9:00 AM – 12:00 PM<br>
                        Sunday & Public Holidays: Closed
                    </p>

                    {{-- CTA --}}
                    <a href="{{ route('login') }}" class="btn btn-primary w-100">
                        Book an Appointment
                    </a>

                </div>
            </div>

            {{-- GOOGLE MAP --}}
            <div class="col-md-7">
                <div class="content-box p-0 overflow-hidden h-100">

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.7092788577473!2d106.71199827507885!3d10.806685891984378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529ed00409f09%3A0x11f7708a5c77d777!2sAptech%20Computer%20Education%20-%20International%20Programmer%20Training%20System!5e0!3m2!1sen!2s!4v1708075512345!5m2!1sen!2s"
                        width="100%" height="100%" style="border:0; min-height:420px;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                </div>
            </div>

        </div>

    </div>
@endsection
