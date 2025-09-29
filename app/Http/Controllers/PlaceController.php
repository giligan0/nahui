<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PlaceRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $places = Place::paginate();

        return view('place.index', compact('places'))
            ->with('i', ($request->input('page', 1) - 1) * $places->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $place = new Place();

        return view('place.create', compact('place'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlaceRequest $request): RedirectResponse
    {
        Place::create($request->validated());

        return Redirect::route('places.index')
            ->with('success', 'Place created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $place = Place::find($id);

        return view('place.show', compact('place'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $place = Place::find($id);

        return view('place.edit', compact('place'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlaceRequest $request, Place $place): RedirectResponse
    {
        $place->update($request->validated());

        return Redirect::route('places.index')
            ->with('success', 'Place updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Place::find($id)->delete();

        return Redirect::route('places.index')
            ->with('success', 'Place deleted successfully');
    }
}
