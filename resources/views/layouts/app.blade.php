<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'LegalEase')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.jpg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #06357A;
        }

        body {
            background: #f2f2f2;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* TOP BAR */
        .top-bar {
            background: var(--primary);
            color: #fff;
        }

        .top-bar a {
            color: #fff;
            text-decoration: none;
            margin-right: 18px;
            font-weight: 600;
            font-size: 14px;
        }

        /* NAV */
        .main-nav {
            background: #0b3f8a;
        }

        .main-nav a {
            color: #fff;
            font-weight: 600;
            margin-right: 20px;
            font-size: 14px;
        }

        /* CONTENT */
        .content-box {
            background: #fff;
            border: 1px solid #ddd;
            padding: 20px;
        }

        h4.section-title {
            font-size: 2.25rem;
            /* TO RÕ */
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #ffffff;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .topic-title {
            font-weight: 700;
            color: var(--primary);
        }

        .topic-desc {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 3em;
            line-height: 1.5em;
            text-align: justify;
        }

        /* SIDEBAR */
        .sidebar-box {
            background: #fff;
            border: 1px solid #ddd;
            padding: 16px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* JUSTIA-STYLE FOOTER */
        .footer-legalease {
            background-color: var(--primary);
            /* Dùng chung biến màu với Top Bar */
            color: #ffffff;
            padding: 15px 0;
            /* Khoảng cách giống py-3 của Top Bar */
        }

        .footer-legalease .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .footer-legalease a {
            color: #ffffff;
            text-decoration: none;
            margin-left: 15px;
            font-weight: 600;
            /* Font weight 600 giống Top Bar */
            font-size: 14px;
            /* Size 14px giống Top Bar */
        }

        .footer-legalease a:hover {
            text-decoration: underline;
            color: red;
        }

        .footer-social a {
            margin-right: 12px;
            font-size: 18px;
        }

        .footer-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
            margin: 12px 0;
        }

        .sticky-nav {
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .text-primary {
            color: #06357A !important;
        }

        .card:hover {
            transform: translateY(-3px);
            transition: 0.2s ease;
        }

        .sidebar-box {
            background: #fff;
            border: 1px solid #ddd;
            padding: 16px;
            margin-bottom: 20px;
        }

        .card-img-top {
            transition: transform 0.25s ease;
        }

        .card-img-top:hover {
            transform: scale(1.03);
        }

        .card-body a:hover h6 {
            text-decoration: underline;
        }

        .section-link {
            color: var(--primary);
            text-decoration: none;
        }

        .section-link:hover {
            text-decoration: unset;
        }

        .section-title a {
            font-size: 3rem;
            font-weight: 900;
        }

        .text-navy {
            color: #1a2a44;
        }

        /* Màu xanh thẫm đặc trưng ngành luật */
        .rounded-shadow {
            box-shadow: 20px 20px 60px #d9d9d9, -20px -20px 60px #ffffff;
            border-radius: 20px;
        }

        .rounded-4 {
            border-radius: 1.5rem !important;
        }

        /* Sticky Header */
        .sticky-nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Nav Link Hover */
        .main-nav a.nav-link:hover {
            color: #ffd700 !important;
            /* Màu vàng Gold tạo điểm nhấn khi hover */
            transition: 0.3s ease;
        }

        /* Footer Hover */
        .footer-legalease a:hover {
            text-decoration: underline;
            opacity: 0.8;
        }

        /* Responsive cho Footer */
        @media (max-width: 768px) {
            .footer-legalease .container {
                flex-direction: column;
                text-align: center;
                justify-content: center;
            }

            .footer-links {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    {{-- TOP BAR --}}
    <div class="top-bar sticky-nav py-2"
        style="background-color: #06357a; border-bottom: 1px solid rgba(255,255,255,0.1);">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center">
                <h1 class="m-0 fw-bold text-white" style="letter-spacing: 1px; font-size: 28px;">LEGAL EASE</h1>
            </a>

            <div class="d-flex align-items-center gap-3">
                <div class="position-relative d-none d-md-block">
                    <input type="text" class="form-control form-control-sm ps-3 pe-5 rounded-pill"
                        placeholder="Search" style="width: 250px;">
                    <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                </div>
                <div class="auth-buttons d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-sm text-white fw-bold px-3">Log In</a>
                    <a href="{{ route('register') }}"
                        class="btn btn-sm btn-outline-light rounded-pill px-4 fw-bold">Sign Up</a>
                </div>
            </div>
        </div>
    </div>

    {{-- NAV --}}
    <div class="main-nav py-2 shadow-sm" style="background-color: #0b3f8a;">
        <div class="container d-flex gap-4">
            <a href="#" class="nav-link text-white small fw-bold text-uppercase">Find a Lawyer</a>
            <a href="#" class="nav-link text-white small fw-bold text-uppercase">Ask a Lawyer</a>
            <a href="#" class="nav-link text-white small fw-bold text-uppercase">Research the Law</a>
            <a href="#" class="nav-link text-white small fw-bold text-uppercase">Laws & Regs</a>
        </div>
    </div>

    {{-- MAIN --}}
    <div class="container my-4">
        @yield('content')
    </div>

    <footer class="footer-legalease" style="background-color: #06357a; color: #fff; padding: 25px 0;">
        <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3">

            <div class="footer-copyright fw-bold small">
                © {{ date('Y') }} Legal Ease
            </div>

            <div class="footer-social d-flex gap-4">
                <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white"><i class="fab fa-x-twitter"></i></a>
                <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                <a href="#" class="text-white"><i class="fas fa-scale-balanced"></i></a>
            </div>

            <div class="footer-links d-flex flex-wrap gap-3 small fw-bold">
                <a href="#" class="text-white text-decoration-none">Legal Portal</a>
                <a href="{{ route('about') }}" class="text-white text-decoration-none">Company</a>
                <a href="{{ route('contact') }}" class="text-white text-decoration-none">Help</a>
                <a href="#" class="text-white text-decoration-none">Terms</a>
                <a href="#" class="text-white text-decoration-none">Privacy Policy</a>
            </div>

        </div>
    </footer>

</body>

</html>
