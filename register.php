<?php
session_start();
if(isset($_COOKIE['username'])) {
	if (!isset($_SESSION['username'])){
		$_SESSION['username'] = $_COOKIE['username'];
	}
   header("Location: index.php");
   exit;
} 
if(isset($_SESSION['username'])){
	 header("Location: index.php");
	 exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="./datepicker.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  <script src="./datepicker.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <style>
	body{
		background: #555;
	}
  </style>
  <script>
	$(document).ready(function() {
		$('[data-toggle="datepicker"]').datepicker();
		$("#formReg").on("submit", function() {
			//console.log("login");
	
    // AJAX submit the form
		var query = $("#formReg").serialize();
		$.post("userregister.php", query, function(data) {
			if(data.status == "success"){
				window.location = "index.php";
			}else{
				$('#error-text').html('<i class="fas fa-exclamation-triangle"></i>&nbsp;' + data.message);
				$('#error-text').show();
			}

		},"json");
			return false;
		});
	
	});
  </script>
</head>
<body>
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center text-white mb-4"><i class="fas fa-magic"></i>&nbsp; Welcome to Hogwarts</h2>
            <div class="row">
                <div class="col-md-6 mx-auto">

                    <!-- form card login -->
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0 text-center">Register</h3>
                        </div>
                        <div class="card-body">
							<h2 style="display:none" id="error-text" class="text-danger"></h2>
                            <form class="form" id="formReg">
								
                                <div class="form-group">
                                    <label for="uname1">Username</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="username" id="username" required>
                                </div>
								<div class="form-group">
                                    <label for="uname1">Name</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="name" id="name" required>
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
									<input name="birthday" data-toggle="datepicker">
									
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

                                <button type="submit" class="btn btn-primary" style="display:block;margin: 0 auto;" id="btnLogin"><i class="fas fa-sign-in-alt"></i>&nbsp;Register</button>
                            </form>
							
							
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->

                </div>


            </div>
            <!--/row-->

        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>
<!--/container-->
</body>
</html>