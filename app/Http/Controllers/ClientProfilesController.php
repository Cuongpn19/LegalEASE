<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Client_profiles;
use App\Models\Reviews;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ClientProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = User::where('role', 'client')->with('clientProfile')->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function dashboard()
    {
        $clientId = Auth::id();

            $hour = date('H');
        if ($hour < 12) {
            $greeting = 'Good Morning';
            $icon = 'fa-sun';
        } elseif ($hour < 18) {
            $greeting = 'Good Afternoon';
            $icon = 'fa-cloud-sun';
        } else {
            $greeting = 'Good Evening';
            $icon = 'fa-moon';
        }

        // Thống kê
        $stats = [
            'upcoming' => Appointments::where('client_id', $clientId)->where('status', 'confirmed')->count(),
            'completed' => Appointments::where('client_id', $clientId)->where('status', 'completed')->count(),
            'pending' => Appointments::where('client_id', $clientId)->where('status', 'pending')->count(),
        ];

        // Lấy 5 lịch hẹn mới nhất
        $recentAppointments = Appointments::with('lawyer')
            ->where('client_id', $clientId)
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard', compact('stats', 'recentAppointments', 'greeting', 'icon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:10',
            'address' => 'required|string|max:500',
        ]);

        $client = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'client',
            'status' => 'active',
            'password' => bcrypt('password'), // Mặc định mật khẩu
        ]);

        $client->clientProfile()->create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.clients.index')->with('success', 'The client has been successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = User::where('role', 'client')->with(['clientProfile'])->findOrFail($id);
        return view('admin.clients.show', compact('client'));
    }

     public function showLawyer($id)
    {
    $lawyer = User::where('id', $id)
        ->where('role', 'lawyer')
        ->whereHas('lawyerProfile')
        ->with('lawyerProfile')
        ->firstOrFail();

    return view('client.lawyers.show', compact('lawyer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = User::with('clientProfile')->findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'phone_number' => 'required|string|max:10',
            'address' => 'required|string|max:500',
        ]);

        $client = User::findOrFail($id);
        $client->clientProfile()->updateOrCreate(
            ['user_id' => $client->id], // Điều kiện tìm kiếm theo user_id
            [
                'name' => $request->name ?? '',
                'phone_number' => $request->phone_number ?? '',
                'address'      => $request->address ?? '',
            ]
        );

        return redirect()->route('admin.clients.index')->with('success', 'Update successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa khách hàng');
    }

    public function findLawyer(Request $request)
    {
        // Lấy danh sách các chuyên ngành (Unique) để làm bộ lọc
        // Giả sử chuyên ngành nằm trong bảng lawyer_profiles
        $specializations = \App\Models\Lawyer_profiles::distinct()->pluck('specialization')->filter();
        $locations = \App\Models\Lawyer_profiles::distinct()->pluck('location')->filter(); // Lấy thêm địa điểm

        // Query danh sách luật sư có trạng thái 'active'
        $query = \App\Models\User::where('role', 'lawyer')->where('status', 'active');

        // Lọc theo tên nếu có
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo chuyên ngành thông qua quan hệ lawyerProfile
        if ($request->has('specialization') && $request->specialization != '') {
            $query->whereHas('lawyerProfile', function($q) use ($request) {
                $q->where('specialization', $request->specialization);
            });
        }

        //Lọc theo Địa chỉ/Khu vực (Mới)
        if ($request->filled('location')) {
            $query->whereHas('lawyerProfile', function($q) use ($request) {
                $q->where('location', 'like', '%' . $request->location . '%');
            });
        }

        $lawyers = $query->with('lawyerProfile')->paginate(10);

        return view('client.lawyers.index', compact('lawyers', 'specializations', 'locations'));
    }

    public function book($id)
    {
        $lawyer = User::findOrFail($id);

        // Giả sử bạn muốn kiểm tra các khung giờ đã đặt cho ngày hiện tại hoặc khi user chọn ngày
        // Ở đây ta định nghĩa các khung giờ làm việc
        $timeSlots = [
            '08:00:00', '09:00:00', '10:00:00', '11:00:00',
            '14:00:00', '15:00:00', '16:00:00', '17:00:00'
        ];

        return view('client.lawyers.book', compact('lawyer', 'timeSlots'));
    }

    // Hàm này để gọi qua AJAX khi khách hàng chọn ngày khác nhau
    public function checkAvailability(Request $request)
    {
        $bookedTimes = Appointments::where('lawyer_id', $request->lawyer_id)
            ->where('appointment_date', $request->date)
            ->whereIn('status', ['pending', 'confirmed', 'completed']) // Block các lịch chưa bị hủy
            ->pluck('start_time')
            ->map(function($time) {
            // Đảm bảo trả về định dạng "08:00:00" để khớp với value của radio button
            return \Carbon\Carbon::parse($time)->format('H:i:s');
        })
            ->toArray();

        return response()->json($bookedTimes);
    }

    public function showBookingForm($id)
    {
        $lawyer = User::where('role', 'lawyer')->findOrFail($id);
        return view('client.lawyers.booking', compact('lawyer'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'lawyer_id' => 'required',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'notes' => 'nullable|string|max:500',
        ]);

        $isBooked = Appointments::where('lawyer_id', $request->lawyer_id)
        ->where('appointment_date', $request->appointment_date)
        ->where('start_time', $request->start_time)
        ->whereIn('status', ['pending', 'confirmed', 'completed'])
        ->exists();

        if ($isBooked)
        {
            return back()->withErrors(['start_time' => 'Unfortunately, this time slot is already booked. Please choose a different time!'])
                        ->withInput();
        }

        Appointments::create([
            'client_id' => Auth::id(),
            'lawyer_id' => $request->lawyer_id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return redirect()->route('client.dashboard')->with('success', 'Booking request sent!');
    }

    public function myAppointments()
    {
        $appointments = Appointments::with('lawyer')
            ->where('client_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('client.appointments.index', compact('appointments'));
    }

    public function cancelAppointment($id)
    {
        $appointment = Appointments::where('id', $id)
            ->where('client_id', Auth::id())
            ->firstOrFail();

        // Chỉ cho phép hủy nếu trạng thái đang là pending hoặc confirmed
        if (in_array($appointment->status, ['pending', 'confirmed'])) {
            $appointment->update(['status' => 'cancelled']);
            return back()->with('success', 'The appointment has been successfully canceled.');
        }

        return back()->with('error', 'It is not possible to cancel an appointment in this state.');
    }

    public function storeReview(Request $request, $appointmentId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $appointment = Appointments::where('id', $appointmentId)
            ->where('client_id', Auth::id())
            ->where('status', 'completed')
            ->firstOrFail();

        Reviews::updateOrCreate(
            ['appointment_id' => $appointmentId],
            [
                'client_id' => Auth::id(),
                'lawyer_id' => $appointment->lawyer_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return back()->with('success', 'Thank you for leaving a review!');
    }

    public function myProfile()
    {
        $user = Auth::user();
        $profile = $user->clientProfile;
        return view('client.profile.index', compact('user', 'profile'));
    }

    public function updateAccount(Request $request)
    {
        $id = Auth::id();

        $validatedAccount = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        User::where('id', $id)->update($validatedAccount);

        return back()->with('success', 'Account information updated.');
    }

    public function updateProfile(Request $request)
    {
        // dd($request->all());
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validatedProfile = $request->validate([
            'full_name' => 'required|string|max:50',
            'phone_number' => 'nullable|string|max:20|regex:/^\d+$/',
            'address'      => 'nullable|string|max:255',
        ]);

        $user->clientProfile()->updateOrCreate(
            ['user_id' => $user->id],
                [
                    'name' => $validatedProfile['full_name'], // or 'name'
                    'phone_number' => $validatedProfile['phone_number'],
                    'address' => $validatedProfile['address'],
                ]
        );
        return back()->with('success', 'Profile information updated.');
    }

    public function settings() {
        return view('client.profile.settings');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }
        $user->update(['password' => Hash::make($request->new_password)]);
        return back()->with('success', 'Password changed successfully!');
    }
}
