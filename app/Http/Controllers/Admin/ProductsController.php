<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.Products', compact('products','categories','subcategories'));
    }

    public function store(Request $request){

        $validator = \Validator::make($request->all(), [
          'title' => 'required|string|max:30|min:2',
          'brand' => 'required|string|max:30|min:2',
          'category_id' => 'required|numeric',
          'subcategory_id' => 'required|numeric',
          'quantity' => 'required|numeric|min:1',
          'price' => 'required|numeric',
          'delivery_fee' => 'required|numeric',
          'provincial_delivery_fee' => 'required|numeric',
          'description' => 'string|max:800|min:2',
          'image1' => 'image',
          'image2' => 'image',
          'image3' => 'image'
              
       ]);
    
        if ($validator->fails()){
          return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
            if(request('image1') != NULL){
           $image1Path = request('image1')->store('avatars','public'); 
                  
            $image1 = Image::make(public_path("storage/{$image1Path}"));
            $image1->fit(700, 401);
            $image1->save();
           }
           else {
            $image1Path = 'products/product_default.png';
           }

           if(request('image2') != NULL){
            $image2Path = request('image2')->store('products','public');       
            $image2 = Image::make(public_path("storage/{$image2Path}"));
            $image2->fit(700, 401);
            $image2->save();
           }
           else {
            $image2Path = 'products/product_default.png';
           }

           if(request('image3') != NULL){
            $image3Path = request('image3')->store('products','public');       
            $image3 = Image::make(public_path("storage/{$image3Path}"));
            $image3->fit(700, 401);
            $image3->save();
           }
           else {
            $image3Path = 'products/product_default.png';
           }

            //  $user = $user = new User; 
             $product = new Product;
             $product->title = request('title');
             $product->brand = request('brand');
             $product->category_id = request('category_id');
             $product->subcategory_id = request('subcategory_id');
             $product->quantity = request('quantity');
             $product->price = request('price');
             $product->delivery_fee = request('delivery_fee');
             $product->provincial_delivery_fee = request('provincial_delivery_fee');
             $product->rating = 0;
             $product->description = request('description');
             $product->status = 'active';
             $product->is_deleted = 0;
             $product->image1 = $image1Path;
             $product->image2 = $image2Path;
             $product->image3 = $image3Path;
             $product->save();
    
             return redirect("/admin/products")->with('message', 'Product added.');
    }

    public function edit(Request $request){

        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:30|min:2',
            'brand' => 'required|string|max:30|min:2',
            'category_id' => 'required|numeric',
            'subcategory_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric',
            'delivery_fee' => 'required|numeric',
            'provincial_delivery_fee' => 'required|numeric',
            'description' => 'string|max:800|min:2',
            'image1' => 'image',
            'image2' => 'image',
            'image3' => 'image'
                
        ]);
    
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
            if(request('image1') != NULL){
            $image1Path = request('image1')->store('avatars','public'); 
                    
            $image1 = Image::make(public_path("storage/{$image1Path}"));
            $image1->fit(700, 401);
            $image1->save();
            }
           
            if(request('image2') != NULL){
            $image2Path = request('image2')->store('products','public');       
            $image2 = Image::make(public_path("storage/{$image2Path}"));
            $image2->fit(700, 401);
            $image2->save();
            }
           
            if(request('image3') != NULL){
            $image3Path = request('image3')->store('products','public');       
            $image3 = Image::make(public_path("storage/{$image3Path}"));
            $image3->fit(700, 401);
            $image3->save();
            }
          
                $product = Product::findOrFail(request('editId'));
                $product->title = request('title');
                $product->brand = request('brand');
                $product->category_id = request('category_id');
                $product->subcategory_id = request('subcategory_id');
                $product->quantity = request('quantity');
                $product->price = request('price');
                $product->delivery_fee = request('delivery_fee');
                $product->provincial_delivery_fee = request('provincial_delivery_fee');
                $product->description = request('description');
                if(request('image1') != NULL){
                   $product->image1 = $image1Path;
                }
                if(request('image2') != NULL){
                   $product->image2 = $image2Path;
                }
                if(request('image3') != NULL){
                   $product->image3 = $image3Path;
                }
                $product->save();
    
                return redirect("/admin/products")->with('message', 'Product updated.');
        }   

    public function activate($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => "active"]);
        $product_name = $product->title;
        return redirect("/admin/products")->with('message', $product_name." product is now visible.");
    }

    public function deactivate($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => "inactive"]);
        $product_name = $product->title;
        return redirect("/admin/products")->with('message', $product_name." product is now hidden.");  
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if($product->orderItems->count()){
            return redirect("/admin/products")->with('error_message', "Cannot delete, the product is included in some orders. Deactivate instead.");  
        }
        if($product->cartItems->count()){
            return redirect("/admin/products")->with('error_message', "Cannot delete, the product is included in some orders. Deactivate instead.");  
        }
        $product_name = $product->title;
        Product::destroy($id);
        return redirect("/admin/products")->with('message', $product_name." product is now deleted.");  ;
    }
}

