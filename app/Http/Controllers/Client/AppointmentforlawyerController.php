<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Appointments;
use App\Models\Consultation;
use App\Models\Lawyer_profiles;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentforlawyerController extends Controller
{
    public function create($id){
        $lawyer=Lawyer_profiles::findOrFail($id);
        return view ('client.appointment');
    }

    public function store(Request $request){
        $appointment= new Appointments();
        $appointment->client_id = $request->client_id;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->notes=$request->notes;
        $appointment-> save();
        return redirect()->back()->with('success', 'Your appointment sended successfully');
    }
    public function accept(Request $request){
        $id = $request->id;
        $accept = Appointments::findOrFail($id);
        $accept->status = 'confirmed';
        $accept->save();
        return back()->with('success', 'Your status updated successfully');
    }

    public function decline(Request $request){
        $id=$request->id;
        $accept = Appointments::findOrFail($id);
        $accept->status = 'cancelled';
        $accept->save();
        return back()->with('success', 'Your status updated successfully');
    }


    public function done(Request $request){
        $id=$request->id;
        $done=Appointments::findOrFail($id);
        $done->status = 'completed';
        $done->save();
        return back()->with('success', 'Your status updated successfully');
    }

    public function question($id){
        $lawyer=Lawyer_profiles::with('user')->where('user_id', $id)->firstOrFail();
        return view('client.question', compact('lawyer'));
    }

    public function storequestion(Request $request){
        Consultation::create([
            'client_id'=>Auth::id(),
            'lawyer_id'=>$request->lawyer_id,
            'question'=>$request->question,
        ]);
        return redirect()->back()->with('success', 'success');
    }

    public function showquestion(){
        $id = Auth::id();
        $storequestion=Consultation::with('lawyer', 'client')->where('lawyer_id', $id)->get();
        return view('lawyer.question.index', compact('storequestion'));

    }
}
