<?php

namespace App\Http\Controllers;

use App\Models\DeviceCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceCategoryController extends Controller
{
    public function index()
    {
        $device_categories = DeviceCatalog::orderBy('id','desc')->get();
        return view('super_admin.device_category.index',compact('device_categories'));
    }

    public function create()
    {
        return view('super_admin.device_category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_name' => 'required',
            'description' => 'required',
        ]);

        $device_category = new DeviceCatalog();
        $device_category->device_name = $request->device_name;
        $device_category->description = $request->description;
        $device_category->save();
        
        return redirect()->route('device.category')->with('success', 'Category created successfully.'); 
    }

    public function edit($id)
    {
        $device_category = DeviceCatalog::find(decrypt($id));
        return view('super_admin.device_category.edit',compact('device_category'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'device_name' => 'required',
            'description' => 'required',
        ]);

        $device_category = DeviceCatalog::find(decrypt($request->category_id));
        $device_category->device_name = $request->device_name;
        $device_category->description = $request->description;
        $device_category->update();
        
        return redirect()->route('device.category')->with('success', 'Category Update successfully.'); 
    }

    public function delete(Request $request)
    {
        try {
         
            $catalog = DeviceCatalog::findOrFail(decrypt($request->id));
            $catalog->devices()->delete();
            $catalog->delete();

            return response()->json([
                'success' => 1,
                'message' => "Category Delete successfully",
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }
}
