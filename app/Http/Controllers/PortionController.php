<?php

namespace App\Http\Controllers;

use App\Models\Portion;
use Illuminate\Http\Request;

class PortionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portions = Portion::all();
        return view('kitchen.index', ['portions' => $portions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kitchen.create') ;   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $portion = new Portion();
        $portion->name = $request->name;
        $portion->quantity = 0;
        $portion->save();
        return redirect()->route('kitchen.index')->with('success','');

    }

    public function updateAll(Request $request)
    {
        foreach ($request->portions as $portion) {
            Portion::where('id', $portion['id'])
                ->update(['quantity' => $portion['quantity']]);
        }
        return redirect()->back()->with('success');
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
        
        return view('kitchen.edit', ['portion' => Portion::findOrFail($id)]) ;  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $portion = Portion::findOrFail($id);
        $portion->name = $request->name;
        $portion->save();
        return redirect()->route('kitchen.index')->with('success','');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
