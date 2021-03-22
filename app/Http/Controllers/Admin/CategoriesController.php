<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

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
            'description' => 'nullable|string|max:500|min:2',     
         ]);
      
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
          
        $category = new Category; 
        $category->title = request('title');
        $category->description = request('description');
        $category->is_deleted = 0;
        $category->status = "active";
        $category->save();

        return redirect("/admin/categories")->with('message', 'Category added.');
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
        
        $category = Category::findOrFail(request('editId'));
        $category->title = request('title');
        $category->description = request('description');
        $category->save();

        return redirect("/admin/categories")->with('message', 'Category updated.');
    }

    public function activate($id)
    {
        $category = Category::findOrFail($id);
        $category->update(['status' => "active"]);
        $category_name = $category->title;
        return redirect("/admin/categories")->with('message', $category_name." category is now visible.");
    }

    public function deactivate($id)
    {
        $category = Category::findOrFail($id);
        $category->update(['status' => "inactive"]);
        $category_name = $category->title;
        return redirect("/admin/categories")->with('message', $category_name." category is now hidden.");  
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if($category->products->count()){
            return redirect("/admin/categories")->with('error_message', "Cannot delete, the category has products. Deactivate instead.");  
        }

        $subcategories = SubCategory::where('category_id',$id)->get();
        foreach($subcategories as $subcategory){
            if($subcategory->products->count()){
                return redirect("/admin/categories")->with('error_message', "Cannot delete, a subcategory of this category has products. Deactivate instead."); 
            }
        }
       
        Category::destroy($category->id);
        return redirect("/admin/categories")->with('message', $category->title." category and its subcategories are now deleted.");  
    }
}

