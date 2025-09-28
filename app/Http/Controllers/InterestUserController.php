<?php

namespace App\Http\Controllers;

use App\Models\InterestUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\InterestUserRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class InterestUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $interestUsers = InterestUser::paginate();

        return view('interest-user.index', compact('interestUsers'))
            ->with('i', ($request->input('page', 1) - 1) * $interestUsers->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $interestUser = new InterestUser();

        return view('interest-user.create', compact('interestUser'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InterestUserRequest $request): RedirectResponse
    {
        InterestUser::create($request->validated());

        return Redirect::route('interest-users.index')
            ->with('success', 'InterestUser created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $interestUser = InterestUser::find($id);

        return view('interest-user.show', compact('interestUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $interestUser = InterestUser::find($id);

        return view('interest-user.edit', compact('interestUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InterestUserRequest $request, InterestUser $interestUser): RedirectResponse
    {
        $interestUser->update($request->validated());

        return Redirect::route('interest-users.index')
            ->with('success', 'InterestUser updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        InterestUser::find($id)->delete();

        return Redirect::route('interest-users.index')
            ->with('success', 'InterestUser deleted successfully');
    }
}
