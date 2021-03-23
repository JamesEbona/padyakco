<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guide;
use App\Models\GuideCategory;
use Intervention\Image\Facades\Image;


class GuidesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $guides = Guide::all();
        return view('admin.Guides', compact('guides'));
    }

    public function create()
    {
        $categories = GuideCategory::all();
        return view('admin.CreateGuide', compact('categories'));
    }

    public function upload(Request $request)
    {
        if($request->hasFile('upload')){
            // $originName = $request->file('upload')->getClientOriginalName();
            // $fileName = pathinfo($originName, PATHINFO_FILENAME);
            // $extension = $request->file('upload')->getClientOriginalExtension();
            // $fileName = $fileName.'_'.time().'.'.$extension;

            // $request->file('upload')->move(public_path('images'), $fileName);

            $imagePath = request('upload')->store('guides','public'); 
                  
            $image = Image::make(public_path("storage/{$imagePath}"));
            $image->save();

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = '/storage/'.$imagePath;
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function store(Request $request){
        // try{
        //     $input = $request->all();
        //     Guide::updateOrCreate([
        //         'id' => $request->id,
        //     ],[
        //         'title' => $input['title'],
        //         'content' => $input['content'],
        //     ]);
        //     if ($request->id) {
        //         $msg = 'update successfully.';
        //     }else{
        //         $msg = 'added successfully.';
        //     }
        //     $arr = array("status" => 200, "msg" => $msg);
        // }
        // catch (\Illuminate\Database\QueryException $ex){
        //     $msg = $ex->getMessage();
        //     if (isset($ex->errorInfo[2])) :
        //         $msg = $ex->errorInfo[2];
        //     endif;

        //     $arr = array("status" => 400, "msg" => $msg, "result" => array());
        // }

        // return \Response::json($arr);

        $request->validate([
            'title' => ['required', 'string'],
            'author' => ['required','string'],
            'content' => ['required'],
            'description' => ['required','string','max:800','min:2'],
            'thumbnail' => ['required','image','dimensions:min_width=750,min_height=300'],
            'category_id' => ['required','numeric']
        ]);

        $thumbnailPath = request('thumbnail')->store('guides','public'); 
                  
        $thumbnail = Image::make(public_path("storage/{$thumbnailPath}"));
        $thumbnail->fit(750, 300);
        $thumbnail->save();

        $guide = new Guide;
        $guide->title = request('title');
        $guide->author = request('author');
        $guide->content = request('content');
        $guide->description = request('description');
        $guide->category_id = request('category_id');
        $guide->thumbnail = $thumbnailPath;
        $guide->status = "active";
        $guide->save();

        return redirect("/admin/guides/create")->with('message', 'Guide created.');
    }

    public function edit($id)
    {
        $guide = Guide::findOrFail($id);
        $categories = GuideCategory::all();
        return view('admin.EditGuide', compact('guide','categories'));
    }

    public function update(Request $request){
        $request->validate([
            'title' => ['required', 'string'],
            'author' => ['required','string'],
            'content' => ['required'],
            'description' => ['required','string','max:800','min:2'],
            'thumbnail' => ['image'],
            'category_id' => ['required','numeric']
        ]);

        if(request('thumbnail') != NULL){
            $thumbnailPath = request('thumbnail')->store('guides','public'); 
                    
            $thumbnail = Image::make(public_path("storage/{$thumbnailPath}"));
            $thumbnail->fit(750, 300);
            $thumbnail->save();
        }

        $guide = Guide::findOrFail(request('guide_id'));
        $guide->title = request('title');
        $guide->author = request('author');
        $guide->content = request('content');
        $guide->description = request('description');
        $guide->category_id = request('category_id');
        if(request('thumbnail') != NULL){
            $guide->thumbnail = $thumbnailPath;
        }
        $guide->save();
    
       return redirect()->route('guide.edit', request('guide_id'))->with('message', 'Trip guide updated.');
    }

    public function activate($id)
    {
        $guide = Guide::findOrFail($id);
        $guide->update(['status' => "active"]);
        $guide_title = $guide->title;

        return redirect("/admin/guides")->with('message', $guide_title." guide is now visible.");
    }

     public function deactivate($id)
    {
        $guide = Guide::findOrFail($id);
        $guide->update(['status' => "inactive"]);
        $guide_title = $guide->title;
        
        return redirect("/admin/guides")->with('message', $guide_title." guide is now hidden.");
    }

     public function destroy($id)
    {
        $guide = Guide::findOrFail($id);
        $guide_title = $guide->title;
        Guide::destroy($id);
       
        return redirect("/admin/guides")->with('message', $guide_title." guide is now deleted."); 
    }

}

