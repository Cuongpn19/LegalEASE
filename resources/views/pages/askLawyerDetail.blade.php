@extends('layouts.app')

@section('title', $update->title)

@section('content')
    <div class="container py-4">
        <div class="content-box mx-auto" style="max-width: 900px">

            {{-- Back --}}
            <div class="mb-3">
                <a href="{{ route('ask.lawyer') }}" class="text-decoration-none">
                    ← Back to questions
                </a>
            </div>

            {{-- Question --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold mb-3">
                        {{ $update->title }}
                    </h4>

                    <p class="text-muted">
                        {{ $update->content }}
                    </p>

                    <small class="text-muted">
                        Asked on {{ optional($update->created_at)->format('d M Y') }}
                    </small>
                </div>
            </div>

            {{-- Answers --}}
            <h5 class="fw-bold mb-3">Answers</h5>

            @forelse ($update->answers ?? [] as $answer)
                <div class="card mb-3 border-0 bg-light">
                    <div class="card-body">
                        <p class="mb-2">
                            {{ $answer->content }}
                        </p>

                        <small class="text-muted">
                            Answered by Lawyer
                        </small>
                    </div>
                </div>
            @empty
                <p class="text-muted">No answers yet.</p>
            @endforelse

            {{-- Answer form --}}
            @auth
                @if (auth()->user()->role === 'lawyer')
                    <div class="card mt-4 border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Your Answer</h6>

                            <form method="POST" action="{{ route('updates.answer', $update->id) }}">
                                @csrf
                                <textarea name="content" class="form-control mb-3" rows="4" required></textarea>

                                <button class="btn btn-primary">
                                    Submit Answer
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth

        </div>
    </div>
@endsection
