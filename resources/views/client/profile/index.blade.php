@extends('layouts.client')

@section('main')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">Personal information</h3>
                        <form action="{{ route('client.profile.update') }}" method="POST">
                            @csrf
                            <div class="mb-3 text-center">
                                <div class="avatar-lg bg-soft-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                    style="width: 100px; height: 100px; background: #eef2ff;">
                                    <span class="display-4 fw-bold text-primary">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Full name</label>
                                <input type="text" name="name"
                                    class="form-control rounded-pill border-0 bg-light px-4" value="{{ $user->name }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email"
                                    class="form-control rounded-pill border-0 bg-light px-4" value="{{ $user->email }}">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2">
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
