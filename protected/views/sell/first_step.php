<?php /* @var $this ServicesController */ ?>
<?php /* @var $cs CClientScript */ ?>

<?php /* @var $client_types array */ ?>
<?php /* @var $form_mdl ClientForm */?>
<?php /* @var $form_srv ServiceForm */?>
<?php /* @var $form CActiveForm */ ?>
<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap-editable.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/tickets_card.css');

$cs->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap-editable.js',CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/sales_first_step.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>


<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row card-holder">

        <div class="col-md-12">
            <div class="form-holder">

                <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-product-form','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'clearfix'))); ?>
                <div class="form-group">
                    <?php echo $form->label($form_srv,'client_type');?>
                    <?php echo $form->dropDownList($form_srv,'client_type',$client_types,array('id' => 'client-type', 'class'=>'form-control ajax-select-client-type'));?>
                </div><!--/form-group -->
                <?php $this->endWidget(); ?>

                <div class="col-md-12 filter-wrapper message-select-type"><h5 class="text-center"><?php echo $this->labels['select client type']; ?></h5></div>

                <div class="col-md-12 filter-wrapper hidden client-select-block">
                    <div class="form-inline">
                        <div class="form-group filter-group">
                            <label><?php echo $this->labels['filter']; ?></label>
                            <input id="client-by-name" type="text" class="form-control client-filter by-name">
                            <input id="client-by-code" type="text" class="form-control client-filter by-number">
                            <button id="filter-button" class="form-control clearfix"><?php echo $this->labels['filter']; ?><span class="glyphicon glyphicon-search text-right"></span></button>
                        </div><!--/form-group -->
                    </div><!--/form-inline -->

                    <div class="filtered-clients">
                    </div>
                </div><!--filter-wrapper -->


                <div class="light-box-holder">
                    <div class="modal fade cust-info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    </div><!--/modal -->
                </div><!--/light-box-holder -->

                <?php $this->renderPartial('_new_client_modal_physical', array('form_mdl' => $form_mdl)); ?>
                <?php $this->renderPartial('_new_client_modal_juridical', array('form_mdl' => $form_mdl)); ?>

            </div><!--/form-holder -->
        </div><!--/left -->
    </div><!--row -->
</div><!--/container -->