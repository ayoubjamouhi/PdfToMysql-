


<div class="deux-tables">
    <div class=" table-responsive">
        <table class="table table-bordered" style="display:block;height:600px">
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
                        <td scope="row"><?=$ticket->document_number; ?></td>
                        <td><?php echo $ticket->gross_fare_cash; ?></td>
                        <td><?php echo $ticket->tax_cash; ?></td>
                        <td><?php echo $ticket->st_comm_amount; ?></td>
                        <td><?php echo $ticket->payable_balance; ?></td>
                        <td>vide</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class=" table-responsive">
        <table class="table table-bordered" style="display:block;height:600px">
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
                	
        
