<?php

namespace App\Http\Controllers;

use App\Models\article;
use App\Models\articleLike;
use App\Models\category;
use App\Models\User;
use App\Notifications\ArticlePendingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(article $article)
    {
        //
        $this->authorize('viewAny', $article);
        $articles = Article::where('status', 'published')->get();
        return view('articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(article $article)
    {
        //
        $this->authorize('create', $article);
        $category = category::all();

        return response()->view('articles.create', ['categories' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, article $article)
    {
        //
        $this->authorize('create', $article);
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|min:5|max:100',
            'info' => 'required|string|max:1000',
            'Short_description' => 'required|string|max:50',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $article = new article();
        // جلب جميع المحررين
        $article->user_id = auth()->id();
        $article->category_id = $request->input('category_id');
        $article->title = $request->input('title');
        $article->info = $request->input('info');
        $article->Short_description = $request->input('Short_description');
        // 3. تحديد الحالة بناءً على دور المستخدم
        if (auth()->user()->role === 'writer') {
            $article->status = 'draft'; // تلقائي معلق
        } else {
            $article->status = $request->input('status', 'draft'); // محرر/أدمن يختار
        }

        $isSaved = $article->save();
        $editors = User::role('Project Editor')->get();

        // إرسال إشعار لكل محرر
        foreach ($editors as $editor) {
            $editor->notify(new ArticlePendingNotification($article));
        }

        // 5. حفظ الصور في جدول article_images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('articles', 'public');
                $article->images()->create(['path' => $path]);
            }
        }
        return redirect()->back()->with([
            'status' => true,
            'icon' => $isSaved ? 'success' : 'error',
            'message' =>  $isSaved ? "تمت الاضافة بنجاح" : "لم يتم الاضافة يرجى التحقق من البيانات"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // 1. جلب المقال مع الصور والعلاقات المرتبطة
        $article = Article::with([
            'images',
            'user',
            'category',
            'likes',
            'comments' => function ($query) {
                $query->where('visible', true)
                    ->whereNull('parent_id')
                    ->with(['user', 'replies.user', 'likes']); // أضف likes هنا
            }
        ])->findOrFail($id);
        // 2. زيادة عدد المشاهدات لكل مسجل له مشاهدة واحدة
        $key = 'viewed_article_' . $article->id;
        if (!session()->has($key)) {
            $article->increment('views');
            session()->put($key, true);
        }
        $articleLike = articleLike::count('id');
        $relatedArticles = Article::with('images')
            ->where('category_id', $article->category_id)
            ->where('status', 'published')
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();
        // 3. إرجاع الواجهة
        return view('articles.show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'articleLikes' => $articleLike
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete');
        // حذف الصور المرتبطة بالمقال من التخزين والقاعدة
        foreach ($article->images as $image) {
            if ($image->path && Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path); // ✅ استخدم خاصية وليس دالة
            }
            $image->delete(); // حذف السجل من قاعدة البيانات
        }
        // حذف المقال نفسه
        $deleted = $article->delete();
        return redirect()->back()->with([
            'status' => $deleted,
            'icon' => $deleted ? 'success' : 'error',
            'message' => $deleted ? "تم حذف الخبر وجميع صوره بنجاح" : "فشل في الحذف"
        ]);
    }

    //لجلب المقالات المعلقة
    public function drafts(article $article)
    {
        $this->authorize('Drafts Article');
        $user = auth()->user();
        // تعليم كل الإشعارات الغير مقروءة كمقروءة
        $user->unreadNotifications->markAsRead();
        $articles = Article::where('status', 'draft')->latest()->paginate(10);
        $count = article::count();
        return view('articles.rejectArticledData', ['articles' => $articles, 'counts' => $count]);
    }


    public function publish(article $article)
    {
        $article->status = 'published';
        $article->save();
        return redirect()->back()->with('success', 'تم نشر المقال بنجاح');
    }

    public function delete(article $article)
    {
        $article->status = 'deleted';
        $article->save();
        return redirect()->back()->with([
            'status' => true,
            'icon' => true ? 'success' : 'error',
            'message' => true ? 'تم حذف المقال قبل النشر' : 'حدث خطا'
        ]);
    }

    public function deletedArticle(article $article)
    {
        $this->authorize('deleted_article');
        $articles = Article::where('status', 'deleted')->latest()->paginate(10);
        $count = article::count();
        return view('articles.statusDeleteArticle', ['articles' => $articles, 'counts' => $count]);
    }

    public function localNews()
    {
        //
        $localArticle = Article::whereHas('category', function ($query) {
            $query->where('name', 'Local News');
        })
            ->where('status', 'published')
            ->get();
        return view('news.local-news', ['localArticles' => $localArticle]);
    }

    public function sportNews()
    {
        //
        $sportArticle = Article::whereHas('category', function ($query) {
            $query->where('name', 'Sport News');
        })
            ->where('status', 'published')
            ->get();
        return view('news.sport-news', ['sportArticles' => $sportArticle]);
    }

    public function internationalNews()
    {
        //
        $internationalArticle = Article::whereHas('category', function ($query) {
            $query->where('name', 'International News');
        })
            ->where('status', 'published')
            ->get();
        return view('news.international-news', ['internationalArticles' => $internationalArticle]);
    }
}
