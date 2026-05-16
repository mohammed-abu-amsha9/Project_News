<?php

namespace App\Http\Controllers;

use App\Models\article;
use App\Models\blockedComment;
use App\Models\comment;
use Illuminate\Http\Request;

class BlockedCommentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(blockedComment::class, 'blockedComment');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $article = comment::where('visible', false)->get();
        // dd($article);
        return response()->view('articles.blockedComments', ['article' => $article]);
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
    }

    /**
     * Display the specified resource.
     */
    public function show(blockedComment $blockedComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(blockedComment $blockedComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, blockedComment $blockedComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
    public function block(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $comment = comment::findOrFail($id);

        $BlockedComment = new blockedComment();
        $BlockedComment->comment_id = $comment->id;
        $BlockedComment->article_id = $comment->article_id;
        $BlockedComment->reason = $request->input('reason');
        $BlockedComment->blocked_by = auth()->id();
        $BlockedComment->blocked_at = now();
        $BlockedComment->save();
        // نخفيه من الواجهة مثلاً
        $comment->visible = false;
        $comment->save();

        return redirect()->back()->with([
            'status' => true,
            'icon' => true ? 'success' : 'error',
            'message' => true ? 'التعليق قيد المراجعة' : 'حدث خطا'
        ]);
    }

    public function recover(request $request , $id)
    {
        $comment = comment::findOrFail($id);
        $comment->visible = true;
        $comment->save();
        return redirect()->back()->with([
            'status' => true,
            'icon' => true ? 'success' : 'error',
            'message' => true ? 'تم استعادة التعليق بنجاح.' : 'حدث خطا'
        ]);
    }
}
