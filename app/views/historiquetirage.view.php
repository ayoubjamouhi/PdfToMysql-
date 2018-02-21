<?php require 'partials/head.php'; ?>

<!-- Start Main-->
<main>

	<div class="container">


	<h1>Historique de <span style="color: #000;display: block;"><?=$produit->nom;?></span></h1>

	<h1>Nombre de produit dans le stock <span style="color: #000;display: block;"><?=$produit->nombre_produit;?></span></h1>

	<div class="produits">

		<table>

			<thead>
				<tr>
					<th>Nombre de tirage</th>					
					<th>Date de tirage</th>					
					<th>Nombre de pièce dans le stock avant le tire</th>					
					<th>Nombre de pièce dans le stock aprés le tire</th>					
				</tr>
			</thead>

			<tbody>
				<?php if($tirages != NULL): ?>
				<?php foreach($tirages as $tirage):?>
					<tr>
						<td><?=$tirage->nombre_tirage; ?></td>
						<td style="color: #f2eaec"><?=$tirage->date_tirage; ?></td>
						<td><?=$tirage->nombre_produit_stock; ?></td>
						<td><?=$tirage->nombre_produit_stock_apres_tire; ?></td>
					</tr>
				<?php endforeach; ?>

				<?php else: ?>
					<tr>
						<td>Pas d'historique</td>
						<td>Pas d'historique</td>

					</tr>
				<?php endif; ?>
			</tbody>
		</table>

	</div>
	</div>

</main>
<!-- End Main-->

<?php require 'partials/footer.php'; ?>
