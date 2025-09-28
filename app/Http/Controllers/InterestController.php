<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\InterestRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $interests = Interest::paginate();

        return view('interest.index', compact('interests'))
            ->with('i', ($request->input('page', 1) - 1) * $interests->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $interest = new Interest();

        return view('interest.create', compact('interest'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InterestRequest $request): RedirectResponse
    {
        Interest::create($request->validated());

        return Redirect::route('interests.index')
            ->with('success', 'Interest created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $interest = Interest::find($id);

        return view('interest.show', compact('interest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $interest = Interest::find($id);

        return view('interest.edit', compact('interest'));
    }

    /**
     * Update the specified resource in storage.
     */
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
    }
}
