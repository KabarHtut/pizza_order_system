<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    //message
    public function contactMessage(){
        return view('user.contact.message');
    }

    //sent message
    public function sent(Request $request){
        $this->sentValidationCheck($request,"sent");
        $data = $this->requestSentInfo($request);
        Contact::create($data);
        return back()->with(['sentSuccess' => 'Sent Message Success..']);
    }

    //contact list
    public function contactList(){
        $contact = Contact::orderBy('created_at','desc')->paginate(5);
        $contact->appends(request()->all());
        return view('admin.contact.list',compact('contact'));
    }


    //request sent info
    private function requestSentInfo($request){
        return [
            'name' => $request->name ,
            'email' => $request->email ,
            'message' => $request->message ,
        ];
    }


    //sent validation
    private function sentValidationCheck($request){
        $validatorMake = [
            'name' => 'required|min:5|',
            'email' => 'required' ,
            'message' => 'required|min:10' ,
        ];

        Validator::make($request->all(),$validatorMake)->Validate();
    }
}
