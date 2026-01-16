@extends('layouts.lawyer')
@section('main')
    <div class="container" style="max-width: 900px">

        <h3 class="mb-4">Lawyer's comments</h3>

        @auth
            <a href="{{ route('lawyer.blogs.create') }}" class="btn btn-primary mb-4">
                Post a new article
            </a>
        @endauth

        @foreach ($posts as $post)
            <div class="card mb-4">
                <div class="card-body">

                    <b>{{ $post->author->name }}</b>
                    <p class="text-muted small">
                        {{ $post->created_at->format('d/m/Y H:i') }}
                    </p>

                    <p>{{ $post->content }}</p>

                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded">
                    @endif

                    <hr>

                </div>
            </div>
        @endforeach

    </div>

    <style>
        body {
            background: #f5f6f8;
        }

        .blog-wrapper {
            max-width: 950px;
            margin: 0 auto;
            padding: 24px;
        }

        /* FORM ĐĂNG BÀI */
        .post-form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }

        .post-form textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px;
            min-height: 90px;
            resize: vertical;
        }

        .post-form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px;
        }

        .post-form button {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
        }

        /* POST */
        .post-card {
            background: #fff;
            padding: 24px;
            border-radius: 10px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }

        .post-header {
            display: flex;
            justify-content: space-between;
            color: #555;
            font-size: 14px;
        }

        .post-content {
            margin: 16px 0;
            font-size: 16px;
            line-height: 1.7;
            color: #1f2937;
        }

        .post-image {
            max-width: 100%;
            border-radius: 8px;
            margin-top: 12px;
        }

        /* COMMENT */
        .comment-section {
            margin-top: 20px;
        }

        .comment {
            background: #f9fafb;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .comment p {
            margin: 6px 0;
        }

        .comment-children {
            margin-left: 24px;
            margin-top: 10px;
        }

        .comment-form textarea,
        .reply-form textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 8px;
            margin-top: 6px;
        }

        .comment-form button,
        .reply-form button {
            margin-top: 6px;
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
        }
    </style>
@endsection
