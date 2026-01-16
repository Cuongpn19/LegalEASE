@extends('layouts.admin')
@section('main')
    <div class="container mt-4">
        <div class="card shadow border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold text-primary">ARTICLE DETAILS</h5>
                <a href="{{ route('admin.contents.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                {{-- Tiêu đề --}}
                <h1 class="fw-bold mb-3">{{ $content->title }}</h1>

                {{-- Thông tin tác giả & Ngày đăng --}}
                <div class="mb-4 text-muted">
                    <span class="me-3"><i class="fas fa-user-tie me-1"></i> Author:
                        <strong>{{ $content->author->name }}</strong></span>
                    <span><i class="fas fa-calendar-alt me-1"></i> Date posted:
                        {{ $content->created_at->format('d/m/Y H:i') }}</span>
                </div>

                <hr>

                {{-- Hình ảnh đại diện --}}
                @if ($content->image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $content->image) }}" class="img-fluid rounded shadow"
                            style="max-height: 400px;">
                    </div>
                @endif

                {{-- Nội dung bài viết --}}
                <div class="content-body lh-lg" style="font-size: 1.1rem; text-align: justify;">
                    {!! nl2br(e($content->content)) !!}
                </div>
            </div>
            <div class="card-footer bg-light text-end">
                <a href="{{ route('admin.contents.edit', $content->id) }}" class="btn btn-warning fw-bold">
                    <i class="fas fa-edit"></i> Edit this post
                </a>
            </div>
        </div>
    </div>
@endsection
