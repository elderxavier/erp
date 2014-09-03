<?php
/* @var $form_mdl ProductCardForm */
/* @var $form CActiveForm */
/* @var $this BuyController */
/* @var $cs CClientScript */
/* @var $supplier Suppliers */
/* @var $stocks Stocks[] */
/* @var $categories_arr Array */
/* @var $card ProductCards */

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
                    <button class="filter-btn-do"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search text-right"></span></button>
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

                            <?php if($card): ?>
                                <td><?php echo $card->product_name; ?></td>
                                <td><?php echo $card->product_code; ?></td>
                                <td>
                                    <a data-name="<?php echo $card->product_name; ?>" data-code="<?php echo $card->product_code; ?>" data-unit="<?php echo $card->units; ?>" data-id="<?php echo $card->id; ?>" class="btn btn-default btn-sm add-prod" href="#">
                                        <?php echo $this->labels['add to list']; ?>&nbsp;<span class="glyphicon glyphicon-share"></span>
                                    </a>
                                </td>
                            <?php else: ?>
                                <td align="center" colspan="3"><?php echo $this->labels['no data found']; ?></td>
                            <?php endif; ?>

                        </tr>
                        </tbody>
                    </table>
                    <div class="btn-holder">
                        <button data-toggle="modal" data-target="#newProduct"><?php echo $this->labels['new product']; ?>&nbsp;<span class="glyphicon glyphicon-plus-sign"></span></button>
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

            <div id="stock-selection" class="form-horizontal">
                <label for="stock-selector"><?php echo $this->labels['stock']; ?></label>
                <select class="form-control" id="stock-selector">
                    <?php foreach($stocks as $stock): ?>
                        <option value="<?php echo $stock->id; ?>"><?php echo $stock->name; ?> [<?php echo $stock->location->city_name; ?>]</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="invoice-number" class="form-horizontal">
                <label for="signer-name"><?php echo $this->labels['signer name']; ?></label>
                <input class="form-control" type="text" id="signer-name" placeholder="<?php echo $this->labels['signer name']; ?>">
            </div>
            <div id="invoice-number" class="form-horizontal">
                <label for="invoice-code"><?php echo $this->labels['invoice code']; ?></label>
                <input class="form-control" type="text" id="invoice-code" placeholder="<?php echo $this->labels['invoice code']; ?>">
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
                            <th><?php echo $this->labels['actions']; ?></th>
                        </tr>
                        </thead>
                        <tbody id="product-list-holder">
                        <tr id="empty-list">
                            <td colspan="6"><?php echo $this->labels['no data found']; ?></td>
                        </tr>
                        <tr class="summ">
                            <td colspan="3"></td>
                            <td><?php echo $this->labels['total']; ?>:</td>
                            <td colspan="2"><span id="total">0</span> EUR</td>
                        </tr>
                        </tbody>
                    </table>
                </div><!--/product-holder-area -->
            </div><!--/product-section -->

        </div><!--/left -->
        <div class="btn-holder col-sm-12 clearfix text-right">
            <button class="btn-submit create-invoice" style="display:none;"  data-toggle="modal" data-target="#invoiceReady"><span><?php echo $this->labels['create invoice']; ?></span><span class="glyphicon glyphicon-chevron-right"></span></button>
        </div><!--/btn-holder -->
    </div><!--row -->
    <div class="modals-holder">
        <div class="invoice-ready">

            <div class="modal fade" id="invoiceReady" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="<?php echo Yii::app()->createUrl('/buy/finishcreation'); ?>">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $this->labels['close']; ?></span></button>
                                <h4 class="modal-title"><?php echo $this->labels['new invoice']; ?></h4>
                            </div><!--/.modal-heafer -->

                            <div class="modal-body">
                                <div class="supl-header">
                                    <table class="table table-bordered" width="100%">
                                        <tr>
                                            <td><?php echo $this->labels['company name']; ?></td>
                                            <td><?php echo $supplier->company_name; ?></td>
                                            <td><?php echo $this->labels['phone'] ?></td>
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
                                            <td colspan="3"><?php echo $supplier->country.', '.$supplier->city.', '.$supplier->street; ?></td>
                                        </tr>
                                    </table>
                                </div><!--/supl-header -->
                                <div class="modal-prod-list-holder">
                                    <table class="table table-bordered" width="100%">
                                        <thead>
                                        <tr>
                                            <th><?php echo $this->labels['name']; ?></th>
                                            <th><?php echo $this->labels['product code']; ?></th>
                                            <th><?php echo $this->labels['units']; ?></th>
                                            <th><?php echo $this->labels['quantity']; ?></th>
                                            <th><?php echo $this->labels['price']; ?> (EUR)</th>
                                        </tr>
                                        </thead>

                                        <tbody class="make-invoice-body">
                                        </tbody>

                                    </table>
                                </div><!--/modal-prod-list-holder -->
                            </div><!--/modal-body -->

                            <div class="make-invoice-fields"></div>

                            <div class="modal-footer">
                                <input type="hidden" name="BuyForm[supplier_id]" value="<?php echo $supplier->id; ?>">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->labels['close']; ?><span class="glyphicon glyphicon-thumbs-down"></span></button>
                                <button type="submit" class="btn btn-primary"><?php echo $this->labels['continue']; ?><span class="glyphicon glyphicon-share-alt"></span></button>
                            </div><!--/modal-footer -->

                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div><!--/invoice-ready -->



        <div class="new-product">
            <div class="modal" id="newProduct" tabindex="-1" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $this->labels['close']; ?></span></button>
                            <h4 class="modal-title"><?php echo $this->labels['new product']; ?></h4>
                        </div><!--/.modal-heafer -->

                        <?php if($form_mdl->hasErrors()):?><div class="opened-modal-prod"></div><?php endif; ?>

                        <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-product-form','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'clearfix', 'enctype' => 'multipart/form-data'))); ?>
                        <div class="modal-body">

                            <div class="form-group">
                                <?php echo $form->label($form_mdl,'product_code');?>
                                <?php echo $form->textField($form_mdl,'product_code',array('class'=>'form-control', 'value' => ''));?>
                                <?php echo $form->error($form_mdl,'product_code'); ?>
                            </div>

                            <div class="form-group">
                                <?php echo $form->label($form_mdl,'product_name');?>
                                <?php echo $form->textField($form_mdl,'product_name',array('class'=>'form-control', 'value' => ''));?>
                                <?php echo $form->error($form_mdl,'product_name'); ?>
                            </div>

                            <div class="form-group">
                                <?php echo $form->label($form_mdl,'category_id');?>
                                <?php echo $form->dropDownList($form_mdl,'category_id',$categories_arr,array('class'=>'form-control','options' => array($card->category_id =>array('selected'=>true))));?>
                            </div>

                            <fieldset>
                                <legend><?php echo $form->label($form_mdl,'dimension_units'); ?></legend>
                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <?php echo $form->radioButton($form_mdl,'units',array('value'=>'units','uncheckValue'=>null,'checked'=>true));?>
                                            <?php echo $this->labels['units']; ?>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <?php echo $form->radioButton($form_mdl,'units',array('value'=>'kg','uncheckValue'=>null,'checked'=>false));?>
                                            <?php echo $this->labels['kg']; ?>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <?php echo $form->radioButton($form_mdl,'units',array('value'=>'liters','uncheckValue'=>null,'checked'=>false));?>
                                            <?php echo $this->labels['liters']; ?>
                                        </label>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <?php echo $form->label($form_mdl,'description');?>
                                <?php echo $form->textArea($form_mdl,'description',array('class'=>'form-control', 'value' => ''));?>
                                <?php echo $form->error($form_mdl,'description'); ?>
                            </div>
                        </div><!--/modal-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->labels['cancel']; ?><span class="glyphicon glyphicon-thumbs-down"></span></button>
                            <button type="submit" class="btn btn-primary"><?php echo $this->labels['save']; ?><span class="glyphicon glyphicon-share-alt"></span></button>
                        </div><!--/modal-footer -->
                        <?php $this->endWidget(); ?>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div><!--/new-product -->

    </div><!--/modals-holder -->
</div><!--/container -->