<?php

namespace App\Http\Controllers;

use App\Models\commentLike;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        $userId = auth()->id(); // أو auth('web')->id() حسب الـ guard
        $commentId = $request->input('comment_id');

        // هل المستخدم قد أعجب مسبقًا؟
        $existingLike = CommentLike::where('user_id', $userId)
            ->where('comment_id', $commentId)
            ->first();

        if ($existingLike) {
            // إزالة الإعجاب (toggle off)
            $existingLike->delete();
            return redirect()->back();
        } else {
            // إضافة إعجاب جديد
            CommentLike::create([
                'user_id' => $userId,
                'comment_id' => $commentId,
            ]);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(commentLike $commentLike)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(commentLike $commentLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, commentLike $commentLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(commentLike $commentLike)
    {
        //
    }
}
