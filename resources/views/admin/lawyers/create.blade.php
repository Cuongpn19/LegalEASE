@extends('layouts.admin')
@section('main')
    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-header text-white fw-bold text-center" style="background-color: #007bff; font-size: 1.5rem;">
                ADD NEW LAWYERS
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.lawyers.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Full name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your name..."
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="example  @gmail.com"
                                required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Specialization</label>
                            <div class="row border rounded p-3 bg-light mx-0">
                                @foreach ($allSpecializations as $spec)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="specialization[]"
                                                value="{{ $spec->id }}" id="spec-{{ $spec->id }}">
                                            <label class="form-check-label" for="spec-{{ $spec->id }}">
                                                {{ $spec->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('specialization')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Bio</label>
                            <input type="text" name="bio" class="form-control" placeholder="Enter your bio...">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="Enter your location...">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Experience</label>
                            <input type="number" name="experience_years" class="form-control"
                                placeholder="Enter your experience...">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Rating</label>
                            <input type="number" name="rating" class="form-control" placeholder="Enter your rating...">
                        </div>

                    </div>

                    <div class="mt-4 d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="fas fa-save me-1"></i> Add
                        </button>
                        <a href="{{ route('admin.lawyers.index') }}" class="btn btn-secondary px-4 shadow-sm">
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
