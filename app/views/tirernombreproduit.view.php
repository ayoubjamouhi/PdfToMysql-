<?php require 'partials/head.php'; ?>

<!-- Start Main-->
<main>

	<div class="container">

		<div class="modification_produit">
			<h1><?=$produit->nom;?></h1>
			<img width="200px" height="200px" src="/public/imagesProduits/<?=$imageProduit->img_nom;?>">
			<h1>Nombre dans le stock</h1>
			<span><?=$produit->nombre_produit;?></span>
			<form enctype="multipart/form-data" method="POST" action="/tirernombreproduit/<?=$produit->id;?>">
				
				<div>
					<span>Nombre à tirez</span>
					<input type="number" name="nombre">
				</div>
				<input type="hidden" name="nombrestock" value="<?=$produit->nombre_produit;?>">
				<div>
					<input type="submit" value="Tirez" name="tirer" />
				</div>

			</form>
		</div>
	</div>

</main>
<!-- End Main-->

<?php require 'partials/footer.php'; ?>
