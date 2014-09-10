<?php /* @var $invoices OperationsIn[] */ ?>
<?php /* @var $this BuyController */ ?>

<?php /* @var $pages int */ ?>
<?php /* @var $current_page int */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/invoice_list.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/paginator.css');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/buy_list.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row filter-holder">
        <form>
            <input id="invoice-nr" type="text" placeholder="<?php echo $this->labels['invoice code']; ?>">
            <input id="supplier-name" type="text" placeholder="<?php echo $this->labels['supplier name']; ?>">
            <input class="date-picker-cl" id="date-from" type="text" placeholder="<?php echo $this->labels['date from']; ?>">
            <input class="date-picker-cl" id="date-to" type="text" placeholder="<?php echo $this->labels['date to']; ?>">
            <button id="search-btn"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search"></span></button>
        </form>
    </div><!--/filter-holder -->
    <div class="row table-holder">
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
            <?php foreach($invoices as $invoice): ?>
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
        <div class="pages-holder">
            <ul class="paginator">
                <?php for($i = 0; $i < $pages; $i++): ?>
                    <li class="<?php if(($i+1) == $current_page): ?>current-page<?php endif; ?> links-pages"><?php echo ($i+1) ?></li>
                <?php endfor; ?>
            </ul>
        </div>
    </div><!--/table-holder -->

    <div class="modals-holder">
        <div class="invoice-ready">

            <div class="modal fade" id="invoiceInfo" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $this->labels['close']; ?></span></button>
                            <h4 class="modal-title"><?php echo $this->labels['invoice']; ?> : 213232323</h4>
                        </div><!--/.modal-heafer -->

                        <div class="modal-body">
                            <div class="supl-header">
                                <table class="table table-bordered" width="100%">
                                    <tr>
                                        <td><?php echo $this->labels['company name']; ?></td>
                                        <td>inclusion</td>
                                        <td><?php echo $this->labels['phone']; ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $this->labels['company code']; ?></td>
                                        <td>2324234</td>
                                        <td><?php echo $this->labels['vat code']; ?></td>
                                        <td>fdghhfdhg</td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $this->labels['address']; ?></td>
                                        <td colspan="3">Vilnius, kapsu g 8, LT-21345</td>
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
                                        <td><?php echo $this->labels['total']; ?> :</td>
                                        <td>700 EUR</td>
                                    </tr>
                                    <tr class="total-with-vat">
                                        <td colspan="3"></td>
                                        <td><?php echo $this->labels['total']; ?> 21% <?php echo $this->labels['vat']; ?> :</td>
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