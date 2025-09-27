<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places= Place::with ('organization','address')->paginate(10);
        return view ('places.index',compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $places= new Place();
        $organizations= Organization::all();
        $addresses= Address::all();
        return view ('places.create',compact('places','organizations','addresses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlaceRequest $request)
    {
        Place::create($request->validated());
        return redirect()->route('places.index')->with('success','Lugares ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $places= Place::find($id);
        $organizations= Organization::all();
        $addresses= Address::all();
        return view ('places.show',compact('places','organizations','addresses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $places= Place::find($id);
        $organizations= Organization::all();
        $addresses= Address::all();
        return view ('places.edit',compact('places','organizations','addresses'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlaceRequest $request, int $id)
    {
        $places= Place::find($id);
        $places->update($request->validated());
        return redirect()->route('places.index')->with('updated','Lugares ha sido actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $places= Place::find($id);
        $places->delete();
        return redirect()->route('places.index')->with('deleted','Lugares ha sido eliminado con éxito');
    }
}
