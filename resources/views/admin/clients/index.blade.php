@extends('layouts.admin')
@section('main')
    <div class="container-fluid">

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.clients.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle me-1"></i> Add clients
            </a>
            <div class="btn-group shadow-sm">
                <a href="{{ route('admin.lawyers.index') }}" class="btn btn-secondary"><i class="fas fa-users me-1"></i>
                    Lawyer</a>
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
                                <th class="ps-3">Full name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th class="text-center">Registration date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr>
                                    <td class="ps-3 fw-bold">{{ $client->name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->clientProfile->phone_number ?? 'N/A' }}</td>
                                    <td>{{ $client->clientProfile->address ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $client->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Nút Xem --}}
                                            <a href="{{ route('admin.clients.show', $client->id) }}"
                                                class="btn btn-sm btn-info text-white fw-bold shadow-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- Nút Sửa --}}
                                            <a href="{{ route('admin.clients.edit', $client->id) }}"
                                                class="btn btn-sm btn-warning text-dark fw-bold shadow-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Nút Xóa --}}
                                            <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST"
                                                class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger fw-bold shadow-sm"
                                                    onclick="return confirm('Delete this post?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">There are no customers in the
                                        system yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
