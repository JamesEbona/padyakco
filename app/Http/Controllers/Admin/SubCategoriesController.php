<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.SubCategories', compact('subcategories','categories'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:30|min:2',
            'description' => 'nullable|string|max:500|min:2|',
            'category_id' => 'required|numeric'     
         ]);
      
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
          
        $subcategory = new SubCategory; 
        $subcategory->title = request('title');
        $subcategory->description = request('description');
        $subcategory->category_id = request('category_id');
        $subcategory->save();

        return redirect("/admin/subcategories")->with('message', 'Subcategory added.');
    }

    public function edit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:30|min:2',
            'description' => 'nullable|string|max:500|min:2',
            'category_id' => 'required|numeric'        
         ]);
      
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
        $subcategory = SubCategory::findOrFail(request('editId'));
        $subcategory->title = request('title');
        $subcategory->description = request('description');
        $subcategory->category_id = request('category_id');
        $subcategory->save();

        return redirect("/admin/subcategories")->with('message', 'Subcategory updated.');
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        SubCategory::destroy($subcategory->id);
        return redirect("/admin/subcategories")->with('message', $subcategory->title." subcategory is now deleted.");  
    }
}

