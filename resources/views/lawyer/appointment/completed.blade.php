@extends('layouts.lawyer')
@section('main')
    <style>
        .custom-table {
            border-collapse: separate;
            border-spacing: 0 10px;
            /* Tạo khoảng cách giữa các hàng */
            background-color: transparent !important;
        }

        .custom-table thead th {
            border: none;
            color: #8898aa;
            /* Màu chữ tiêu đề nhạt đi cho sang */
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            padding-bottom: 15px;
        }

        .custom-table tbody tr {
            background-color: #fff;
            /* Nền trắng cho từng hàng */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            /* Đổ bóng nhẹ cho hàng */
            transition: all 0.3s;
        }

        .custom-table tbody tr:hover {
            transform: scale(1.01);
            /* Nhích nhẹ khi di chuột */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .custom-table tbody td {
            padding: 20px;
            vertical-align: middle;
            border: none;
        }

        .custom-table tbody td:first-child {
            border-radius: 12px 0 0 12px;
        }

        /* Bo góc trái hàng */
        .custom-table tbody td:last-child {
            border-radius: 0 12px 12px 0;
        }

        /* Bo góc phải hàng */

        /* Màu cho các trạng thái (Badge) */
        .badge-soft-warning {
            background-color: #fef5e5;
            color: #f39c12;
            border: none;
        }

        .badge-soft-success {
            background-color: #e8fadf;
            color: #28a745;
            border: none;
        }

        .appointment-card {
            background-color: #fffdf2;
            /* Màu vàng nhẹ */
            border: 1px solid #f0e68c;
            /* Viền vàng nhạt */
            border-radius: 8px;
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
            /* Hiệu ứng đổ bóng ở dưới */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1), 0 6px 6px rgba(0, 0, 0, 0.05);
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #857b26;
            /* Màu chữ nâu vàng cho đẹp */
        }

        .form-group input,
        .form-group textarea {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            font-family: sans-serif;
        }

        .btn-done {
            background-color: #ffffff;
            border: 2px solid #857b26;
            color: #857b26;
            padding: 8px 25px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            float: right;
            transition: all 0.3s;
        }

        .btn-done:hover {
            background-color: #857b26;
            color: white;
        }

        /* Clearfix cho nút float */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>

    <h4 class="mb-4 font-weight-bold text-dark">📅 Consultation completed</h4>

    <table class="table custom-table">
        <thead>
            <tr>
                <th>Client</th>
                <th>Date</th>
                <th>Status</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($completed as $d)
                <tr>

                    <td>
                        <div class="d-flex align-items-center">

                            <div>
                                <span class="font-weight-bold d-block text-dark">{{ $d->client?->name ?? 'Stranger' }}</span>
                            </div>
                        </div>
                    </td>
                    <td>{{ $d->appointment_date }}</td>
                    <td>
                        <span class="badge badge-pill badge-soft-success px-3 py-2">{{ $d->status }}</span>
                    </td>
                    <td class="text-muted">{{ $d->notes }}</td>
            @endforeach
        </tbody>
    </table>
    <a href="{{ Route('lawyer.dashboard') }}" class="text-decoration-none text-blue">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
@endsection
