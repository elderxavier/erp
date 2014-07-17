<?php /* @var $supplier Suppliers */ ?>
<?php /* @var $product ProductCards */ ?>
<?php /* @var $suppliers Array */ ?>
<?php /* @var $products Array */ ?>
<?php /* @var $stocks Array */ ?>
<?php /* @var $stock Stocks */ ?>
<?php /* @var $this BuyController */ ?>

<?php
/* @var $cs CClientScript */
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->baseUrl.'/css/buy-ops.css');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/jqueryui-touch-punch/jquery.ui.touch-punch.min.js',CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/buy-ops.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid main-content-holder">
    <div class="row widget-container col-lg-4 col-md-4">

        <div class="widgets widget1">
            <input id="client-input" type="text" placeholder="<?php echo $this->labels['supplier search']; ?>">
            <div class="table-wrapper">
                <table id="client-table" class="table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <?php foreach($suppliers as $supplier): ?>
                        <tr client_id = "<?php echo $supplier->id; ?>"><td><p  class="glyphicon glyphicon-hand-down"></p></td><td><?php echo $supplier->type ? $supplier->company_name : $supplier->name.' '.$supplier->surname; ?></td></tr>
                    <?php endforeach;?>
                </table>
            </div><!--client-table-wrapper-->
        </div><!--/client-widget-->

        <div class="widgets widget2">
            <input id="product-input" type="text" placeholder="<?php echo $this->labels['product search']; ?>">
            <div class="table-wrapper">
                <table id="product-table" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <th><?php echo $this->labels['product code']; ?></th>
                        <th><?php echo $this->labels['name'];?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($products as $product): ?>
                        <tr product_id = "<?php echo $product->id; ?>">
                            <td><p  class="glyphicon glyphicon-hand-down"></p></td>
                            <td class="prod_code"><?php echo $product->product_code; ?></td>
                            <td class="prod_name"><?php echo $product->product_name; ?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div><!--product-table-wrapper-->
        </div><!--/product-widget-->
    </div><!--/client-and-goods-widget-container-->

    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 form-widget-container">
        <div class="form-widget">
            <div class="form-wrapper">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="inputClient" class="col-lg-2 col-md-2 control-label"><?php echo $this->labels['supplier']; ?></label>
                        <div class="col-lg-10 col-md-10 col-sm-12">
                            <input type="text" class="form-control droppable" id="inputClient" placeholder="<?php echo $this->labels['supplier']; ?>">
                            <input type="hidden" name="client_id" value="" class="cli-id">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">

                        <label class="col-lg-2 col-md-2 control-label">Products</label>
                        <div class="col-lg-10 col-md-10 col-sm-12 droppable" id="inputProduct">
                        <table class="table-prods">
                            <tr>
                                <th style="width: 80%"><?php echo $this->labels['product']; ?></th>
                                <th><?php echo $this->labels['quantity'];?></th>
                            </tr>
                        </table>
                        </div>

<!--                        <label for="inputProduct" class="col-lg-2 col-md-2 control-label">--><?php //echo $this->labels['product']; ?><!--</label>-->
<!--                        <div class="col-lg-10 col-md-10 col-sm-12">-->
<!--                            <input type="text" class="form-control droppable" id="inputProduct" placeholder="--><?php //echo $this->labels['product']; ?><!--">-->
<!--                        </div>-->
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="inputClient" class="col-lg-2 col-md-2 control-label"><?php echo $this->labels['stock']; ?></label>
                        <div class="col-lg-10 col-md-10 col-sm-12">
                            <select class="form-control">
                                <option value="">select</option>
                                <?php foreach($stocks as $stock): ?>
                                    <option value="<?php echo $stock->id; ?>"><?php echo $stock->name; ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </form><!--input-form-->
<!--                <hr>-->
            </div><!--/form-wrapper-->
        </div><!--/form-widget-->
    </div><!--/form-widget-container -->
</div><!--/content-holder-->