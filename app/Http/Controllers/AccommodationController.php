<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AccommodationRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AccommodationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $accommodations = Accommodation::paginate();

        return view('accommodation.index', compact('accommodations'))
            ->with('i', ($request->input('page', 1) - 1) * $accommodations->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $accommodation = new Accommodation();

        return view('accommodation.create', compact('accommodation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccommodationRequest $request): RedirectResponse
    {
        Accommodation::create($request->validated());

        return Redirect::route('accommodations.index')
            ->with('success', 'Accommodation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $accommodation = Accommodation::find($id);

        return view('accommodation.show', compact('accommodation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $accommodation = Accommodation::find($id);

        return view('accommodation.edit', compact('accommodation'));
    }

    /**
     * Update the specified resource in storage.
     */
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
    }
}
