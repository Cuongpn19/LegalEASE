@extends('layouts.admin')
@section('main')
    <div class="card shadow border-0">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0 text-uppercase">Client details</h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Full name:</strong> {{ $client->name }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $client->email }}</li>
                <li class="list-group-item"><strong>Phone:</strong> {{ $client->clientProfile->phone_number }}</li>
                <li class="list-group-item"><strong>Address:</strong> {{ $client->clientProfile->address }}</li>
                <li class="list-group-item"><strong>Register date:</strong> {{ $client->created_at->format('d/m/Y') }}</li>
            </ul>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
