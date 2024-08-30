<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $validatedData = $request->validate([
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

        try {
            $class = ClassModel::create($validatedData);
            return response()->json($class, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the class.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $class = ClassModel::findOrFail($id);
            return response()->json($class);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Class not found.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
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

        try {
            $class = ClassModel::findOrFail($id);
            $class->update($validatedData);
            return response()->json($class);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Class not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the class.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $class = ClassModel::findOrFail($id);
            $class->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Class not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the class.'], 500);
        }
    }
}
