<?php
session_start();
require('dbconfig.php');
?>
<?php 
	if(!(isset($_GET['id']) && isset($_SESSION['name']))){
		?>
		<script> location.href = 'fblogin/index.php';
              </script>
			  <?php
	}
	$userName = $_SESSION["name"];
	$userId = $_SESSION["user_id"];
	$userEmail = $_SESSION["email"];
	$userDp = $_SESSION["dp"];
	$eid = $_GET['id'];
	$_SESSION['changepic']= 'default.jpg';
?>
<?php

if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['imageUpload'])){
	$filename=$_FILES['my_file']['name'];
	$filesize=$_FILES['my_file']['size'];
	$filetype=$_FILES['my_file']['type'];
	$tmp_name=$_FILES['my_file']['tmp_name'];
	$caption = $_POST['caption'];
	$ename = $_POST['ename'];
	$q = "select max(entry_id) from entry";
	$res = mysqli_query($con,$q) or die("could not run query!");
	$row= mysqli_fetch_assoc($res);
	if(mysqli_num_rows($res)==0)
		$name=0;
	else{
		/*print_r($row);
		die("d");*/
	$name = $row['max(entry_id)']+1;
	}
	//$filename = $name;
	$loaction = "entry/".$ename."/";
	if(isset($filename)){
		if(!empty($filename)){
			$extension = pathinfo($filename,PATHINFO_EXTENSION);
			if($filesize<=5*1024*1024){
				if(($filetype=="image/jpeg" && $extension=="jpg") || ($filetype=="application/pdf" && $extension=="pdf")){
					if(move_uploaded_file($tmp_name,$loaction.$name.".".$extension)){
						
						$_SESSION['changepic'] = $loaction.$name.".".$extension;
						if($extension=='pdf')
							$_SESSION['changepic']='pdf_default.jpg';
						
						$q = "insert into entry (event_id,uploader_id,caption,file_type) values('$eid','$userId ','$caption','$extension')";
						mysqli_query($con,$q) or die("could not run query!");
						?>
						<div class="alert alert-success alert-dismissable">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <strong>Success!</strong> File sucessfully Uploaded. The upload shall be verified and then added to feed and your MyUploads section.
						</div>
						<?php
						
						
						
						$to = $_SESSION["email"];
						$subject = "Entry Received!";
						$txt = "Hey ".$_SESSION["name"].",<br>Your entry for the event <strong>".$_SESSION["event_name"]."</strong> has been received.<br>We will get back to you soon when all the entries for this event are declared for public feed!<br><br>-Team Zarf";
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

						// More headers
						$headers .= 'From: <team.zarf@gmail.com>' . "\r\n";
						mail($to,$subject,$txt,$headers);
							//echo "Mail sent to <strong>".$row1['email']."</strong><br>";

						
						
						
						
					}
				}else{
					?>
					<div class="alert alert-danger alert-dismissable">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <strong>Ooops!</strong>File format not supported. Try another <strong>.jpg</strong> or <strong>.pdf</strong> file!
					</div>
					<?php 
					
				}
			}else{
				echo "File must be 5 megabytes or less!<br/>";
			}
		}else{
			echo "Please upload a file!<br/>";
		}
	}
}

?>
<!DOCTYPE html>

<html lang="en">
<head>
  <title>Upload</title>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  

</head>
<script>

</script>
<body style="background-image:url('upload.jpg'); background-size:cover; width: 100%; height: 100%;background-position: center;">
	<br><br><br><br>
	<div class="container">
	
	 <?php 
		$q = "select * from event where event_id = '$eid'";
		$res = mysqli_query($con,$q) or die("could not run query!");
		$row = mysqli_fetch_assoc($res);
		$ename =  $row['event_name'];
		$_SESSION['event_name'] = $row['event_name'];
		if($row['event_status']!=1){
			echo "<strong>Permission Denied!</strong>";
			die("");
		}
	 ?>
	  <div class="panel panel-primary" style="opacity:0.8;" id="inner" >
		  <div class="panel-heading"><?php echo $row['event_name']; ?></div>;
		  <div class="row">
		  
		  
		  <div class="col-md-4">
		  <div class="panel-body" ><img src="entry/<?php echo $ename; ?>/titledp.jpg"  class="img-responsive img-rounded" alt="Loading..."></div>
		  </div>
		  <div class="col-md-8">
		  <blockquote>
			<p><?php echo $row['event_desc']; ?></p>
			<footer>Running</footer>
		  </blockquote>
		  </div>
		  </div>
		</div>
		<div class="row">
		<div class="col-md-3">
		
		<div class="panel panel-info"  >
		  <div class="panel-heading">Your Upload!</div>;
		  
		  <div class="panel-body" ><center><img src="<?php echo $_SESSION['changepic']; ?>"  class="img-responsive img-rounded" alt="Loading..."></center></div>
		</div>
		
		
		</div>
		<div class="col-md-9">
		<div class="well text-danger">
		<h4>Disclamer:</h4>
		Caption is mandatory to upload and it should be less than 100 words. Further image should be of <strong>.jpg</strong> format and document should be of <strong>.pdf</strong> format, neither of them exceeding <strong>5MB</strong> of size.
		</div>
		<form action="uploadPortal.php?id=<?php echo $eid; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
		
			
			<div class="form-group">
				<label class="control-label col-sm-2" for="email">Uploader's Name:</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" value="<?php echo $_SESSION['name']; ?>" id="uname" name="uname" readonly>
				</div>
			</div>
			<div class="form-group">
				
				<div class="col-sm-10">
				  <input type="hidden" class="form-control" value="<?php echo $ename; ?>" id="ename" name="ename" readonly >
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="pwd">Caption:  <strong class="text-danger"> There is a word limit of around 500 words</strong></label>
				<div class="col-sm-10"> 
				  <input type="text" class="form-control" name="caption" id="pwd"   placeholder="Enter caption" required/>
				</div>
			</div>
			
			<div class="form-group">
			<div class="col-sm-10" style="margin-left:17%;">
			<input type="file" class="form-control"  id="files" name="my_file" required/>
			</div>
			</div>
			<?php if($_SESSION['changepic']=='default.jpg'){?>
			<input type="submit" class="btn btn-danger" name="imageUpload">
			<?php } ?>
		</form>
		<br>
		<?php if($_SESSION['changepic']!='default.jpg'){?>
		<button class="btn btn-default"> <a href="feed.php" class="text-success">Go Back</a></button><br><br><br><hr>
		<?php } ?> 
		<!--<form >
		  <div class="form-group">
			<label class="control-label col-sm-2" for="email">Uploader's Name:</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" value="<?php echo $_SESSION['name']; ?>" id="uname" readonly>
			</div>
		  </div>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="pwd">Caption:</label>
			<div class="col-sm-10"> 
			  <input type="text" pattern=".{800}" class="form-control" name="caption" id="pwd"   placeholder="Enter caption" required/>
			</div>
		  </div>
		  <div class="form-group"> 
			<div class="col-sm-offset-2 col-sm-10" >
			  <button type="submit" class="btn btn-danger" >Upload</button >
			</div>
		  </div>
		</form> -->
	  </div>
	  </div>
	
	
	</div>
</body>
<script>
function update(x) {
     alert(x);
}
</script>
</head>