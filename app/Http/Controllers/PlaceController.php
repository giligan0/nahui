<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use App\Http\Requests\PlaceRequest;
use Inertia\Inertia;
use Inertia\Response;

class PlaceController extends Controller
{
    public function index(Request $request): Response
    {
        $places = Place::paginate(10);
        return Inertia::render('Places/Index', [
            'places' => $places,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Places/Create', [
            'place' => new Place(),
        ]);
    }

    public function store(PlaceRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('imagenes')) {
            $imagenes = [];
            foreach ($request->file('imagenes') as $file) {
                $imagenes[] = $file->store('places', 'public');
            }
            $data['imagenes'] = $imagenes;
        }

        Place::create($data);

        return redirect()->route('places.index')->with('success','Lugar creado con éxito');
    }

    public function edit(Place $place)
    {
        return Inertia::render('Places/Edit', [
            'place' => $place,
        ]);
    }

    public function update(PlaceRequest $request, Place $place)
    {
        $data = $request->validated();

        if ($request->hasFile('imagenes')) {
            $imagenes = $place->imagenes ?? [];
            foreach ($request->file('imagenes') as $file) {
                $imagenes[] = $file->store('places', 'public');
            }
            $data['imagenes'] = $imagenes;
        }

        $place->update($data);

        return redirect()->route('places.index')->with('success','Lugar actualizado con éxito');
    }

    public function destroy(Place $place)
    {
        $place->delete();
        return redirect()->route('places.index')->with('success','Lugar eliminado con éxito');
    }
}
