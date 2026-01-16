@extends('layouts.admin')
@section('main')
    {{-- <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary text-white">
                <h6 class="m-0 font-weight-bold">Quản lý lịch rảnh cố định</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('availabilities.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-3">
                        <label>Thứ trong tuần</label>
                        <select name="day_of_week" class="form-control" required>
                            <option value="Monday">Monday (Thứ 2)</option>
                            <option value="Tuesday">Tuesday (Thứ 3)</option>
                            <option value="Wednesday">Wednesday (Thứ 4)</option>
                            <option value="Thursday">Thursday (Thứ 5)</option>
                            <option value="Friday">Friday (Thứ 6)</option>
                            <option value="Saturday">Saturday (Thứ 7)</option>
                            <option value="Sunday">Sunday (Chủ nhật)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Giờ bắt đầu</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Giờ kết thúc</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">Thêm lịch rảnh</button>
                    </div>
                </form>

                <hr>

                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>Thứ</th>
                            <th>Khung giờ</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($availabilities as $item)
                            <tr>
                                <td>{{ $item->day_of_week }}</td>
                                <td>{{ $item->start_time }} - {{ $item->end_time }}</td>
                                <td>
                                    <form action="{{ route('availabilities.destroy', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
    <pre>
COUNT: {{ $availabilities->count() }}
</pre>

    @if ($availabilities->isEmpty())
        <p>No appointment yet.</p>
    @endif

    @foreach ($availabilities as $item)
        <tr>
            <td>{{ $item->day_of_week }}</td>
            <td>{{ $item->start_time }}</td>
            <td>{{ $item->end_time }}</td>
            <td>{{ $item->status }}</td>
        </tr>
    @endforeach
@endsection
