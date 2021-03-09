<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuideCategory;

class GuideCategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $categories = GuideCategory::all();
        return view('admin.GuideCategories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:30|min:2',
            'description' => 'nullable|string|max:500|min:2',     
         ]);
      
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
          
        $category = new GuideCategory; 
        $category->title = request('title');
        $category->description = request('description');
        $category->save();

        return redirect("/admin/guideCategories")->with('message', 'Category added.');
    }

    public function edit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:30|min:2',
            'description' => 'nullable|string|max:500|min:2',     
         ]);
      
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
        $category = GuideCategory::findOrFail(request('editId'));
        $category->title = request('title');
        $category->description = request('description');
        $category->save();

        return redirect("/admin/guideCategories")->with('message', 'Category updated.');
    }

    public function destroy($id)
    {
        $category = GuideCategory::findOrFail($id);
        GuideCategory::destroy($category->id);
        return redirect("/admin/guideCategories")->with('message', $category->title." category is now deleted.");  
    }
}

