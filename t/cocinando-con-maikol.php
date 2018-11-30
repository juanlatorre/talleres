<?php
include_once("../sql/config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$nombre = htmlspecialchars(stripslashes(trim($_POST["nombre"])));
	$correo = htmlspecialchars(stripslashes(trim($_POST["correo"])));
	$telefono = htmlspecialchars(stripslashes(trim($_POST["telefono"])));

	$sql = "INSERT INTO Inscrito (Nombre, Correo, Telefono) VALUES ('$nombre', '$correo', '$telefono')";
	$sql2 = "SELECT TallerID FROM Taller WHERE Nombre = 'Cocinando con Maikol'";

	if (mysqli_query($db, $sql)) {
		echo '<div class="notification is-primary"><button class="delete"></button>Te has registrado correctamente en el taller Cocinando con Maikol, pronto recibirás un correo con la información de pago.</div>';
	} else {
		echo '<div class="notification is-danger"><button class="delete"></button>Tu inscripción al taller no se pudo realizar, intentalo nuevamente o contáctanos.</div>';
	}

	if (mysqli_query($db, $sql2)) {
		$resultado = mysqli_query($db, $sql2);
		while($row = mysqli_fetch_array($resultado)) {
			$TallerID = $row['TallerID'];
			$Dia = date('Y-m-d');
			$sql3 = "INSERT INTO Taller_Inscrito (TallerID, Correo, FechaInscripcion) VALUES ('$TallerID', '$correo', '$Dia')";
			if(mysqli_query($db, $sql3)) {
				$asunto = 'Te inscribiste en bla bla bla';
				$mensaje = 'Wena choro te inscribiste en bla bla bla';
				
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
	        	Cocinando con Maikol
	      	  </h1>
		  	<p>aojisfoijdsgi</p>
		  	<br>
  			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
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
</html>