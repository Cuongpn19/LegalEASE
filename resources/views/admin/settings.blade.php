@extends('layouts.admin')

@section('main')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">
                            <i class="fa-solid fa-user-gear me-2"></i>
                            Set up personal information
                        </h5>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.settings.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Full name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Enter new password">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Confirm new password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>

                            <button class="btn btn-dark w-100">
                                <i class="fa-solid fa-save me-1"></i> Save
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
