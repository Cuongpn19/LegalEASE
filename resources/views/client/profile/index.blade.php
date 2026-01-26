@extends('layouts.client')

@section('main')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">My Profile</h3>

                        {{-- Error Summary --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>We couldn’t save your changes.</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Tabs --}}
                        <ul class="nav mb-4 gap-2">
                            <li class="nav-item">
                                <button class="nav-link active fw-bold border-0 border-bottom border-3" data-bs-toggle="tab"
                                    data-bs-target="#account">
                                    Account Info
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold border-0 border-bottom border-3" data-bs-toggle="tab"
                                    data-bs-target="#profile">
                                    Profile Info
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">

                            {{-- ================= Account Info ================= --}}
                            <div class="tab-pane fade show active" id="account">
                                <form action="{{ route('client.profile.update') }}" method="POST">
                                    @csrf
                                    <div class="mb-4 text-center">
                                        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                            style="width: 100px; height: 100px; background: #eef2ff;">
                                            <span
                                                class="display-5 fw-bold text-primary">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Username</label>
                                        <input type="text" name="name"
                                            class="form-control rounded-pill border-0 bg-light px-4"
                                            value="{{ old('name', auth()->user()->name) }}">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Email</label>
                                        <input type="email" name="email"
                                            class="form-control rounded-pill border-0 bg-light px-4"
                                            value="{{ old('email', auth()->user()->email) }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2">
                                        Save Account Info
                                    </button>
                                </form>
                            </div>

                            {{-- ================= Profile Info ================= --}}
                            <div class="tab-pane fade" id="profile">

                                <form action="{{ route('client.profile.update') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Full Name</label>
                                        <input type="text" name="full_name"
                                            class="form-control rounded-pill border-0 bg-light px-4"
                                            value="{{ old('name', $profile->name ?? '') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Phone</label>
                                        <input type="text" name="phone_number"
                                            class="form-control rounded-pill border-0 bg-light px-4"
                                            value="{{ old('phone_number', $profile->phone_number ?? '') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Address</label>
                                        <textarea name="address" class="form-control border-0 bg-light px-4 rounded-4" rows="3">{{ old('address', $profile->address ?? '') }}</textarea>
                                    </div>

                                    <button class="btn btn-success w-100 rounded-pill fw-bold py-2">
                                        Save Profile Info
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
