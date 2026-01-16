<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegalEase</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary-dark: #1e293b;
            --accent-blue: #3b82f6;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        .vh-100-custom {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            display: flex;
            align-items: center;
        }

        .register-card {
            border: none;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #64748b;
            text-transform: uppercase;
        }

        .input-group-text {
            background: transparent;
            border-right: none;
            color: #94a3b8;
        }

        .form-control {
            border-left: none;
            padding: 0.75rem;
            border-color: #e2e8f0;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: var(--accent-blue);
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--accent-blue);
            color: var(--accent-blue);
        }

        .btn-register {
            background: var(--primary-dark);
            color: white;
            padding: 0.8rem;
            font-weight: 700;
            transition: 0.3s;
            border: none;
        }

        .btn-register:hover {
            background: #0f172a;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <section class="vh-100-custom py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card register-card">
                        <div class="row g-0">
                            <div class="col-md-5 d-none d-md-block bg-primary p-5 text-white d-flex align-items-center"
                                style="background: url('https://images.unsplash.com/photo-1505664194779-8beaceb93744?q=80&w=2070&auto=format&fit=crop') center/cover;">
                                <div class="w-100 py-5"
                                    style="background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(5px); border-radius: 1rem; padding: 20px;">
                                    <h3 class="fw-bold">Join LegalEase</h3>
                                    <p class="small opacity-75">Smart, transparent, and effective legal management
                                        solutions for lawyers and clients.</p>
                                    <ul class="list-unstyled small mt-4">
                                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Absolute data
                                            security</li>
                                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Connect with experts
                                            24/7</li>
                                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Smart appointment
                                            management</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-7 bg-white p-4 p-lg-5">
                                <div class="text-center mb-4">
                                    <h2 class="fw-bold" style="color: var(--primary-dark);">Register</h2>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <p class="text-muted small">Please fill in the information to create an account.</p>
                                </div>
                                <form action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Full name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Nguyen Van A" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="email@example.com" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="••••••••" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Confirm password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="fas fa-shield-check"></i></span>
                                                <input type="password" name="password_confirmation" class="form-control"
                                                    placeholder="••••••••" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="terms" required>
                                        <label class="form-check-label small text-muted" for="terms">
                                            I agree <a href="#" class="text-decoration-none">Terms &
                                                Conditions</a>
                                        </label>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold">WHO ARE YOU?</label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <input type="radio" class="btn-check" name="role" id="role_client"
                                                    value="client" checked>
                                                <label class="btn btn-outline-primary w-100 py-3" for="role_client">
                                                    <i class="fas fa-user-tie mb-1"></i> Client
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <input type="radio" class="btn-check" name="role" id="role_lawyer"
                                                    value="lawyer">
                                                <label class="btn btn-outline-primary w-100 py-3" for="role_lawyer">
                                                    <i class="fas fa-gavel mb-1"></i> Lawyer
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-register w-100 rounded-3 mb-3">
                                        CREATE AN ACCOUNT</button>
                                    <p class="text-center small text-muted">Do you already have an account? <a
                                            href="{{ route('login') }}" class="fw-bold text-decoration-none">Sign in
                                            now</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
