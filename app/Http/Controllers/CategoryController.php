<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(category $category)
    {
        //
        $this->authorize('viewAny', $category);
        $Category = Category::withCount('articles')->get();
        // $Category = Category::all();
        return response()->view('categories.index', ['categories' => $Category]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(category $category)
    {
        //
        $this->authorize('create', $category);
        return response()->view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, category $category)
    {
        //
        $this->authorize('create', $category);
        $request->validate([
            'name' => 'required|string',
        ]);

        $category = new category();
        $category->name = $request->input('name');
        $isSaved = $category->save();
        return redirect()->back()->with([
            'status'=> $isSaved,
            'icon' => $isSaved ? 'success' : 'error',
            'message' =>  $isSaved ? "تمت الاضافة بنجاح" : "لم يتم الاضافة يرجى التحقق من البيانات"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(category $category, $slug)
    {
        $this->authorize('view', $category);
        $category = Category::where('slug', $slug)->firstOrFail();

        // جلب الأخبار المرتبطة بالفئة
        $articles = $category->articles()->where('status', 'published')->paginate(10);

        return view('categories.show', compact('category', 'articles'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category)
    {
        //
        $this->authorize('update', $category);
        return response()->view('categories.update',['categories' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, category $category)
    {
        //
        $this->authorize('update', $category);
        $request->validate([
            'name' => 'required|string',
        ]);
        $category->name = $request->input('name');
        $isSaved = $category->save();
        return redirect()->route('categories.index')->with([
            'status'=> $isSaved,
            'icon' => $isSaved ? 'success' : 'error',
            'message' =>  $isSaved ? "تمت التعديل بنجاح" : "لم يتم التعديل يرجى التحقق من البيانات"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(category $category)
    public function destroy($id)
    {
        //
        $this->authorize('delete', category::findOrFail($id));
        $deleted = category::findOrFail($id)->delete();
        return redirect()->back()->with([ //session بيرحع على نفس الواجهة وبيرجع
            'status'=> $deleted,
            'icon' => $deleted ? 'success' : 'error',
            'message' =>  $deleted ? "تم حذف التصنيف بنجاح" : "لم يتم الحذف"
        ]);
    }
}
