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
$userId = $_SESSION["user_id"];
//$file = fopen("w.txt","a");
	
if(isset($_POST['name']) && isset($_POST['rxn'])){
	$eId = $_POST['name'];
	$rxn = $_POST['rxn'];
	
	$q = "select * from rxn where user_id = '$userId' and entry_id='$eId'";
	
	$res = mysqli_query($con,$q) or die("Could not run!");
	//fwrite($file,$eId.$rxn."\n");
	
	$row = mysqli_fetch_assoc($res);
	if(mysqli_num_rows($res)==0){
		//$q1 = "insert into user (id,name,email,dp) values('$userId','$userName','$userEmail','$userDp')";
		$q1 = "insert into rxn (user_id,entry_id,rxn_type) values('$userId','$eId','$rxn')";
		mysqli_query($con,$q1) or die("Could not run!");
		//fwrite($file,$eId.$rxn."\n");
	}else if($row['rxn_type']==$rxn){
		$q1 = "delete from rxn where user_id = '$userId' and entry_id='$eId'";
		mysqli_query($con,$q1) or die("Could not run!");
	}else{
		$q1 = "update rxn set rxn_type='$rxn' where user_id = '$userId' and entry_id='$eId'";
		mysqli_query($con,$q1) or die("Could not run!");
	}
}
//fclose($file);
?>