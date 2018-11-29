<?php
$dbhost="localhost";
$dbuser="root";
$dbpass="root";
$dbname="talleres";

$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ("Error conectando a la base de datos.");
mysqli_query($db, "SET NAMES 'utf8'");
mysqli_select_db($db, "talleres") or die (mysql_error());

$target_dir = "../dist/uploads/";
?>