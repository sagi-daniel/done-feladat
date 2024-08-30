<?php

namespace App\Http\Controllers;

use App\Models\GradeModel;
use App\Models\StudentModel;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = GradeModel::all();
        $totalItems = $grades->count();

        return response()->json([
            'status' => 'success',
            'data' => $grades,
            'totalItems' => $totalItems,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ha van szükség formális megjelenítésre
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

            // Számítsd ki és frissítsd a diák átlagát
            $grade->student->updateGradesAverage();

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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ha van szükség formális megjelenítésre
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

            // Számítsd ki és frissítsd a diák átlagát
            $grade->student->updateGradesAverage();

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $grade = GradeModel::findOrFail($id);
            $grade->delete();

            // Számítsd ki és frissítsd a diák átlagát
            $grade->student->updateGradesAverage();

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
