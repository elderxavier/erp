<?php
/* @var $this BuyController */
/* @var $cs CClientScript */
/* @var $supplier Suppliers */

$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/invoice_in.css');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/purchase.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row card-holder">

        <div class="col-sm-6 left-part">
            <div class="filter-holder">
                <h4><?php echo $this->labels['product filter']; ?></h4>
                <div class="filter-inputs-holder">
                    <input id="prod-name-input" type="text" placeholder="<?php echo $this->labels['product name']; ?>" />
                    <input id="prod-code-input" type="text" placeholder="<?php echo $this->labels['product code']; ?>" />
                    <button class="filter-btn-do"><?php echo $this->labels['search']; ?></button>
                </div>
                <div class="product-table-holder">
                    <table width="100%" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th><?php echo $this->labels['product name']; ?></th>
                            <th><?php echo $this->labels['product code']; ?></th>
                            <th><?php echo $this->labels['actions']; ?></th>
                        </tr>
                        </thead>
                        <tbody id="filtered-tbl-body">
                        <tr>
                            <td align="center" colspan="3"><?php echo $this->labels['no data found']; ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="btn-holder">
                        <button data-toggle="modal" data-target="#invoiceReady"><?php echo $this->labels['new products']; ?>&nbsp;<span class="glyphicon glyphicon-plus-sign"></span></button>
                    </div>
                </div><!--/product-table-holder -->
            </div><!--/filter-holder -->
        </div><!--/left-part -->

        <div class="col-lg-6 col-md-6 col-sm-6 pull-right">
            <div class="table-holder">
                <h4><?php echo $this->labels['supplier info']; ?></h4>
                <table  class="table table-bordered">
                    <tbody>
                    <tr>
                        <td><?php echo $this->labels['company name']; ?></td>
                        <td><?php echo $supplier->company_name; ?></td>
                        <td><?php echo $this->labels['phone'];?></td>
                        <td><?php echo $supplier->phone1; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $this->labels['company code']; ?></td>
                        <td><?php echo $supplier->company_code; ?></td>
                        <td><?php echo $this->labels['vat code']; ?></td>
                        <td><?php echo $supplier->vat_code; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $this->labels['address']; ?></td>
                        <td colspan="3"><?php echo $supplier->country.', '.$supplier->city.', '.$supplier->street.', '.$supplier->building_nr; ?></td>
                    </tr>
                    </tbody>
                </table>
            </div><!--/table-holder -->
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
                            <th><?php echo $this->labels['actions']; ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="summ">
                            <td colspan="3"></td>
                            <td>Summ:</td>
                            <td colspan="2">3456 EUR</td>
                        </tr>
                        </tbody>
                    </table>
                </div><!--/product-holder-area -->
            </div><!--/product-section -->

        </div><!--/left -->
        <div class="btn-holder col-sm-12 clearfix text-right">
            <button class="btn-reset" type="reset"><span><?php echo $this->labels['reset fields']; ?></span> <span class="glyphicon glyphicon-remove"></span></button>
            <button class="btn-submit create-invoice" data-toggle="modal" data-target="#invoiceReady"><span><?php echo $this->labels['create ticket']; ?></span><span class="glyphicon glyphicon-chevron-right"></span></button>
        </div><!--/btn-holder -->
    </div><!--row -->
    <div class="modals-holder">
        <div class="invoice-ready">

            <div class="modal fade" id="invoiceReady" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title"><?php echo $this->labels['invoice info']; ?></h4>
                        </div><!--/.modal-heafer -->

                        <div class="modal-body">
                            <p>One fine body&hellip;</p>
                        </div><!--/modal-body -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div><!--/modal-footer -->
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div><!--/invoice-ready -->

        <div class="new-product">

            <div class="modal fade" id="newProduct" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Modal title</h4>
                        </div><!--/.modal-heafer -->

                        <div class="modal-body">
                            <p>One fine body&hellip;</p>
                        </div><!--/modal-body -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div><!--/modal-footer -->
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div><!--/new-product -->

    </div><!--/modals-holder -->
</div><!--/container -->