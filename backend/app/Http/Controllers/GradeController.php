<?php

namespace App\Http\Controllers;

use App\Models\GradeModel;;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = GradeModel::with('subject', 'student.classes',);

        if ($request->has('student_name')) {
            $query->join('students', 'grades.student_id', '=', 'students.id')
                ->where('students.student_name', 'like', '%' . $request->input('student_name') . '%')
                ->select('grades.*', 'students.student_name');
        }

        if ($request->has('subject_name')) {
            $query->join('subjects', 'grades.subject_id', '=', 'subjects.id')
                ->where('subjects.subject_name', 'like', '%' . $request->input('subject_name') . '%')
                ->select('grades.*', 'subjects.subject_name');
        }

        if ($request->has('class_name')) {
            $query->join('classes', 'grades.class_id', '=', 'classes.id')  // Kapcsolat az osztályhoz
                ->where('classes.class_name', 'like', '%' . $request->input('class_name') . '%')
                ->select('grades.*', 'classes.class_name');
        }

        // Egyéb feltételek
        if ($request->has('grade')) {
            $query->where('grade', $request->input('grade'));
        }

        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('date', [
                $request->input('date_from'),
                $request->input('date_to')
            ]);
        } elseif ($request->has('date_from')) {
            $query->where('date', '>=', $request->input('date_from'));
        } elseif ($request->has('date_to')) {
            $query->where('date', '<=', $request->input('date_to'));
        }

        $perPage = $request->input('per_page', 10);

        $grades = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $grades->items(),
            'totalItems' => $grades->total(),
            'currentPage' => $grades->currentPage(),
            'lastPage' => $grades->lastPage(),
            'perPage' => $grades->perPage(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string|max:255',
            'grade' => 'required|integer|min:1|max:5',
            'date' => 'required|date',
        ];

        $messages = [
            'student_id.exists' => 'A megadott diák nem létezik.',
            'grade.min' => 'A jegynek legalább 1-nek kell lennie.',
            'grade.max' => 'A jegy legfeljebb 5 lehet.',
        ];

        try {
            $validatedData = $request->validate($rules, $messages);

            $grade = GradeModel::create($validatedData);



            return response()->json([
                'status' => 'success',
                'data' => $grade,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error storing grade: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the grade.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $grade = GradeModel::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $grade,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Grade not found.',
            ], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'subject' => 'sometimes|required|string|max:255',
            'grade' => 'sometimes|required|integer|min:1|max:5',
            'date' => 'sometimes|required|date',
        ];

        $messages = [
            'grade.min' => 'A jegynek legalább 1-nek kell lennie.',
            'grade.max' => 'A jegy legfeljebb 5 lehet.',
        ];

        try {
            $validatedData = $request->validate($rules, $messages);

            $grade = GradeModel::findOrFail($id);
            $grade->update($validatedData);



            return response()->json([
                'status' => 'success',
                'data' => $grade,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Grade not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error updating grade: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the grade.',
            ], 500);
        }
    }

    public function byStudent($student_id, Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);

            $grades = GradeModel::with('subject')
                ->where('student_id', $student_id)
                ->paginate($perPage);

            if ($grades->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No grades found for this student.',
                ], 404);
            }

            $formattedGrades = $grades->items();

            $formattedGrades = array_map(function ($grade) {
                return [
                    'id' => $grade->id,
                    'student_id' => $grade->student_id,
                    'subject_id' => $grade->subject_id,
                    'subject_name' => $grade->subject ? $grade->subject->subject_name : 'N/A',
                    'grade' => $grade->grade,
                    'date' => $grade->date,
                    'created_at' => $grade->created_at,
                    'updated_at' => $grade->updated_at,
                    'deleted_at' => $grade->deleted_at,
                ];
            }, $formattedGrades);

            return response()->json([
                'status' => 'success',
                'data' => $formattedGrades,
                'totalItems' => $grades->total(),
                'currentPage' => $grades->currentPage(),
                'lastPage' => $grades->lastPage(),
                'perPage' => $grades->perPage(),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error retrieving grades for student: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while retrieving grades.',
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $grade = GradeModel::findOrFail($id);
            $grade->delete();



            return response()->json([
                'status' => 'success',
                'data' => $grade,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Grade not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting grade: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the grade.',
            ], 500);
        }
    }
}
