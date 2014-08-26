<?php
/* @var $cs CClientScript */
/* @var $this SellController */
/* @var $form CActiveForm */
/* @var $form_mdl ClientForm */

$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/ui-lightness/jquery-ui-1.10.4.custom.min.css');
$cs->registerCssFile(Yii::app()->baseUrl.'/css/purchases_step1.css');

$cs->registerCoreScript('jquery.ui',CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl."/js/sales_first_step.js",CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>


<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row card-holder">

        <div class="col-md-12">
            <div class="form-holder">

                <div class="col-md-12 filter-wrapper">
                    <div class="form-inline">
                        <div class="form-group filter-group">
                            <label><?php echo $this->labels['find client']; ?></label>
                            <input type="text" class="form-control client-filter by-name">
                            <input type="text" class="form-control client-filter by-number">
                            <button class="form-control clearfix" id="filter-search"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search text-right"></span></button>
                        </div><!--/form-group -->
                    </div><!--/form-inline -->

                    <div class="table-holder header-holder">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th><?php echo $this->labels['name']; ?></th>
                                <th><?php echo $this->labels['code']; ?></th>
                                <th><?php echo $this->labels['address']; ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div><!--/table-header-holder -->
                    <div class="table-holder body-holder">
                        <table class="table table-bordered table-hover">
                            <tbody>
                            <tr>
                                <td colspan="3" class="text-center"><h5><?php echo $this->labels['no data found']; ?></h5></td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!--body-holder-->

                    <div class="new-cust-btn-holder">
                        <button data-toggle="modal" data-target=".new-customer"><?php echo $this->labels['new client']; ?><span class="glyphicon glyphicon-plus-sign"></span></button>
                    </div><!--/new-cust-btn-holder -->
                </div><!--filter-wrapper -->

                <div class="light-box-holder">
                    <div class="modal cust-info"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content" id="modal-user-info">
                                <!-- modal goes here -->
                            </div><!--/modal-content -->
                        </div><!--/modal-dialog -->
                    </div><!--/modal -->

                    <div class="modal new-customer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <?php if($form_mdl->hasErrors()):?><div class="opened-modal-new-customer"></div><?php endif; ?>
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header clearfix">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $this->labels['close']; ?></span></button>
                                    <h4 class="modal-title"><?php echo $this->labels['new client']; ?></h4>
                                </div><!--/modal-header -->
                                <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-product-form','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'clearfix'))); ?>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'personal_code');?>
                                        <?php echo $form->textField($form_mdl,'personal_code',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'personal_code'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'vat_code');?>
                                        <?php echo $form->textField($form_mdl,'vat_code',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'vat_code'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'name');?>
                                        <?php echo $form->textField($form_mdl,'name',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'name'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'surname');?>
                                        <?php echo $form->textField($form_mdl,'surname',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'surname'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'phone1');?>
                                        <?php echo $form->textField($form_mdl,'phone1',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'phone1'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'email1');?>
                                        <?php echo $form->textField($form_mdl,'email1',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'email1'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'remark');?>
                                        <?php echo $form->textArea($form_mdl,'remark',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'remark'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'remark_for_service');?>
                                        <?php echo $form->textArea($form_mdl,'remark_for_service',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'remark_for_service'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'company'); ?>
                                        <input type="checkbox" name="ClientForm[company]">
                                        <?php //echo $form->checkBox($form_mdl,'company'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'company_name');?>
                                        <?php echo $form->textField($form_mdl,'company_name',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'company_name'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'company_code');?>
                                        <?php echo $form->textField($form_mdl,'company_code',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'company_code'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'country');?>
                                        <?php echo $form->textField($form_mdl,'country',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'country'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'city');?>
                                        <?php echo $form->textField($form_mdl,'city',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'city'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'street');?>
                                        <?php echo $form->textField($form_mdl,'street',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'street'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $form->label($form_mdl,'building_nr');?>
                                        <?php echo $form->textField($form_mdl,'building_nr',array('class'=>'form-control'));?>
                                        <?php echo $form->error($form_mdl,'building_nr'); ?>
                                    </div>
                                </div><!--/modal-body -->

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->labels['close']; ?><span class="glyphicon glyphicon-thumbs-down"></span></button>
                                    <button type="submit" class="btn btn-primary"><?php echo $this->labels['continue']; ?><span class="glyphicon glyphicon-share-alt"></span></button>
                                </div><!--/modal-footer -->
                                <?php $this->endWidget(); ?>
                            </div><!--/modal-content -->
                        </div><!--/modal-dioalog -->
                    </div><!--/moda new-customer -->
                </div><!--/light-box-holder -->
            </div><!--/form-holder -->
        </div><!--/left -->
    </div><!--row -->
</div><!--/container -->
