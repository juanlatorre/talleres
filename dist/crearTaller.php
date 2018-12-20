<section class="section">
	<div class="container">
		<form method="post" enctype="multipart/form-data">
			<div class="columns">
				<div class="column is-half">
					<div class="field">
						<label class="label">Nombre</label>
						<div class="control">
							<input class="input" name="nombre" type="text" placeholder="Nombre del Taller">
						</div>
					</div>				
				</div>
			
				<div class="column is-half">
					<div class="field">
						<label class="label">Fecha</label>
						<div class="control">
							<input class="input" name="fecha" type="date" placeholder="Fecha del Taller">
						</div>
					</div>
				</div>
			</div>
		
			<div class="columns">
				<div class="column is-half">
					<div class="field">
						<label class="label">Hora</label>
						<div class="control">
							<input class="input" name="hora" type="time" placeholder="Hora del Taller">
						</div>
					</div>
				</div>
			
				<div class="column is-half">
					<div class="field">
						<label class="label">Foto</label>
						<div class="control">
							<input class="input" name="foto" type="file" placeholder="Foto del Taller">
						</div>
					</div>
				</div>		
			</div>
		
			<div class="columns">
				<div class="column">
					<div class="field">
						<label class="label">Descripción</label>
						<div class="control">
							<textarea class="textarea" name="descripcion" placeholder="Descripción del Taller"></textarea>
						</div>
					</div>
				</div>
			</div>
		
			<div class="columns">
				<div class="column is-half">
					<div class="field">
						<label class="label">Capacidad (Personas)</label>
						<div class="control">
							<input class="input" name="capacidad" type="number" min="1" max="12" step="1" value="1">
						</div>
					</div>
				</div>
			
				<div class="column is-half">
					<div class="field">
						<label class="label">Precio por Persona</label>
						<div class="control">
							<input class="input" name="precio" type="number" min="0" max="200000" step="1" value="25000">
						</div>
					</div>
				</div>
			</div>
		
			<div class="field is-grouped">
				<div class="control">
					<button type="submit" name="crearTaller" class="button is-link">Agregar</button>
				</div>
			</div>
		</form>
	</div>
</section> 