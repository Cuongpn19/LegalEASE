@extends('layouts.admin')
@section('main')
    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-header text-white fw-bold text-center" style="background-color: #ffc107; font-size: 1.5rem;">
                EDIT CLIENT INFORMATION
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.clients.update', $client->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Bắt buộc phải có để Laravel hiểu đây là cập nhật --}}

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Full name</label>
                            <input type="text" name="name" class="form-control" value="{{ $client->name }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $client->email }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="number" name="phone_number" class="form-control"
                                value="{{ $client->clientProfile->phone_number ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ $client->clientProfile->address ?? '' }}">
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-warning px-4 shadow-sm">
                            <i class="fas fa-save me-1"></i> Save
                        </button>
                        <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary px-4 shadow-sm">
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
