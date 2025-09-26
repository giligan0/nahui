<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transports= Transport::with ('place','organization')->paginate(10);
        return view ('transports.index',compact('tranports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tranports= new Transport();
        $places= Place::all();
        $organizations= Organization::all();
        return view ('transports.create',compact('transports','places','organizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransportRequest $request)
    {
        Transport::create($request->validated());
        return redirect()->route('transports.index')->with('success','Transporte ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $transports= Transport::find($id);
        $places= Place::all();
        $organizations= Organization::all();
        return view ('transports.show',compact('transports','places','organizations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $tranports= Transport::find($id);
        $places= Places::all();
        $organizations= Organization::all();
        return view ('transport.edit',compact('transports','places','organizations'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransportRequest $request, int $id)
    {
        $transports= Transport::find($id);
        $transports->update($request->validated());
        return redirect()->route('transports.index')->with('updated','Transportes ha sido actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $transports= Tranport::find($id);
        $transports->delete();
        return redirect()->route('transports.index')->with('deleted','Transportes ha sido eliminado con éxito');
    }
}
