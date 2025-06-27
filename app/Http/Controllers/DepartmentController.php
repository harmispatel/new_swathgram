<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{

    //   Route::controller(DepartmentController::class)->group(function () {
    //         Route::get('departments','index')->name('department');
    //         Route::get('department/create','create')->name('department.create');
    //         Route::post('department/store','store')->name('department.store');
    //         Route::post('department/delete','delete')->name('department.delete');
    //     });

    public function index(Request $request)
    {
        if (Auth::user()->can('department')) {

            $departments = Department::with('tests')->orderBy('id','desc')->get();
            $editDepartment = null;

            if ($request->has('edit_id')) {
                $editDepartment = Department::findOrFail(decrypt($request->edit_id));
            }
            return view('super_admin.department.index', compact('departments', 'editDepartment'));
        }
        else {
            return redirect()->back()->with('error','You have no rights for this action!');
        }
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
