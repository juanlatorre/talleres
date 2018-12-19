<?php
include_once('sql/config.php');
$query = mysqli_query($db, "SELECT * FROM Taller");

session_start();
if (session_id() == '' || !isset($_SESSION['login'])) {
	 include 'dist/login.html';
} else { 
	echo 'Ya estás logeado.';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$usuario = mysqli_real_escape_string($db,$_POST['usuario']);
	$clave	 = mysqli_real_escape_string($db,$_POST['clave']);
	
	$sql = "SELECT AdministradorID FROM administradores WHERE usuario = '$usuario' and clave = '$clave'";
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	
	if($count == 1) {
		session_register($usuario);
		$_SESSION['login'] = $usuario;     
			include 'dist/index.html';
	      }else {
	         $error = "Your Login Name or Password is invalid";
		 }
} 

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Talleres Cabo Blanco</title>
	<link rel="stylesheet" href="dist/css/styles.css">
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>

</body>
</html>

<?php
$mysqli->close();
?>

