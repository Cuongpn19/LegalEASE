@extends('layouts.admin')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@section('main')
    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-header text-white fw-bold text-center" style="background-color: #ffc107; font-size: 1.5rem;">
                EDIT LAWYER INFORMATION
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.lawyers.update', $lawyer->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Bắt buộc phải có để Laravel hiểu đây là cập nhật --}}

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Full name</label>
                            <input type="text" name="name" class="form-control" value="{{ $lawyer->name }}" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Specialization</label>
                            <select name="specializations[]" class="form-control select2-multiple" multiple="multiple"
                                style="width: 100%">
                                @foreach ($allSpecializations as $spec)
                                    <option value="{{ $spec->id }}"
                                        {{ $lawyer->specializations->contains($spec->id) ? 'selected' : '' }}>
                                        {{ $spec->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <script>
                            $(document).ready(function() {
                                $('.select2-multiple').select2({
                                    placeholder: "Select specialties (e.g., Criminal Law, Civil Law)",
                                    allowClear: true,
                                    theme: "classic"
                                });
                            });
                        </script>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Bio</label>
                            <textarea name="bio" class="form-control" rows="4">{{ $lawyer->lawyerProfile->bio ?? '' }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Location</label>
                            <input type="text" name="location" class="form-control"
                                value="{{ $lawyer->lawyerProfile->location ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Experience (years)</label>
                            <input type="number" name="experience_years" class="form-control"
                                value="{{ $lawyer->lawyerProfile->experience_years ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ $lawyer->status == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="pending" {{ $lawyer->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="inactive" {{ $lawyer->status == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Rating</label>
                            <input type="number" name="rating" class="form-control"
                                value="{{ $lawyer->lawyerProfile->rating ?? '' }}">
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-warning px-4 shadow-sm">
                            <i class="fas fa-save me-1"></i> Save
                        </button>
                        <a href="{{ route('admin.lawyers.index') }}" class="btn btn-secondary px-4 shadow-sm">
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2-multiple').select2({
                placeholder: "Select Specializations",
                allowClear: true
            });
        });
    </script>
@endsection
