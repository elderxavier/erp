<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/stock_out.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/stock_movement_create.js',CClientScript::POS_END);
?>

<?php /* @var $this StockController */ ?>
<?php /* @var $stocks Stocks[] */ ?>


<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
<div class="row card-holder">

<div class="col-sm-6 left-part">
    <h4><?php echo $this->labels['source stock info']; ?></h4>
    <div id="stock-selection-from" class="form-horizontal stock-select-holder">
        <label><?php echo $this->labels['from stock']; ?></label>
        <select id="stock-id-src" class="form-control">
            <?php foreach($stocks as $stock): ?>
                <option data-city="<?php echo $stock->location->city_name; ?>" data-postcode="<?php echo $stock->post_code; ?>" data-address="<?php echo htmlspecialchars($stock->address,ENT_QUOTES); ?>" value="<?php echo $stock->id; ?>"><?php echo $stock->name.' ['.$stock->location->city_name.']'; ?></option>
            <?php endforeach;?>
        </select>
    </div><!--/stock-selection -->

    <div class="table-holder">
        <table  class="table table-bordered">
            <tbody>
            <tr>
                <td><?php echo $this->labels['company name']; ?></td>
                <td>INLUX</td>
                <td><?php echo $this->labels['phone']; ?></td>
                <td>+343254324</td>
            </tr>
            <tr>
                <td><?php echo $this->labels['company code']; ?></td>
                <td>34325432432</td>
                <td><?php echo $this->labels['vat code']; ?></td>
                <td>LT_3432434</td>
            </tr>
            <tr>
                <td><?php echo $this->labels['address']; ?></td>
                <td class="src-address" colspan="3">
                    <?php if(!empty($stocks)): ?>
                        <?php $first_stock = $stocks[0]; ?>
                        <?php echo $first_stock->address.', '.$first_stock->location->city_name.', '.$first_stock->post_code; ?>
                    <?php endif;?>
                </td>
            </tr>
            </tbody>
        </table>
    </div><!--/table-holder -->

    <div class="filter-holder">
        <h4><?php echo $this->labels['filter']; ?></h4>
        <div class="filter-inputs-holder">
            <input id="prod-name-src" type="text" placeholder="<?php echo $this->labels['product name']; ?>" />
            <input id="prod-code-src" type="text" placeholder="<?php echo $this->labels['product code']; ?>" />
            <button id="filter-btn-prods"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search text-right"></span></button>
        </div>
        <div class="product-table-holder">
            <table width="100%" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th><?php echo $this->labels['product name']; ?></th>
                    <th><?php echo $this->labels['product code'];?></th>
                    <th><?php echo $this->labels['quantity']; ?></th>
                    <th><?php echo $this->labels['actions']; ?></th>
                </tr>
                </thead>
                <tbody class="filtered-prods">

                </tbody>
            </table>

        </div><!--/product-table-holder -->
    </div><!--/filter-holder -->
</div><!--/left-part -->

