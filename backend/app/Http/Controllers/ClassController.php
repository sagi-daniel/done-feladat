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
        $classes = ClassModel::all();
        return response()->json($classes);
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
            ],
        ], [
            'class_name.min' => 'Az osztály neve legalább 3 karakter hosszú legyen.',
            'class_name.required' => 'Az osztály név megadása kötelező.',
            'class_name.unique' => 'Már létezik osztály ezen a néven. Válassz új osztály nevet!',
            'classroom.required' => 'Az osztályterem megadása kötelező.',
            'teacher.required' => 'Az osztályfőnök megadása kötelező.',
            'teacher_email.required' => 'Az osztályfőnök email címének megadása kötelező.',
        ]);

        $class = new ClassModel();
        $class->class_name = $request->class_name;
        $class->classroom = $request->classroom;
        $class->teacher = $request->teacher;
        $class->teacher_email = $request->teacher_email;
        $class->save();

        return response()->json($class, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $class = ClassModel::findOrFail($id);
        return response()->json($class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'class_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'unique:classes,class_name,' . $id
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
            ],
        ], [
            'class_name.min' => 'Az osztály neve legalább 3 karakter hosszú legyen.',
            'class_name.required' => 'Az osztály név megadása kötelező.',
            'class_name.unique' => 'Már létezik osztály ezen a néven. Válassz új osztály nevet!',
            'classroom.required' => 'Az osztályterem megadása kötelező.',
            'teacher.required' => 'Az osztályfőnök megadása kötelező.',
            'teacher_email.required' => 'Az osztályfőnök email címének megadása kötelező.',
        ]);

        $class = ClassModel::findOrFail($id);
        $class->class_name = $request->class_name;
        $class->classroom = $request->classroom;
        $class->teacher = $request->teacher;
        $class->teacher_email = $request->teacher_email;
        $class->save();

        return response()->json($class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = ClassModel::findOrFail($id);
        $class->delete();

        return response()->json(null, 204);
    }
}
