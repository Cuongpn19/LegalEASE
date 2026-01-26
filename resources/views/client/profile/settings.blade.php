@extends('layouts.client')

@section('main')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4"><i class="fas fa-cog me-2 text-primary"></i>Security settings</h3>

                        <form action="{{ route('client.settings.password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Current password</label>
                                <input type="password" name="current_password"
                                    class="form-control rounded-pill border-0 bg-light px-4 shadow-none">
                            </div>

                            @error('current_password')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="mb-3">
                                <label class="form-label fw-bold">New password</label>
                                <input type="password" name="new_password"
                                    class="form-control rounded-pill border-0 bg-light px-4 shadow-none">
                            </div>

                            @error('new_password')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="mb-4">
                                <label class="form-label fw-bold">Confirm new password</label>
                                <input type="password" name="new_password_confirmation"
                                    class="form-control rounded-pill border-0 bg-light px-4 shadow-none">
                            </div>

                            @error('new_password_confirmation')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                            <button type="submit" class="btn btn-dark w-100 rounded-pill fw-bold py-2 shadow">
                                Update password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
