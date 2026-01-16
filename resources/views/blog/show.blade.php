{{-- resources/views/blog/show.blade.php --}}
@extends('layouts.app')

@section('title', $blog->title)

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <article class="content-box">
                <h1 class="fw-bold text-primary mb-3">
                    {{ $blog->title }}
                </h1>

                <img src="{{ Storage::url($blog->image) }}" class="img-fluid mb-4 rounded">

                <div class="text-muted small mb-3">
                    Published on {{ $blog->created_at->format('d M Y') }}
                </div>

                <div class="blog-content">
                    {!! nl2br(e($blog->content)) !!}
                </div>
            </article>

        </div>
    </div>
@endsection
