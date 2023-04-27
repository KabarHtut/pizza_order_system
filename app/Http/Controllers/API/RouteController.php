<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    //get all product list
    public function productList(){
        $products = Product::get();
        return response()->json($products, 200);
    }

    //get all category list
    public function categoryList(){
        $categories = Category::get();
        return response()->json($categories, 200);
    }

    //get all user list
    public function userList(){
        $users = User::get();
        return response()->json($users, 200);
    }

    //get all cart list
    public function cartList(){
        $carts = Cart::get();
        return response()->json($carts, 200);
    }

    //get all contact list
    public function contactList(){
        $contacts = Contact::get();
        return response()->json($contacts, 200);
    }

    //get all order list
    public function orderList(){
        $orderlists = OrderList::get();
        return response()->json($orderlists, 200);
    }

    //get all order
    public function order(){
        $orders = Order::get();
        return response()->json($orders, 200);
    }

    //post create category
    public function categoryCreate(Request $request){
        $data = [
            'name' => $request->name ,
            'created_at' => Carbon::now() ,
            'update_at' => Carbon::now()
        ];

        $responce = Category::create($data);
        return response()->json($responce, 200);
    }

    // create contact
    public function contactCreate(Request $request){
        $data = [
            'name' => $request->name ,
            'email' => $request->email ,
            'message' => $request->message ,
            'created_at' => Carbon::now() ,
            'update_at' => Carbon::now()
        ];

        $responce = Contact::create($data)->get();
        return response()->json($responce, 200);
    }

    //delete category
    public function deleteCategory(Request $request){
        $data = Category::where('id',$request->category_id)->first();
        if(isset($data)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(['status' => true ,'message' => "delete success",'deleteData' => $data], 200);
        }
        return response()->json(['status' => false ,'message' => "There is no category..."], 200);
    }

    //category details
    public function categoryDetails($id){
        $data = Category::where('id',$id)->first();
        if(isset($data)){
            return response()->json(['status' => true ,'category' => $data], 200);
        }
        return response()->json(['status' => false ,'category' => "There is no category..."], 500);
    }

    public function updateCategory(Request $request){
        $categoryId = $request->category_id;

        $dbSource = Category::where('id',$categoryId)->first();
        if(isset($dbSource)){
            $data = $this->getCategoryData($request);
            Category::where('id',$categoryId)->update($data);
            $responce = Category::where('id',$categoryId)->first();
            return response()->json(['status' => true ,'message' => "category update success...",'category' => $responce], 200);
        }
        return response()->json(['status' => false ,'message' => "there is no category for update..."], 500);

    }

    //get category data
    private function getCategoryData($request){
        return [
            'name' => $request->category_name ,
            'updated_at' => Carbon::now() ,
        ];
    }
}
