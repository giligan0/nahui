<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
=======
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
>>>>>>> origin/autocrud

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
<<<<<<< HEAD
    public function index()
    {
        $addresses = Address::latest()->paginate(10);
        return view('addresses.index',compact('addresses'));
=======
    public function index(Request $request): View
    {
        $addresses = Address::paginate();

        return view('address.index', compact('addresses'))
            ->with('i', ($request->input('page', 1) - 1) * $addresses->perPage());
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for creating a new resource.
     */
<<<<<<< HEAD
    public function create()
    {
        $addresses= new Address();
        return view('addresses.create',compact('addresses'));
=======
    public function create(): View
    {
        $address = new Address();

        return view('address.create', compact('address'));
>>>>>>> origin/autocrud
    }

    /**
     * Store a newly created resource in storage.
     */
<<<<<<< HEAD
    public function store(AddressRequest $request)
    {
        Address::create ($request->validated());
        return redirect()->route('addresses.index')->with('success','Dirección ha sido creado con éxito');
=======
    public function store(AddressRequest $request): RedirectResponse
    {
        Address::create($request->validated());

        return Redirect::route('addresses.index')
            ->with('success', 'Address created successfully.');
>>>>>>> origin/autocrud
    }

    /**
     * Display the specified resource.
     */
<<<<<<< HEAD
    public function show(int $id)
    {
        $addresses= Address::find($id);
        return view('addresses.show',compact('addresses'));
=======
    public function show($id): View
    {
        $address = Address::find($id);

        return view('address.show', compact('address'));
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for editing the specified resource.
     */
<<<<<<< HEAD
    public function edit(int $id)
    {
        $addresses= Address::find($id);
        return view ('addresses.edit',compact('addresses'));
=======
    public function edit($id): View
    {
        $address = Address::find($id);

        return view('address.edit', compact('address'));
>>>>>>> origin/autocrud
    }

    /**
     * Update the specified resource in storage.
     */
<<<<<<< HEAD
    public function update(AddressRequest $request, int $id)
    {
        $addresses= Address::find($id);
        $addresses->update($request->validated());
        return redirect()->route('addresses.index')->with('success','Dirección ha sido actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $addresses= Address::find($id);
        $addresses->delete();
        return redirect()->route('addresses.index')->with('success','Dirección ha sido eliminado con éxito');
    }

=======
    public function update(AddressRequest $request, Address $address): RedirectResponse
    {
        $address->update($request->validated());

        return Redirect::route('addresses.index')
            ->with('success', 'Address updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Address::find($id)->delete();

        return Redirect::route('addresses.index')
            ->with('success', 'Address deleted successfully');
    }
>>>>>>> origin/autocrud
}
