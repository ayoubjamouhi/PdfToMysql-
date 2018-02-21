<?php require 'partials/head.php'; ?>

<!-- Start Main-->
<main>

	<div class="container">

		<div class="modification_produit">
			<h1><?=$produit->nom;?></h1>
			<img width="200px" height="200px" src="/public/imagesProduits/<?=$imageProduit->img_nom;?>">
			<form enctype="multipart/form-data" method="POST" action="/modifierproduit/<?=$produit->id;?>">
				
				<div>
					<span>Modifier le nom</span>
					<input type="text" name="nom" value="<?=$produit->nom;?>">
				</div>

				<div>
					<span>Le nombre de produit dans le stock</span>
					<input type="number" name="nombre" value="<?=$produit->nombre_produit;?>">
				</div>

				<div>
					<span>Modifier l'image</span>
					<input type="file" name="fic" size=50/>
				</div>

				<div>
					<input type="submit" value="Modifié" name="modifier" />
				</div>

			</form>
		</div>
	</div>

</main>
<!-- End Main-->

<?php require 'partials/footer.php'; ?>
