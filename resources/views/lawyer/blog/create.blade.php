@extends('layouts.lawyer')

@section('main')
    <div class="container" style="max-width: 700px">

        <h4 class="mb-4">Post a blog post</h4>

        <form action="{{ route('lawyer.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="fw-bold">Article title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter title..." required>
            </div>
            <div class="mb-3">
                <textarea name="content" class="form-control" rows="5" placeholder="Enter blog content..." required></textarea>
            </div>

            <div class="mb-3">
                <input type="file" name="image" class="form-control">
            </div>

            <button class="btn btn-primary" onsubmit="this.querySelector('button').disabled=true;">
                Post
            </button>
        </form>

    </div>
@endsection
