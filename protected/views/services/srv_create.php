<?php /* @var $this ServicesController */ ?>
<?php /* @var $cs CClientScript */ ?>

<?php /* @var $client_types array */ ?>
<?php /* @var $form_mdl ServiceForm */?>
<?php /* @var $form CActiveForm */ ?>
<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap-editable.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/tickets_card.css');

$cs->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap-editable.js',CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/service.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>


<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row card-holder">

        <div class="col-md-12">
            <div class="form-holder">

                <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-product-form','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'clearfix'))); ?>
                <div class="form-group">
                    <?php echo $form->label($form_mdl,'client_type');?>
                    <?php echo $form->dropDownList($form_mdl,'client_type',$client_types,array('id' => 'client-type', 'class'=>'form-control ajax-select-client-type'));?>
                </div><!--/form-group -->
                <?php $this->endWidget(); ?>

                <div class="col-md-12 filter-wrapper hidden client-select-block">
                    <div class="form-group">
                        <label for="name-filter"><?php echo $this->labels['filter']; ?></label>
                        <input id="name-filter" type="text" class="form-control client-filter" placeholder="">
                    </div><!--/form-group -->

                    <div class="filtered-clients">
                    </div>
                </div><!--filter-wrapper -->

                <div class="light-box-holder">
                    <div class="modal fade cust-info"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    </div><!--/modal -->
                </div><!--/light-box-holder -->

            </div><!--/form-holder -->
        </div><!--/left -->
    </div><!--row -->
</div><!--/container -->

