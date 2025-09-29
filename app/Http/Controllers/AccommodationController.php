<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
=======
use App\Models\Accommodation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AccommodationRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
>>>>>>> origin/autocrud

class AccommodationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
<<<<<<< HEAD
    public function index()
    {
        $accommodations= Accommodation::with ('organization','address')->paginate(10);
        return view ('accommodations.index',compact('accommodations'));
=======
    public function index(Request $request): View
    {
        $accommodations = Accommodation::paginate();

        return view('accommodation.index', compact('accommodations'))
            ->with('i', ($request->input('page', 1) - 1) * $accommodations->perPage());
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for creating a new resource.
     */
<<<<<<< HEAD
    public function create()
    {
        $accommodations= new Accommodation();
        $organizations= Organization::all();
        $addresses= Address::all();
        return view ('accommodations.create',compact('accommodations','organizations','addresses'));
=======
    public function create(): View
    {
        $accommodation = new Accommodation();

        return view('accommodation.create', compact('accommodation'));
>>>>>>> origin/autocrud
    }

    /**
     * Store a newly created resource in storage.
     */
<<<<<<< HEAD
    public function store(AccommodationRequest $request)
    {
        Accommodation::create($request->validated());
        return redirect()->route('accommodations.index')->with('success','Alojamientos ha sido creado con éxito');
=======
    public function store(AccommodationRequest $request): RedirectResponse
    {
        Accommodation::create($request->validated());

        return Redirect::route('accommodations.index')
            ->with('success', 'Accommodation created successfully.');
>>>>>>> origin/autocrud
    }

    /**
     * Display the specified resource.
     */
<<<<<<< HEAD
    public function show(int $id)
    {
        $accommodations= Accommodation::find($id);
        $organizations= Organization::all();
        $addresses= Address::all();
        return view ('accommodations.show',compact('accommodations','organizations','addresses'));
=======
    public function show($id): View
    {
        $accommodation = Accommodation::find($id);

        return view('accommodation.show', compact('accommodation'));
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for editing the specified resource.
     */
<<<<<<< HEAD
    public function edit(int $id)
    {
        $accommodations= Accommodation::find($id);
        $organizations= Organization::all();
        $addresses= Address::all();
        return view ('accommodations.edit',compact('accommodations','organizations','addresses'));

=======
    public function edit($id): View
    {
        $accommodation = Accommodation::find($id);

        return view('accommodation.edit', compact('accommodation'));
>>>>>>> origin/autocrud
    }

    /**
     * Update the specified resource in storage.
     */
<<<<<<< HEAD
    public function update(AccommodationRequest $request, int $id)
    {
        $accommodations= Accommodation::find($id);
        $accommodations->update($request->validated());
        return redirect()->route('accommodations.index')->with('updated','Alojamientos ha sido actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $accommodations= Accommodation::find($id);
        $accommodations->delete();
        return redirect()->route('accommodations.index')->with('deleted','Alojamientos ha sido eliminado con éxito');
=======
    public function update(AccommodationRequest $request, Accommodation $accommodation): RedirectResponse
    {
        $accommodation->update($request->validated());

        return Redirect::route('accommodations.index')
            ->with('success', 'Accommodation updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Accommodation::find($id)->delete();

        return Redirect::route('accommodations.index')
            ->with('success', 'Accommodation deleted successfully');
>>>>>>> origin/autocrud
    }
}
