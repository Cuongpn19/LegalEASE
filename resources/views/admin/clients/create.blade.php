@extends('layouts.admin')
@section('main')
    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-header text-white fw-bold text-center" style="background-color: #007bff; font-size: 1.5rem;">
                ADD NEW CLIENTS
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.clients.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Full name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your name..."
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="example@gmail.com"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="number" name="phone_number" class="form-control" placeholder="0987xxxxxx">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Address (Province/City)</label>
                            <select name="address" class="form-select">
                                <option value="Hà Nội">Hà Nội</option>
                                <option value="Đà Nẵng">Đà Nẵng</option>
                                <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="fas fa-save me-1"></i> Add
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
