<section class="section">
	<div class="container">
		<div class="columns">
			<?php for($i = 1; $row = mysqli_fetch_array($query); $i++) { ?>
				<div class="column is-one-quarter">
					<a href="#">
						<div class="card">
							<div class="card-image">
								<figure class="image is-4by3">
									<?php echo '<img src="data:image/png;base64,'.base64_encode( $row['Foto'] ).'"/>'; ?>
								</figure>
							</div>
							<div class="card-content">
								<div class="media">
									<div class="media-left">
										<time><?php echo date('g:i A', strtotime($row['Hora']));?> - <?php echo date('d/m/Y', strtotime($row['Fecha']));?></time>
										<p class="title is-4"><?php echo substr($row["Nombre"], 0, 16) . "...";?></p>
									</div>
								</div>
								<div class="content">
									<?php echo substr($row["Descripcion"], 0, 100) . "...";?>
								</div>
							</div>
						</div>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
</section> 