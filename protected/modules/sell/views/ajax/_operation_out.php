<?php /* @var $this AjaxController */ ?>
<?php /* @var $operation OperationsOut */ ?>
<?php /* @var $item_pr OperationsOutItems */ ?>
<?php /* @var $item_ot OperationsOutOptItems */?>

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><?php echo $this->labels['operation'] ?> : <?php echo $operation->id; ?></h4>
    </div><!--/.modal-heafer -->
    <div class="modal-body">
        <div class="supl-header">
            <table class="table table-bordered" width="100%">
                <tr>
                    <td><?php echo $operation->client->type == 1 ? $this->labels['company name'] : $this->labels['name']; ?></td>
                    <td><?php echo $operation->client->type == 1 ? $operation->client->company_name : $operation->client->name.' '.$operation->client->company_name; ?></td>
                    <td><?php echo $this->labels['email']; ?></td>
                    <td><?php echo $operation->client->email1; ?></td>
                </tr>
                <tr>
                    <td><?php echo $operation->client->type == 1 ? $this->labels['company code'] : $this->labels['personal code']; ?></td>
                    <td><?php echo $operation->client->type == 1 ? $operation->client->company_code : $operation->client->personal_code; ?></td>
                    <td><?php echo $this->labels['vat code']; ?></td>
                    <td><?php echo $operation->client->vat_code; ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->labels['address']; ?></td>
                    <td colspan="3"><?php echo $operation->client->getAddressFormatted(', '); ?></td>
                </tr>
            </table>
        </div><!--/supl-header -->
        <div class="modal-prod-list-holder">
            <table class="table table-bordered" width="100%">
                <thead>
                <tr>
                    <th><?php echo $this->labels['name']; ?></th>
                    <th><?php echo $this->labels['code'];?></th>
                    <th><?php echo $this->labels['units']; ?></th>
                    <th><?php echo $this->labels['quantity'];?></th>
                    <th><?php echo $this->labels['price']; ?> (EUR)</th>
                    <th><?php echo $this->labels['discount']; ?> %</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($operation->operationsOutItems as $item_pr): ?>
                    <tr>
                        <td><?php echo $item_pr->productCard->product_name; ?></td>
                        <td><?php echo $item_pr->productCard->product_code; ?></td>
                        <td><?php echo $item_pr->productCard->measureUnits->name; ?></td>
                        <td><?php echo $item_pr->qnt; ?></td>
                        <td><?php echo $this->centsToPriceStr($item_pr->price); ?></td>
                        <td><?php echo $item_pr->discount_percent; ?></td>
                    </tr>
                <?php endforeach;?>

                <?php foreach($operation->operationsOutOptItems as $item_ot): ?>
                    <tr>
                        <td colspan="4"><?php echo $item_ot->optionCard->name ; ?></td>
                        <td><?php echo $this->centsToPriceStr($item_ot->price); ?></td>
                        <td></td>
                    </tr>
                <?php endforeach;?>

                <tr class="total">
                    <td colspan="3"></td>
                    <td colspan="2"><?php echo $this->labels['total']; ?>:</td>
                    <td><?php echo $this->centsToPriceStr($operation->calculateTotalPrice(false),'',' EUR'); ?></td>
                </tr>
                <tr class="total-with-vat">
                    <td colspan="3"></td>
                    <td colspan="2" class="name"><?php echo $this->labels['total']; ?> <span><?php echo $operation->vat->percent; ?></span>% <?php echo $this->labels['VAT']; ?>:</td>
                    <td colspan="2"><?php echo $this->centsToPriceStr($operation->calculateTotalPrice(true),'',' EUR'); ?></td>
                </tr>
                </tbody>
            </table>
        </div><!--/modal-prod-list-holder -->
    </div><!--/modal-body -->
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->labels['close']; ?><span class="glyphicon glyphicon-thumbs-down"></span></button>
    </div><!--/modal-footer -->
</div><!-- /.modal-content -->