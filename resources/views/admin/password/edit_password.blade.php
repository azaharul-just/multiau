@extends('admin.admin_master')

@section('admin')
 


<div style="padding: 20px">
	 
<div class="row" > 
	<div class="col-md-6">
		<h2>Change Password</h2>
		<hr>

		<form method="post" action="{{route('admin.password.update')}}" >
			@csrf
		  <div class="mb-3">
		    <label for="exampleInputEmail1" class="form-label">Current Password</label>
		    <input id="current_password" type="password" name="oldpassword"   class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >

		    @error('oldpassword')
		    	<span class="text-danger">{{$message}}</span>
		    @enderror

		  </div>
		  
		  <div class="mb-3">
		    <label for="exampleInputEmail1" class="form-label">New Password</label>
		    <input id="password" type="password" name="password"   class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" > 
		       @error('password')
		    	<span class="text-danger">{{$message}}</span>
		   	   @enderror
		  </div> 

		  <div class="mb-3">
		    <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
		    <input id="password_confirmation" type="password" name="password_confirmation"   class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" > 
		  	  @error('password_confirmation')
		    	<span class="text-danger">{{$message}}</span>
		   	   @enderror
		  </div> 
 
		  <button type="submit" class="btn btn-primary">Update Password</button>
		</form>
	</div>
</div>
</div>
 


@endsection