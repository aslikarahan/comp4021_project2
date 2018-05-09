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
if($_FILES){
	move_uploaded_file($_FILES["file"]["tmp_name"],"userpp/".$_FILES["file"]["name"]);
}if($_POST){
$users = file_get_contents("users.json");
$users = json_decode($users, true);
$id = $_POST['username'];
$users[$id]["name"] = $_POST["name"];
$users[$id]["email"] = $_POST["email"];
$users[$id]["gender"] = $_POST["gender"];
$users[$id]["birthday"] =$_POST["birthday"];
$users[$id]["password"] = $_POST["password"];
$users[$id]["image"] = "userpp/".$_FILES["file"]["name"];


file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
header("Location: index.php");

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
  <script src='./lib/datepicker.min.js'></script>
  <link rel="stylesheet" href="./lib/datepicker.min.css">

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
	//$('[data-toggle="datepicker"]').datepicker();
	$('#back-to-main').on('click', function(){
		window.location = 'index.php';
	});
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

      $('[data-toggle="datepicker"]').datepicker({
			date: new Date(editCharacter.birthday) // Or '02/14/2014'
		});
      $("#pwd").val(editCharacter.password);
		$('#birthday').val($('[data-toggle="datepicker"]').datepicker('getDate', true));
  },"json");

  /*$("#editForm").on("submit", function() {
 $('#birthday').val($('[data-toggle="datepicker"]').datepicker('getDate', true));
  var query = $("#editForm").serialize();
 console.log(JSON.stringify(query));
 $.post("editUser.php", query, function(data) {
    if (data == "success"){
		$("#success-text").show();
		$("#editForm").hide();
		

    }
  }, "json");

  return false;
  });*/



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
  <h2 id="error-text" class="text-danger"></h2>
          <form enctype="multipart/form-data" method="POST" action="profileEdit.php" class="form" id="editForm">

              <div class="form-group">
                  <label for="username-edit">Username</label>
                  <input type="text" class="form-control form-control-lg rounded-0" name="username" id="username-edit" readonly required>
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
					<input class="form-control form-control-lg " id="birthday" name="birthday" data-toggle="datepicker">
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
			</div>

  <h6>Upload a different photo...</h6>
    <input type="file" name="file" class="form-control">

    <button type="submit" class="btn btn-primary" style="display:block;margin: 0 auto;" id="btnSubmit">Submit Changes</button>

  </form>

	<button style="margin-top: 5px;" id="back-to-main" class="btn btn-outline-primary">Back to Main Page</button>
	</div>
  </body>
  </html>
