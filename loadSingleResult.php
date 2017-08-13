<!DOCTYPE html>
<?php 
if(!isset($_GET['id']))
			die("Ooops!");
		$id = $_GET['id'];
		$designation = $_GET['d'];
?>
<html lang="en">
<head>
  <title>Zarf | Online Events</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body onload="LoadPage()">
<div class="container-fluid">
    <div class="row">
	
	
		
		
		<div class="col-md-9" id="loadFeed"></div>
		
		
      <div class="col-md-3"></div>
	  </div>
</div>
</body>
<script>
function LoadPage(){
  $.get('getResult.php?id='+<?php echo $id; ?>+'&d='+<?php echo $designation; ?>, function(data) {
    $('#loadFeed').html(data);
  });
}
</script>
</html>