<?php

namespace App\Http\Controllers;

use App\Models\articleLike;
use Illuminate\Http\Request;

class ArticleLikeController extends Controller
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
            'article_id' => 'required|exists:articles,id',
        ]);

        $userId = auth()->id();
        $articleId = $request->input('article_id');

        // تحقق إذا الإعجاب موجود بالفعل
        $alreadyLiked = articleLike::where('user_id', $userId)
            ->where('article_id', $articleId)
            ->exists();

        if ($alreadyLiked) {
            return redirect()->back()->with([
                'status' => false,
                'icon' => 'info',
                'message' => 'لقد قمت بالإعجاب بهذا المقال مسبقاً.'
            ]);
        }

        // إنشاء الإعجاب
        $articleLike = new articleLike();
        $articleLike->user_id = $userId;
        $articleLike->article_id = $articleId;
        $articleLike->save();

        return redirect()->back()->with([
            'status' => true,
            'icon' => 'success',
            'message' => 'تم تسجيل الإعجاب.'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(articleLike $articleLike)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(articleLike $articleLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, articleLike $articleLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(articleLike $articleLike)
    {
        //
    }
}
