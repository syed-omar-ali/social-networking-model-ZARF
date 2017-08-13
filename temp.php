<?php 
require('dbconfig.php');
$q = "select * from entry where event_id = 2 order by cast(score as unsigned) desc ";
	$res1 = mysqli_query($con,$q) or die("Failed");
	$i=0;
	while($row1 = mysqli_fetch_assoc($res1)){
		$entryId = $row1['entry_id']." ".$row1['score']."<br>";
		echo $entryId;
	}
?>