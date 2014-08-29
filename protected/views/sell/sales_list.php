<?php /* @var $invoices Array */ ?>
<?php /* @var $invoice OperationsOut */ ?>
<?php /* @var $this SellController */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/invoice_list.css');
//$cs->registerScriptFile(Yii::app()->baseUrl.'/js/buy-ops.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row filter-holder">
        <form>
            <input type="text" placeholder="<?php echo $this->labels['invoice code']; ?>">
            <input type="text" placeholder="<?php echo $this->labels['client name']; ?>">
            <select>
                <option selected><?php echo $this->labels['client type']; ?></option>
                <option>All</option>
                <option>Fisical</option>
                <option>Juridical</option>
            </select>
            <select>
                <option disabled selected value=""><?php echo $this->labels['city']; ?></option>
                <option value=""><?php echo $this->labels['all']; ?></option>
                <option>Vilnius</option>
                <option>Kaunas</option>
                <option>Klaipeda</option>
            </select>
            <input type="text" placeholder="date from">
            <input type="text" placeholder="date to">
            <select>
                <option>Delivery status</option>
                <option>Delivered</option>
                <option>On the way</option>
            </select>
            <button>Search<span class="glyphicon glyphicon-search"></span></button>
        </form>
    </div><!--/filter-holder -->
    <div class="row table-holder">
        <table class="table table-bordered table-striped table-hover" >
            <thead>
            <tr>
                <th>#</th>
                <th>Operation  N</th>
                <th>customer</th>
                <th>Client type</th>
                <th>Miestas</th>
                <th>Created</th>
                <th>Invoice number</th>
                <th>PDF</th>
                <th>Delivery status</th>
                <th>actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td><a href="#" data-toggle="modal" data-target="#invoiceInfo"> 00234</a></td>
                <td><a href="#">Btoken Pipe</a></td>
                <td>Phisical</td>
                <td>vilnius</td>
                <td>01.07.2014 14:30</td>
                <td>VLN 0001</td>
                <td><a href="#">Generate pdf</a></td>
                <td>On the way</td>
                <td><a href="#">Send invoice</a></td>
            </tr>

            <tr>
                <td>2</td>
                <td><a href="#" data-toggle="modal" data-target="#invoiceInfo"> 00234</a></td>
                <td><a href="#">Btoken Pipe</a></td>
                <td>Juridical</td>
                <td>Kaunas</td>
                <td>01.07.2014 14:30</td>
                <td>KUN 0001</td>
                <td><a href="#">Generate pdf</a></td>
                <td>Delivered</td>
                <td><a href="#">Send invoice</a></td>
            </tr>

            <tr>
                <td>3</td>
                <td><a href="#" data-toggle="modal" data-target="#invoiceInfo"> 00234</a></td>
                <td><a href="#">Btoken Pipe</a></td>
                <td>Phisical</td>
                <td>Klaipeda</td>
                <td>01.07.2014 14:30</td>
                <td>KLP 0001</td>
                <td><a href="#">Generate pdf</a></td>
                <td>On the way</td>
                <td><a href="#">Send invoice</a></td>
            </tr>
            </tbody>
        </table>
    </div><!--/table-holder -->

    <div class="modals-holder">
        <div class="invoice-ready">

            <div class="modal fade" id="invoiceInfo" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Invoice : 213232323</h4>
                        </div><!--/.modal-heafer -->

                        <div class="modal-body">
                            <div class="supl-header">
                                <table class="table table-bordered" width="100%">
                                    <tr>
                                        <td>company</td>
                                        <td>inclusion</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>compaany code</td>
                                        <td>2324234</td>
                                        <td>Vat code </td>
                                        <td>fdghhfdhg</td>
                                    </tr>
                                    <tr>
                                        <td>Adress</td>
                                        <td colspan="3">Vilnius, kapsu g 8, LT-21345</td>
                                    </tr>
                                </table>
                            </div><!--/supl-header -->
                            <div class="modal-prod-list-holder">
                                <table class="table table-bordered" width="100%">
                                    <thead>
                                    <tr>
                                        <th>product name</th>
                                        <th>prod code</th>
                                        <th>units</th>
                                        <th>quant</th>
                                        <th>price (EUR)</th>
                                        <th>discount %</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Product 1</td>
                                        <td>prd 12345677</td>
                                        <td>litr</td>
                                        <td>123</td>
                                        <td>213321</td>
                                        <td>10</td>
                                    </tr>

                                    <tr>
                                        <td>Product 1</td>
                                        <td>prd 12345677</td>
                                        <td>litr</td>
                                        <td>123</td>
                                        <td>213321</td>
                                        <td>5</td>
                                    </tr>
                                    <tr class="total">
                                        <td colspan="3"></td>
                                        <td colspan="2">Total :</td>
                                        <td>700 EUR</td>
                                    </tr>
                                    <tr class="total-with-vat">
                                        <td colspan="3"></td>
                                        <td colspan="2">Total 21% VAT :</td>
                                        <td>700 EUR</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div><!--/modal-prod-list-holder -->
                        </div><!--/modal-body -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close<span class="glyphicon glyphicon-thumbs-down"></span></button>
                        </div><!--/modal-footer -->
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div><!--/invoice-ready -->

    </div><!--/modals-holder -->

</div><!--/container -->