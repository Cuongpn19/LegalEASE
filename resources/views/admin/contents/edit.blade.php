@extends('layouts.admin')
@section('main')
    <div class="container mt-4">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">EDIT ARTICLE</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.contents.update', $content->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="fw-bold">Article title</label>
                        <input type="text" name="title" class="form-control" value="{{ $content->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold d-block">Current profile picture</label>
                        @if ($content->image)
                            <img src="{{ asset('storage/' . $content->image) }}" class="img-thumbnail mb-2"
                                style="width: 200px;">
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Leave it blank if you don't want to change the image.</small>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">
                            Detailed content</label>
                        <textarea name="content" class="form-control" rows="10" id="editor">{{ $content->content }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">Save</button>
                        <a href="{{ route('admin.contents.index') }}" class="btn btn-secondary px-4">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
