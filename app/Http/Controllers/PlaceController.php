<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
=======
use App\Models\Place;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PlaceRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
>>>>>>> origin/autocrud

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
<<<<<<< HEAD
    public function index()
    {
        $places= Place::with ('organization','address')->paginate(10);
        return view ('places.index',compact('places'));
=======
    public function index(Request $request): View
    {
        $places = Place::paginate();

        return view('place.index', compact('places'))
            ->with('i', ($request->input('page', 1) - 1) * $places->perPage());
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for creating a new resource.
     */
<<<<<<< HEAD
    public function create()
    {
        $places= new Place();
        $organizations= Organization::all();
        $addresses= Address::all();
        return view ('places.create',compact('places','organizations','addresses'));
=======
    public function create(): View
    {
        $place = new Place();

        return view('place.create', compact('place'));
>>>>>>> origin/autocrud
    }

    /**
     * Store a newly created resource in storage.
     */
<<<<<<< HEAD
    public function store(PlaceRequest $request)
    {
        Place::create($request->validated());
        return redirect()->route('places.index')->with('success','Lugares ha sido creado con éxito');
=======
    public function store(PlaceRequest $request): RedirectResponse
    {
        Place::create($request->validated());

        return Redirect::route('places.index')
            ->with('success', 'Place created successfully.');
>>>>>>> origin/autocrud
    }

    /**
     * Display the specified resource.
     */
<<<<<<< HEAD
    public function show(int $id)
    {
        $places= Place::find($id);
        $organizations= Organization::all();
        $addresses= Address::all();
        return view ('places.show',compact('places','organizations','addresses'));
=======
    public function show($id): View
    {
        $place = Place::find($id);

        return view('place.show', compact('place'));
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for editing the specified resource.
     */
<<<<<<< HEAD
    public function edit(int $id)
    {
        $places= Place::find($id);
        $organizations= Organization::all();
        $addresses= Address::all();
        return view ('places.edit',compact('places','organizations','addresses'));

=======
    public function edit($id): View
    {
        $place = Place::find($id);

        return view('place.edit', compact('place'));
>>>>>>> origin/autocrud
    }

    /**
     * Update the specified resource in storage.
     */
<<<<<<< HEAD
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
=======
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
>>>>>>> origin/autocrud
    }
}
