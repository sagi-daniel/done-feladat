<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'unique:classes,class_name'
            ],
            'classroom' => [
                'required',
                'integer'
            ],
            'teacher' => [
                'required',
                'string'
            ],
            'teacher_email' => [
                'required',
                'email',
                'unique:classes,teacher_email'
            ],
        ]);

        $class = new ClassModel();
        $class->class_name = $request->class_name;
        $class->classroom = $request->classroom;
        $class->teacher = $request->teacher;
        $class->teacher_email = $request->teacher_email;
        // Az osztály automatikusan frissíti a students_count értéket az updated eseménnyel
        $class->save();

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
