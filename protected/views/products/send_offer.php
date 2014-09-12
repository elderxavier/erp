<?php /* @var $card ProductCards */ ?>
<?php /* @var $templates MailTemplates[] */ ?>
<?php /* @var $this ProductsController */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/prod_letter.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/prod-letter.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>


<div class="container-fluid  main-content-holder content-wrapper">
<div class="row card-holder">

    <div class="col-sm-6 left-part">

        <div class="filter-holder">
            <h4><?php echo $this->labels['search client']; ?></h4>
            <div class="filter-inputs-holder">
                <input id="cli-name" type="text" placeholder="<?php echo $this->labels['client name']; ?>" />
                <input id="cli-code" type="text" placeholder="<?php echo $this->labels['personal / company code']; ?>" />
                <button class="filter-btn"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search text-right"></span></button>
            </div>
            <div class="product-table-holder">
                <table width="100%" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><?php echo $this->labels['client name']; ?></th>
                        <th><?php echo $this->labels['email']; ?></th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                    </thead>
                    <tbody class="filtered-body">
                    </tbody>
                </table>

            </div><!--/product-table-holder -->
            <h4><?php echo $this->labels['email templates']; ?></h4>
            <div class="transport-option-holder">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><?php echo $this->labels['name']; ?></th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($templates as $template): ?>
                        <tr>
                            <td><?php echo $template->name; ?></td>
                            <td>
                                <a data-name="option1"  data-unit="vnt" data-id="1" class="btn btn-default btn-sm add-option" href="#">
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
            <h4><?php echo $this->labels['product info']; ?></h4>
            <table  class="table table-bordered">
                <tbody>

                <tr>
                    <td><?php echo $this->labels['product name']; ?></td>
                    <td><?php echo $card->product_name; ?></td>
                    <td><?php echo $this->labels['product_code']; ?></td>
                    <td><?php echo $card->product_code; ?></td>
                </tr>

                <tr>
                    <td>measure units</td>
                    <td>kg</td>
                    <td>gabaritai dim</td>
                    <td>cm</td>
                </tr>
                <tr>
                    <td>Netto  (kg)</td>
                    <td>1.234</td>
                    <td>Brutto (kg)</td>
                    <td>1.456</td>
                </tr>
                <tr>
                    <td>Gabaritai height x weight x length</td>
                    <td colspan="3">2244 x 23424 323</td>
                </tr>
                </tbody>
            </table>
        </div><!--/table-holder -->


        <div id="email-create-section">
            <h4>To:</h4>
            <div id="address-to-section" class="clearfix">
                <ul id="emails-to-holder">
                    <li id="empty-list">Put here user emails</li>
                </ul><!--emails-to-holder -->
            </div>
            <div id="text-holder-area">
                <textarea></textarea>
            </div><!--/product-holder-area -->
            <div id="files-section">
                <h5>Aviable files</h5>
                <ul class="clearfix">
                    <li> <input type="checkbox"> <span>file1 file1 file1 file1</span></li>
                    <li> <input type="checkbox"> <span>file2</span></li>
                    <li> <input type="checkbox"> <span>file3</span></li>
                    <li> <input type="checkbox"> <span>file4</span></li>
                </ul>
            </div><!--/files-section -->
        </div><!--/email-create-section -->

    </div><!--/left -->
    <div class="btn-holder col-sm-12 clearfix text-right">
        <button class="btn-submit"   data-toggle="modal" data-target="#invoiceReady"><span>Creare letter</span><span class="glyphicon glyphicon-chevron-right"></span></button>
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
                        <button type="button" class="btn btn-primary">Continue<span class="glyphicon glyphicon-print"></span></button>
                        <button type="button" class="btn btn-primary">Continue<span class="glyphicon glyphicon-share-alt"></span></button>
                    </div><!--/modal-footer -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div><!--/invoice-ready -->

</div><!--/modals-holder -->
</div><!--/container -->