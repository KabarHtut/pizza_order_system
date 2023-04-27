<?php

namespace App\Http\Controllers\User;

use Storage;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //home page
    public function home(){
        $pizza = Product::orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart','history'));
    }

    //change page
    public function passwordChangePage(){
        return view('user.password.change');
    }

    //password change
    public function changePassword(Request $request){
        $this->passwordValidationCheck($request);

        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbHashValue = $user->password;

        if(Hash::check($request->oldPassword, $dbHashValue)){
            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);

            //return back();
            // Auth::logout();
            // return redirect()->route('auth#loginPage');

            return back()->with(['changeSuccess' => 'Password Change Success..']);
        }

        return back()->with(['notMatch' => 'The Old Password not Match. Try Again!']);
    }

    //account change
    public function edit(){
        return view('user.profile.account');
    }

    //update
    public function update($id,Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        if($request->hasfile('image')){
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null ){
                Storage::delete('public/',$dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }
        User::where('id',$id)->update($data);
        return back()->with(['updateSuccess'=>'User Account Updated...']);
    }

    //user filter
    public function filter($categoryId){
        $pizza = Product::where('category_id',$categoryId)->orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart','history'));
    }

    //pizza details
    public function details($id){
        $pizza = Product::where('id',$id)->first();
        $pizzaList = Product::get();
        return view('user.main.detail',compact('pizza','pizzaList'));
    }

    //pizza cart
    public function cartList(){
        $cartList = Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as product_image')
                  ->leftJoin('products','products.id','carts.product_id')
                  ->where('carts.user_id',Auth::user()->id)
                  ->get();
        $totalPrice = 0;

        foreach($cartList as $c){
            $totalPrice += $c->pizza_price*$c->qty;
        }
        return view('user.main.cart',compact('cartList','totalPrice'));
    }

    //direct history page
    public function history(){
        $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate('4');
        return view('user.main.history',compact('order'));
    }

    //direct user list page
    public function userList(){
        $users = User::where('role','user')->paginate(3);
        return view('admin.user.list',compact('users'));
    }

    //change user role
    public function userChangeRole(Request $request){
        $updateSource = [
           'role' => $request->role
        ];
        User::where('id',$request->userId)->update($updateSource);
    }

    //user edit
    public function userEdit($id){
        $user = User::where('id',$id)->first();
        return view('admin.user.edit',compact('user'));
    }

    //user update
    public function userUpdate(Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        //for image
        if($request->hasfile('image')){
            $dbImage = User::where('id',$request->userId)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        User::where('id',$request->userId)->update($data);
        return redirect()->route('admin#userList');
    }

    //user delete
    public function userDelete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess' => 'User Account Deleted....']);
    }

    //get user data
    private function getUserData($request){
        return [
            'name' => $request->name ,
            'email' => $request->email ,
            'phone' => $request->phone ,
            'gender' => $request->gender ,
            'address' => $request->address ,
            'updated_at' => Carbon::now()
        ];
    }

    //account Validation Check

    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required|min:5|unique:users,name,'.$request->userId ,
            'email' => 'required' ,
            'phone' => 'required' ,
            'image' => 'mimes:png,jpg,jpeg,webp|file',
            'gender' => 'required' ,
            'address' => 'required' ,
        ])->validate();
    }

    //password Validation Check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6' ,
            'newPassword' => 'required|min:6' ,
            'confirmPassword' => 'required|min:6|same:newPassword'
        ])->validate();
    }
}
