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
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap-editable.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/tickets_card.css');

$cs->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap-editable_r.js',CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/service.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row card-holder">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-product-form','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'clearfix'))); ?>


            <div class="col-lg-5 col-md-5 col-sm-6 right-part">
                <div class="form-holder client-settings hidden">

                </div><!--/form holder-->
            </div><!--/right -->


            <div class="col-lg-6 col-md-6 col-sm-6 left-part">
                <div class="form-holder">

                    <div class="form-group">
                        <?php echo $form->label($form_mdl,'client_id');?>
                        <?php echo $form->hiddenField($form_mdl,'client_id',array('id' => 'cli_id', 'txt' => '')); ?>
                        <?php echo $form->textField($form_mdl,'client_name',array('id' => 'fio', 'class'=>'form-control auto-complete-clients', 'placeholder' => 'Enter customer name'));?>
                        <?php echo $form->error($form_mdl,'client_name'); ?>
                    </div>
                    <hr/>

                    <div class="row">
                        <div  class="col-sm-6">
                            <?php echo $form->label($form_mdl,'city_id');?>
                            <?php echo $form->dropDownList($form_mdl,'city_id',$cities,array('id' => 'branch', 'class'=>'form-control ajax-filter-city'));?>
                        </div>

                        <div  class="col-sm-6">
                            <?php echo $form->label($form_mdl,'worker_id');?>
                            <?php echo $form->dropDownList($form_mdl,'worker_id',$workers,array('id' => 'worker', 'class'=>'form-control filtered-users'));?>
                        </div>
                    </div><!--/row -->

                    <hr/>

                    <div class="form-group">
                        <?php echo $form->label($form_mdl,'select_priority');?>
                        <div class="col-xs-12 btn-group" data-toggle="buttons">
                            <label class="btn btn-primary active">
                                <input type="radio" name="options" id="option1" checked> <?php echo $this->labels['low']; ?>
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="options" id="option2"> <?php echo $this->labels['medium']; ?>
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="options" id="option3"> <?php echo $this->labels['high']; ?>
                            </label>
                        </div>
                    </div><!--/form-group -->

                    <div class="form-group">
                        <?php echo $form->label($form_mdl,'problem_type_id');?>
                        <?php echo $form->dropDownList($form_mdl,'problem_type_id',$problems,array('class'=>'form-control'));?>
                    </div><!--/form-group -->

                    <div class="form-group">
                        <?php echo $form->label($form_mdl,'remark');?>
                        <?php echo $form->textArea($form_mdl,'remark',array('class'=>'form-control'));?>
                        <?php echo $form->error($form_mdl,'remark'); ?>
                    </div>
                </div><!--/form-holder -->
            </div><!--/left -->
            <div class="btn-holder col-sm-12 clearfix">
                <button class="btn-submit" type="submit"><span><?php echo $this->labels['create ticket']; ?></span><span class="glyphicon glyphicon-chevron-right"></span></button>
                <button class="btn-reset" type="reset"><span><?php echo $this->labels['reset fields']; ?></span> <span class="glyphicon glyphicon-remove"></span></button>
            </div><!--/btn-holder -->
            <?php $this->endWidget(); ?>
    </div>
</div>

