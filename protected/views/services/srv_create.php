<?php /* @var $service ServiceProcesses */ ?>
<?php /* @var $services array */ ?>
<?php /* @var $this ServicesController */ ?>

<?php /* @var $cs CClientScript */ ?>

<?php /* @var $form_mdl ServiceForm */?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $clients array */ ?>
<?php /* @var $problems array */ ?>
<?php /* @var $cities array */ ?>
<?php /* @var $workers array */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/add_product.css');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/service.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-product-form','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'clearfix'))); ?>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'label');?>
                <?php echo $form->textField($form_mdl,'label',array('class'=>'form-control'));?>
                <?php echo $form->error($form_mdl,'label'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'remark');?>
                <?php echo $form->textArea($form_mdl,'remark',array('class'=>'form-control'));?>
                <?php echo $form->error($form_mdl,'remark'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl, 'start_date');?>
                <?php echo $form->dateField($form_mdl, 'start_date',array('class'=>'form-control')); ?>
                <?php echo $form->error($form_mdl,'start_date'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl, 'close_date');?>
                <?php echo $form->dateField($form_mdl, 'close_date',array('class'=>'form-control')); ?>
                <?php echo $form->error($form_mdl,'close_date'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'client_id');?>
                <?php echo $form->hiddenField($form_mdl,'client_id',array('id' => 'cli_id', 'txt' => '')); ?>
                <?php echo $form->textField($form_mdl,'client_name',array('class'=>'form-control auto-complete-clients'));?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'problem_type_id');?>
                <?php echo $form->dropDownList($form_mdl,'problem_type_id',$problems,array('class'=>'form-control'));?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'operation_id');?>
                <?php echo $form->textArea($form_mdl,'operation_id',array('class'=>'form-control srv-product-picker'));?>
                <?php echo $form->error($form_mdl,'operation_id'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'operation_id');?>
                <?php echo $form->textArea($form_mdl,'operation_id',array('class'=>'form-control srv-product-picker'));?>
                <?php echo $form->error($form_mdl,'operation_id'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'city_id');?>
                <?php echo $form->dropDownList($form_mdl,'city_id',$cities,array('class'=>'form-control ajax-filter-city'));?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'worker_id');?>
                <?php echo $form->dropDownList($form_mdl,'worker_id',$workers,array('class'=>'form-control filtered-users'));?>
            </div>

            <button type="submit"><span><?php echo $this->labels['save']; ?></span><span class="glyphicon glyphicon-plus"></span></button>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

