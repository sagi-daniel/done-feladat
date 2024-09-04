<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\StudentModel;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = StudentModel::with('classes');

        if ($request->has('name')) {
            $query->where('student_name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('phone')) {
            $query->where('student_phone', 'like', '%' . $request->input('phone') . '%');
        }

        if ($request->has('class')) {
            $query->where('class_id', $request->input('class'));
        }

        // if ($request->has('grades_avg_from') && $request->has('grades_avg_to')) {
        //     $query->whereBetween('grades_avg', [
        //         $request->input('grades_avg_from'),
        //         $request->input('grades_avg_to')
        //     ]);
        // }

        $perPage = $request->input('per_page', 10);

        $students = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $students->items(),
            'totalItems' => $students->total(),
            'currentPage' => $students->currentPage(),
            'lastPage' => $students->lastPage(),
            'perPage' => $students->perPage(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'student_name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'student_phone' => 'required|string|max:15',
        ];

        $messages = [
            'student_name.required' => 'A diák neve megadása kötelező.',
            'class_id.exists' => 'A megadott osztály nem létezik.',
            'student_phone.required' => 'A diák telefonszáma megadása kötelező.',
        ];

        try {
            $validatedData = $request->validate($rules, $messages);

            $student = StudentModel::create($validatedData);
            $class = ClassModel::findOrFail($validatedData['class_id']);

            $class->students()->attach($student->id);


            return response()->json([
                'status' => 'success',
                'data' => $student,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the student.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        try {
            $student = StudentModel::with('classes')->findOrFail($id);

            $grades = $student->grades()
                ->with('subject')
                ->paginate(10);

            $averageGradesBySubject = $student->grades()
                ->selectRaw('subject_id, AVG(grade) as average_grade')
                ->groupBy('subject_id')
                ->with('subject')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'student' => $student,
                    'grades' => [
                        'data' => $grades->items(),
                        'totalItems' => $grades->total(),
                        'currentPage' => $grades->currentPage(),
                        'lastPage' => $grades->lastPage(),
                        'perPage' => $grades->perPage(),
                    ],
                    'average_grades_by_subject' => $averageGradesBySubject
                ],
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Student not found.',
            ], 404);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'student_name' => 'sometimes|required|string|max:255',
            'class_id' => 'sometimes|required|exists:classes,id',
            'student_phone' => 'sometimes|required|string|max:15',
        ];

        $messages = [
            'student_name.required' => 'A diák neve megadása kötelező.',
            'class_id.exists' => 'A megadott osztály nem létezik.',
            'student_phone.required' => 'A diák telefonszáma megadása kötelező.',
        ];

        try {
            $validatedData = $request->validate($rules, $messages);

            $student = StudentModel::findOrFail($id);
            $originalClassId = $student->class_id;

            $student->update($validatedData);


            if (isset($validatedData['class_id']) && $validatedData['class_id'] != $originalClassId) {
                if ($originalClassId) {
                    $originalClass = ClassModel::find($originalClassId);
                    if ($originalClass) {
                        $originalClass->students()->detach($student->id);
                    }
                }
                $newClass = ClassModel::find($validatedData['class_id']);
                if ($newClass) {
                    $newClass->students()->attach($student->id);
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => $student,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Student not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the student.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $student = StudentModel::findOrFail($id);

            $student->classes()->detach();
            $student->delete();

            return response()->json([
                'status' => 'success',
                'data' => $student,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Student not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the student.',
            ], 500);
        }
    }
}
