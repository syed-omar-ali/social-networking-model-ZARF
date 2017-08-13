<?php
session_start();
?>
<?php
require('dbconfig.php');
if(!isset($_SESSION['name'])){
	?>
		<script> location.href = 'fblogin/index.php';
              </script>
			  <?php
}
/*##########################*/
$userName = $_SESSION["name"];
$userId = $_SESSION["user_id"];
$userEmail = $_SESSION["email"];
$userDp = $_SESSION["dp"];
$q = "select * from user where id = $userId";
$res = mysqli_query($con,$q) or die("querry failed!");	 
if(mysqli_num_rows($res)==0){
	$q1 = "insert into user (id,name,email,dp) values('$userId','$userName','$userEmail','$userDp')";
	mysqli_query($con,$q1) or die("querry failed!");	 
}else{
	$q1 = "select * from user where id = $userId";
	$res1 = mysqli_query($con,$q) or die("querry failed!");
	$row = mysqli_fetch_assoc($res1);
	$h = $row['hit'];
	$h = $h + 1;
	$q1 = "update user set hit = '$h' where id = $userId";
	mysqli_query($con,$q1) or die("querry failed!");	 
}
/*##########################*/

?>
<!-- Navigation -->
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Zarf | Online Events</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="sidebar.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body >
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="feed.php">Zarf 2017</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-collapse">
      <!--<ul class="nav navbar-nav">
        <li class="active"><a href="#">Option 1 <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Option 2</a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul>-->
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="http://zarf.co.in"  role="button" aria-expanded="false">Home </a>
          <!--<ul class="dropdown-menu" role="menu">
            <li><a href="#"><span class="fa fa-user"></span> Profile</a></li>
            <li><a href="#"><span class="fa fa-envelope-o"></span> Contact</a></li>
            <li><a href="#"><span class="fa fa-cogs"></span> Settings</a></li>
            <li class="divider"></li>
            <li><a href="#"><span class="fa fa-power-off"></span> Log Out</a></li>
          </ul>-->
        </li>
		<li class="dropdown">
          <a href="http://zarf.co.in/online/logout.php"  role="button" aria-expanded="false">Logout </a>
          <!--<ul class="dropdown-menu" role="menu">
            <li><a href="#"><span class="fa fa-user"></span> Profile</a></li>
            <li><a href="#"><span class="fa fa-envelope-o"></span> Contact</a></li>
            <li><a href="#"><span class="fa fa-cogs"></span> Settings</a></li>
            <li class="divider"></li>
            <li><a href="#"><span class="fa fa-power-off"></span> Log Out</a></li>
          </ul>-->
        </li>
		<li class="dropdown">
          <a href="http://zarf.co.in/dev/index7.html"   role="button" aria-expanded="false"><strong class="text-danger">Developers </strong></a>
          <!--<ul class="dropdown-menu" role="menu">
            <li><a href="#"><span class="fa fa-user"></span> Profile</a></li>
            <li><a href="#"><span class="fa fa-envelope-o"></span> Contact</a></li>
            <li><a href="#"><span class="fa fa-cogs"></span> Settings</a></li>
            <li class="divider"></li>
            <li><a href="#"><span class="fa fa-power-off"></span> Log Out</a></li>
          </ul>-->
        </li>
      </ul>      
      <ul class="nav navbar-nav sider-navbar">
        <li id="profile">
          <figure class="profile-userpic">
            <img src="<?php echo $userDp; ?>" class="img-responsive" alt="Profile Picture">
          </figure>
          <div class="profile-usertitle">
            <div class="profile-usertitle-name"><?php echo $userName; ?></div>
            <div class="profile-usertitle-title"><?php echo $userEmail; ?></div>
          </div>
        </li>
        <li class="sider-menu">
          <ul>
            <li class="active"><a href="#" data-toggle="collapse" data-target="#submenu-7"><span class="fa fa-fw fa-dashboard"></span> My Running Uploads <span class="fa fa-fw fa-caret-down"></span></a>
			<ul id="submenu-7" class="collapse">
			  <?php
					$q2 = "select * from entry as En,event as Ev
					where (Ev.event_status=2) and Ev.event_id=En.event_id and En.uploader_id = '$userId'";
					$res2 = mysqli_query($con,$q2) or die("querry failed!");	
					while($row = mysqli_fetch_assoc($res2)){
						$eid = $row['event_id'];
			  ?>
				
                <li><a href="loadSingleEntry.php?id=<?php echo $row['entry_id']; ?>">in <strong class="text-info"><?php echo $row['event_name']; ?></strong></a></li>
				<?php
					}
				?>
                
              </ul>
			
			</li>
            <li>
              <a href="#" data-toggle="collapse" data-target="#submenu-1"><span class="fa fa-database"></span> Participate <span class="fa fa-fw fa-caret-down"></span></a>
              <ul id="submenu-1" class="collapse">
			  <?php
					$q2 = "select * from event where event_status=1";
					$res2 = mysqli_query($con,$q2) or die("querry failed!");	
					while($row = mysqli_fetch_assoc($res2)){
						$eid = $row['event_id'];
			  ?>
				
                <li><a href="uploadPortal.php?id=<?php echo $eid; ?>"><?php echo $row['event_name']; ?></a></li>
				<?php
					}
				?>
                
              </ul>
            </li> 
            <li id="results"><a href="#"><span class="fa fa-folder"></span> Results</a></li>
            <li>
              <a href="#" id="dec"><i class="fa fa-cog"></i> See Declared Events </a>
            </li>  
          </ul>
       </li>
      </ul>
	  
    </div>
  </div>
