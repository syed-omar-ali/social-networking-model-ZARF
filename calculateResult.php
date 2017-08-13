<?php
if(isset($_GET['pass']) && isset($_GET['eid']) && $_GET['pass']=='omar'){
	require('dbconfig.php');
	$eventId = $_GET['eid'];
	$q1 = "select * from entry where event_id = '$eventId'";
	$res1 = mysqli_query($con,$q1) or die("Failed");
	while($row1 = mysqli_fetch_assoc($res1)){
		$entryId = $row1['entry_id'];
		$q2 = "select count(user_id)
				from rxn
				where rxn_type='like' and entry_id='$entryId'";
		$res2 = mysqli_query($con,$q2) or die("Failed2");
		$row2 = mysqli_fetch_assoc($res2);
		$c = $row2['count(user_id)'];
		//echo $c;
		$q3 = "update entry set no_likes = '$c' where entry_id='$entryId'";
		mysqli_query($con,$q3) or die("Failed3");
	}
	
	
	$q1 = "select * from entry where event_id = '$eventId'";
	$res1 = mysqli_query($con,$q1) or die("Failed");
	while($row1 = mysqli_fetch_assoc($res1)){
		$entryId = $row1['entry_id'];
		$q2 = "select count(user_id)
				from rxn
				where rxn_type='dislike' and entry_id='$entryId'";
		$res2 = mysqli_query($con,$q2) or die("Failed2");
		$row2 = mysqli_fetch_assoc($res2);
		$c = $row2['count(user_id)'];
		//echo $c;
		$q3 = "update entry set no_dislike = '$c' where entry_id='$entryId'";
		mysqli_query($con,$q3) or die("Failed3");
	}
	
	
	$q1 = "select * from entry where event_id = '$eventId'";
	$res1 = mysqli_query($con,$q1) or die("Failed");
	while($row1 = mysqli_fetch_assoc($res1)){
		$entryId = $row1['entry_id'];
		$q2 = "select count(user_id)
				from rxn
				where rxn_type='love' and entry_id='$entryId'";
		$res2 = mysqli_query($con,$q2) or die("Failed2");
		$row2 = mysqli_fetch_assoc($res2);
		$c = $row2['count(user_id)'];
		//echo $c;
		$q3 = "update entry set no_love = '$c' where entry_id='$entryId'";
		mysqli_query($con,$q3) or die("Failed3");
	}
	
	
	$q1 = "select * from entry where event_id = '$eventId'";
	$res1 = mysqli_query($con,$q1) or die("Failed");
	while($row1 = mysqli_fetch_assoc($res1)){
		$entryId = $row1['entry_id'];
		$q2 = "select count(*)
				from comment
				where  entry_cid='$entryId'";
		$res2 = mysqli_query($con,$q2) or die("Failed2");
		$row2 = mysqli_fetch_assoc($res2);
		$c = $row2['count(*)'];
		//echo $c;
		$q3 = "update entry set no_comment = '$c' where entry_id='$entryId'";
		mysqli_query($con,$q3) or die("Failed3");
	}
	
	$q1 = "select * from entry where event_id = '$eventId'";
	$res1 = mysqli_query($con,$q1) or die("Failed");
	while($row1 = mysqli_fetch_assoc($res1)){
		$entryId = $row1['entry_id'];
		$c1 = $row1['no_likes'];
		$c2 = $row1['no_dislike'];
		$c3 = $row1['no_love'];
		$c4 = $row1['no_comment'];
		$score = $c1+ $c3;
		//echo $c;
		$q3 = "update entry set score = '$score' where entry_id='$entryId'";
		mysqli_query($con,$q3) or die("Failed3");
	}
	
	$q = "update event set event_status=3 where event_id = '$eventId'";
	mysqli_query($con,$q) or die("Failed");
	
	
	$q = "select * from entry where event_id = '$eventId' order by cast(score as unsigned) desc limit 3";
	$res1 = mysqli_query($con,$q) or die("Failed");
	$i=0;
	//echo 'hy';
	while($row1 = mysqli_fetch_assoc($res1)){
		$entryId = $row1['entry_id'];
		echo $entryId." ";
		if($i==0){
		$qd = "update event set event_w1 = '$entryId' where event_id='$eventId'";
		$i++;
		}
		else if($i==1){
		$qd = "update event set event_w2 = '$entryId' where event_id='$eventId'";
		$i++;
		}
		else if($i==2){
		$qd = "update event set event_w3 = '$entryId' where event_id='$eventId'";
		$i++;
		}
		mysqli_query($con,$qd) or die("Failed");
	}
	
	
	
}

$q = "select * from event where event_id='$eventId'";
$res1 = mysqli_query($con,$q) or die("Failed");
$row1 = mysqli_fetch_assoc($res1);
$eventName = $row1['event_name'];
$email = "select * from user";
$res1 = mysqli_query($con,$email) or die("Failed");
$i=0;
while($row1 = mysqli_fetch_assoc($res1)){
$to = $row1['email'];
$subject = "Result Declared";
$txt = "Hey ".$row1['name'].",<br>Result for the event <strong>".$eventName."</strong> has been declared.<br>Go check out the website!<br><br>-Team Zarf";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <team.zarf@gmail.com>' . "\r\n";
if(mail($to,$subject,$txt,$headers)){
	echo $i.". Mail sent to <strong>".$row1['email']."</strong><br>";
	$i++;
}
}
?>