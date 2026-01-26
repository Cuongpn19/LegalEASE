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
            --sb-bg: #1e293b;
            /* Slate 800 */
            --sb-hover: #334155;
            --accent: #fbbf24;
            /* Amber 400 */
            --nav-height: 70px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
        }

        /* Sidebar */
        #sidebar-wrapper {
            min-height: 100vh;
            width: 260px;
            background-color: var(--sb-bg);
            transition: all 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1030;
        }

        .sidebar-heading {
            height: var(--nav-height);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.25rem;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-link-custom {
            color: #94a3b8 !important;
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: 0.2s;
            text-decoration: none;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active-link {
            color: white !important;
            background-color: var(--sb-hover);
        }

        .nav-link-custom.active-link {
            border-left: 4px solid var(--accent);
            color: var(--accent) !important;
        }

        .nav-link-custom i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 12px;
        }

        /* Submenu */
        .submenu .nav-link-custom {
            padding-left: 3.5rem;
            font-size: 0.9rem;
        }

        .rotate-icon {
            transition: transform 0.3s;
        }

        [aria-expanded="true"] .rotate-icon {
            transform: rotate(180deg);
        }

        /* Content Area */
        #page-content-wrapper {
            padding-left: 260px;
            /* Bằng độ rộng sidebar */
            width: 100%;
            transition: all 0.3s ease;
        }

        .navbar-custom {
            height: var(--nav-height);
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 1.5rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            #sidebar-wrapper {
                margin-left: -260px;
            }

            #page-content-wrapper {
                padding-left: 0;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">
                <i class="fas fa-gavel text-warning me-2"></i>LEGALEASE
            </div>

            <div class="mt-3">
                <a href="{{ route('lawyer.dashboard') }}"
                    class="nav-link-custom {{ request()->routeIs('lawyer.dashboard') ? 'active-link' : '' }}">
                    <i class="fas fa-house"></i> Dashboard
                </a>

                <a href="{{ route('lawyer.profile') }}"
                    class="nav-link-custom {{ request()->routeIs('lawyer.profile') ? 'active-link' : '' }}">
                    <i class="fas fa-file-lines"></i> Profile
                </a>

                <a href="{{ route('lawyer.question') }}"
                    class="nav-link-custom {{ request()->routeIs('lawyer.question') ? 'active-link' : '' }}">
                    <i class="fas fa-file-circle-question"></i> FAQs
                </a>

                <a href="{{ route('lawyer.blog') }}"
                    class="nav-link-custom {{ request()->routeIs('lawyer.blog') ? 'active-link' : '' }}">
                    <i class="fas fa-chart-pie"></i> Blog
                </a>
            </div>
        </div>

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand navbar-light navbar-custom sticky-top">
                <button class="btn btn-light border" id="menu-toggle">
                    <i class="fas fa-bars-staggered"></i>
                </button>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center fw-bold text-dark" href="#"
                            data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D6EFD&color=fff"
                                class="rounded-circle me-2" width="32">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0 p-2 mt-2">
                            <a class="dropdown-item rounded" href="{{ route('lawyer.settings') }}">
                                <i class="fas fa-user-cog me-2 text-muted"></i> Setting
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item rounded text-danger" type="submit">
                                    <i class="fas fa-power-off me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="container-fluid p-4">
                @yield('main')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle Sidebar Script (Vanilla JS for BS5)
        const menuToggle = document.getElementById('menu-toggle');
        const wrapper = document.getElementById('wrapper');

        menuToggle.addEventListener('click', () => {
            wrapper.classList.toggle('toggled');
            // Logic ẩn hiện sidebar trên mobile
            const sidebar = document.getElementById('sidebar-wrapper');
            if (window.innerWidth <= 992) {
                if (sidebar.style.marginLeft === '0px') {
                    sidebar.style.marginLeft = '-260px';
                } else {
                    sidebar.style.marginLeft = '0px';
                }
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
