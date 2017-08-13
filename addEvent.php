<?php
require('dbconfig.php');
if(isset($_POST['addE'])){
	$ename = $_POST['ename'];
	$elink = $_POST['elink'];
	$edesc = $_POST['edesc'];
	$q1 = "insert into event (event_name,event_desc,event_dp) values('$ename','$edesc','$elink')";
	mysqli_query($con,$q1) or die("querry failed!");
	mkdir("entry/".$ename);
}
if(isset($_GET['pass']) && $_GET['pass']=='omar'){
	
	?>
	<form action="addEvent.php" method="POST">
	<input type="text" name="ename" placeholder="name"/>
	<input type="text" name="elink" placeholder="link"/>
	<textarea name="edesc" placeholder="description"></textarea>
	<input type="submit" name="addE"/>
	</form>
	<?php
}
?>