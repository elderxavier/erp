<?php /* @var $invoices Array */ ?>
<?php /* @var $invoice InvoicesOut */ ?>
<?php /* @var $this SellController */ ?>
<?php /* @var $client Clients */ ?>
<?php /* @var $options OptionCards[] */ ?>
<?php /* @var $available_stocks_id array */ ?>
<?php /* @var $stocks Stocks[]*/ ?>
<?php /* @var $vats Vat[] */ ?>
<?php /* @var $count int */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/invoice_out.css');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/sales_next_step.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
<div class="row card-holder">

    <div class="col-sm-6 left-part">

        <div id="stock-selection" class="form-horizontal">

            <label><?php echo $this->labels['select stock']; ?></label>
            <select id="stock-selector" class="form-control">
                <?php foreach($stocks as $index => $stock): ?>
                    <option value="<?php echo $stock->id; ?>"><?php echo $stock->name.' ['.$stock->location->city_name.']'; ?></option>
                <?php endforeach; ?>
            </select>

        </div>
        <div class="filter-holder">
            <h4><?php echo $this->labels['filter']; ?></h4>
            <div class="filter-inputs-holder">
                <input id="prod-name" type="text" placeholder="<?php echo $this->labels['product name']; ?>" />
                <input id="prod-code" type="text" placeholder="<?php echo $this->labels['product code']; ?>" />
                <button id="filter-button"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search text-right"></span></button>
            </div>
            <div class="product-table-holder">
                <table width="100%" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><?php echo $this->labels['product name']; ?></th>
                        <th><?php echo $this->labels['product code']; ?></th>
                        <th><?php echo $this->labels['quantity']; ?></th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                    </thead>
                    <tbody id="filtered-body">
                    <tr>
                        <td colspan="3"><?php echo $this->labels['no data']; ?></td>
                    </tr>
                    </tbody>
                </table>
            </div><!--/product-table-holder -->

            <h4><?php echo $this->labels['options']; ?></h4>
            <div class="transport-option-holder">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><?php echo $this->labels['name']; ?></th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($options as $option): ?>
                        <tr>
                            <td><?php echo $option->name; ?></td>
                            <td>
                                <a data-name="<?php echo $option->name; ?>"  data-unit="vnt" data-id="<?php echo $option->id; ?>" class="btn btn-default btn-sm add-option" href="#">
                                    <?php echo $this->labels['add to list']; ?>&nbsp;<span class="glyphicon glyphicon-share"></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!--/tranport-table0holder-->

        </div><!--/filter-holder -->
    </div><!--/left-part -->

    <div class="col-lg-6 col-md-6 col-sm-6 pull-right">
        <div class="table-holder">
            <h4><?php echo $this->labels['client info']; ?></h4>
            <table  class="table table-bordered">
                <tbody>
                <tr>
                    <td><?php echo $client->type == 1 ? $this->labels['company name'] : $this->labels['name']; ?></td>
                    <td><?php echo $client->type == 1 ? $client->company_name : $client->name.' '.$client->surname; ?></td>
                    <td><?php echo $this->labels['phone']; ?></td>
                    <td><?php echo $client->phone1; ?></td>
                </tr>
                <tr>
                    <td><?php echo $client->type == 1 ? $this->labels['company code'] : $this->labels['personal code']; ?></td>
                    <td><?php echo $client->type == 1 ? $client->company_code : $client->personal_code; ?></td>
                    <td><?php echo $this->labels['vat code']; ?></td>
                    <td><?php echo $client->vat_code; ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->labels['address']; ?></td>
                    <td colspan="3"><?php echo $client->getAddressFormatted(', '); ?></td>
                </tr>
                </tbody>
            </table>
        </div><!--/table-holder -->


        <div id="vat-section">
            <label><?php echo $this->labels['select VAT']; ?> %</label>
            <select id="vat">
                <?php foreach($vats as $vat): ?>
                    <option value="<?php echo $vat->id; ?>"><?php echo $vat->percent; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="product-section">
            <h4><?php echo $this->labels['product list']; ?></h4>
            <div class="product-holder-area">
                <table id="prod-list" class="table table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th><?php echo $this->labels['product name']; ?></th>
                        <th><?php echo $this->labels['product code']; ?></th>
                        <th><?php echo $this->labels['units']; ?></th>
                        <th><?php echo $this->labels['quantity']; ?></th>
                        <th><?php echo $this->labels['price']; ?> (EUR)</th>
                        <th><?php echo $this->labels['discount']; ?> %</th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                    </thead>
                    <tbody id="product-list-holder">
                    <tr id="empty-list">
                        <td colspan="7"><?php echo $this->labels['no data']; ?></td>
                    </tr>
                    <tr class="summ">
                        <td colspan="3"></td>
                        <td colspan="2"><?php echo $this->labels['total']; ?>:</td>
                        <td colspan="2"><span id="total">0.00</span> EUR</td>
                    </tr>
                    <tr class="summ-plus-vat">
                        <td colspan="3"></td>
                        <td colspan="2" class="name"><?php echo $this->labels['total']; ?> <span><?php if(isset($vats[0])){ echo $vats[0]->percent;} ?></span>% <?php echo $this->labels['VAT']; ?>:</td>
                        <td colspan="2"><span id="total-plus-vat">0.00</span> EUR</td>
                    </tr>
                    </tbody>
                </table>
            </div><!--/product-holder-area -->
        </div><!--/product-section -->

    </div><!--/left -->
    <div class="btn-holder col-sm-12 clearfix text-right">
        <button class="btn-submit" data-toggle="modal" data-target="#invoiceReady"><span><?php echo $this->labels['create invoice']; ?></span><span class="glyphicon glyphicon-chevron-right"></span></button>
    </div><!--/btn-holder -->
