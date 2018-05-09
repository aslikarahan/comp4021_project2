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
  <title>Hogwarts</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="./lib/jquery.twbsPagination.js"></script>

  <style>
	html, body{
      padding: 0;
      margin: 0;
   }
	 .container{
 		margin, padding: 0;
 	}
  .center-block {
    display: center-block;
    margin-left: auto;
    margin-right: auto;
  }
  .del-btn, .edit-btn{
	 display:block;
	 margin: 0 auto;
  }
	.carousel{
		display: block;
		width:75vw;
    margin: auto;
    /* margin-right: auto; */

		margin-bottom: 10px;
		background-color: rgba(0, 0, 0, 0.95);
		background-size: cover;


	}
	.carousel-inner img {
  margin: auto;
}
.close {
    color: #fff;
    opacity: 0.80;
}
.carousel-inner > .carousel-item > img {
 max-height: 60vh;
max-width:100vw;
min-width: 50vw;

}
	#profile-pic{
		height:10vh;
		border-radius: 5vh;
		margin-left: 2vw;
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

  var totalPage = 10;
  var editCharacter = {};
  var $pagination = $('#pagination');
   var defaultOpts = {
        totalPages: totalPage,
            visiblePages: 10,
			first: false,
			last: false,
			startPage: 1,
            onPageClick: function (event, page) {
                $('.char-col').hide();
				$('.char-card-'+(page)).show();
				$('html, body').animate({
					scrollTop: (0)
				},100);
    }
   };
	$pagination.twbsPagination(defaultOpts);
    /**$(function () {
        var obj = $('#pagination').twbsPagination({
            totalPages: totalPage,
            visiblePages: 10,
			first: false,
			last: false,
            onPageClick: function (event, page) {
                $('.char-col').hide();
				$('.char-card-'+(page-1)).show();
				$('html, body').animate({
					scrollTop: (0)
				},500);
            }
        });
        console.info(obj.data());
    });**/
  $('.carousel').carousel({
    interval: 2000
  })


  $("#back-to-list").on("click",function(){
	 window.location.hash = "#list";
	 $("#listForm").trigger("change");

  });
  $("#add_form").on("submit", function() {
    // AJAX submit the form
    var query = $("#add_form").serialize();
    $.post("add.php", query, function(data) {
      if (data == "success"){
        $("#add_form").hide();
				$("#fail_text").hide();

        $("#success_text").show();
		$("#add_form")[0].reset();
	}else{
		$("#add_form").hide();

		$("#success_text").hide();
		$("#fail_text").show();
		$("#add_form")[0].reset();


	}
    }, "json");

    return false;
  });

    $("#edit_form").on("submit", function() {
    // AJAX submit the form
    var query = $("#edit_form").serialize();
    $.post("edit.php", query, function(data) {
      if (data == "success"){
		$("#edit_form").hide();
        $("#success_edit_text").show();

      }
    }, "json");

    return false;
  });




  $(window).on('hashchange', function() {

    // Get the fragment identifier from the URL
    var page = window.location.hash;
    if (page == "#add"){
		$("#add_form").show();
        $("#success_text").hide();
				$("#fail_text").hide();

      $("#add_page").slideDown();
      $("#home_page").hide();
      $("#list_page").hide();
      $("#edit_page").hide();
    }else if(page == "#list"){
			$("#home_page").show();

      $("#list_page").slideDown();
      var html ="";
      $.getJSON("search.php", function(data) {
			processData(data);
        },"json");

      $("#add_page").hide();
      $("#edit_page").hide();
    }else if (page == "#edit"){

	    $("#edit_form").show();
        $("#success_edit_text").hide();
		if( !editCharacter.name){
			window.location.hash = "#list";
		}
		$("#home_page").show();
      $("#edit_page").slideDown();
      $("#add_page").hide();
      $("#list_page").show();
	  $("#id-edit").val(editCharacter.id);
	  $("#name-edit").val(editCharacter.name);
	  $("#house-edit").val(editCharacter.house);
	  $("#status-edit").val(editCharacter.status);
	  $("#patronus-edit").val(editCharacter.patronus);
	  $("#image-edit").val(editCharacter.image);
		$("#description-edit").val(editCharacter.description);

    }else if((page == "#")){
      $("#home_page").show();

      $("#edit_page").hide();
      $("#add_page").hide();
      $("#list_page").show();
    }else{
      $("#home_page").show();

      $("#edit_page").hide();
      $("#add_page").hide();
      $("#list_page").show();
    }
  });
  function processData(data){
	        var html ="";
			var character = (data);
			var i = 0;
			var counter = 0;
html += "<div class='row'>";
      $.each(character, function(key) {
		  if((i % 6) == 0){counter++;}
		  i++;
		  html += "<div class='col-sm char-col char-card-"+counter+"' style=' display: none; padding: 1em'>"
		  html += "<div class='card char-card' style='width: 20rem;'>";
		  html += "<img class='card-img-top' src='"+character[key].image+"' alt='Card image cap'>";
		  html += "<div class='card-body'>";
		  html += " <h5 class='card-title'>"+character[key].name+"</h5><hr>";
          html += "<p style='margin-bottom: 0'><strong>House: </strong>"+character[key].house+"</p>"
          html += "<p style='margin-bottom: 0'><strong>Status: </strong>"+character[key].status+"</p>"
          html += "<p style='margin-bottom: 0'><strong>Patronus: </strong>"+character[key].patronus+"</p>";
					html += "<p style='margin-bottom: 0'><strong>Description: </strong>"+character[key].description+"</p>";

		  html += "<br><button  id='"+character[key].name+"' class='edit-btn btn btn-outline-info'>Edit this character</button>";
		  html += "<br><button id='"+character[key].name+"' class='del-btn btn btn-outline-dark'>Delete this character</button></div></div></div>";


      });
	   html += "</div>"
	  $("#total").text("Total: " + Object.keys(character).length);
	 totalPage = Object.keys(character).length/6;
	 if (Object.keys(character).length%6){
		 totalPage ++;
	 }
      $("#list").html(html);
	  $pagination.twbsPagination('destroy');
	  $pagination.twbsPagination($.extend({}, defaultOpts, {
                startPage: 1,
                totalPages: totalPage
            }));
	$('html, body').animate({
			scrollTop: (0)
		},100);
  }
   $(document).on('click','.del-btn', function(){
      var char_key = $(this).attr('id');
	  $.post("delete.php", {name: char_key}, function(data){
		processData(data);
    },"json");
   });

	 $(document).on('click','#close-carousel', function(){

	 $("#home_page").slideUp();

	 });

	 $(document).on('click','.edit-btn', function(){
		 var char_key = $(this).attr('id');
		$.getJSON("getChar.php", {name: char_key}, function(data){
			console.log(data);
			editCharacter = (data);
			window.location.hash = "#edit";
		},"json");

    });


  $("#listForm").on("change", function() {
    var query = $("#listForm").serialize();
    $.getJSON("search.php", query, function(data) {
		processData(data);
    },"json")
    .fail(function() {
      alert("Unknown error!");
    });
  });

	 $("#listForm select").trigger("change");
	$("#listForm").on("submit",function(event){
		event.preventDefault();
	});
  $(window).trigger("hashchange");

  $("#logoutBtn").on("click", function(){
		$.get("logout.php", function(data){
			window.location = 'loginform.php';
			$editCharacter = data;
		},"json");
  });
});
</script>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light" >

    <a class="navbar-brand" href="#">
      <img border="0" src="img/logo.png" height="50vh">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav" margin-bottom="100px">
      <ul class="navbar-nav">
		<li class="nav-item active">
          <a class="nav-link" href="#home"><i class="fas fa-home"></i>&nbsp;Home<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#add">Add Some Magic</a>
        </li>
				<li class="nav-item">
          <a class="nav-link" href="profileEdit.php">Edit Profile</a>
        </li>

      </ul>

    </div>

		<img id="profile-pic" class ="d-none d-md-block" src="" alt="">
		<span class ="d-none d-md-block" style="font-size: 5vh;">Hi,<?php echo $_SESSION['username']?></span>&nbsp;&nbsp;
		<button id="logoutBtn" class="btn btn-outline-primary d-inline"><i class="fas fa-spinner-third"></i>Logout</button>

  </nav>

  <div  id ="home_page" class="container-fluid" style="display: none">
		<!-- <button type="button" class="close" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button> -->
    <div  class="carousel slide d-block" data-ride="carousel" >
			<button id="close-carousel" type="button" class="close" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
      <div class="carousel-inner d-block">
        <div class="carousel-item active">
          <img class="d-block" src="img\/c1.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block" src="img\/c2.jpg" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block" src="img\/c3.jpg" alt="Third slide">
        </div>
        <div class="carousel-item">
          <img class="d-block" src="img\/c4.jpeg" alt="Fourth slide">
        </div>
				<div class="carousel-item">
          <img class="d-block" src="img\/c5.jpg" alt="Fifth slide">
        </div>
				<div class="carousel-item">
          <img class="d-block" src="img\/c6.jpg" alt="Sixth slide">
        </div>
				<div class="carousel-item">
          <img class="d-block" src="img\/c7.jpg" alt="Seventh slide">
        </div>
				<div class="carousel-item">
          <img class="d-block" src="img\/c8.jpg" alt="Eigth slide">
        </div>
				<div class="carousel-item">
          <img class="d-block" src="img\/c9.jpg" alt="Ninth slide">
        </div>
				<div class="carousel-item">
          <img class="d-block" src="img\/c10.jpg" alt="Tenth slide">
        </div>

      </div>
    </div>
  </div>


  <div  id ="add_page" class="container-fluid" style="display: none">
    <h2>Add Character</h2>
    <form id="add_form">
      <div class="form-group" display="None">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required>
      </div>
      <div class="form-group">
        <label for="house">House: </label>
        <select class="form-control"  id="house" placeholder="Select house" name="house">
          <option value = "Gryffindor">Gryffindor</option>
          <option value = "Slytherin">Slytherin</option>
          <option value = "Hufflepuff">Hufflepuff</option>
          <option value = "Ravenclaw">Ravenclaw</option>
          <option value = "-">None</option>
        </select>
      </div>
      <div class="form-group">
        <label for="house">Status: </label>
        <select class="form-control"  id="status" placeholder="Enter status" name="status" required>
          <option value = "Pure Blood">Pure Blood</option>
          <option value = "Half Blood">Half Blood</option>
          <option value = "Muggle Born">Muggle Born</option>
          <option value = "Muggle">Muggle</option>
          <option value = "-">Other</option>
        </select>
      </div>

      <div class="form-group">
        <label for="status">Patronus: </label>
        <input type="text" class="form-control" id="patronus" placeholder="Enter patronus" name="patronus">
      </div>
      <div class="form-group">
        <label for="image">Image: </label>
        <input type="text" class="form-control" id="image" placeholder="Enter image" name="image">
      </div>
			<div class="form-group">
				<label for="description">Description:</label>
				<textarea type="text" class="form-control" rows="5" maxlength="350" id="description" name="description" placeholder="Enter the description, no more than 350 chars"></textarea>
			</div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <h1 id="success_text" style="display:none;color: green;">Added!</h1>
		<h1 id="fail_text" style="display:none;color: red;">Character Already Exists!</h1>

  </div>

  <div  id ="list_page" class="container" style="display: none">
    <h2>List Character</h2>
    <br>
    <form class="form-inline" id="listForm">
      <label class="my-2 mr-4" for="house">House</label>
      <select class="custom-select my-1 mr-sm-2" id="house" name="house">
        <option selected value = "">All</option>
        <option value = "Gryffindor">Gryffindor</option>
        <option value = "Slytherin">Slytherin</option>
        <option value = "Hufflepuff">Hufflepuff</option>
        <option value = "Ravenclaw">Ravenclaw</option>

      </select>

      <label class="my-2 mr-4" for="sort">Sort By</label>
      <select class="custom-select my-1 mr-sm-2" id="sort" name="sort">
        <option selected value ="">---</option>
        <option value = "by-name">By Name</option>
        <option value = "by-patronus">By Patronus</option>
      </select>

			<input class="form-control mr-sm-2" type="search" id="search-element" placeholder="Search" name="search" aria-label="Search">
			<input type="button" class="btn btn-primary btnSeccion" id="btnSeccion3" value="Search"/>

    </form>


	<p id="total"><p>
    <div id="list"></div>

	<ul class="pagination" id="pagination"></ul>
  </div>

  <div  id ="edit_page" class="container-fluid" style="display: none">
    <h2>Edit Character</h2>

	<form id="edit_form">
	<input type="hidden" class="form-control" id="id-edit"  name="id">
      <div class="form-group" display="None">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name-edit" value="" placeholder="Enter name" name="name" required>
      </div>
      <div class="form-group">
        <label for="house">House: </label>
        <select class="form-control"  id="house-edit" placeholder="Select house" name="house">
          <option value = "Gryffindor">Gryffindor</option>
          <option value = "Slytherin">Slytherin</option>
          <option value = "Hufflepuff">Hufflepuff</option>
          <option value = "Ravenclaw">Ravenclaw</option>
          <option value = "-">None</option>
        </select>
      </div>
      <div class="form-group">
        <label for="status">Status: </label>
        <select class="form-control"  id="status-edit" placeholder="Enter status" name="status" required>
          <option value = "Pure Blood">Pure Blood</option>
          <option value = "Half Blood">Half Blood</option>
          <option value = "Muggle Born">Muggle Born</option>
          <option value = "Muggle">Muggle</option>
          <option value = "-">Other</option>
        </select>
      </div>

      <div class="form-group">
        <label for="patronus">Patronus: </label>
        <input type="text" class="form-control" id="patronus-edit" placeholder="Enter patronus" name="patronus">
      </div>
      <div class="form-group">
        <label for="image">Image: </label>
        <input type="text" class="form-control" id="image-edit" placeholder="Enter image" name="image">
      </div>
			<div class="form-group">
				<label for="description">Description:</label>
				<textarea type="text" class="form-control" id="description-edit" rows="5" maxlength="350" name="description" placeholder="Enter the description, no more than 350 chars"></textarea>
			</div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
	<h1 id="success_edit_text" style="display:none;color: green;">Saved!</h1>
	<button style="margin-top: 5px;" id="back-to-list" class="btn btn-outline-primary">Back to List</button>
    </div>

  </body>
  </html>
