@extends('layouts.admin')
@section('main')
    <form action="{{ route('admin.contents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="fw-bold">Article title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter title..." required>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Avatar</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="fw-bold">Content</label>
            {{-- Bạn có thể tích hợp CKEditor ở đây --}}
            <textarea name="content" id="editor" class="form-control" rows="10"></textarea>
        </div>

        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-paper-plane me-1"></i> Publish
        </button>
    </form>
@endsection
