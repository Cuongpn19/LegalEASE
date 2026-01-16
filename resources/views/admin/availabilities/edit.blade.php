@extends('layouts.admin')
@section('main')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title mb-4">Adjust available time slots</h5>
                <form action="{{ route('admin.availabilities.update', $availability->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Lawyer</label>
                            <select name="lawyer_id" class="form-select" required>
                                @foreach ($lawyers as $lawyer)
                                    <option value="{{ $lawyer->id }}"
                                        {{ $availability->lawyer_id == $lawyer->id ? 'selected' : '' }}>
                                        {{ $lawyer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Days</label>
                            <select name="day_of_week" class="form-select" required>
                                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                    <option value="{{ $day }}"
                                        {{ $availability->day_of_week == $day ? 'selected' : '' }}>{{ $day }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Start time</label>
                            <input type="time" name="start_time" class="form-control"
                                value="{{ substr($availability->start_time, 0, 5) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">End time</label>
                            <input type="time" name="end_time" class="form-control"
                                value="{{ substr($availability->end_time, 0, 5) }}" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
