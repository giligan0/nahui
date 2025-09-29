<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
use App\Models\Municipality;
=======
use App\Models\Municipality;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MunicipalityRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
>>>>>>> origin/autocrud

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
<<<<<<< HEAD
    public function index()
    {
        $municipalities= Municipality::with ('department')->paginate(10);
        return view ('municipalities.index',compact('municipalities'));
=======
    public function index(Request $request): View
    {
        $municipalities = Municipality::paginate();

        return view('municipality.index', compact('municipalities'))
            ->with('i', ($request->input('page', 1) - 1) * $municipalities->perPage());
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for creating a new resource.
     */
<<<<<<< HEAD
    public function create()
    {
        $municipalities= new Municipality();
        $departments= Department::all();
        return view ('municipalities.create',compact('municipality','deapartments'));
=======
    public function create(): View
    {
        $municipality = new Municipality();

        return view('municipality.create', compact('municipality'));
>>>>>>> origin/autocrud
    }

    /**
     * Store a newly created resource in storage.
     */
<<<<<<< HEAD
    public function store(MunicipalityRequest $request)
    {
        Municipality::create($request->validated());
        return redirect()->route('mumicipalities.index')->with('success','Municipio ha sido creado con éxito');
=======
    public function store(MunicipalityRequest $request): RedirectResponse
    {
        Municipality::create($request->validated());

        return Redirect::route('municipalities.index')
            ->with('success', 'Municipality created successfully.');
>>>>>>> origin/autocrud
    }

    /**
     * Display the specified resource.
     */
<<<<<<< HEAD
    public function show(int $id)
    {
        $municipalities= Municipality::find($id);
        $department= Department::all();
        return view ('municipalities.show',compact('municipalities','departments'));
=======
    public function show($id): View
    {
        $municipality = Municipality::find($id);

        return view('municipality.show', compact('municipality'));
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for editing the specified resource.
     */
<<<<<<< HEAD
    public function edit(int $id)
    {
        $municipalities= Municipality::find($id);
        $departments= Department::all();
        return view ('municipalities.edit',compact('municipalities','departments'));

=======
    public function edit($id): View
    {
        $municipality = Municipality::find($id);

        return view('municipality.edit', compact('municipality'));
>>>>>>> origin/autocrud
    }

    /**
     * Update the specified resource in storage.
     */
<<<<<<< HEAD
    public function update(MunicipalityRequest $request, int $id)
    {
        $municipalities= Municipality::find($id);
        $municipalities->update($request->validated());
        return redirect()->route('municipalities.index')->with('updated','Municipio ha sido actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $municipalities= Municipality::find($id);
        $municipalities->delete();
        return redirect()->route('municipalities.index')->with('deleted','Municipio ha sido eliminado con éxito');
=======
    public function update(MunicipalityRequest $request, Municipality $municipality): RedirectResponse
    {
        $municipality->update($request->validated());

        return Redirect::route('municipalities.index')
            ->with('success', 'Municipality updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Municipality::find($id)->delete();

        return Redirect::route('municipalities.index')
            ->with('success', 'Municipality deleted successfully');
>>>>>>> origin/autocrud
    }
}
