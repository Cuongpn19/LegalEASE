@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-md-8">
                <h1 class="fw-bold text-navy mb-2">Page Not Found</h1>
                <p class="lead mb-4">I'm looking...</p>

                <div class="mb-4">
                    <img src="{{ asset('storage/uploads/contents/shebasearch.jpg') }}" alt="Lost Pug"
                        class="img-fluid rounded shadow-sm" style="max-width: 500px; border: 1px solid #ddd;">
                </div>

                <h3 class="fw-bold mt-4">But I just can't find that page anywhere.</h3>
                <p class="text-muted italic">Perhaps I should look at the screen instead of this treat...</p>

                <div class="mt-4">
                    <p>You can <a href="{{ url('/') }}" class="text-primary fw-bold text-decoration-none">Return to the
                            home page</a>, or try the Search above.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .text-navy {
            color: #1a2a44;
        }

        .italic {
            font-style: italic;
        }
    </style>
@endsection
