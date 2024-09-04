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

        $classesArray = $classes->getCollection()->map(function ($class) {
            $classArray = $class->toArray();
            $classArray['students_count'] = $class->student_count;
            return $classArray;
        });

        return response()->json([
            'status' => 'success',
            'data' => $classesArray,
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
        $rules = [
            'class_name' => 'required|string|min:3|max:255|unique:classes,class_name',
            'classroom' => 'required|integer',
            'teacher' => 'required|string',
            'teacher_email' => 'required|email',
        ];

        $messages = [
            'class_name.min' => 'Az osztály neve legalább 3 karakter hosszú legyen.',
            'class_name.required' => 'Az osztály név megadása kötelező.',
            'class_name.unique' => 'Már létezik osztály ezen a néven. Válassz új osztály nevet!',
            'classroom.required' => 'Az osztályterem megadása kötelező.',
            'teacher.required' => 'Az osztályfőnök megadása kötelező.',
            'teacher_email.required' => 'Az osztályfőnök email címének megadása kötelező.',
        ];

        try {

            $validatedData = $request->validate($rules, $messages);

            $class = ClassModel::create($validatedData);

            return response()->json([
                'status' => 'success',
                'data' => $class,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
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


            $classArray = $class->toArray();
            $classArray['student_count'] = $class->student_count;

            return response()->json([
                'status' => 'success',
                'data' => $classArray,
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

        $rules = [
            'class_name' => 'required|string|min:3|max:255|unique:classes,class_name,' . $id,
            'classroom' => 'integer',
            'teacher' => 'string',
            'teacher_email' => 'email',
        ];


        $messages = [
            'class_name.min' => 'Az osztály neve legalább 3 karakter hosszú legyen.',
            'class_name.unique' => 'Már létezik osztály ezen a néven. Válassz új osztály nevet!',
        ];

        try {

            $validatedData = $request->validate($rules, $messages);


            $class = ClassModel::findOrFail($id);
            $class->update($validatedData);

            $class->updateStudentsCount();

            return response()->json([
                'status' => 'success',
                'data' => $class,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
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
                'error_details' => $e->getMessage(),
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
                'error_details' => $e->getMessage()
            ], 500);
        }
    }
}
