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
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 10);

        $classes = ClassModel::paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $classes->items(),
            'totalItems' => $classes->total(),
            'currentPage' => $classes->currentPage(),
            'lastPage' => $classes->lastPage(),
            'perPage' => $classes->perPage(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'class_name' => 'required|string|min:3|max:255|unique:classes,class_name',
            'classroom' => 'required|integer',
            'teacher' => 'required|string',
            'teacher_email' => 'required|email',
        ];

        // Custom error messages
        $messages = [
            'class_name.min' => 'Az osztály neve legalább 3 karakter hosszú legyen.',
            'class_name.required' => 'Az osztály név megadása kötelező.',
            'class_name.unique' => 'Már létezik osztály ezen a néven. Válassz új osztály nevet!',
            'classroom.required' => 'Az osztályterem megadása kötelező.',
            'teacher.required' => 'Az osztályfőnök megadása kötelező.',
            'teacher_email.required' => 'Az osztályfőnök email címének megadása kötelező.',
        ];

        try {
            // Validate the request data
            $validatedData = $request->validate($rules, $messages);

            // Create the resource
            $class = ClassModel::create($validatedData);

            return response()->json([
                'status' => 'success',
                'data' => $class,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return custom error response for validation errors
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(), // Validation errors
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the class.',
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $class = ClassModel::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $class,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Class not found.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation rules
        $rules = [
            'class_name' => 'required|string|min:3|max:255|unique:classes,class_name,' . $id,
            'classroom' => 'integer',
            'teacher' => 'string',
            'teacher_email' => 'email',
        ];

        // Custom error messages
        $messages = [
            'class_name.min' => 'Az osztály neve legalább 3 karakter hosszú legyen.',
            'class_name.unique' => 'Már létezik osztály ezen a néven. Válassz új osztály nevet!',
        ];

        try {
            // Validate the request data
            $validatedData = $request->validate($rules, $messages);

            // Find the resource and update it
            $class = ClassModel::findOrFail($id);
            $class->update($validatedData);
            $class->students_count = $class->calculateStudentsCount();
            $class->save();

            return response()->json([
                'status' => 'success',
                'data' => $class,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return custom error response for validation errors
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(), // Validation errors
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Class not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the class.',
            ], 500);
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

            return response()->json([
                'status' => 'success',
                'data' => $class,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Class not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the class.',
            ], 500);
        }
    }
}
