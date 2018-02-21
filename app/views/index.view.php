<?php require 'partials/head.php'; ?>

<!-- Start Main-->

<main>

	<div class="container-fluid">
		<input id="tab1" type="radio" name="tabs" checked>
		<label class="label" for="tab1">Pointage Vente</label>

		<input id="tab2" type="radio" name="tabs">
		<label class="label" for="tab2">Pointage Remp</label>

		<div class="tables" id="content1">

			<form class="formindex" id="formpointagevente" action="pointage-bsp" method="post" enctype="multipart/form-data">
				
				<div class="left-form">

					<h6>Chemin Fichier BSP</h6>
						<input type="text"  id="inputtextpointage" placeholder="C:\Users\User\Desktop\bsp-01-2018.pdf" value="<?php  if(!empty($_POST['filepdf'])) echo $_POST['filepdf'];?>">
						<input type="file" name="filepdf" id="file-input-pointage" required="required" style="display:none">
						<label for="file-input-pointage" class="label-file">.....</label>
						<input type="submit" id="pointage-bsp" value="Pointage BSP">
						
				</div>

				<div class="right-form">
					<h6>Période</h6>
					<label for="">Du</label>
					<input type="date" name="dateinit"  required="required">
					<label for="">Au</label>
					<input type="date" name="datefinal"  required="required">
					<input type="submit" id="pointeur-vente" value="Pointeur Vente">
					<input type="submit" style="display:none" id="regenerer-vente" value="Regénérer Vente">
					<input type="submit"  id="regenerer-vente" value="Close">
				</div>

            </form>	
			<img src="public/svg/Spinner-1s-51px.svg" alt="" class="spinner" style="margin: auto;display: block;display:none">
			
			<div id="result"></div>
		</div>

		<div class="tables" id="content2">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col">Ticket</th>
						<th scope="col">MtHT</th>
						<th scope="col">MtTaxes</th>
						<th scope="col">MtComm</th>
						<th scope="col">NetBSP</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($tickets as $ticket): ?>
						<tr>
							<td scope="row"><?php echo $ticket->document_number; ?></td>
							<td><?php echo $ticket->gross_fare_cash; ?></td>
							<td><?php echo $ticket->tax_cash; ?></td>
							<td><?php echo $ticket->st_comm_amount; ?></td>
							<td><?php echo $ticket->payable_balance; ?></td>
							<td>vide</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col">Ticket</th>
						<th scope="col">MtHT</th>
						<th scope="col">MtTaxes</th>
						<th scope="col">MtComm</th>
						<th scope="col">NetBSP</th>
						<th scope="col">Status</th>
						<th scope="col">Facture</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($tickets as $ticket): ?>
						<tr>
							<td scope="row"><?php echo $ticket->document_number; ?></td>
							<td><?php echo $ticket->gross_fare_cash; ?></td>
							<td><?php echo $ticket->tax_cash; ?></td>
							<td><?php echo $ticket->st_comm_amount; ?></td>
							<td><?php echo $ticket->payable_balance; ?></td>
							<td>vide</td>
							<td>FB201703679</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>		
		</div>
	</div>

</main>
<!-- End Main-->

<?php require 'partials/footer.php'; ?>
