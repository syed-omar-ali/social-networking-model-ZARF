<?php
require('dbconfig.php');
$q = "delete from entry";
mysqli_query($con,$q);
?>