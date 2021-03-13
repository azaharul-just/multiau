<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MainUserController extends Controller
{
    public function Logout(){
    	Auth::logout();
    	return redirect()->route('login');
    }

    public function UserProfile(){
    	$id = Auth::user()->id;
    	$user = User::find($id);
    	//echo $user;
    	return view('user.profile.view_profile',compact('user'));
    }

    public function UserProfileEdit(){
    	$id = Auth::user()->id;
    	$editData = User::find($id);
    	//echo $user;
    	return view('user.profile.view_profile_edit',compact('editData'));
    }

    public function UserProfileStore(Request $request){
    	$data = User::find(Auth::user()->id);
    	//echo $data;
    	$data->name = $request->name;
    	$data->email = $request->email;

    	if ($request->file('profile_photo_path')) {
    		$file = $request->file('profile_photo_path');
    		@unlink(public_path('upload/user_images/'.$data->profile_photo_path));
    		$filename = date('YmdHi').$file->getClientOriginalName();
    		$file->move(public_path('upload/user_images'),$filename);
    		$data['profile_photo_path'] = $filename;
    	}
    	$data->save();

    	//return redirect()->route('user.profile');
    	 $notification = array(
            'message'=>'Profile Update Successfully',
            'alert-type'=>'success'
        );

        return Redirect()->route('user.profile')->with($notification);

    }

    public function UserpPasswordView(){
        return view('user.password.edit_password');
    }

    public function UserPasswordUpdate(Request $request){
        $validatedData = $request->validate([ 
            'oldpassword' => 'required',  
            'password' => 'required|confirmed',
        ]);  

        $hashedPassword = Auth::user()->password; 
        $password = $request->oldpassword;
        
        if (Hash::check($password,$hashedPassword)) {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();

            //return redirect()->route('login')->with('success','Password Changed Successfully');

             $notification = array(
            'message'=>'Profile Update Successfully',
            'alert-type'=>'success'
            );

            return Redirect()->route('login')->with($notification);


        }else{

             $notification = array(
            'message'=>'Current Password Invalid',
            'alert-type'=>'warning'
            );

            return Redirect()->back()->with($notification);
            //return redirect()->back()->with('success','Current Password Invalid'); 
        }
    } 



}
