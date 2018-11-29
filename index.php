<?php
include_once('sql/config.php');
$query = mysqli_query($db, "SELECT * FROM Taller");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Talleres Cabo Blanco</title>
	<link rel="stylesheet" href="dist/css/styles.css">
</head>
<body>

<?php include 'dist/index.html'; ?>

</body>
</html>

<?php
$mysqli->close();
?>

