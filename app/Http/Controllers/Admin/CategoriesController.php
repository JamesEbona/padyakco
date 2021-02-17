<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $categories = Category::all();
        return view('admin.Categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:30|min:2',
            'description' => 'string|max:500|min:2',     
         ]);
      
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
          
        $category = new Category; 
        $category->title = request('title');
        $category->description = request('description');
        $category->save();

        return redirect("/admin/categories")->with('message', 'Category added.');
    }

    public function edit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:30|min:2',
            'description' => 'string|max:500|min:2',     
         ]);
      
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
        $category = Category::findOrFail(request('editId'));
        $category->title = request('title');
        $category->description = request('description');
        $category->save();

        return redirect("/admin/categories")->with('message', 'Category updated.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        Category::destroy($category->id);
        return redirect("/admin/categories")->with('message', $category->title." category and its subcategories are now deleted.");  
    }
}

