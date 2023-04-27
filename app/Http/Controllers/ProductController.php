<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //product list
    public function pizzaList(){
        $pizzaes = Product::when(request('key'),function($query){
            $query->where('products.name','like','%'.request('key').'%');
        })->select('products.*','categories.name as category_name')
        ->leftJoin('categories','products.category_id','categories.id')
        ->orderBy('products.created_at','desc')->paginate(3);
        $pizzaes->appends(request()->all());
        return view('admin.product.pizzaList',compact('pizzaes'));
    }

    //product create
    public function createPage() {
        $categories = Category::select('id','name')->get();
        return view('admin.product.create',compact('categories'));
    }

    //product delete
    public function delete($id) {
        Product::where('id',$id)->delete();
        return redirect()->route('product#list')->with(['deleteSuccess' => 'Product Delete Success...']);
    }

    //product edit
    public function edit($id) {
        $pizza = Product::select('products.*','categories.name as category_name')
                ->leftJoin('categories','products.category_id','categories.id')
                ->where('products.id',$id)->first();
        return view('admin.product.details',compact('pizza'));
    }

    //product updatePage
    public function updatePage($id) {
        $pizza = Product::where('id',$id)->first();
        $category = Category::get();
        return view('admin.product.update',compact('pizza','category'));
    }

    //create
    public function create(Request $request) {
        $this->productValidationCheck($request,"create");
        $data = $this->requestProductInfo($request);

        $fileName = uniqid().$request->file('pizzaImage')->getClientOriginalName();
        $request->file('pizzaImage')->storeAs('public',$fileName);
        $data['image'] = $fileName;

        Product::create($data);
        return redirect()->route('product#list');
    }

    //update
    public function update(Request $request) {
        $this->productValidationCheck($request,"update");
        $data = $this->requestProductInfo($request);

        if($request->hasfile('pizzaImage')){
            $oldImage = Product::where('id',$request->pizzaId)->first();
            $oldImage = $oldImage->image;

            if($oldImage != null){
                Storage::delete('public/'.$oldImage);
            }

            $fileName = uniqid().$request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        Product::where('id',$request->pizzaId)->update($data);
        return redirect()->route('product#list');
    }

    //request product Info
    private function requestProductInfo($request){
        return [
            'category_id' => $request->pizzaCategory ,
            'name' => $request->pizzaName ,
            'description' => $request->pizzaDescription ,
            'price' => $request->pizzaPrice ,
            'waiting_time' => $request->pizzaWaitingTime,
        ];
    }

    //product validation Check
    private function productValidationCheck($request,$action){
        $validatorMake = [
            'pizzaName' => 'required|min:5|unique:products,name,'.$request->pizzaId ,
            'pizzaCategory' => 'required' ,
            'pizzaDescription' => 'required|min:10' ,
            'pizzaPrice' => 'required' ,
            'pizzaWaitingTime' => 'required' ,
        ];

        $validatorMake['pizzaImage'] = $action == "create" ? 'required|mimes:jpg,png,jpeg,webp|file': "mimes:jpg,png,jpeg,webp|file";
        Validator::make($request->all(),$validatorMake)->Validate();
    }
}
