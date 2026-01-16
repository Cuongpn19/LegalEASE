@extends('layouts.lawyer')
@section('main')
    <div class="container py-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 text-primary fw-bold">
                    <i class="fas fa-question-circle me-2"></i>List of customer questions
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" style="width: 20%">Client</th>
                                <th style="width: 35%">Question content</th>
                                <th style="width: 45%">Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($storequestion as $s)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $s->client->name ?? 'Ẩn danh' }}</div>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-secondary">{{ $s->question }}</p>
                                    </td>
                                    <td class="pe-4">
                                        @if ($s->answer)
                                            <div
                                                class="p-2 rounded bg-primary bg-opacity-10 border border-primary border-opacity-25">
                                                <small class="d-block fw-bold text-primary mb-1">
                                                    <i class="fas fa-check-double me-1"></i>Answered:
                                                </small>
                                                <span class="text-dark">{{ $s->answer }}</span>
                                            </div>
                                            <a href="?edit_id={{ $s->id }}" class="row-link"
                                                style="margin-top:20px">Edit</a>
                                            @if (request('edit_id') == $s->id)
                                                <form action="{{ route('lawyer.reanswer', $s->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <textarea name="answer" class="form-control">{{ $s->answer }}</textarea>
                                                    <button class="btn btn-primary btn-sm mt-1">Save</button>
                                                    <a href="{{ route('lawyer.question') }}"
                                                        class="btn btn-secondary btn-sm mt-1">Cancel</a>
                                                </form>
                                            @else
                                                <p>{{ $s->content }}</p>
                                            @endif
                                        @else
                                            <form action="{{ route('lawyer.answer') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="consultation_id" value="{{ $s->id }}">
                                                <div class="input-group">
                                                    <input type="text" name="answer"
                                                        class="form-control border-success-subtle"
                                                        placeholder="Enter your advice..." required>
                                                    <button class="btn btn-success px-3" type="submit">
                                                        <i class="fas fa-paper-plane me-1"></i> Send
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($storequestion->isEmpty())
                <div class="card-body text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80"
                        class="opacity-25 mb-3">
                    <p class="text-muted">There are currently no questions that need to be addressed.</p>
                </div>
            @endif
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
