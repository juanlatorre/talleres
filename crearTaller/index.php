<?php
include_once('../sql/config.php');

$nombreErr = $fechaErr = $horaErr = $fotoErr = $descripcionErr  = $capacidadErr = $precioErr = "";
$nombre = $fecha = $hora = $foto = $descripcion  = $capacidad = $precio = $crearTaller = "";
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
		echo '<div class="notification is-primary"><button class="delete"></button>Tu taller fue creado correctamente, el link de inscripciones es: <a href="#">'.$nombre.'</a></div>';
		$crearTaller = true;
		$tallerNuevo = fopen("../t/".str_replace(' ', '-', strtolower($nombre)).".php", "w") or die("No se puede crear el archivo!");
	} else {
		echo '<div class="notification is-danger"><button class="delete"></button>Error al crear el Taller.</a></div>';
		$crearTaller = false;
	}
	
	$contenidoGenerado = '<?php
include_once("../sql/config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$nombre = htmlspecialchars(stripslashes(trim($_POST["nombre"])));
	$correo = htmlspecialchars(stripslashes(trim($_POST["correo"])));
	$telefono = htmlspecialchars(stripslashes(trim($_POST["telefono"])));

	$sql = "INSERT INTO Inscrito (Nombre, Correo, Telefono) VALUES (\'$nombre\', \'$correo\', \'$telefono\')";
	$sql2 = "SELECT TallerID FROM Taller WHERE Nombre = \''.$nombre.'\'";

	if (mysqli_query($db, $sql)) {
		echo \'<div class="notification is-primary"><button class="delete"></button>Te has registrado correctamente en el taller '.$nombre.', pronto recibirás un correo con la información de pago.</div>\';
	} else {
		echo \'<div class="notification is-danger"><button class="delete"></button>Tu inscripción al taller no se pudo realizar, intentalo nuevamente o contáctanos.</div>\';
	}

	if (mysqli_query($db, $sql2)) {
		$resultado = mysqli_query($db, $sql2);
		while($row = mysqli_fetch_array($resultado)) {
			$TallerID = $row[\'TallerID\'];
			$Dia = date(\'Y-m-d\');
			$sql3 = "INSERT INTO Taller_Inscrito (TallerID, Correo, FechaInscripcion) VALUES (\'$TallerID\', \'$correo\', \'$Dia\')";
			if(mysqli_query($db, $sql3)) {
				$asunto = \'Te inscribiste en bla bla bla\';
				$mensaje = \'Wena choro te inscribiste en bla bla bla\';
				
				mail($correo, $asunto, $mensaje);
			};
		}
	} else {
		echo "Error: " . $sql2 . "<br>" . mysqli_error($db);
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Taller X</title>
	<link rel="stylesheet" href="../dist/css/styles.css">
</head>
<body>
	<section class="section">
		<div class="container">
	      	<h1 class="title">
	        	'.$nombre.'
	      	  </h1>
		  	<p>'.$descripcion.'</p>
		  	<br>
  			<form action="<?php echo htmlspecialchars($_SERVER[\'PHP_SELF\']); ?>" method="post" enctype="multipart/form-data">
  				<div class="columns">
  					<div class="column">
  						<div class="field">
  							<label class="label">Nombre</label>
  							<div class="control">
  								<input class="input" name="nombre" type="text">
  							</div>
  						</div>				
  					</div>
  				</div>
		
  				<div class="columns">
  					<div class="column">
  						<div class="field">
  							<label class="label">Correo</label>
  							<div class="control">
  								<input class="input" name="correo" type="email">
  							</div>
  						</div>
  					</div>	
  				</div>
		
  				<div class="columns">
  					<div class="column">
  						<div class="field">
  							<label class="label">Teléfono</label>
  							<div class="control">
  								<input class="input" name="telefono" type="text">
 							</div>
  						</div>
  					</div>
  				</div>
		
  				<div class="field is-grouped">
  					<div class="control">
  						<button type="submit" class="button is-link">Enviar</button>
  					</div>
  				</div>
  			</form>
	    </div>
	</section>
</body>
</html>';
	fwrite($tallerNuevo, $contenidoGenerado);
	fclose($tallerNuevo);
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