<?php
include_once('sql/config.php');
$query = mysqli_query($db, "SELECT * FROM Taller");
setlocale(LC_MONETARY, 'es_CL');

if (isset($_GET['editar_taller'])) {
	$editmode = true;
} else {
	$editmode = false;
}

if (isset($_GET['ver_participantes'])) {
	$participantesmode = true;
} else {
	$participantesmode = false;
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
	<style>
		th, td {
			text-align: center !important;
		}
	</style>
</head>
<body>
	<?php if ($participantesmode) {
		$P_ID = $_GET['ver_participantes'];
		$q_ins = mysqli_query($db, "SELECT * FROM Taller WHERE TallerID='$P_ID'");
		$resultado = mysqli_fetch_array($q_ins);
		$P_Nombre = $resultado['Nombre'];
		?>
		<div class="modal is-active" id="modal">
		  <div class="modal-background"></div>
		  <div class="modal-card">
		    <header class="modal-card-head">
		      <p class="modal-card-title">Lista de Participantes <?php echo $P_Nombre; ?></p>
		      <button onclick="closeModal()" class="delete" aria-label="close"></button>
		    </header>
		    <section class="modal-card-body">
	  			<table class="table is-fullwidth" id="lista-participantes">
	  			  <thead class="has-text-centered">
	  			    <tr>
	  			      <th>#</th>
	  			      <th>Nombre</th>
	  			      <th>Correo</th>
	  				  <th>Teléfono</th>
					  <th>¿Pagó?</th>
					  <th>¿Asistió?</th>
	  			    </tr>
	  			  </thead>
	  			  <tbody>
				      <?php
				      $query1 = mysqli_query($db, "SELECT * FROM Taller_Inscrito WHERE TallerID='$P_ID'");
					  for ($x = 1; $row = mysqli_fetch_array($query1); $x++) {
						  $correo = $row['Correo'];
						  $pagado = $row['Pagado'];
						  $asistencia = $row['Asistencia'];
						  $query2 = mysqli_query($db, "SELECT * FROM Inscrito WHERE Correo='$correo'");
						  for ($z = 1; $row = mysqli_fetch_array($query2); $z++) { ?>
							  <th> <?php echo $z; ?></th>
							  <td> <?php echo $row['Nombre']; ?></td>
							  <td> <?php echo $row['Correo']; ?></td>
							  <td> <?php echo $row['Telefono']; ?></td>
							  <td> <?php if($pagado) { ?> <input type="checkbox" value="0" checked disabled> <?php } else { ?> <input type="checkbox" disabled> <?php }; ?></td>
							  <td> <?php if($asistencia) { ?> <input type="checkbox" value="0" checked disabled> <?php } else { ?> <input type="checkbox" disabled> <?php }; ?></td>
						  <?php }
					  } ?>
	  			  </tbody>
	  			</table>
		    </section>
		    <footer class="modal-card-foot">
		      <button onclick="exportTableToExcel('lista-participantes')" class="button is-success">Descargar Planilla</button>
		      <button onclick="closeModal()" class="button">Cerrar</button>
		    </footer>
		  </div>
		</div>
	<?php } ?>
	
	<?php if ($editmode ) {
		$T_ID = $_GET['editar_taller'];
		$T_Nombre = $T_Fecha = $T_Hora = $T_Descripcion = $T_Foto = $T_Disponibilidad = $T_Capacidad = $T_Precio = $T_Enlace = "";
		
		$q_ins = mysqli_query($db, "SELECT * FROM Taller WHERE TallerID='$T_ID'");
		for($i = 1; $row = mysqli_fetch_array($q_ins); $i++) {
			$T_Nombre = $row['Nombre'];
			$T_Fecha = $row['Fecha'];
			$T_Hora = $row['Hora'];
			$T_Descripcion = $row['Descripcion'];
			$T_Foto = $row['Foto'];
			$T_Disponibilidad = $row['Disponibilidad'];
			$T_Capacidad = $row['Capacidad'];
			$T_Precio = $row['Precio'];
			$T_Enlace = $row['Enlace'];
		} ?>
		
		<div class="modal is-active" id="modal">
		  <div class="modal-background"></div>
		  <div class="modal-card">
		    <header class="modal-card-head">
		      <p class="modal-card-title">Editar <?php echo $T_Nombre; ?></p>
		      <button onclick="closeModal()" class="delete" aria-label="close"></button>
		    </header>
		    <section class="modal-card-body">
		      <!-- Content ... -->
		    </section>
		    <footer class="modal-card-foot">
		      <button class="button is-success">Save changes</button>
		      <button onclick="closeModal()" class="button">Cancel</button>
		    </footer>
		  </div>
		</div>
	<?php } ?>
	<section class="section">
		<div class="container">
			<h1 class="title"></i>
				Administración Talleres Cabo Blanco | Cocina & Taller | <button onclick="cerrarSesion()" class="button">Cerrar Sesión</button>
			</h1>
		</div>
	</section>
	
	<section class="section">
		<div class="container ">
			<table class="table is-fullwidth">
			  <thead class="has-text-centered">
			    <tr>
			      <th>#</th>
			      <th>Nombre</th>
			      <th>Fecha</th>
				  <th>Hora</th>
				  <th>Disponible</th>
				  <th>Inscritos</th>
				  <th>Precio</th>
				  <th>Participantes</th>
				  <th>Editar</th>
			    </tr>
			  </thead>
			  <tbody>
				  <?php for($i = 1; $row = mysqli_fetch_array($query); $i++) { ?>
				  <tr>
					  <th><?php echo $i ?></th>
			      	  <td><a href="<?php echo $row['Enlace']; ?>" title="<?php echo $row['Nombre']; ?>"><?php echo $row['Nombre']; ?></a></td>
			      	  <td><?php echo $row['Fecha']; ?></td>
			      	  <td><?php echo(date("h:i A", strtotime($row['Hora']))); ?></td>
			      	  <td>
			      	  <?php if($row['Disponibilidad'] == 0) { ?>
						  <i class="fas fa-times"></i>
					  <?php } else { ?>
						  <i class="fas fa-check"></i>
					  <?php }?>
			      	  </td>
					  <?php
					  $TallerID = $row['TallerID'];
					  $query_ins = mysqli_query($db, "SELECT * FROM Taller_Inscrito WHERE TallerID='$TallerID'");
					  $inscritos = mysqli_num_rows($query_ins);
					  ?>
			      	  <td><?php echo $inscritos."/".$row['Capacidad']; ?></td>
			      	  <td><?php echo (money_format('%.0n', $row['Precio'])); ?></td>
					  <td><a href="javascript:window.open('http://talleres.caboblanco.cl/lista.php?ver_participantes=<?php echo $row['TallerID']; ?>', '_self')"><i class="fas fa-users"></i></a></td>
			      	  <td><a href="javascript:window.open('http://talleres.caboblanco.cl/lista.php?editar_taller=<?php echo $row['TallerID']; ?>', '_self')"><i class="fas fa-pen-square"></i></a></td>
			      </tr>
				  <?php } ?>
			  </tbody>
			</table>
		</div>
	</section>
	
	<script>
		var modal = document.getElementById('modal');
		
		function openModal() {
			modal.classList.add("is-active");
		}
		
		function closeModal() {
			modal.classList.remove("is-active");	
		}
		
		function exportTableToExcel(tableID, filename = ''){
		    var downloadLink;
		    var dataType = 'application/vnd.ms-excel';
		    var tableSelect = document.getElementById(tableID);
		    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
		    // Specify file name
		    filename = filename?filename+'.xls':'excel_data.xls';
    
		    // Create download link element
		    downloadLink = document.createElement("a");
    
		    document.body.appendChild(downloadLink);
    
		    if(navigator.msSaveOrOpenBlob){
		        var blob = new Blob(['\ufeff', tableHTML], {
		            type: dataType
		        });
		        navigator.msSaveOrOpenBlob( blob, filename);
		    }else{
		        // Create a link to the file
		        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
		        // Setting the file name
		        downloadLink.download = filename;
        
		        //triggering the function
		        downloadLink.click();
		    }
		}
	</script>
</body>
</html>