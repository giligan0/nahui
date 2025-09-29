<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;

class InterestController extends Controller

=======
use App\Models\Interest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\InterestRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class InterestController extends Controller
>>>>>>> origin/autocrud
{
    /**
     * Display a listing of the resource.
     */
<<<<<<< HEAD
    public function index()
    {
        $interests = Interest::latest()->paginate(10);
        return view('interests.index',compact('interests'));
=======
    public function index(Request $request): View
    {
        $interests = Interest::paginate();

        return view('interest.index', compact('interests'))
            ->with('i', ($request->input('page', 1) - 1) * $interests->perPage());
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for creating a new resource.
     */
<<<<<<< HEAD
    public function create()
    {
        $interests= new Interest();
        return view('interests.create',compact('interests'));
=======
    public function create(): View
    {
        $interest = new Interest();

        return view('interest.create', compact('interest'));
>>>>>>> origin/autocrud
    }

    /**
     * Store a newly created resource in storage.
     */
<<<<<<< HEAD
    public function store(InterestRequest $request)
    {
        Interest::create ($request->validated());
        return redirect()->route('interests.index')->with('success','Interes creado con éxito');
=======
    public function store(InterestRequest $request): RedirectResponse
    {
        Interest::create($request->validated());

        return Redirect::route('interests.index')
            ->with('success', 'Interest created successfully.');
>>>>>>> origin/autocrud
    }

    /**
     * Display the specified resource.
     */
<<<<<<< HEAD
    public function show(int $id)
    {
        $interests= Interest::find($id);
        return view('interests.show',compact('interests'));
=======
    public function show($id): View
    {
        $interest = Interest::find($id);

        return view('interest.show', compact('interest'));
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for editing the specified resource.
     */
<<<<<<< HEAD
    public function edit(int $id)
    {
        $interests= Interest::find($id);
        return view ('interests.edit',compact('interests'));
=======
    public function edit($id): View
    {
        $interest = Interest::find($id);

        return view('interest.edit', compact('interest'));
>>>>>>> origin/autocrud
    }

    /**
     * Update the specified resource in storage.
     */
<<<<<<< HEAD
    public function update(InterestRequest $request, int $id)
    {
        $interests= Interest::find($id);
        $interests->update($request->validated());
        return redirect()->route('interests.index')->with('updated','Interes actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $interests= Interest::find($id);
        $interests->delete();
        return redirect()->route('interests.index')->with('deleted','Interes eliminado con éxito');
=======
    public function update(InterestRequest $request, Interest $interest): RedirectResponse
    {
        $interest->update($request->validated());

        return Redirect::route('interests.index')
            ->with('success', 'Interest updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Interest::find($id)->delete();

        return Redirect::route('interests.index')
            ->with('success', 'Interest deleted successfully');
>>>>>>> origin/autocrud
    }
}
