<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Organization;
use App\Models\Address;
use App\Http\Requests\PlaceRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::with('organization', 'address')->paginate(10);
        return Inertia::render('Places/Index', [
            'places' => $places
        ]);
    }

    public function create()
    {
        $organizations = Organization::all();
        $addresses = Address::all();

        return Inertia::render('Places/Create', [
            'organizations' => $organizations,
            'addresses' => $addresses
        ]);
    }

    public function store(PlaceRequest $request)
    {
        Place::create($request->validated());
        return redirect()->route('places.index')->with('success', 'Lugar creado con éxito');
    }

    public function edit($id)
    {
        $place = Place::findOrFail($id);
        return Inertia::render('Places/Edit', [
            'place' => $place
        ]);
    }

    public function update(PlaceRequest $request, $id)
    {
        $place = Place::findOrFail($id);
        $place->update($request->validated());
        return redirect()->route('places.index')->with('success', 'Lugar actualizado con éxito');
    }

    public function destroy($id)
    {
        $place = Place::findOrFail($id);
        $place->delete();
        return redirect()->route('places.index')->with('deleted', 'Lugar eliminado con éxito');
    }
}