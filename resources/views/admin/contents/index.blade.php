@extends('layouts.admin')
@section('main')
    <div class="container-fluid">
        {{-- <h2 class="text-center fw-bold mb-4">QUẢN LÝ NỘI DUNG & THÔNG BÁO</h2> --}}


        <a href="{{ route('admin.contents.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Add new article
        </a>

        {{-- Bộ lọc theo luật sư --}}
        <div class="mb-3 mt-2">
            {{-- {{ route('admin.legal-updates.index') }} --}}
            <form action="#" method="GET" class="d-flex gap-2 w-25">
                <select name="author_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- All lawyers --</option>
                    @foreach ($lawyers as $lawyer)
                        <option value="{{ $lawyer->id }}" {{ request('author_id') == $lawyer->id ? 'selected' : '' }}>
                            {{ $lawyer->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Image</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Poster</th>
                            <th class="text-center">Date posted</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($updates as $item)
                            <tr>
                                <td>
                                    @if (!empty($item->image))
                                        <img src="{{ Storage::url($item->image) }}"
                                            style="width:220px;height:150px;object-fit:cover" class="rounded shadow-sm">
                                    @else
                                        <span class="text-muted small">No image</span>
                                    @endif
                                </td>
                                <td class="ps-3 fw-bold">{{ Str::limit($item->title, 60) }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-user-tie me-1"></i> {{ $item->author->name }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $item->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        <a href="{{ route('admin.contents.show', $item->id) }}"
                                            class="btn btn-sm btn-outline-info btn-action-custom" title="View article">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.contents.edit', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary btn-action-custom"
                                            title="Edit PHP artisan storage:link to post">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- Nút xóa --}}
                                        <form action="{{ route('admin.contents.destroy', $item->id) }}" method="POST"
                                            class="m-0">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-action-custom"
                                                onclick="return confirm('Delete this post?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
