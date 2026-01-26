<?php

namespace App\Http\Controllers;

use App\Models\Legal_updates;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LegalUpdatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Legal_updates::with('author');

        if($request->has('author_id')){
            $query->where('author_id', $request->author_id);
        }
        $updates = $query->latest()->paginate(10);
        $lawyers = User::where('role', 'lawyer')->get();

        return view('admin.contents.index', compact('updates', 'lawyers'));
    }

    public function index1(Request $request)
    {
        $updates = Legal_updates::when($request->keyword, function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%');
            })
            ->when($request->specialization, function ($q) use ($request) {
                $q->where('specialization_id', $request->specialization);
            })
            ->paginate(5)
            ->withQueryString();

        $specializations = Specialization::all();

        return view('pages.askLawyer', compact('updates', 'specializations'));
    }

    public function show1(Legal_updates $update)
    {
        return view('pages.askLawyerDetail', compact('update'));
    }



    public function authorProfile($id)
    {
        $author = User::with('legal_updates')->findOrFail($id); // Theo dõi blog của luật sư cụ thể
        return view('admin.content.author_detail', compact('author'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Giới hạn 2MB
    ]);

        $data = $request->only(['title', 'content']);
        $data['author_id'] = Auth::id() ?? '1'; // Tự động gán ID luật sư đang đăng nhập

        if ($request->hasFile('image')) {
            // Lưu ảnh vào thư mục public/uploads/contents
            $data['image'] = $request->file('image')->store('uploads/contents', 'public');
        }

        Legal_updates::create($data);

        return redirect()->route('admin.contents.index')->with('success', 'Đã đăng bài viết mới thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $content = Legal_updates::with('author')->findOrFail($id);
        return view('admin.contents.show', compact('content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $content = Legal_updates::findOrFail($id);
        return view('admin.contents.edit', compact('content'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $content = Legal_updates::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['title', 'content']);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại trong storage để tránh rác server
            if ($content->image) {
                Storage::disk('public')->delete($content->image);
            }
            // Lưu ảnh mới
            $data['image'] = $request->file('image')->store('uploads/contents', 'public');
        }

        $content->update($data);

        return redirect()->route('admin.contents.index')->with('success', 'Cập nhật nội dung thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Legal_updates::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa bài đăng thành công.');
    }
}
