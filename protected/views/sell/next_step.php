<?php /* @var $invoices Array */ ?>
<?php /* @var $invoice InvoicesOut */ ?>

<?php
$cs = Yii::app()->clientScript;
//$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/table.css');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/sales_next_step.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
<div class="row card-holder">

    <div class="col-sm-6 left-part">

        <div id="stock-selection" class="form-horizontal">
            <label>Select stock</label>
            <select class="form-control">
                <option>Vilnius</option>
                <option>Kaunas</option>
                <option>Klaipeda</option>
            </select>
        </div>
        <div class="filter-holder">
            <h4>Product filter</h4>
            <div class="filter-inputs-holder">
                <input type="text" placeholder="product name" />
                <input type="text" placeholder="product code" />
                <button>Search<span class="glyphicon glyphicon-search text-right"></span></button>
            </div>
            <div class="product-table-holder">
                <table width="100%" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Product name</th>
                        <th>Product code</th>
                        <th>quant</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="3">No data</td>
                    </tr>
                    <tr>
                        <td>product 1</td>
                        <td>1223435353</td>
                        <td>3</td>
                        <td>
                            <a data-name="product" data-code="1234545" data-unit="vnt" data-id="1" class="btn btn-default btn-sm add-prod clearfix" href="#">
                                add to list&nbsp;<span class="glyphicon glyphicon-share"></span>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>product 1</td>
                        <td>1223435353</td>
                        <td>3</td>
                        <td>
                            <a data-name="product" data-code="1234545" data-unit="vnt" data-id="2" class="btn btn-default btn-sm add-prod" href="#">
                                add to list&nbsp;<span class="glyphicon glyphicon-share"></span>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>product 1</td>
                        <td>1223435353</td>
                        <td>3</td>
                        <td>
                            <a data-name="product" data-code="1234545" data-unit="vnt" data-id="3" class="btn btn-default btn-sm add-prod" href="#">
                                add to list&nbsp;<span class="glyphicon glyphicon-share"></span>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>product 1</td>
                        <td>1223435353</td>
                        <td>3</td>
                        <td>
                            <a data-name="product" data-code="1234545" data-unit="vnt" data-id="4" class="btn btn-default btn-sm add-prod" href="#">
                                add to list&nbsp;<span class="glyphicon glyphicon-share"></span>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>product 1</td>
                        <td>1223435353</td>
                        <td>3</td>
                        <td>
                            <a data-name="product" data-code="1234545" data-unit="vnt" data-id="5" class="btn btn-default btn-sm add-prod" href="#">
                                add to list&nbsp;<span class="glyphicon glyphicon-share"></span>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div><!--/product-table-holder -->
            <h4>Transport</h4>
            <div class="transport-option-holder">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Transport name</th>
                        <th>action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Option 1</td>
                        <td>
                            <a data-name="option1"  data-unit="vnt" data-id="1" class="btn btn-default btn-sm add-option" href="#">
                                add to list&nbsp;<span class="glyphicon glyphicon-share"></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Option 2</td>
                        <td>
                            <a data-name="option2"  data-unit="vnt" data-id="2" class="btn btn-default btn-sm add-option" href="#">
                                add to list&nbsp;<span class="glyphicon glyphicon-share"></span>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div><!--/tranport-table0holder-->

        </div><!--/filter-holder -->
    </div><!--/left-part -->

    <div class="col-lg-6 col-md-6 col-sm-6 pull-right">
        <div class="table-holder">
            <h4>Client info</h4>
            <table  class="table table-bordered">
                <tbody>
                <tr>
                    <td>Comapny name</td>
                    <td>Inliusion</td>
                    <td>tel</td>
                    <td>+343254324</td>
                </tr>
                <tr>
                    <td>Company code</td>
                    <td>34325432432</td>
                    <td>Vat code</td>
                    <td>LT_3432434</td>
                </tr>
                <tr>
                    <td>Adress</td>
                    <td colspan="3">Perkunkemio g 7, Vilnius, LT-012345</td>
                </tr>
                </tbody>
            </table>
        </div><!--/table-holder -->



        <div id="product-section">
            <h4>Product list</h4>
            <div class="product-holder-area">
                <table id="prod-list" class="table table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th>product name</th>
                        <th>prod code</th>
                        <th>units</th>
                        <th>quant</th>
                        <th>price (EUR)</th>
                        <th>action</th>
                    </tr>
                    </thead>
                    <tbody id="product-list-holder">
                    <tr id="empty-list">
                        <td colspan="6">No data</td>
                    </tr>
                    <tr class="summ">
                        <td colspan="3"></td>
                        <td>Summ:</td>
                        <td colspan="2"><span id="total">0</span> EUR</td>
                    </tr>
                    </tbody>
                </table>
            </div><!--/product-holder-area -->
        </div><!--/product-section -->

    </div><!--/left -->
    <div class="btn-holder col-sm-12 clearfix text-right">
        <button class="btn-submit"   data-toggle="modal" data-target="#invoiceReady"><span>Creat invoice</span><span class="glyphicon glyphicon-chevron-right"></span></button>
    </div><!--/btn-holder -->
</div><!--row -->
<div class="modals-holder">
    <div class="invoice-ready">

        <div class="modal fade" id="invoiceReady" tabindex="-1" role="dialog">
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
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Product 1</td>
                                    <td>prd 12345677</td>
                                    <td>litr</td>
                                    <td>123</td>
                                    <td>213321</td>
                                </tr>

                                <tr>
                                    <td>Product 1</td>
                                    <td>prd 12345677</td>
                                    <td>litr</td>
                                    <td>123</td>
                                    <td>213321</td>
                                </tr>
                                <tr class="total">
                                    <td colspan="3"></td>
                                    <td>Total :</td>
                                    <td>700 EUR</td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!--/modal-prod-list-holder -->
                    </div><!--/modal-body -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close<span class="glyphicon glyphicon-thumbs-down"></span></button>
                        <button type="button" class="btn btn-primary">Continue<span class="glyphicon glyphicon-share-alt"></span></button>
                    </div><!--/modal-footer -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div><!--/invoice-ready -->

    <div class="new-product">


    </div><!--/modals-holder -->
</div><!--/container -->
</div><!--/ main-container -->