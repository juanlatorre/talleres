<?php
session_start();
ob_start();

include_once('sql/config.php');
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
	<?php
	if((isset($_COOKIE['usuario']) && $_COOKIE['usuario'] != '') || (isset($_SESSION['usuario']) && $_SESSION['usuario'] !='')) {
		include "dist/admin.php";
	} else {
		include "dist/login.php";
	
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
					$_SESSION['usuario'] = $id;
				}
				header("Refresh:0");
			} else {
				echo "<div class='notification is-danger'><button class='delete'></button>Usuario o Contraseña inválida, intente de nuevo.</div>";
			}
		}
	}

	$nombre = $fecha = $hora = $foto = $descripcion  = $capacidad = $precio = $crearTaller = "";
	$target_file = $target_dir . basename($_FILES["foto"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	if (isset($_POST['crearTaller'])) {
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
		
		$enlace = 'http://talleres.caboblanco.cl/taller/' . str_replace(' ', '-', strtolower($nombre) . '.php');
		
		$qqq = "INSERT INTO Taller (Nombre, Fecha, Hora, Descripcion, Foto, Disponibilidad, Capacidad, Precio, Enlace) VALUES ('$nombre', '$fecha', '$hora', '$descripcion', '$fotoContent', '1', '$capacidad', '$precio', '$enlace')";

		if (mysqli_query($db, $qqq)) {
			echo '<div class="notification is-primary"><button class="delete"></button>Tu taller fue creado correctamente, el link de inscripciones es: <a href="'.$enlace.'">'.$nombre.'</a></div>';
			$crearTaller = true;
			$tallerNuevo = fopen("taller/".str_replace(' ', '-', strtolower($nombre)).".php", "w") or die("No se puede crear el archivo!");
		} else {
			echo '<div class="notification is-danger"><button class="delete"></button>Error al crear el Taller.</a></div>';
			$crearTaller = false;
		}
	
		$contenidoGenerado = '<?php
	include_once("../sql/config.php");
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	require "../phpmailer/PHPMailer.php";
	require "../phpmailer/SMTP.php";
	require "../phpmailer/Exception.php";


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
				$sql3 = "INSERT INTO Taller_Inscrito (TallerID, Correo, FechaInscripcion, Pagado, Asistencia) VALUES (\'$TallerID\', \'$correo\', \'$Dia\', 0, 0)";
				if(mysqli_query($db, $sql3)) {
					$mail = new PHPMailer(true);
					try {
						//Server settings
						$mail->isSMTP();
						$mail->Host = "terralia.cl";
						$mail->SMTPAuth = true;
						$mail->Username = "caboblanco@terralia.cl";
						$mail->Password = "khl0695";
						$mail->SMTPSecure = "ssl";
						$mail->Port = 465;
					
						//Recipients
						$mail->setFrom("caboblanco@terralia.cl", "Karime Harcha");
						$mail->addAddress($correo, $nombre);
						
						//Content
						$mail->isHTML(true);
						$mail->Subject = "Información de Pago '.$nombre.'";
						$mail->Body    = "<p>Muchísimas gracias {{Nombre}}  ! Ya estas en nuestra lista !</p><p>Cualquier pregunta, puedes contestar a este mail. Es muy grato para nosotros recibir vuestro feedback!</p><p>Te invitamos a visitar nuestros futuros talleres en nuestra web <u>Talleres Cabo Blanco C&T</u></p><p>Para finalizar el proceso de inscripción debes realizar la transferencia por su valor a la cuenta señalada, enviándonos a este mail la confirmación de transferencia, <b>señalando claramente el taller que pagas.</b></p><p><b>Cuenta Corriente N° 740112597-8 </b></p> <p><b>Banco Santander</b></p> <p><b> a nombre de Karime Harcha L.</b></p> <p><b>RUT 8033963-1</b></p>";
						$mail->AltBody = "<p>Muchísimas gracias {{Nombre}}  ! Ya estas en nuestra lista !</p><p>Cualquier pregunta, puedes contestar a este mail. Es muy grato para nosotros recibir vuestro feedback!</p><p>Te invitamos a visitar nuestros futuros talleres en nuestra web <u>Talleres Cabo Blanco C&T</u></p><p>Para finalizar el proceso de inscripción debes realizar la transferencia por su valor a la cuenta señalada, enviándonos a este mail la confirmación de transferencia, <b>señalando claramente el taller que pagas.</b></p><p><b>Cuenta Corriente N° 740112597-8 </b></p> <p><b>Banco Santander</b></p> <p><b> a nombre de Karime Harcha L.</b></p> <p><b>RUT 8033963-1</b></p>";
					
						$mail->send();
					} catch (Exception $e) {}
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
		<title>Taller '.$nombre.'</title>
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
		$cuchi = '<script type="text/javascript">$("#mainSection").load("dist/crearTaller.php");</script>';
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	?>
</body>
</html>