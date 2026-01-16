<?php

namespace App\Http\Controllers;

use App\Models\Lawyer_profiles;
use App\Models\Legal_updates;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Nếu đã login thì redirect dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        $query = Legal_updates::with('author');
              if($request->has('author_id')){
                    $query->where('author_id', $request->author_id);
                }
                $updates = $query->latest()->paginate(10);
                 $lawyers = User::where('role', 'lawyer')->get();
        // User chưa login → homepage public
        return view('home', compact('updates', 'lawyers'));

    }

    public function show($id)
    {
        $blog = Legal_updates::findOrFail($id);
        return view('blog.show', compact('blog'));
    }
}
