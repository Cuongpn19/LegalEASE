@extends('layouts.admin')
@section('main')
    <div class="container-fluid px-4">

        <ul class="nav nav-tabs mt-4" id="userTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="lawyers-tab" data-bs-toggle="tab" data-bs-target="#lawyers-pane"
                    type="button" role="tab" aria-controls="lawyers-pane" aria-selected="true">
                    <i class="fas fa-user-tie me-1"></i> Lawyer
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="clients-tab" data-bs-toggle="tab" data-bs-target="#clients-pane" type="button"
                    role="tab" aria-controls="clients-pane" aria-selected="false">
                    <i class="fas fa-users me-1"></i> Client
                </button>
            </li>
        </ul>

        <div class="tab-content border-start border-end border-bottom p-3 bg-white" id="userTabContent">

            <div class="tab-pane fade show active" id="lawyers-pane" role="tabpanel" aria-labelledby="lawyers-tab">
                <div class="table-responsive">
                    <a href="{{ route('admin.lawyers.index') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-user"></i> Lawyers
                    </a>
                    <table class="table table-striped mt-3">
                        <thead class="thead-dark">
                            <tr>
                                <th>Full name</th>
                                <th>Specialization</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lawyers as $lawyer)
                                <tr>
                                    <td>{{ $lawyer->name }}</td>
                                    <td>
                                        @if ($lawyer->specializations->count() > 0)
                                            {{ $lawyer->specializations->pluck('name')->implode(', ') }}
                                        @else
                                            <span class="text-muted">Not updated yet</span>
                                        @endif
                                    </td>
                                    <td>{{ $lawyer->lawyerProfile->location ?? 'N/A' }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $lawyer->status == 'active' ? 'bg-success' : ($lawyer->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $lawyer->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($lawyer->status == 'pending')
                                            <form action="{{ route('admin.lawyers.approve', $lawyer->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-primary">Approve</button>
                                            </form>
                                        @endif

                                        @if ($lawyer->status == 'active')
                                            <form action="{{ route('admin.users.revertPending', $lawyer->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-warning">Revert to Pending</button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.users.toggleStatus', $lawyer->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button
                                                class="btn btn-sm {{ $lawyer->status !== 'banned' ? 'btn-danger' : 'btn-success' }}">
                                                {{ $lawyer->status !== 'banned' ? 'Block' : 'Unblock' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="clients-pane" role="tabpanel" aria-labelledby="clients-tab">
                <div class="table-responsive">
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-user"></i> Clients
                    </a>
                    <table class="table table-striped mt-3">
                        <thead class="thead-dark">
                            <tr>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                {{-- <th>Hành động</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->clientProfile->phone_number ?? 'N/A' }}</td>
                                    <td>{{ $client->clientProfile->address ?? 'N/A' }}</td>
                                    {{-- <td>
                                    <form action="{{ route('admin.users.toggleStatus', $client->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm {{ $client->status !== 'banned' ? 'btn-danger' : 'btn-success' }}">
                                            {{ $client->status !== 'banned' ? 'Khóa' : 'Mở khóa' }}
                                        </button>
                                    </form>
                                </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Chưa có khách hàng đăng ký.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
