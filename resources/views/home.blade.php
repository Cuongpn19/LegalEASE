@extends('layouts.app')
<style>
    /* =========================
   MOBILE RESPONSIVE
   ========================= */
    @media (max-width: 768px) {

        /* HEADER */
        .top-bar h1 {
            font-size: 20px !important;
            letter-spacing: 0.5px;
        }

        .top-bar .auth-buttons a {
            font-size: 12px;
            padding: 4px 10px;
        }

        .top-bar .form-control {
            display: none;
            /* Ẩn search trên mobile */
        }

        /* NAV */
        .main-nav .container {
            overflow-x: auto;
            white-space: nowrap;
            gap: 16px;
        }

        .main-nav a {
            font-size: 12px;
        }

        /* CONTENT */
        .content-box {
            padding: 15px;
        }

        h4.section-title,
        h4.section-titles,
        h4.section-title1 {
            font-size: 1.3rem !important;
            font-weight: 800;
            text-transform: none;
        }

        /* CARD */
        .card-img-top {
            height: 140px !important;
        }

        .card h6 {
            font-size: 14px;
        }

        .card p {
            font-size: 12px;
        }

        /* GRID */
        .col-md-6 {
            width: 100%;
        }

        /* SIDEBAR */
        .sidebar-box {
            padding: 14px;
        }

        .sidebar-box h5 {
            font-size: 15px;
        }

        .sidebar-box img {
            width: 60px !important;
            height: 60px !important;
        }

        .sidebar-box .fw-bold {
            font-size: 13px;
        }

        .sidebar-box .small {
            font-size: 12px;
        }

        /* FOOTER */
        .footer-legalease {
            text-align: center;
        }

        .footer-social {
            justify-content: center;
            margin: 10px 0;
        }

        .footer-links {
            justify-content: center;
        }
    }
</style>
@section('title', 'Home')

@section('content')
    <div class="row">

        {{-- MAIN CONTENT --}}
        <div class="col-md-8">
            <div class="content-box mb-4">
                <h4 class="section-titles">
                    <a href="{{ route('home') }}" class="section-link">
                        Legal Guides
                    </a>
                </h4>


                <div class="row">
                    @foreach ($updates as $item)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">

                                {{-- IMAGE CLICK --}}
                                <a href="{{ route('blog.show', $item->id) }}" class="text-decoration-none">
                                    <img src="{{ Storage::url($item->image) }}" class="card-img-top"
                                        style="height:160px; object-fit:cover;">
                                </a>

                                <div class="card-body">

                                    {{-- TITLE CLICK --}}
                                    <a href="{{ route('blog.show', $item->id) }}" class="text-decoration-none">
                                        <h6 class="fw-bold mb-2 text-primary">
                                            {{ $item->title }}
                                        </h6>
                                    </a>

                                    <p class="small text-muted mb-0">
                                        {{ Str::limit($item->description ?? 'Legal information and resources related to this topic.', 90) }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <div class="content-box">
                <h4 class="section-title1">Legal Research & Law Practice</h4>

                <div class="row">
                    @foreach ([['Laws: Cases & Codes', 'US Constitution, US Laws, State Laws...'], ['US Federal Government', 'Executive, Congress, Courts...'], ['US Courts', 'Supreme Court, Federal Courts, State Courts...'], ['US States', 'California, Texas, Florida, New York...']] as [$title, $desc])
                        <div class="col-md-6 mb-3">
                            <div class="fw-bold text-primary">{{ $title }}</div>
                            <div class="small text-muted">{{ $desc }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- SIDEBAR --}}
        <div class="col-md-4">
            <div class="sidebar-box text-center">
                <h5 class="fw-bold text-primary">Legal Ease Connect</h5>
                <p class="small text-muted mb-3">
                    Access your free membership dashboard.
                </p>

                <a href="{{ route('login') }}" class="btn btn-danger w-100 mb-2">
                    Log In
                </a>

                <a href="#" class="small text-decoration-none">
                    Learn More →
                </a>
            </div>


            <div class="sidebar-box">
                <h5 class="fw-bold mb-3 text-primary">Free Daily Summaries in Your Inbox</h5>

                @foreach ([1, 2] as $w)
                    <div class="d-flex gap-3 mb-3">
                        <img src="{{ Storage::url($item->image) }}" style="width:70px;height:70px;object-fit:cover"
                            class="rounded">

                        <div>
                            <div class="fw-bold small">
                                {{ $w == 1 ? 'AI & SEO Highlights' : 'Managing Difficult Clients' }}
                            </div>
                            <div class="small text-muted">
                                {{ $w == 1 ? 'Jan 14, 2pm ET' : 'Jan 16, 1pm ET' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="sidebar-box">
                <h5 class="fw-bold mb-3 text-primary">Free Webinars for All</h5>

                @foreach ([1, 2] as $w)
                    <div class="d-flex gap-3 mb-3">
                        <img src="{{ Storage::url($item->image) }}" style="width:70px;height:70px;object-fit:cover"
                            class="rounded">

                        <div>
                            <div class="fw-bold small">
                                {{ $w == 1 ? 'AI & SEO Highlights' : 'Managing Difficult Clients' }}
                            </div>
                            <div class="small text-muted">
                                {{ $w == 1 ? 'Jan 14, 2pm ET' : 'Jan 16, 1pm ET' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="sidebar-box">
                <h5 class="fw-bold mb-3 text-primary">Ask a Lawyer
                    Get Free Answers</h5>

                @foreach ([1, 2] as $w)
                    <div class="d-flex gap-3 mb-3">
                        <img src="{{ Storage::url($item->image) }}" style="width:70px;height:70px;object-fit:cover"
                            class="rounded">

                        <div>
                            <div class="fw-bold small">
                                {{ $w == 1 ? 'AI & SEO Highlights' : 'Managing Difficult Clients' }}
                            </div>
                            <div class="small text-muted">
                                {{ $w == 1 ? 'Jan 14, 2pm ET' : 'Jan 16, 1pm ET' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="sidebar-box">
                <h5 class="fw-bold mb-3 text-primary">Find a Lawyer</h5>

                @foreach ([1, 2] as $w)
                    <div class="d-flex gap-3 mb-3">
                        <img src="{{ Storage::url($item->image) }}" style="width:70px;height:70px;object-fit:cover"
                            class="rounded">

                        <div>
                            <div class="fw-bold small">
                                {{ $w == 1 ? 'AI & SEO Highlights' : 'Managing Difficult Clients' }}
                            </div>
                            <div class="small text-muted">
                                {{ $w == 1 ? 'Jan 14, 2pm ET' : 'Jan 16, 1pm ET' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>
@endsection
