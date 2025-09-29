<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
=======
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
>>>>>>> origin/autocrud

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
<<<<<<< HEAD
    public function index()
    {
        $departments = Department::latest()->paginate(10);
        return view('departments.index',compact('departments'));
=======
    public function index(Request $request): View
    {
        $departments = Department::paginate();

        return view('department.index', compact('departments'))
            ->with('i', ($request->input('page', 1) - 1) * $departments->perPage());
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for creating a new resource.
     */
<<<<<<< HEAD
    public function create()
    {
        $departments= new Department();
        return view('departments.create',compact('departments'));
=======
    public function create(): View
    {
        $department = new Department();

        return view('department.create', compact('department'));
>>>>>>> origin/autocrud
    }

    /**
     * Store a newly created resource in storage.
     */
<<<<<<< HEAD
    public function store(DepartmentRequest $request)
    {
        Department::create ($request->validated());
        return redirect()->route('departments.index')->with('success','Departamento ha sido creado con éxito');
=======
    public function store(DepartmentRequest $request): RedirectResponse
    {
        Department::create($request->validated());

        return Redirect::route('departments.index')
            ->with('success', 'Department created successfully.');
>>>>>>> origin/autocrud
    }

    /**
     * Display the specified resource.
     */
<<<<<<< HEAD
    public function show(int $id)
    {
        $departments= Department::find($id);
        return view('departments.show',compact('departments'));
=======
    public function show($id): View
    {
        $department = Department::find($id);

        return view('department.show', compact('department'));
>>>>>>> origin/autocrud
    }

    /**
     * Show the form for editing the specified resource.
     */
<<<<<<< HEAD
    public function edit(int $id)
    {
        $departments= Department::find($id);
        return view ('departments.edit',compact('departments'));
=======
    public function edit($id): View
    {
        $department = Department::find($id);

        return view('department.edit', compact('department'));
>>>>>>> origin/autocrud
    }

    /**
     * Update the specified resource in storage.
     */
<<<<<<< HEAD
    public function update(DepartmentRequest $request, int $id)
    {
        $departments= Department::find($id);
        $departments->update($request->validated());
        return redirect()->route('departments.index')->with('success','Departamento ha sido actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $departments= Department::find($id);
        $departments->delete();
        return redirect()->route('departments.index')->with('success','Departamento ha sido eliminado con éxito');
=======
    public function update(DepartmentRequest $request, Department $department): RedirectResponse
    {
        $department->update($request->validated());

        return Redirect::route('departments.index')
            ->with('success', 'Department updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Department::find($id)->delete();

        return Redirect::route('departments.index')
            ->with('success', 'Department deleted successfully');
>>>>>>> origin/autocrud
    }
}
