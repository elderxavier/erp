<?php /* @var $items OperationsIn[] */ ?>
<?php /* @var $pager CPagerComponent*/ ?>

<table class="table table-bordered table-striped table-hover" >
    <thead>
    <tr>
        <th>#</th>
        <th><?php echo $this->labels['invoice code']; ?></th>
        <th><?php echo $this->labels['supplier']; ?></th>
        <th><?php echo $this->labels['date']; ?></th>
        <th><?php echo $this->labels['actions'] ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($items as $invoice): ?>
        <tr>
            <td><?php echo $invoice->id; ?></td>
            <td><a href="#" data-toggle="modal" data-target="#invoiceInfo"><?php echo $invoice->invoice_code; ?></a></td>
            <td><?php echo $invoice->supplier->company_name;?></td>
            <td><?php echo date('Y.m.d',$invoice->date_created); ?></td>
            <td><a href="#"><?php echo $this->labels['edit']; ?></a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php $pager->renderPages(); ?>