<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Portion;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $items = Item::where('name', 'like', '%' . $search . '%')->get();
        } else {
            $items = Item::all();
        }

        return view('items.index', ['items' => $items, 'search' => $search]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = SubCategory::orderBy('name', 'asc')->get();
        return view('items.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = new Item;
        $item->name = $request->name;
        $item->subcategory_id = $request->subcategory_id;
        $item->cost = $request->cost;
        $item->save();
        return redirect(route('items.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        return view('items.edit', ['item' => Item::findOrFail($id),'portions' => Portion::orderBy('name', 'desc')->get(), 'categories' => Category::orderBy('name', 'desc')->get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Item::findOrFail($id);
        $item->name = $request->name;
        $item->subcategory_id = $request->subcategory_id;
        $item->portion_id = $request->portion_id;
        $item->cost = $request->cost;
        $item->save();
        return redirect(route('items.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect(route('items.index'));
    }
}
