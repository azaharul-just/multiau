<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class MainAdminController extends Controller
{
    public function AdminProfile(){
    	$adminData = Admin::find(1);
    	//echo $adminData;
    	return view('admin.profile.view_profile',compact('adminData'));
    }

    public function AdminProfileEdit(){
    	$editData = Admin::find(1);
    	//echo $adminData;
    	return view('admin.profile.view_profile_edit',compact('editData')); 

    }

    public function AdminProfileStore(Request $request){
    	$data = Admin::find(1);
    	//echo $data;
    	$data->name = $request->name;
    	$data->email = $request->email;

    	if ($request->file('profile_photo_path')) {
    		$file = $request->file('profile_photo_path');

    		@unlink(public_path('upload/admin_images/'.$data->profile_photo_path));
    		$filename = date('YmdHi').$file->getClientOriginalName();
    		$file->move(public_path('upload/admin_images'),$filename);
    		$data['profile_photo_path'] = $filename; 
    	}

    	$data->save();

    	$notification = array(
            'message'=>'Profile Update Successfully',
            'alert-type'=>'success'
        ); 
        return Redirect()->route('admin.profile')->with($notification);  
    	
    }

    public function AdminPasswordView(){
        return view('admin.password.edit_password');
    }

    public function AdminPasswordUpdate(Request $request){
        $validatedData = $request->validate([ 
            'oldpassword' => 'required',  
            'password' => 'required|confirmed',
        ]);  

        $hashedPassword = Admin::find(1)->password; 
        $password = $request->oldpassword;
        
        if (Hash::check($password,$hashedPassword)) {
            $admin = Admin::find(1);
            $admin->password = Hash::make($request->password);
            $admin->save();
            Auth::logout();

            //return redirect()->route('login')->with('success','Password Changed Successfully');

             $notification = array(
            'message'=>'Password Update Successfully',
            'alert-type'=>'success'
            );

            return Redirect()->route('admin.logout')->with($notification);


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
