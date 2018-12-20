<script>
	function listaTaller() {
		$('#mainSection').load('dist/talleres.php');
	}
	
	function listaParticipante() {
		$('#mainSection').load('dist/participantes.html');
	}
	
	function crearTalleres() {
		$('#mainSection').load('dist/crearTaller.php');
	}
</script>

<section class="section">
	<div class="container">
		<h1 class="title"></i>
			Administración Talleres Cabo Blanco | Cocina & Taller
		</h1>
	</div>
</section>
<section class="section" id="mainSection">
	<div class="container">
		<div class="tile is-ancestor">
			<div class="tile is-vertical is-8">
				<div class="tile">
					<div class="tile is-parent is-vertical">
						<article onclick="listaTaller()" style="cursor:pointer;" class="tile is-child notification is-primary">
							<p class="title">Talleres</p>
							<p class="subtitle">Ver listado de talleres</p>
						</article>
					</div>
				</div>
				<div class="tile is-parent">
					<article onclick="listaParticipante()" style="cursor:pointer;" class="tile is-child notification is-danger">
						<p class="title">Participantes</p>
						<p class="subtitle">Ver listado de participantes</p>
					</article>
				</div>
			</div>
			<div class="tile is-parent">
				<article onclick="crearTalleres()" style="cursor:pointer;" class="tile is-child notification is-success">
					<div class="content">
						<p class="title">Crear taller</p>
						<p class="subtitle">Creación de un nuevo taller</p>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>