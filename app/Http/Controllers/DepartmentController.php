<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::with('tests')->orderBy('id','desc')->get();
        $editDepartment = null;

        if ($request->has('edit_id')) {
            $editDepartment = Department::findOrFail(decrypt($request->edit_id));
        }
        return view('super_admin.department.index', compact('departments', 'editDepartment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name' => 'required',
        ]);

        if ($request->has('edit_id')) {
            // Update flow
            $department = Department::findOrFail(decrypt($request->edit_id));
            $department->department_name = $request->department_name;
            $department->save();

            return redirect()->route('department')->with('success', 'Department updated successfully.');
        } else {
            // Store flow
            $department = new Department();
            $department->department_name = $request->department_name;
            $department->save();

            return redirect()->back()->with('success', 'Department created successfully.');
        }
    }

    public function delete(Request $request)
    {
        try {
            $patient = Department::find(decrypt($request->id));
            $patient->delete();

            return response()->json([
                'success' => 1,
                'message' => "Department Delete successfully",
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }

}
