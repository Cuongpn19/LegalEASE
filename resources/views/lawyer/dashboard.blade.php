@extends('layouts.lawyer')
@section('main')
    <style>
        .stat-card {
            border: none;
            border-radius: 16px;
            /* Bo góc nhiều hơn nhìn sẽ hiện đại */
            transition: transform 0.3s;
            overflow: hidden;
            color: #fff;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            /* Hiệu ứng bay bổng khi di chuột vào */
        }

        .card-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 4rem;
            opacity: 0.2;
            /* Icon ẩn nhẹ phía sau nhìn rất sang */
        }

        /* Bảng màu sang trọng */
        .bg-navy {
            background: linear-gradient(45deg, #2c3e50, #4ca1af);
        }

        .bg-gold {
            background: linear-gradient(45deg, #f39c12, #f1c40f);
        }

        .bg-teal {
            background: linear-gradient(45deg, #16a085, #1abc9c);
        }

        .bg-berry {
            background: linear-gradient(45deg, #8e44ad, #c39bd3);
        }
    </style>

    <div class="container">
        <div class="row mb-5 " style="padding-left: 2%; padding-right: 2%;">
            <div class="col-md-4">
                <div class="card stat-card bg-navy shadow-lg h-100">
                    <div class="card-body p-4">
                        <a href="{{ Route('lawyer.pendingList') }}" class="text-decoration-none text-white">
                            <h2 class="font-weight-bold"> {{ $pending }}</h2>
                            <p class="mb-0 op-7">Pending</p>
                            <i class="fas fa-calendar-alt card-icon"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="card stat-card bg-gold shadow-lg h-100">
                    <div class="card-body p-4 text-dark">
                        <a href="{{ Route('lawyer.confirmedList') }}" class="text-decoration-none text-dark">
                            <h2 class="font-weight-bold">{{ $confirmed }}</h2>
                            <p class="mb-0">Confirmed</p>
                            <i class="fas fa-clock card-icon"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card bg-teal shadow-lg h-100">
                    <div class="card-body p-4">
                        <a href="{{ Route('lawyer.completedList') }}" class="text-decoration-none text-white">
                            <h2 class="font-weight-bold">{{ $completed }}</h2>
                            <p class="mb-0">Completed</p>
                            <i class="fas fa-user-plus card-icon"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="Description" content="Enter your description here" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <title>Profile</title>
    </head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling interface</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .booking-card {
            max-width: 950px;
            margin: 50px auto;
            background: white;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            display: flex;
            overflow: hidden;
        }

        /* Bên trái: Thông tin */
        .left-panel {
            width: 40%;
            padding: 40px;
            border-right: 1px solid #eee;
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .lawyer-name {
            color: #666;
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .meeting-title {
            color: #002d5b;
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .duration {
            color: #555;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .desc {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Bên phải: Lịch */
        .right-panel {
            width: 60%;
            padding: 40px;
        }

        .calendar-header {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .calendar-table {
            width: 100%;
            text-align: center;
        }

        .calendar-table th {
            font-size: 0.75rem;
            color: #777;
            padding-bottom: 15px;
            font-weight: normal;
        }

        .calendar-table td {
            padding: 10px 0;
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
        }

        /* Vòng tròn xanh cho ngày rảnh */
        .day-item {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 50%;
            transition: 0.3s;
        }

        .available {
            background-color: #e8f0fe;
            color: #0061ff;
            font-weight: bold;
        }

        .available:hover {
            background-color: #d0e1fd;
        }

        /* Ngày đang được chọn */
        .selected {
            background-color: #0061ff !important;
            color: white !important;
            position: relative;
        }

        .selected::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
        }

        .timezone {
            font-size: 0.85rem;
            margin-top: 30px;
            color: #444;
        }

        .today {
            background-color: #0061ff !important;
            color: #fff !important;
            font-weight: 800;
        }

        /* Container chứa các nút giờ */
        #time-slots-list {
            padding: 5px;
        }

        /* Style cho từng nút giờ */
        .time-slot-btn {
            background-color: #fff;
            color: #0061ff;
            border: 1px solid #0061ff;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
            margin-bottom: 10px;
            display: block;
            width: 100%;
            text-align: center;
            text-decoration: none;
        }

        /* Hiệu ứng khi di chuột vào (Hover) */
        .time-slot-btn:hover {
            background-color: #0061ff;
            color: #fff;
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 97, 255, 0.2);
        }

        /* Hiệu ứng khi nhấn vào */
        .time-slot-btn:active {
            transform: scale(0.98);
        }

        /* Tùy chỉnh thanh cuộn cho danh sách giờ */
        .time-list-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .time-list-scroll::-webkit-scrollbar-thumb {
            background: #e0e0e0;
            border-radius: 10px;
        }
    </style>
    </style>

    <body>
        <div class="booking-card shadow-sm">
            <div class="left-panel">
                <img src="{{ asset('storage/uploads/contents/business-8598080_640.jpg') }}" class="profile-img">
                <p class="lawyer-name">{{ $name->name }}</p>
                <h1 class="meeting-title">1 Hour Meeting</h1>
                <div class="duration"><i class="far fa-clock me-2"></i> 1 Hour</div>
                <p class="desc">
                    Today <strong>{{ $today->format('d/m/Y') }}</strong>,
                    you have <span class="badge bg-primary">{{ $todayCount }}</span>
                    {{ Str::plural('appointment', $todayCount) }}
                </p>
            </div>

            <div class="right-panel">
                <h5 class="text-center mb-4 fw-bold">SCHEDULE AN ONLINE APPOINTMENT</h5>

                <div class="d-flex" id="booking-wrapper">

                    <div id="calendar-container" style="flex: 1; transition: all 0.3s ease;">
                        <div class="calendar-header d-flex justify-content-between align-items-center mb-4">
                            <i class="fas fa-chevron-left" id="prevMonth" style="cursor: pointer;"></i>
                            <span id="monthDisplay" class="fw-bold"></span>
                            <i class="fas fa-chevron-right text-primary" id="nextMonth" style="cursor: pointer;"></i>
                        </div>
                        <table class="calendar-table w-100">
                            <thead>
                                <tr class="text-muted small">
                                    <th>MON</th>
                                    <th>TUE</th>
                                    <th>WED</th>
                                    <th>THU</th>
                                    <th>FRI</th>
                                    <th>SAT</th>
                                    <th>SUN</th>
                                </tr>
                            </thead>
                            <tbody id="calendarBody"></tbody>
                        </table>
                    </div>

                    <div id="time-slots-container"
                        style="width: 0; opacity: 0; overflow: hidden; transition: all 0.3s ease; border-left: 1px solid #eee; padding-left: 0;">
                        <h6 class="fw-bold mb-3 text-center" id="selected-date-title">Thursday, Jan 15</h6>
                        <div class="time-list-scroll" style="max-height: 350px; overflow-y: auto; padding-right: 10px;">
                            <div class="d-grid gap-2" id="time-slots-list"></div>
                        </div>
                    </div>
                </div>

                <div class="timezone mt-3">
                    <strong>Time zone</strong><br>
                    <i class="fas fa-globe me-1"></i> Time ({{ now()->format('H:i') }})
                </div>
            </div>
        </div>

        <script>
            const appointments = @json($appointments);
            const now = new Date();
            let currentMonth = now.getMonth();
            let currentYear = now.getFullYear();

            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                "October", "November", "December"
            ];

            function renderCalendar(month, year) {
                const calendarBody = document.getElementById("calendarBody");
                const monthDisplay = document.getElementById("monthDisplay");

                const today = new Date();
                const todayDate = today.getDate();
                const todayMonth = today.getMonth();
                const todayYear = today.getFullYear();

                let firstDay = new Date(year, month, 1).getDay();
                let startDay = (firstDay === 0) ? 6 : firstDay - 1;
                let daysInMonth = new Date(year, month + 1, 0).getDate();

                calendarBody.innerHTML = "";
                monthDisplay.innerText = monthNames[month] + " " + year;

                let date = 1;
                for (let i = 0; i < 6; i++) {
                    let row = document.createElement("tr");
                    for (let j = 0; j < 7; j++) {
                        let cell = document.createElement("td");
                        if (i === 0 && j < startDay) {
                            cell.innerHTML = "";
                        } else if (date > daysInMonth) {
                            break;
                        } else {
                            let isToday =
                                date === todayDate &&
                                month === todayMonth &&
                                year === todayYear;

                            cell.innerHTML = `
                    <span
                        class="day-item available ${isToday ? 'today' : ''}"
                        onclick="showSlots(${date}, ${month}, ${year}, this)">
                        ${date}
                    </span>`;
                            date++;
                        }
                        row.appendChild(cell);
                    }
                    calendarBody.appendChild(row);
                    if (date > daysInMonth) break;
                }
            }


            // Hàm xử lý bung khung giờ
            function showSlots(day, month, year, el) {
                // 1. UI feedback
                document.querySelectorAll('.day-item').forEach(d => d.classList.remove('selected'));
                el.classList.add('selected');

                const calendarCont = document.getElementById('calendar-container');
                const timeBox = document.getElementById('time-slots-container');
                calendarCont.style.flex = "0 0 60%";
                timeBox.style.width = "40%";
                timeBox.style.opacity = "1";

                // 2. Cập nhật tiêu đề
                const dateTitle = `${monthNames[month]} ${day}, ${year}`;
                document.getElementById('selected-date-title').innerText = dateTitle;

                // 3. Quan trọng: Tạo chuỗi ngày chuẩn YYYY-MM-DD
                const selectedDateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                // Debug thử xem chuỗi ngày có khớp không
                console.log("Ngày đang chọn:", selectedDateStr);
                console.log("Dữ liệu appointments hiện có:", appointments);

                // 4. Lọc dữ liệu - Kiểm tra cả hai trường hợp chuỗi
                const matchedAppointments = appointments.filter(a => {
                    if (!a.appointment_date) return false;
                    const dbDate = a.appointment_date.substring(0, 10);
                    return dbDate === selectedDateStr;
                });

                // 5. Hiển thị
                let html = "";
                if (matchedAppointments.length === 0) {
                    html = `<div class="text-center py-5"><p class="text-muted">No appointment scheduled!</p></div>`;
                } else {
                    matchedAppointments.forEach((appt, index) => {
                        let timeDisplay = "00:00";
                        if (appt.start_time) {
                            timeDisplay = appt.start_time.substring(0, 5);
                        } else if (appt.appointment_date.includes(' ')) {
                            timeDisplay = appt.appointment_date.split(' ')[1].substring(0, 5);
                        }

                        html += `
                <button class="time-slot-btn mb-3" onclick="viewDetail(${index}, '${selectedDateStr}')">
                    ${timeDisplay}
                </button>`;
                    });
                }

                document.getElementById('time-slots-list').innerHTML = html;
            }

            function viewDetail(index, dateStr) {
                // Lọc lại chính xác danh sách của ngày đó
                const matched = appointments.filter(a => a.appointment_date.substring(0, 10) === dateStr);
                const data = matched[index];

                if (!data) return;

                const modalBody = document.getElementById('modalContent');
                const clientName = data.client ? data.client.name : "Khách hàng";
                const statusLabel = data.status || 'pending';
                const timeVal = data.start_time ? data.start_time.substring(0, 5) : "00:00";

                modalBody.innerHTML = `
        <div class="text-center mb-4">
            <h5 class="fw-bold mb-0">${clientName}</h5>
            <span class="badge bg-primary text-capitalize">${statusLabel}</span>
        </div>
        <div class="p-2 border-bottom mb-2">
            <small class="text-muted d-block">Start time</small>
            <span class="fw-bold text-primary" style="font-size: 1.2rem;">${timeVal}</span>
        </div>
        <div class="p-2">
            <small class="text-muted d-block">Note</small>
            <p class="text-muted">${data.notes || 'Empty'}</p>
        </div>
    `;

                new bootstrap.Modal(document.getElementById('appointmentModal')).show();
            }


            document.getElementById("prevMonth").onclick = () => {
                currentMonth--;
                renderCalendar(currentMonth, currentYear);
            };
            document.getElementById("nextMonth").onclick = () => {
                currentMonth++;
                renderCalendar(currentMonth, currentYear);
            };

            renderCalendar(currentMonth, currentYear);
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    </body>

    </html>
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                <div class="modal-header bg-navy text-white" style="border-radius: 16px 16px 0 0;">
                    <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Appointment details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="modalContent">
                </div>
            </div>
        </div>
    </div>
@endsection
