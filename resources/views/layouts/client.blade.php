<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LegalEase')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary-color: #4f46e5;
            /* Indigo 600 */
            --bg-light: #f8fafc;
            --text-main: #1e293b;
            --nav-height: 72px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
        }

        /* Tinh chỉnh Navbar */
        .navbar {
            height: var(--nav-height);
            border-bottom: 1px solid #e2e8f0 !important;
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.9) !important;
        }

        .navbar-brand {
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            color: #64748b !important;
            padding: 0.5rem 1rem !important;
            transition: all 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color) !important;
        }

        /* Nút Profile Dropdown */
        .user-dropdown-btn {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 6px 16px;
            transition: all 0.3s;
        }

        .user-dropdown-btn:hover {
            background: #e2e8f0;
        }

        /* Card & Container */
        .main-content {
            padding-top: 2rem;
            padding-bottom: 4rem;
        }

        /* Hiệu ứng bo góc đồng bộ cho trang Client */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
    @include('toast.css')
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="{{ route('client.dashboard') }}">
                    <i class="fas fa-balance-scale me-2"></i>LEGAL EASE
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#clientNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="clientNav">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('client/dashboard') ? 'active' : '' }}"
                                href="{{ route('client.dashboard') }}"><i class="fas fa-home me-1 small"></i>
                                Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client.lawyers.index') }}"><i
                                    class="fas fa-search me-1 small"></i> Find Lawyer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client.appointments.index') }}"><i
                                    class="fas fa-calendar-check me-1 small"></i> My Appointments</a>
                        </li>
                    </ul>

                    <div class="dropdown">
                        <a class="btn user-dropdown-btn dropdown-toggle d-flex align-items-center" href="#"
                            data-bs-toggle="dropdown">
                            <div class="avatar-circle me-2 bg-primary text-white d-flex align-items-center justify-content-center"
                                style="width: 30px; height: 30px; border-radius: 50%; font-size: 12px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="fw-medium text-dark">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 p-2"
                            style="border-radius: 12px; min-width: 200px;">
                            <li><a class="dropdown-item rounded-3 py-2" href="{{ route('client.profile') }}"><i
                                        class="far fa-user me-2"></i>
                                    My Profile</a></li>
                            <li><a class="dropdown-item rounded-3 py-2" href="{{ route('client.settings') }}"><i
                                        class="fas fa-cog me-2"></i>
                                    Settings</a></li>
                            <li>
                                <hr class="dropdown-divider opacity-50">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item rounded-3 py-2 text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main class="main-content container">
            @yield('main')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @include('toast.toast')
</body>

</html>
