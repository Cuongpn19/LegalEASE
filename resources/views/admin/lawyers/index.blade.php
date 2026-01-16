@extends('layouts.admin')
@section('main')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.lawyers.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle me-1"></i> Add lawyers
            </a>
            <div class="btn-group shadow-sm">
                <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary active"><i class="fas fa-user me-1"></i>
                    Clients</a>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary"><i
                        class="fas fa-calendar-check me-1"></i> Appointment schedule</a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Full name</th>
                                <th>Email</th>
                                <th>Specialization</th>
                                <th>Location</th>
                                <th class="text-center">Experience</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lawyers as $lawyer)
                                <tr>
                                    <td class="fw-bold">{{ $lawyer->name }}</td>
                                    <td>{{ $lawyer->email }}</td>
                                    <td>
                                        @if ($lawyer->specializations->count() > 0)
                                            {{ $lawyer->specializations->pluck('name')->implode(', ') }}
                                        @else
                                            <span class="text-muted">Not updated yet</span>
                                        @endif
                                    </td>
                                    <td>{{ $lawyer->lawyerProfile->location ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $lawyer->lawyerProfile->experience_years ?? 0 }} years</td>
                                    <td class="text-center">
                                        @if ($lawyer->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($lawyer->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">

                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Nút Xem --}}
                                            <a href="{{ route('admin.lawyers.show', $lawyer->id) }}"
                                                class="btn btn-sm btn-info text-white fw-bold shadow-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- Nút Sửa --}}
                                            <a href="{{ route('admin.lawyers.edit', $lawyer->id) }}"
                                                class="btn btn-sm btn-warning text-dark fw-bold shadow-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Nút Xóa --}}
                                            <form action="{{ route('admin.lawyers.destroy', $lawyer->id) }}" method="POST"
                                                class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger fw-bold shadow-sm"
                                                    onclick="return confirm('You probably want to remove the lawyer: {{ $lawyer->name }}?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
