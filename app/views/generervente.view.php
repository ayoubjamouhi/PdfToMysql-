<?php require 'partials/head.php'; ?>

<!-- Start Main-->
<main>

	<div class="container-fluid">
		<input id="tab1" type="radio" name="tabs" checked>
		<label class="label" for="tab1">Pointage Vente</label>

		<input id="tab2" type="radio" name="tabs">
		<label class="label" for="tab2">Pointage Remp</label>

		<div class="tables" id="content1">

            <div class="top-tables">
                <form class="formpointagevente" id="formpointagevente" action="pointage-vente" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text"  id="inputtextpointage" class="form-control" placeholder="Le nom de pdf">

                    </div>
                    <div class="form-group">
                        <input type="file" name="filepdf" id="file-input-pointage" style="display:none" >
                        <label for="file-input-pointage">Choisis un fichier pdf</label>
                    </div>
                    <input type="hidden" name="dateinit" value="<?php if(!empty($_POST['dateinit'])) echo $_POST['dateinit'];?>">
					<input type="hidden" name="datefinal" value="<?php if(!empty($_POST['datefinal'])) echo $_POST['datefinal'];?>">
					
                    <div class="form-group">
                        <input type="submit" value="Pointeur BSP" class="btn btn-success">
                    </div>
                </form>				
                <form class="form-regenerer-vente" action="regenerer-vente" method="post">
                    <h2>Période</h2>
                    <div class="form-group">
                        <span>Du</span>
                        <input type="date" name="dateinit" class="form-control" value="<?php if(!empty($_POST['dateinit'])) echo $_POST['dateinit'];?>">
                    </div>
                    <div class="form-group">
                        <span>Au</span>
                        <input type="date" name="datefinal" class="form-control" value="<?php if(!empty($_POST['datefinal'])) echo $_POST['datefinal'];?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Régénérer Vente</button>
                        <button class="btn btn-secondary">Vide</button>
                        <button class="btn btn-close">Fermé</button>
                    </div>
                </form>	
			</div>
            <?php if($date_correct && $ya_de_donnees): ?>
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
            
            <?php elseif(!$date_correct): ?>	
            <div class="alert alert-info text-center" role="alert">
            Date invalid
            </div>
            <?php elseif(!$ya_de_donnees): ?>	
            <div class="alert alert-info text-center" role="alert">
                Pas de données pour ce date
            </div>
            <?php endif; ?>	
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
