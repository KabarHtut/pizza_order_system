<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //password change
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    //admin change password
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

    //account detail
    public function details(){
        return view('admin.account.details');
    }

    //account edit
    public function edit(){
        return view('admin.account.edit');
    }

    //account update

    public function update($id,Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        //for image
        if($request->hasfile('image')){
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        User::where('id',$id)->update($data);
        return redirect()->route('admin#details')->with(['updateSuccess'=>'Admin Account Updated...']);
    }

    //account list

    public function list(){
        $admin = User::when(request('key'),function($query){
                    $query->orWhere('name','like','%'.request('key').'%')
                          ->orWhere('email','like','%'.request('key').'%')
                          ->orWhere('phone','like','%'.request('key').'%')
                          ->orWhere('gender','like','%'.request('key').'%')
                          ->orWhere('address','like','%'.request('key').'%');
                })
                ->where('role','admin')->paginate(3);
        $admin->appends(request()->all());
        return view('admin.account.list',compact('admin'));
    }

    //change admin role
    public function changeRole(Request $request){
        $updateSource = [
            'role' => $request->role
        ];
        User::where('id',$request->adminId)->update($updateSource);
    }

    public function delete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Admin Account Deleted...']);
    }

    //user request data

    private function userRequestData($request){
        return [
            'role' => $request->role
        ];
    }

    //update Check

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
            'name' => 'required' ,
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
