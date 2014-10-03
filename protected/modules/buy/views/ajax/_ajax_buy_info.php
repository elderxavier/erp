<?php /* @var $purchase OperationsIn */ ?>
<?php /* @var $this AjaxController */ ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $this->labels['close']; ?></span></button>
    <h4 class="modal-title"><?php echo $this->labels['invoice']; ?> : <?php echo $purchase->invoice_code; ?></h4>
</div><!--/.modal-heafer -->
<div class="modal-body">
    <div class="supl-header">
        <table class="table table-bordered" width="100%">
            <tr>
                <td><?php echo $this->labels['company name']; ?></td>
                <td><?php echo $purchase->supplier->company_name; ?></td>
                <td><?php echo $this->labels['phone']; ?></td>
                <td><?php echo $purchase->supplier->phone1; ?></td>
            </tr>
            <tr>
                <td><?php echo $this->labels['company code']; ?></td>
                <td><?php echo $purchase->supplier->company_code; ?></td>
                <td><?php echo $this->labels['vat code']; ?></td>
                <td><?php echo $purchase->supplier->vat_code; ?></td>
            </tr>
            <tr>
                <td><?php echo $this->labels['address']; ?></td>
                <td colspan="3"><?php echo $purchase->supplier->city; ?>, <?php echo $purchase->supplier->street; ?>, LT-21345</td>
            </tr>
        </table>
    </div><!--/supl-header -->
    <div class="modal-prod-list-holder">
        <table class="table table-bordered" width="100%">
            <thead>
            <tr>
                <th><?php echo $this->labels['product name']; ?></th>
                <th><?php echo $this->labels['product code']; ?></th>
                <th><?php echo $this->labels['units']; ?></th>
                <th><?php echo $this->labels['quantity']; ?></th>
                <th><?php echo $this->labels['price']; ?> (EUR)</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($purchase->operationsInItems as $item): ?>
                <tr>
                    <td><?php echo $item->productCard->product_name; ?></td>
                    <td><?php echo $item->productCard->product_code; ?></td>
                    <td><?php echo $item->productCard->measureUnits->name; ?></td>
                    <td><?php echo $item->qnt; ?></td>
                    <td><?php echo $this->centsToPriceStr($item->price); ?></td>
                </tr>
            <?php endforeach; ?>

            <tr class="total">
                <td colspan="3"></td>
                <td><?php echo $this->labels['total']; ?> :</td>
                <td><?php echo $this->centsToPriceStr($purchase->calculateTotalPrice(),'',' EUR'); ?></td>
            </tr>
            </tbody>
        </table>
    </div><!--/modal-prod-list-holder -->
</div><!--/modal-body -->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->labels['close']; ?><span class="glyphicon glyphicon-thumbs-down"></span></button>
</div><!--/modal-footer -->