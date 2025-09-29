<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
=======
use App\Models\InterestUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\InterestUserRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
>>>>>>> origin/autocrud

class InterestUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
<<<<<<< HEAD
    public function index()
    {
        $interestusers = InterestUser::latest()->paginate(10);
        return view('interestusers.index',compact('interestusers'));
=======
    public function index(Request $request): View
    {
        $interestUsers = InterestUser::paginate();

        return view('interest-user.index', compact('interestUsers'))
            ->with('i', ($request->input('page', 1) - 1) * $interestUsers->perPage());
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for creating a new resource.
     */
<<<<<<< HEAD
    public function create()
    {
        $interestusers= new InterestUser();
        return view('interestusers.create',compact('interestusers'));
=======
    public function create(): View
    {
        $interestUser = new InterestUser();

        return view('interest-user.create', compact('interestUser'));
>>>>>>> origin/autocrud
    }

    /**
     * Store a newly created resource in storage.
     */
<<<<<<< HEAD
    public function store(InterestUserRequest $request)
    {
        InterestUser::create ($request->validated());
        return redirect()->route('interestusers.index')->with('success','Interes de usuario creado con éxito');
=======
    public function store(InterestUserRequest $request): RedirectResponse
    {
        InterestUser::create($request->validated());

        return Redirect::route('interest-users.index')
            ->with('success', 'InterestUser created successfully.');
>>>>>>> origin/autocrud
    }

    /**
     * Display the specified resource.
     */
<<<<<<< HEAD
    public function show(int $id)
    {
        $interestusers= InterestUser::find($id);
        return view('interestusers.show',compact('interestusers'));
=======
    public function show($id): View
    {
        $interestUser = InterestUser::find($id);

        return view('interest-user.show', compact('interestUser'));
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for editing the specified resource.
     */
<<<<<<< HEAD
    public function edit(int $id)
    {
        $interestusers= InterestUser::find($id);
        return view ('interestusers.edit',compact('interestusers'));
=======
    public function edit($id): View
    {
        $interestUser = InterestUser::find($id);

        return view('interest-user.edit', compact('interestUser'));
>>>>>>> origin/autocrud
    }

    /**
     * Update the specified resource in storage.
     */
<<<<<<< HEAD
    public function update(InterestUserRequest $request, int $id)
    {
        $interestusers= InterestUser::find($id);
        $interestusers->update($request->validated());
        return redirect()->route('interestusers.index')->with('success','Interes de usuario actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $interestusers= InterestUser::find($id);
        $interestusers->delete();
        return redirect()->route('interestusers.index')->with('success','Interes de usuario eliminado con éxito');
=======
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
>>>>>>> origin/autocrud
    }
}
