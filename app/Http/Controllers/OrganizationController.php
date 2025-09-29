<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $organizations = Organization::paginate();

        return view('organization.index', compact('organizations'))
            ->with('i', ($request->input('page', 1) - 1) * $organizations->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $organization = new Organization();

        return view('organization.create', compact('organization'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrganizationRequest $request): RedirectResponse
    {
        Organization::create($request->validated());

        return Redirect::route('organizations.index')
            ->with('success', 'Organization created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $organization = Organization::find($id);

        return view('organization.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $organization = Organization::find($id);

        return view('organization.edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrganizationRequest $request, Organization $organization): RedirectResponse
    {
        $organization->update($request->validated());

        return Redirect::route('organizations.index')
            ->with('success', 'Organization updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Organization::find($id)->delete();

        return Redirect::route('organizations.index')
            ->with('success', 'Organization deleted successfully');
    }
}