</nav>
<section id="page-keeper">
  <div class="container-fluid">
  <div class="row">
  <div class="col-md-9" id="here">
  
  </div> 
  <div class="col-md-3">
  
  <div class="well">
  <center>
  <strong class="text-success">Total Hits on Online Portal: </strong>
  <?php 
	$a = "select sum(hit) from user";
	$r = mysqli_query($con,$a);
	$r = mysqli_fetch_assoc($r);?>
	<kbd><?php echo $r['sum(hit)']; ?></kbd>
	<?php
  ?>
  </center>
  </div>
  </div> 
  
  </div>
 
  </div>
</section>
</body>
<script>



$(document).ready(function(){
    $("#results").click(function(){
		//alert('fd');
		$('#here').html('');
		/*<?php
	
		$q = "select * from entry as En,event as Ev
		where En.event_id=Ev.event_id and Ev.event_status=3";
		$res = mysqli_query($con,$q) or die("querry failed!");
		//echo mysqli_num_rows($res);
		
		while($row = mysqli_fetch_assoc($res)){
			//echo $row['entry_id'];
		?>
	  
	   $('#here').append('<div id="div'+ <?php echo $row['entry_id']; ?> +'" />');
		$('#div'+<?php echo $row['entry_id']; ?>).load('getEntry.php?id='+<?php echo $row['entry_id']; ?>);
	  <?php } ?>*/
	  <?php
	  $q = "select * from event where event_status=3 order by event_id desc";
	  $res = mysqli_query($con,$q) or die("querry failed!");
	  while($row = mysqli_fetch_assoc($res)){
		$eventId = $row['event_id'];
		$q1 = "select * from entry where event_id='$eventId' order by cast(score as unsigned) desc limit 3";
		$res1 = mysqli_query($con,$q1) or die("querry failed!");
		$i =0;
		while($row1 = mysqli_fetch_assoc($res1)){
			$i++;
		?>
		$('#here').append('<div id="div'+ <?php echo $row1['entry_id']; ?> +'" />');
		$('#div'+<?php echo $row1['entry_id']; ?>).load('getResult.php?id='+<?php echo $row1['entry_id']; ?>+'&d='+<?php echo $i; ?>);
		<?php
		}
	  }
	  ?>
    });
	
	
	
	$("#dec").click(function(){
		//alert('fd');
		$('#here').html('');
		/*<?php
	
		$q = "select * from entry as En,event as Ev
		where En.event_id=Ev.event_id and Ev.event_status=3";
		$res = mysqli_query($con,$q) or die("querry failed!");
		//echo mysqli_num_rows($res);
		
		while($row = mysqli_fetch_assoc($res)){
			//echo $row['entry_id'];
		?>
	  
	   $('#here').append('<div id="div'+ <?php echo $row['entry_id']; ?> +'" />');
		$('#div'+<?php echo $row['entry_id']; ?>).load('getEntry.php?id='+<?php echo $row['entry_id']; ?>);
	  <?php } ?>*/
	  <?php
	  $q = "select * from event where event_status=3 order by event_id desc";
	  $res = mysqli_query($con,$q) or die("querry failed!");
	  while($row = mysqli_fetch_assoc($res)){
		$eventId = $row['event_id'];
		$q1 = "select * from entry where event_id='$eventId' order by cast(score as unsigned) desc";
		$res1 = mysqli_query($con,$q1) or die("querry failed!");
		$i =0;
		while($row1 = mysqli_fetch_assoc($res1)){
			$i++;
		?>
		$('#here').append('<div id="div'+ <?php echo $row1['entry_id']; ?> +'" />');
		$('#div'+<?php echo $row1['entry_id']; ?>).load('getResult.php?id='+<?php echo $row1['entry_id']; ?>+'&d='+<?php echo $i; ?>);
		<?php
		}
	  }
	  ?>
    });
	
	
});	


$(document).ready(function(){
	<?php
	
	$q = "select * from entry as En,event as Ev
	where En.event_id=Ev.event_id and En.permit=1 and Ev.event_status=2 order by En.event_id desc";
	$res = mysqli_query($con,$q) or die("querry failed!");
	//echo mysqli_num_rows($res);
	
	while($row = mysqli_fetch_assoc($res)){
		//echo $row['entry_id'];
	?>
  
   $('#here').append('<div id="div'+ <?php echo $row['entry_id']; ?> +'" />');
	$('#div'+<?php echo $row['entry_id']; ?>).load('getEntry.php?id='+<?php echo $row['entry_id']; ?>);
  <?php } ?>
});


</script>
</html>