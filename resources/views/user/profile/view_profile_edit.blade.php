@extends('user.user_master')

@section('user')

<!-- Jquery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div style="padding: 20px">
	 <h2>Edit Profile</h2>
	<hr>
<div class="row" > 
	<div class="col-md-6">
		<form method="post" action="{{route('profile.store')}}" enctype="multipart/form-data">
			@csrf
		  <div class="mb-3">
		    <label for="exampleInputEmail1" class="form-label">User Name</label>
		    <input type="text" name="name" value="{{$editData->name}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" > 
		  </div>
		  
		  <div class="mb-3">
		    <label for="exampleInputEmail1" class="form-label">Email Address</label>
		    <input type="email" name="email" value="{{$editData->email}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" > 
		  </div> 

	 	  <div class="mb-3">
		   <label for="formFile" class="form-label">Profile Image</label>
		   <input class="form-control" type="file" name="profile_photo_path" id="image">
		  </div>

		  <div class="mb-3">
		    <img id="showImage" src="{{ (!empty($editData->profile_photo_path)) ? url('upload/user_images/'.$editData->profile_photo_path):url('upload/no_image.jpg')}}" height="120px" width="120px">
		  </div> 

		  <button type="submit" class="btn btn-primary">Update Profile</button>
		</form>
	</div>
</div>
</div>

<!-- After select image show, Don't forget add jquery cdn that is above this file -->
<script type="text/javascript">
	$(document).ready(function(){
			$('#image').change(function(e){
					var reader = new FileReader();
					reader.onload = function(e){
						$('#showImage').attr('src',e.target.result);
					}
					reader.readAsDataURL(e.target.files['0']);
			});
	});
</script>


@endsection