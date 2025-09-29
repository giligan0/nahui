<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MunicipalityRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $municipalities = Municipality::paginate();

        return view('municipality.index', compact('municipalities'))
            ->with('i', ($request->input('page', 1) - 1) * $municipalities->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $municipality = new Municipality();

        return view('municipality.create', compact('municipality'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MunicipalityRequest $request): RedirectResponse
    {
        Municipality::create($request->validated());

        return Redirect::route('municipalities.index')
            ->with('success', 'Municipality created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $municipality = Municipality::find($id);

        return view('municipality.show', compact('municipality'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $municipality = Municipality::find($id);

        return view('municipality.edit', compact('municipality'));
    }

    /**
     * Update the specified resource in storage.
     */
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
    }
}
