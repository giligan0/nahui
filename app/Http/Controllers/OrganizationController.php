<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganizationController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organizations = Organization::latest()->paginate(10);
        return view('organizations.index',compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $organizations= new Organization();
        return view('organizations.create',compact('organizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrganizationRequest $request)
    {
        Organization::create ($request->validated());
        return redirect()->route('organizations.index')->with('success','Organización creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $organizations= Customer::find($id);
        return view('customers.show',compact('customers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $customers= Customer::find($id);
        return view ('customers.edit',compact('customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, int $id)
    {
        $customers= Customer::find($id);
        $customers->update($request->validated());
        return redirect()->route('customers.index')->with('updated','Cliente actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $customers= Customer::find($id);
        $customers->delete();
        return redirect()->route('customers.index')->with('deleted','Cliente eliminado con éxito');
    }
}

