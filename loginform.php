<?php
if(isset($_COOKIE['username'])) {
	error_log("have cookie");
	if (!isset($_SESSION['username'])){
		error_log("don't have session");
		$_SESSION['username'] = $_COOKIE['username'];
	}
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <style>
	body{
		background: #555;
	}
  </style>
  <script>
	$(document).ready(function() {
		$("#formLogin").on("submit", function() {
			//console.log("login");
  
    // AJAX submit the form
		var query = $("#formLogin").serialize();
		$.post("login.php", query, function(data) {
			console.log(query);
			if (data.status == "success"){
				window.location = "index.php";
			}else{
				$("#error-text").html('<i class="fas fa-exclamation-triangle"></i>&nbsp;' + data.message);
				$("#error-text").show();
				
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
                            <h3 class="mb-0 text-center">Login</h3>
                        </div>
                        <div class="card-body">
							<h2 style="display:none" id="error-text" class="text-danger"></h2>
                            <form class="form" id="formLogin">
                                <div class="form-group">
                                    <label for="uname1">Username</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="username" id="username" required>
                                    <div class="invalid-feedback">Oops, you missed this one.</div>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" id="pwd" name="password" autocomplete="new-password" required>
                                    <div class="invalid-feedback">Enter your password too!</div>
                                </div>
                                <div class="form-group form-check">
                                    <label class="form-check-label">
                                       <input class="form-check-input" name="rmbme" type="checkbox">
									   &nbsp;Remember me
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary" style="display:block;margin: 0 auto;" id="btnLogin"><i class="fas fa-sign-in-alt"></i>&nbsp;Login</button>
                            </form>
							<hr>
							<p class="text-center">Don't have an account?</p>
							<button type="submit"class="btn btn-info" style="display:block;margin: 0 auto;">Register</button>
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