<div class="col-lg-6 col-md-6 col-sm-6 pull-right">
    <h4><?php echo $this->labels['target stock info']; ?></h4>
    <div id="stock-selection-to" class="form-horizontal stock-select-holder">
        <label><?php echo $this->labels['to stock']; ?></label>
        <select id="stock-id-trg" class="form-control">
            <?php foreach($stocks as $stock): ?>
                <option data-city="<?php echo $stock->location->city_name; ?>" data-postcode="<?php echo $stock->post_code; ?>" data-address="<?php echo htmlspecialchars($stock->address,ENT_QUOTES); ?>" value="<?php echo $stock->id; ?>"><?php echo $stock->name.' ['.$stock->location->city_name.']'; ?></option>
            <?php endforeach;?>
        </select>
    </div><!--/stock-selection -->


    <div class="table-holder">
        <table  class="table table-bordered">
            <tbody>
            <tr>
                <td><?php echo $this->labels['company name']; ?></td>
                <td>INLUX</td>
                <td><?php echo $this->labels['phone']; ?></td>
                <td>+343254324</td>
            </tr>
            <tr>
                <td><?php echo $this->labels['company code']; ?></td>
                <td>34325432432</td>
                <td><?php echo $this->labels['vat code']; ?></td>
                <td>LT_3432434</td>
            </tr>
            <tr>
                <td><?php echo $this->labels['address']; ?></td>
                <td class="trg-address" colspan="3">
                    <?php if(!empty($stocks)): ?>
                        <?php $first_stock = $stocks[0]; ?>
                        <?php echo $first_stock->address.', '.$first_stock->location->city_name.', '.$first_stock->post_code; ?>
                    <?php endif;?>
                </td>
            </tr>
            </tbody>
        </table>
    </div><!--/table-holder -->

    <div id="product-section">
        <h4><?php echo $this->labels['product list']; ?></h4>
        <div class="product-holder-area">
            <table id="prod-list" class="table table-bordered table-hover" width="100%">
                <thead>
                <tr>
                    <th><?php echo $this->labels['name']; ?></th>
                    <th><?php echo $this->labels['code']; ?></th>
                    <th><?php echo $this->labels['measure']; ?></th>
                    <th><?php echo $this->labels['qnt']; ?></th>
                    <th><?php echo $this->labels['dim'];?></th>
                    <th><?php echo $this->labels['size'];?></th>
                    <th><?php echo $this->labels['net']; ?>(KG)</th>
                    <th><?php echo $this->labels['gross']; ?>(KG)</th>
                    <th><?php echo $this->labels['act']; ?></th>
                </tr>
                </thead>
                <tbody id="product-list-holder">
                <tr id="empty-list">
                    <td colspan="9"><?php echo $this->labels['no data']; ?></td>
                </tr>
                <tr class="summ">
                    <td colspan="5"></td>
                    <td colspan="2"><?php echo $this->labels['total net']; ?> :</td>
                    <td colspan="3"><span id="total-net">0.000</span> KG</td>
                </tr>
                <tr class="summ-plus-vat">
                    <td colspan="5"></td>
                    <td colspan="2" class="name-gross"><?php echo $this->labels['total gross']; ?>:</td>
                    <td colspan="3"><span id="total-gross">0.000</span> KG</td>
                </tr>
                </tbody>
            </table>
        </div><!--/product-holder-area -->
    </div><!--/product-section -->

    <div id="transport-detail-section">
        <div class="col-xs-6">
            <label><?php echo $this->labels['transport brand']; ?></label>
            <input id="car-brand-input" type="text" class="form-control">
        </div>

        <div class="col-xs-6">
            <label><?php echo $this->labels['transport number']; ?></label>
            <input id="car-number-input" type="text" class="form-control">
        </div>

    </div><!--/transport-detail-section -->

</div><!--/left -->
    <div class="btn-holder col-sm-12 clearfix text-right">
        <button class="btn-submit"   data-toggle="modal" data-target="#transferInfo"><span><?php echo $this->labels['move']; ?></span><span class="glyphicon glyphicon-chevron-right"></span></button>
    </div><!--/btn-holder -->
</div><!--row -->
<div class="modals-holder">
    <div class="invoice-ready">

        <div class="modal fade" id="transferInfo" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $this->labels['close']; ?></span></button>
                        <h4 class="modal-title"><?php echo $this->labels['new movement']; ?></h4>
                    </div><!--/.modal-heafer -->

                    <div class="modal-body">
                        <div class="supl-header">
                            <table class="table table-bordered" width="100%">
                                <tr>
                                    <td><?php echo $this->labels['from stock']; ?></td>
                                    <td class="vis-stock-from"></td>
                                    <td><?php echo $this->labels['to stock']; ?></td>
                                    <td class="vis-stock-to"></td>
                                </tr>
                            </table>
                        </div><!--/supl-header -->
                        <div class="modal-prod-list-holder">
                            <table class="table table-bordered" width="100%">
                                <thead>
                                <tr>
                                    <th><?php echo $this->labels['name']; ?></th>
                                    <th><?php echo $this->labels['code']; ?></th>
                                    <th><?php echo $this->labels['measure']; ?></th>
                                    <th><?php echo $this->labels['qnt']; ?></th>
                                    <th><?php echo $this->labels['dim'];?></th>
                                    <th><?php echo $this->labels['size'];?></th>
                                    <th><?php echo $this->labels['net']; ?>(KG)</th>
                                    <th><?php echo $this->labels['gross']; ?>(KG)</th>
                                </tr>
                                </thead>
                                <tbody class="body-modal-prods">
                                </tbody>
                            </table>
                        </div><!--/modal-prod-list-holder -->
                    </div><!--/modal-body -->

                    <form method="post" action="<?php echo Yii::app()->createUrl('/stock/movefinish') ?>">
                        <div class="hidden-fields">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->labels['close']; ?><span class="glyphicon glyphicon-thumbs-down"></span></button>
                            <button type="submit" class="btn btn-primary" name="MovementForm[generate_pdf]" value="1"><?php echo $this->labels['continue']; ?><span class="glyphicon glyphicon-print"></span></button>
                            <button type="submit" class="btn btn-primary"><?php echo $this->labels['continue']; ?><span class="glyphicon glyphicon-share-alt"></span></button>
                        </div><!--/modal-footer -->
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div><!--/invoice-ready -->

</div><!--/modals-holder -->
</div><!--/container -->