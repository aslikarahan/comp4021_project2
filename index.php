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
<script src="./jquery.twbsPagination.js"></script>
  <style>
  .center-block {
    display: block;
    margin-left: auto;
    margin-right: auto;
  }
  .del-btn{
	 display:block;
	 margin: 0 auto;
  }
</style>
<script>
$(document).ready(function() {
  // Submit the form
  var totalPage = 10;
  var $pagination = $('#pagination');
   var defaultOpts = {
        totalPages: totalPage,
            visiblePages: 10,
			first: false,
			last: false,
			startPage: 1,
            onPageClick: function (event, page) {
                $('.char-col').hide();
				$('.char-card-'+(page-1)).show();
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

  $("#add_form").on("submit", function() {
    // AJAX submit the form
    var query = $("#add_form").serialize();
    $.post("add.php", query, function(data) {
      if (data == "success"){
        $("#add_form").hide();
        $("#success_text").show();
      }
    }, "json");

    return false;
  });




  $(window).on('hashchange', function() {
    // Get the fragment identifier from the URL
    var page = window.location.hash;
    if (page == "#add"){
      $("#add_page").slideDown();
      $("#home_page").hide();
      $("#list_page").hide();
      $("#edit_page").hide();
    }else if(page == "#list"){
      $("#list_page").slideDown();
      var html ="";
      $.getJSON("list.php", function(data) {
        var character = JSON.parse(data);
        $.each(character, function(key) {
          html += "<div class='card'>";
		  html += "<img class='card-img-top' src='"+character[key].image+"' alt='Card image cap'>";
		  html += "<div class='card-body'>";
		  html += " <h5 class='card-title'>"+character[key].name+"</h5>";
          html += "<p><strong>House: </strong>"+character[key].house+"</p>"
          html += "<p><strong>Status: </strong>"+character[key].status+"</p>"
          html += "<p><strong>Patronus: </strong>"+character[key].patronus+"</p></div></div>";
        
          
        });
        $("#list").html(html);
      });
      $("#home_page").hide();
      $("#add_page").hide();
      $("#edit_page").hide();
    }else if (page == "#edit"){
      $("#edit_page").slideDown();
      $("#home_page").hide();
      $("#add_page").hide();
      $("#list_page").hide();
    }else if((page == "#")){
      $("#home_page").show();

      $("#edit_page").hide();
      $("#add_page").hide();
      $("#list_page").hide();
    }else{
      $("#home_page").show();

      $("#edit_page").hide();
      $("#add_page").hide();
      $("#list_page").hide();
    }
  });
  function processData(data){
	        var html ="";

      var character = JSON.parse(data);
	
      $.each(character, function(key) {
		  console.log(key);
		  if (key % 3 == 1) html += "<div class='row'>";
		  html += "<div class='col char-col char-card-"+parseInt((key-1)/6)+"' style=' display: none; padding: 1em'>"
		  html += "<div class='card char-card' style='width: 20rem;'>";
		  html += "<img class='card-img-top' src='"+character[key].image+"' alt='Card image cap'>";
		  html += "<div class='card-body'>";
		  html += " <h5 class='card-title'>"+character[key].name+"</h5><hr>";
          html += "<p style='margin-bottom: 0'><strong>House: </strong>"+character[key].house+"</p>"
          html += "<p style='margin-bottom: 0'><strong>Status: </strong>"+character[key].status+"</p>"
          html += "<p style='margin-bottom: 0'><strong>Patronus: </strong>"+character[key].patronus+"</p>";
		  html += "<br><button id='"+key+"' class='del-btn btn btn-outline-dark'>Delete this character</button></div></div></div>";
		  if (key % 3 == 0) html += "</div>"
		 
      });
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
	  $.post("delete.php", {id: char_key}, function(data){
		processData(data);
    })
    .fail(function() {
      alert("Unknown error!");
    });

   });
  $("#listForm select").on("change", function() {
    var query = $("#listForm").serialize();
    $.get("list.php", query, function(data) {
		processData(data);
    })
    .fail(function() {
      alert("Unknown error!");
    });
  });

	$("#listForm select").trigger("change");

  $(window).trigger("hashchange");
  $("#logoutBtn").on("click", function(){
		$.get("logout.php", function(data){
			window.location = 'loginform.php';
		});
  });
});
</script>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="#">
      <img border="0" src="img/logo.png" height="75">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
		<li class="nav-item active">
          <a class="nav-link" href="#home"><i class="fas fa-home"></i>&nbsp;Home<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#list">List the Magic</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#add">Add Some Magic</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#edit">Edit Character</a>
        </li>
      </ul>

    </div>

      <button id="logoutBtn" class="btn btn-outline-primary"><i class="fas fa-spinner-third"></i>Logout</button>

  </nav>

  <div  id ="home_page" class="container center-block" style="display: none">
    <div  class="carousel slide" data-ride="carousel" >
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-75" src="img\/c1.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-75" src="img\/c2.jpg" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-75" src="img\/c3.jpg" alt="Third slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-75" src="img\/c4.jpeg" alt="Fourth slide">
        </div>
      </div>
    </div>
  </div>


  <div  id ="add_page" class="container" style="display: none">
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
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <h1 id="success_text" style="display:none;color: green;">Added!</h1>
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

      <label class="my-2 mr-4" for="status">Status</label>
      <select class="custom-select my-1 mr-sm-2" id="status" name="status">
        <option selected value ="">All</option>
        <option value = "Pure Blood">Pure Blood</option>
        <option value = "Half Blood">Half Blood</option>
        <option value = "Muggle Born">Muggle Born</option>
        <option value = "Muggle">Muggle</option>
      </select>
    </form>
	<p id="total"><p>
    <div id="list"></div>
	<ul class="pagination" id="pagination"></ul>
  </div>

  <div  id ="edit_page" class="container" style="display: none">
    <h2>Edit Character</h2>
    <p> ipsum lolzi lolzi lolzi akjdhkjahsd<p>
    </div>


  </body>
  </html>
