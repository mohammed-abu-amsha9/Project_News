<?php

namespace App\Http\Controllers;

use App\Models\article;
use App\Models\comment;
use Illuminate\Http\Request;

class CommentController extends Controller
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
        //
        $request->validate([
            'comment' => 'required|string',
            'article_id' => 'required|exists:articles,id',
        ]);
        $comment = new comment();
        $comment->comment = $request->input('comment');
        $comment->user_id = auth()->user()->id;
        $comment->article_id = $request->input('article_id');
        $isSaved = $comment->save();
        return redirect()->back()->with([
            'status'=> $isSaved,
            'icon' => $isSaved ? 'success' : 'error',
            'message' =>  $isSaved ? "تمت  نشر التعليق" : "لم يتم الاضافة يرجى التحقق من البيانات"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        // جلب المقال مع التعليقات ومعلومات كل مستخدم كتب تعليق
        // $article = article::with(['comments.user' => function ($query) {
        //     $query->where('visible', true)
        //           ->whereNull('parent_id')
        //           ->with(['user', 'replies.user']);
        //         }])->findOrFail($id);
        //         dd($article);
        // return view('articles.show', ['article' => $article]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        comment::findOrFail($id)->delete();
        return redirect()->back()->with([
            'status' => true,
            'icon' => true ? 'success' : 'error',
            'message' => true ? 'تم حذف التعليق بالكامل.' : 'حدث خطا'
        ]);
    }
}
