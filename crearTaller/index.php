<?php
include_once('../sql/config.php');

$nombreErr = $fechaErr = $horaErr = $fotoErr = $descripcionErr  = $capacidadErr = $precioErr = "";
$nombre = $fecha = $hora = $foto = $descripcion  = $capacidad = $precio = "";
$target_file = $target_dir . basename($_FILES["foto"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["nombre"])) {
		$nombreErr = "El nombre es obligatorio";
	} else {
		$nombre = test_input($_POST["nombre"]);
	}
	
	if (empty($_POST["fecha"])) {
		$fechaErr = "La fecha es obligatoria";
	} else {
		$fecha = test_input($_POST["fecha"]);
	}
	
	if (empty($_POST["hora"])) {
		$horaErr = "La hora es obligatoria";
	} else {
		$hora = test_input($_POST["hora"]);
	}
	
	if (empty($_POST["foto"])) {
		$fotoErr = "La foto es obligatoria";
	} else {
		$foto = test_input($_POST['foto']);
	}
	
	if (empty($_POST["descripcion"])) {
		$descripcionErr = "La descripción es obligatoria";
	} else {
		$descripcion = test_input($_POST["descripcion"]);
	}
	
	if (empty($_POST["capacidad"])) {
		$capacidadErr = "La capacidad es obligatoria";
	} else {
		$capacidad = test_input($_POST["capacidad"]);
	}
	
	if (empty($_POST["precio"])) {
		$precioErr = "El precio es obligatorio";
	} else {
		$precio = test_input($_POST["precio"]);
	}
	
	// vemos si el archivo es una imagen o no xd
	$check = getimagesize($_FILES["foto"]["tmp_name"]);
	if ($check !== false) {
		$uploadOk = 1;
	} else {
		$uploadOk = 0;
	}	
	
	$foto = $_FILES['foto']['tmp_name'];
	$fotoContent = addslashes(file_get_contents($foto));
		
	$qqq = "INSERT INTO Taller (Nombre, Fecha, Hora, Descripcion, Foto, Disponibilidad, Capacidad, Precio) VALUES ('$nombre', '$fecha', '$hora', '$descripcion', '$fotoContent', '1', '$capacidad', '$precio')";

	if (mysqli_query($db, $qqq)) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $qqq . "<br>" . mysqli_error($db);
	}

	mysqli_close($db);
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Crear Talleres Cabo Blanco</title>
	<link rel="stylesheet" href="../dist/css/styles.css">
</head>
<body>
	
<?php include '../dist/crearTaller.html'; ?>

</body>
</html>

<?php
//$mysqli->close();
?>

