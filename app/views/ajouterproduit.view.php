<?php require 'partials/head.php'; ?>

<!-- Start Main-->
<main>

	<div class="container">
	<div class="ajouter">
		<form enctype="multipart/form-data" method="POST" action="ajouterproduit">
			<div>
				<span>Le nom</span>
				<input type="text" name="nom" placeholder="enter un nom">
			</div>
			<div>
				<span>Image</span>
				<input type="file" name="fic" size=50/>
			</div>			
			<div>
				<span>Nombre</span>
				<input type="number" name="nombre" placeholder="entrer un nombre">
			</div><br>
			<div>
				<input type="submit" name="ajouter">
			</div>
		</form>
	</div>
	</div>

</main>
<!-- End Main-->

<?php require 'partials/footer.php'; ?>
