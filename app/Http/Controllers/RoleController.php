<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\{Role, Permission};
use Yajra\DataTables\Facades\DataTables;


use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\RoleHasPermissions;

    
class RoleController extends Controller
{
    public function index()
    {
        // if(Auth::guard('admin')->user()->can('roles.index')){
            return view('super_admin.roles.index');
        // }else{
        //     return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        // }
    }

    public function load(Request $request)
    {
        try {
            if ($request->ajax()) {
                $roles = Role::with('permissions')->get();

                return DataTables::of($roles)
                    ->addIndexColumn()
                    ->addColumn('permissions', function ($row) {
                        $permissions_html = '';
                        $permissions = $row->permissions->pluck('name') ?? [];

                        if ($row->id == 1) {
                            $permissions_html .= '<span class="badge bg-primary">All Access</span>';
                        } elseif (count($permissions) > 0) {
                            foreach ($permissions as $permission) {
                                $permissions_html .= '<span class="badge bg-info">' . $permission . '</span> ';
                            }
                        } else {
                            $permissions_html = '-';
                        }

                        return $permissions_html;
                    })
                    ->addColumn('actions', function ($row) {
                        $action_html = '-';
                      //  if ($row->id > 1) {
                            $action_html = '';
                            //if (Auth::guard('admin')->user()?->can('roles.edit')) {
                                $action_html .= '<a href="' . route('roles.edit', encrypt($row->id)) . '" class="btn btn-sm btn-info"><i class="bi bi-pencil"></i></a> ';
                           // }
                          //  if (Auth::guard('admin')->user()?->can('roles.destroy')) {
                                $action_html .= '<a onclick="deleteRole(\'' . encrypt($row->id) . '\')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>';
                          //  }
                      //  }
                        return $action_html;
                    })
                    ->rawColumns(['permissions', 'actions'])
                    ->make(true);
            }
        } catch (\Exception $e) {
           dd($e);
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    public function create()
    {

       // if(Auth::guard('admin')->user()->can('roles.create')){

            $permissions = Permission::pluck('id', 'name')->toArray();
            return view('super_admin.roles.create',compact('permissions'));

        // }else{

        //     return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');

        // }

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        try {
            $permissionIds = $request->permissions ?? [];

            $role = Role::create(['name' => $request->name]);

        
            $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();

            $role->syncPermissions($permissionNames);
            return redirect()->route('roles.index')->with('success', 'Role has been Created.');
        } catch (\Throwable $th) {
            dd($th);
            return back()->with('error', 'Oops, Something went wrong!');
        }
    }

    public function edit($id)
    {
        try {
            $roleId = decrypt($id);
            $role = Role::findOrFail($roleId);
            $permissions = Permission::pluck('id', 'name')->toArray();
            $role_permissions = $role->permissions->pluck('id')->toArray();
            // dd($role_permissions);
            return view('super_admin.roles.edit', compact('role', 'permissions', 'role_permissions'));
        } catch (\Throwable $th) {
            return back()->with('error', 'Oops, Something went wrong!');
        }
    }

    public function update(Request $request)
    {
        $roleId = decrypt($request->id);
        $request->validate([
            'name' => 'required|unique:roles,name,' . $roleId,
        ]);

        try {
            $permissions = $request->permissions ?? [];
            $role = Role::findOrFail($roleId);
            $role->name = $request->name;
            $role->save();
            
            $permissionNames = Permission::whereIn('id', $permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
            return redirect()->back()->with('success', 'Role has been Updated.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Oops, Something went wrong!');
        }
    }




    // Remove the specified resource from storage.
    public function destroy(Request $request)
    {
        try{

            $role = Role::find(decrypt($request->id));
            $role->permissions()->detach($role->id);
            $role->delete();
            return response()->json([
                'success' => 1,
                'message' => "Role has been Deleted.",
            ]);

        }catch (\Throwable $th){
            dd($th);
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }
}