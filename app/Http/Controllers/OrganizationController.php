<?php

namespace App\Http\Controllers;

use App\Models\Organization;
<<<<<<< HEAD

class OrganizationController extends Controller

=======
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class OrganizationController extends Controller
>>>>>>> origin/autocrud
{
    /**
     * Display a listing of the resource.
     */
<<<<<<< HEAD
    public function index()
    {
        $organizations = Organization::latest()->paginate(10);
        return view('organizations.index',compact('organizations'));
=======
    public function index(Request $request): View
    {
        $organizations = Organization::paginate();

        return view('organization.index', compact('organizations'))
            ->with('i', ($request->input('page', 1) - 1) * $organizations->perPage());
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for creating a new resource.
     */
<<<<<<< HEAD
    public function create()
    {
        $organizations= new Organization();
        return view('organizations.create',compact('organizations'));
=======
    public function create(): View
    {
        $organization = new Organization();

        return view('organization.create', compact('organization'));
>>>>>>> origin/autocrud
    }

    /**
     * Store a newly created resource in storage.
     */
<<<<<<< HEAD
    public function store(OrganizationRequest $request)
    {
        Organization::create ($request->validated());
        return redirect()->route('organizations.index')->with('success','Organización ha sido creada con éxito');
=======
    public function store(OrganizationRequest $request): RedirectResponse
    {
        Organization::create($request->validated());

        return Redirect::route('organizations.index')
            ->with('success', 'Organization created successfully.');
>>>>>>> origin/autocrud
    }

    /**
     * Display the specified resource.
     */
<<<<<<< HEAD
    public function show(int $id)
    {
        $organizations= Organization::find($id);
        return view('organizations.show',compact('organizations'));
=======
    public function show($id): View
    {
        $organization = Organization::find($id);

        return view('organization.show', compact('organization'));
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for editing the specified resource.
     */
<<<<<<< HEAD
    public function edit(int $id)
    {
        $organizations= Organization::find($id);
        return view ('Organizations.edit',compact('organizations'));
=======
    public function edit($id): View
    {
        $organization = Organization::find($id);

        return view('organization.edit', compact('organization'));
>>>>>>> origin/autocrud
    }

    /**
     * Update the specified resource in storage.
     */
<<<<<<< HEAD
    public function update(OrganizationRequest $request, int $id)
    {
        $organizations= Organization::find($id);
        $organizations->update($request->validated());
        return redirect()->route('organizations.index')->with('updated','Organización ha sido actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $organizations= Organization::find($id);
        $organizations->delete();
        return redirect()->route('organizations.index')->with('deleted','Organización ha sido eliminado con éxito');
    }
}

=======
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
>>>>>>> origin/autocrud
