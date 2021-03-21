<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guide;
use App\Models\GuideCategory;


class GuidesController extends Controller
{

    public function index()
    {
        $guides = Guide::where('status','active')->orderBy('created_at', 'desc')->paginate(6);
        $categories = GuideCategory::all();
        $authors = Guide::distinct()->get('author');
        return view('home.guides', compact('guides','categories','authors'));
    }

    public function fetch_guides_data(Request $request)
    {
     if($request->ajax())
     {
        // if(request('subcategory_id') != NULL){  
        $category_filter = $request->get('category_id');
        $author_filter = $request->get('author');
        
        $guides = Guide::whereIn('category_id', $category_filter)->whereIn('author', $author_filter)->where('status','active')->orderBy('created_at', 'desc')->paginate(6); 
       
         
        return view('home.guides_data', compact('guides'))->render();
     }
    }

    public function show($id){
        $guide = Guide::findOrFail($id);
        $popular_guides = Guide::where('status','active')->where('id', '!=' , $id)->inRandomOrder()->limit(3)->get();
      
        return view('home.guide', compact('guide','popular_guides'));

    }

}
