<?php
include_once('sql/config.php');
$query = mysqli_query($db, "SELECT * FROM Taller");

session_start();

if((isset($_COOKIE['usuario']) && $_COOKIE['usuario'] != '') || (isset($_SESSION['usuario']) && $_SESSION['usuario'] !='')) {
	include 'dist/admin.php';
} else {
	include 'dist/login.php';
	
	if (isset($_POST['login'])) {
		$usuario = $_POST['usuario'];
		$clave 	 = md5($_POST['clave']);

		$query = "SELECT * FROM administradores WHERE usuario='$usuario' and clave='$clave'";
		$result = mysqli_query($db, $query);
		$count = mysqli_num_rows($result);
		
		if ($count > 0) {
			$result = mysqli_fetch_assoc(mysqli_query($db, $query));
			$id = $result['AdministradorID'];
			$cookie_name = "usuario";
			$cookie_value = $id;
			// calculo de tiempo: 86400 = 1 día (86400*30 = 1 Mes)
			$expiry = time() + (86400 * 30);
			$recordar = $_POST['recordar'];
			if ($recordar == 'true') {
				setcookie($cookie_name, $cookie_value, $expiry);
			} else {
				session_start();
				$_SESSION['usuario'] = $id;
			}
			header("Refresh:0");
		} else {
			echo "<div class='notification is-danger'><button class='delete'></button>Usuario o Contraseña inválida, intente de nuevo.</div>";
		}
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
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>

</body>
</html>

<?php
$mysqli->close();
?>

