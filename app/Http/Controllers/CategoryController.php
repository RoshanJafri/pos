<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $maxOrder = Category::max('order') ?? 0;

        $category = new Category();
        $category->name = $request->name;
        $category->order = $maxOrder + 1;
        $category->save();

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $itemCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $itemCategory)
    {
        //
    }

    public function sort()
    {

        $categories = Category::orderBy('order', 'asc')->get();
        return view('categories.sort', ['categories' => $categories]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $itemCategory)
    {
        //
    }
    
    public function updateOrder(Request $request)
    {
        foreach ($request->order as $item) {
            \App\Models\Category::where('id', $item['id'])
                ->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $itemCategory)
    {
        //
    }
}
