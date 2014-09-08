<?php /* @var $this StockController */ ?>
<?php /* @var $movement StockMovements */ ?>
<?php /* @var $statuses StockMovementStatuses[] */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/stock_out.css');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/stock_movement_create.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>


<div class="container-fluid  main-content-holder content-wrapper">
<div class="row card-holder">

    <div class="col-sm-6 left-part">
        <h4><?php echo $this->labels['from stock']; ?></h4>
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
                    <td><?php echo $this->labels['company code']; ?></td>
                    <td>LT_3432434</td>
                </tr>
                <tr>
                    <td><?php echo $this->labels['address']; ?></td>
                    <td colspan="3"><?php echo $movement->srcStock->address;?>, <?php echo $movement->srcStock->location->city_name;?>, <?php echo $movement->srcStock->post_code; ?></td>
                </tr>
                </tbody>
            </table>
        </div><!--/table-holder -->

        <div id="product-section">
            <h4><?php echo $this->labels['products']; ?></h4>
            <div class="product-holder-area">
                <table id="prod-list" class="table table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <th><?php echo $this->labels['product name']; ?></th>
                        <th><?php echo $this->labels['product code']; ?></th>
                        <th><?php echo $this->labels['measure']; ?></th>
                        <th><?php echo $this->labels['qnt']; ?></th>
                        <th><?php echo $this->labels['dimension'];?></th>
                        <th><?php echo $this->labels['sizes'];?></th>
                        <th><?php echo $this->labels['net']; ?> (kg)</th>
                        <th><?php echo $this->labels['gross']; ?> (kg)</th>
                    </tr>
                    </thead>
                    <tbody id="product-list-holder">
                    <?php foreach($movement->stockMovementItems as $item): ?>
                        <tr>
                            <td><?php echo $item->productCard->product_name; ?></td>
                            <td><?php echo $item->productCard->product_code; ?></td>
                            <td><?php echo $item->productCard->measureUnits->name; ?></td>
                            <td><?php echo $item->qnt; ?></td>
                            <td><?php echo $item->productCard->sizeUnits->name;?></td>
                            <td><?php echo $item->productCard->weight.'x'.$item->productCard->height.'x'.$item->productCard->length; ?></td>
                            <td><?php echo number_format($item->productCard->weight_net/1000,3); ?></td>
                            <td><?php echo number_format($item->productCard->weight/1000,3); ?></td>
                        </tr>
                    <?php endforeach;?>

                    <tr class="summ">
                        <td colspan="4"></td>
                        <td colspan="2"><?php echo $this->labels['total net']; ?>:</td>
                        <td colspan="3"><span id="total-net"><?php echo number_format($movement->calculateTotalWeight(true,true),3); ?></span> KG</td>
                    </tr>
                    <tr class="summ-plus-vat">
                        <td colspan="4"></td>
                        <td colspan="2" class="name-gross"><?php echo $this->labels['total gross']; ?>:</td>
                        <td colspan="3"><span id="total-gross"><?php echo number_format($movement->calculateTotalWeight(false,true),3); ?></span> KG</td>
                    </tr>

                    </tbody>
                </table>
            </div><!--/product-holder-area -->
        </div><!--/product-section -->
        <div class="transport-detail-holder">
            <p><?php echo $this->labels['transport']; ?> : <?php echo $movement->car_brand; ?>, <?php echo $movement->car_number; ?></p>
        </div><!--/transport detail holder -->
    </div><!--/left-part -->

    <div class="col-lg-6 col-md-6 col-sm-6 pull-right">
        <h4><?php echo $this->labels['to stock']; ?></h4>


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
                    <td><?php echo $this->labels['company code']; ?></td>
                    <td>LT_3432434</td>
                </tr>
                <tr>
                    <td><?php echo $this->labels['address']; ?></td>
                    <td colspan="3"><?php echo $movement->trgStock->address;?>, <?php echo $movement->trgStock->location->city_name;?>, <?php echo $movement->trgStock->post_code; ?></td>
                </tr>
                </tbody>
            </table>
        </div><!--/table-holder -->



        <div id="product-section">
            <h4><?php echo $this->labels['details']; ?></h4>
            <div class="product-holder-area">
                <table id="prod-list" class="table table-bordered table-hover" width="100%">
                    <thead>

                    <tr>
                        <th>#</th>
                        <th><?php echo $this->labels['status']; ?></th>
                        <th><?php echo $this->labels['description']; ?></th>
                        <th><?php echo $this->labels['remark'];?></th>
                        <th><?php echo $this->labels['time']; ?></th>
                        <th><?php echo $this->labels['name']; ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php foreach($movement->stockMovementStages as $nr => $stage): ?>
                            <td><?php echo $nr + 1; ?></td>
                            <td><?php echo $movement->status->name; ?></td>
                            <td><?php echo $stage->getDescription(); ?></td>
                            <td><?php echo $stage->remark; ?></td>
                            <td><?php echo date('Y.m.d H:i');?></td>
                            <td><?php echo $stage->userOperator->name.' '.$stage->userOperator->surname; ?></td>
                        <?php endforeach; ?>
                    </tr>
                    </tbody>
                </table>
            </div><!--/product-holder-area -->
            <form method="post" action="#">
                <h4><?php echo $this->labels['change status']; ?></h4>
                <div id="status-selection-from" class="form-horizontal stock-select-holder">
                    <label><?php echo $this->labels['select']; ?></label>
                    <select class="form-control">
                        <?php foreach($statuses as $status): ?>
                            <option value="<?php echo $status->id; ?>"><?php echo $status->name; ?></option>
                        <?php endforeach;?>
                    </select>
                </div><!--/stock-selection -->
                <div class="text-area-holder">
                    <label><?php echo $this->labels['remark']; ?></label>
                    <textarea class="form-control"></textarea>
                </div><!--text-area-holder-->

                <div class="btn-holder col-sm-12 clearfix text-right">
                    <button class="btn-submit"><span><?php echo $this->labels['save']; ?> </span><span class="glyphicon glyphicon-chevron-right"></span></button>
                </div><!--/btn-holder -->
            </form>
        </div><!--/product-section -->



    </div><!--/left -->
</div><!--row -->
<div class="modals-holder">
</div><!--/modals-holder -->
</div><!--/container -->