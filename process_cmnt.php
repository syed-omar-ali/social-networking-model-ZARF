<?php
session_start();
?>
<?php
if(!isset($_SESSION['name'])){
	?>
		<script> location.href = 'fblogin/index.php';
              </script>
			  <?php
}
require('dbconfig.php');
if(isset($_POST['csubmit'])){
	$cmnt = $_POST['cmnt'];
	$uid = $_POST['uid'];
	$eid = $_POST['eid'];
	$q = "insert into comment values('$uid','$eid','$cmnt')";
	mysqli_query($con,$q) or die("query failed!");
	
}else if(isset($_POST['cdel'])){
	$cmnt = $_POST['dcmnt'];
	$uid = $_POST['duid'];
	$eid = $_POST['deid'];
	$q = "delete from comment where user_cid='$uid' and entry_cid='$eid' and cmnt='$cmnt'";
	mysqli_query($con,$q) or die("query failed!");
	
}
?>
<script>
	location.href='feed.php';
	</script>