<?php require 'partials/head.php'; ?>

<!-- Start Main-->
<main>

	<div class="container">
	<div class="recherche">
		<h1>Recherche Produit</h1>
		<form action="/rechercheproduit" method="POST">
			<div>
				<input type="text" name="nom" placeholder="Entrer un nom">
			</div>
			<div>
				<input type="submit" name="recherche">
			</div>
		</form>
	</div>

	<h1>Les Produits</h1>

	<div class="produits">

		<table>
			<thead>
				<tr>
					<th>Image</th>
					<th>Nom</th>
					<th>nombre de produit dans le stock</th>					
					<th>Modifier le produit</th>					
					<th>Tirez</th>					
					<th>Historique de tirage</th>					
				</tr>
			</thead>

			<tbody>
				<?php $i=0; foreach($produits as $produit):?>

				<tr>
					<td><a href="/public/imagesProduits/<?=$imgid[$produit->img_id];?>"><img width="100px" height="100px" src="/public/imagesProduits/<?=$imgid[$produit->img_id];?>"></a></td>
					<td><?=$produit->nom; ?></td>
					<td><?=$produit->nombre_produit; ?></td>
					<td><a href="/modifierproduit/<?=$produit->id;?>">Modifié</a></td>
					<td><a href="/tirernombreproduit/<?=$produit->id;?>">Tiré</a></td>
					<td><a href="/historiquetirage/<?=$produit->id;?>">Historique</a></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

	</div>
	</div>

</main>
<!-- End Main-->

<?php require 'partials/footer.php'; ?>