</div><!--row -->
<div class="modals-holder">
    <div class="invoice-ready">

        <div class="modal fade" id="invoiceReady" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $this->labels['close']; ?></span></button>
                        <h4 class="modal-title"><?php echo $this->labels['invoice']; ?> : <?php echo $count + 1; ?></h4>
                    </div><!--/.modal-heafer -->
                    <form method="post" action="<?php echo Yii::app()->createUrl('/sell/finalstep'); ?>">
                    <div class="modal-body">
                        <div class="supl-header">
                            <table class="table table-bordered" width="100%">
                                <tr>
                                    <td><?php echo $client->type == 1 ? $this->labels['company name'] : $this->labels['name']; ?></td>
                                    <td><?php echo $client->type == 1 ? $client->company_name : $client->name.' '.$client->surname; ?></td>
                                    <td><?php echo $this->labels['phone']; ?></td>
                                    <td><?php echo $client->phone1; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $client->type == 1 ? $this->labels['company code'] : $this->labels['personal code']; ?></td>
                                    <td><?php echo $client->type == 1 ? $client->company_code : $client->personal_code; ?></td>
                                    <td><?php echo $this->labels['vat code']; ?></td>
                                    <td><?php echo $client->vat_code; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->labels['address']; ?></td>
                                    <td colspan="3"><?php echo $client->getAddressFormatted(', '); ?></td>
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
                                    <th><?php echo $this->labels['discount']; ?> %</th>
                                </tr>
                                </thead>

                                <tbody class="modal-tbl-body">
                                </tbody>

                                <tfoot>
                                <tr class="total">
                                    <td colspan="3"></td>
                                    <td colspan="2"><?php echo $this->labels['total']; ?> :</td>
                                    <td><span id="total-modal">0.00</span> EUR</td>
                                </tr>
                                <tr class="total-with-vat">
                                    <td colspan="3"></td>
                                    <td colspan="2"><?php echo $this->labels['total']; ?> <span class="vat-percent"></span>% <?php echo $this->labels['VAT']; ?> :</td>
                                    <td><span id="total-plus-vat-modal">0.00</span> EUR</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div><!--/modal-prod-list-holder -->
                    </div><!--/modal-body -->

                    <div class="hidden-fields-modal"></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->labels['close']; ?><span class="glyphicon glyphicon-thumbs-down"></span></button>
                        <button type="button" class="btn btn-primary"><?php echo $this->labels['continue']; ?><span class="glyphicon glyphicon-print"></span></button>
                        <button type="submit" class="btn btn-primary"><?php echo $this->labels['continue']; ?><span class="glyphicon glyphicon-share-alt"></span></button>
                    </div><!--/modal-footer -->
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div><!--/invoice-ready -->



</div><!--/modals-holder -->
</div><!--/container -->