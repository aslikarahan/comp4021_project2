<?php
session_start();
if(!isset($_SESSION['username'])){
		if(isset($_COOKIE['username'])){
			$_SESSION['username'] = $_COOKIE['username'];
		}else{
			header("Location: loginform.php");
			exit;
		}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="./lib/jquery.twbsPagination.js"></script>
<script src="./lib/datepicker.min.js"></script>


  <style>
  .center-block {
    display: center-block;
    margin-left: auto;
    margin-right: auto;
  }
  .del-btn, .edit-btn{
	 display:block;
	 margin: 0 auto;
  }

	#profile-pic{
		background: lightgrey;
	}

</style>


<script>


$(document).ready(function() {
var username = <?php echo json_encode($_SESSION['username']) ?>;
var query= "username="+username;
$.getJSON("userProfilePicture.php", query, function(data) {
$("#profile-pic").attr("src",data);
},"json")
.fail(function() {
	alert("Unknown error!");
});

  var editCharacter = {};
  $.getJSON("getUser.php", {name: username}, function(data){
    editCharacter = (data);

      $("#name-edit").val(editCharacter.name);
      $("#username-edit").val(username);
      $("#email").val(editCharacter.email);
      if(editCharacter.gender=="F"){
        $("#gender2").attr("checked", true);
      }else{
        $("#gender1").attr("checked", true);

      }

      $("#birthday").val(editCharacter.birthday);
      $("#pwd").val(editCharacter.password);

  },"json");

  $("#editForm").on("submit", function() {
  // AJAX submit the form
  var query = $("#editForm").serialize();
  $.post("editUser.php", query, function(data) {
    if (data == "success"){
  $("#editForm").hide();
      $("#success_edit_text").show();

    }
  }, "json");

  return false;
  });



});
</script>
</head>
<body>
  <img id="profile-pic" class="col-md6 col-sm-3" src="" alt="">
  <div class="card rounded-0">
      <div class="card-header">
          <h3 class="mb-0 text-center">Edit Profile</h3>
      </div>
      <div class="card-body">
  <h2 style="display:none" id="error-text" class="text-danger"></h2>
          <form class="form" id="editForm">

              <div class="form-group">
                  <label for="username-edit">Username</label>
                  <input type="text" class="form-control form-control-lg rounded-0" name="username" id="username-edit" required>
              </div>
  <div class="form-group">
                  <label for="name-edit">Name</label>
                  <input type="text" class="form-control form-control-lg rounded-0" name="name" id="name-edit" required>
              </div>
  <div class="form-group">
                  <label for="email">E-mail</label>
                  <input type="email" class="form-control form-control-lg rounded-0" name="email" id="email" required>
              </div>
              <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control form-control-lg rounded-0" id="pwd" name="password" required>
              </div>
  <div class="form-group">
                  <label>Birthday</label><br>
                  <!--<input type="text" class="form-control form-control-lg rounded-0" id="birthday" name="birthday" required>!-->
  <input class="form-control form-control-lg " name="birthday" data-toggle="datepicker">

              </div>
  <div class="form-group">
                  <label>Gender</label>&nbsp;
                  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="gender" id="gender1" value="M" checked>
  <label class="form-check-label" for="exampleRadios1">
  Male
  </label>
  </div>
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="gender" id="gender2" value="F">
  <label class="form-check-label" for="exampleRadios1">
  Female
  </label>
  </div>

  <h6>Upload a different photo...</h6>
    <input type="file" class="form-control">

    <button type="submit" class="btn btn-primary" style="display:block;margin: 0 auto;" id="btnSubmit">Submit Changes</button>

  </form>
  </body>
  </html>
