<?php /* @var $movements StockMovements[] */ ?>
<?php /* @var $this StockController */ ?>
<?php /* @var $stocks array */ ?>

<?php /* @var $pages int */ ?>
<?php /* @var $current_page int */ ?>


<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/stock_list.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/paginator.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/stock_movements.js',CClientScript::POS_END);
?>
   
<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row filter-holder">
        <form method="post" action="#">

            <input id="mov-id" type="text" placeholder="<?php echo $this->labels['movement id']; ?>">

            <select id="from-stock">
                <option value=""><?php echo $this->labels['from stock']; ?></option>
                <?php foreach($stocks as $id => $name): ?>
                    <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                <?php endforeach;?>
            </select>

            <select id="to-stock">
                <option value=""><?php echo $this->labels['to stock']; ?></option>
                <?php foreach($stocks as $id => $name): ?>
                    <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                <?php endforeach;?>
            </select>

            <input id="date-from" type="text" placeholder="<?php echo $this->labels['date from']; ?>">
            <input id="date-to" type="text" placeholder="<?php echo $this->labels['date to']; ?>">

            <button><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search"></span></button>
        </form>
    </div><!--/filter-holder -->

    <div class="row table-holder">
        <table class="table table-bordered table-striped table-hover" >
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo $this->labels['movement id']; ?></th>
                <th><?php echo $this->labels['from stock']; ?></th>
                <th><?php echo $this->labels['to stock']; ?></th>
                <th><?php echo $this->labels['transport']; ?></th>
                <th><?php echo $this->labels['date']; ?></th>
                <th><?php echo $this->labels['status']; ?></th>
                <th><?php echo $this->labels['actions']; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($movements as $nr => $movement): ?>
                <tr>
                    <td><?php echo $nr; ?></td>
                    <td><?php echo $movement->id; ?></td>
                    <td><?php echo $movement->srcStock->name.' ['.$movement->srcStock->location->city_name.']'; ?></td>
                    <td><?php echo $movement->trgStock->name.' ['.$movement->trgStock->location->city_name.']'; ?></td>
                    <td><?php echo $movement->car_brand.' - '.$movement->car_number; ?></td>
                    <td><?php echo date('Y.m.d',$movement->trg_stock_id); ?></td>
                    <td><?php echo $movement->status->name; ?></td>
                    <td><a href="#"><?php echo $this->labels['change status']; ?></a></td>
                </tr>
            <?php endforeach; ?>
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
