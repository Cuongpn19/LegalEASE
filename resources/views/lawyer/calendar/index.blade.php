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
</style>

<body>
    <div class="booking-card shadow-sm">
        <div class="left-panel">
            <img src="https://via.placeholder.com/80" class="profile-img">
            <p class="lawyer-name"></p>
            <h1 class="meeting-title">15 Minute Meeting</h1>
            <div class="duration"><i class="far fa-clock me-2"></i> 15 min</div>
            <p class="desc">Chọn một ngày và giờ phù hợp để chúng ta bắt đầu buổi tư vấn.</p>
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
                <i class="fas fa-globe me-1"></i> Indochina Time ({{ date('H:i') }})
            </div>
        </div>
    </div>

    <script>
        let currentMonth = 0; // January
        let currentYear = 2026;
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
            "October", "November", "December"
        ];

        function renderCalendar(month, year) {
            const calendarBody = document.getElementById("calendarBody");
            const monthDisplay = document.getElementById("monthDisplay");
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
                        // Gắn sự kiện onclick trực tiếp vào đây
                        cell.innerHTML =
                            `<span class="day-item available" onclick="showSlots(${date}, ${month}, ${year}, this)">${date}</span>`;
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
            // Highlight ngày chọn
            document.querySelectorAll('.day-item').forEach(d => d.classList.remove('selected'));
            el.classList.add('selected');

            // Bung lụa khung giờ
            document.getElementById('calendar-container').style.flex = "0 0 60%";
            const timeBox = document.getElementById('time-slots-container');
            timeBox.style.width = "40%";
            timeBox.style.opacity = "1";
            timeBox.style.paddingLeft = "10px";

            // Cập nhật tiêu đề ngày
            document.getElementById('selected-date-title').innerText = `${monthNames[month]} ${day}`;

            // Đổ giờ mẫu
            const times = ["09:00", "09:30", "10:00", "10:30", "11:00", "14:00", "15:00"];
            let html = "";
            times.forEach(t => {
                html += `<button class="time-btn" onclick="this.classList.toggle('active')">${t}</button>`;
            });
            document.getElementById('time-list').innerHTML = html;
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
