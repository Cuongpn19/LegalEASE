<?php

namespace App\Http\Controllers;

use App\Models\Legal_updates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    // XEM BLOG (ai cũng xem được)
    public function index()
    {
        $posts = Legal_updates::with('author')
            ->latest()
            ->get();

        return view('lawyer.blog.index', compact('posts'));
    }

    // FORM ĐĂNG BLOG (chỉ luật sư)
    public function create()
    {
        // nếu bạn có role lawyer thì check ở đây
        // if (Auth::user()->role !== 'lawyer') abort(403);

        return view('lawyer.blog.create');
    }

    // LƯU BLOG (chỉ luật sư)
   public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|max:255', // Thêm validate cho tiêu đề
            'content' => 'required',
            'image'   => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Lưu vào public/blogs để asset('storage/blogs/...') gọi ra được
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        Legal_updates::create([
            'title'     => $request->title,   // PHẢI THÊM DÒNG NÀY ĐỂ HẾT LỖI
            'content'   => $request->content,
            'image'     => $imagePath,
            'author_id' => Auth::id(),
        ]);

        return redirect()->route('lawyer.blog');
    }
    
}
