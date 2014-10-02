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

                <div class="form-group">
                    <label for="client-type"><?php echo $this->labels['client type']; ?></label>
                    <select id="client-type" class="form-control">
                        <?php foreach($client_types as $key => $value):?>
                            <option value="<?php echo $key?>"><?php echo $value; ?></option>
                        <?php endforeach;?>
                    </select>
                </div><!--/form-group -->

                <div class="col-md-12 filter-wrapper">
                    <!--/filter ajax goes here -->
                    <h5 class="text-center"><?php echo $this->labels['select client type']; ?></h5>
                </div><!--filter-wrapper -->

                <div class="light-box-holder">
                    <div class="modal cust-info"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div id="modal-user-info" class="modal-content">
                                <!--/ modal content goes here -->
                            </div><!--/modal-content -->
                        </div><!--/modal-dialog -->
                    </div><!--/modal -->

                    <?php if($form_mdl->hasErrors()): ?>
                        <?php if($form_mdl->company): ?>
                            <input type="hidden" value="1" id="open-modal-create-client">
                        <?php else:?>
                            <input type="hidden" value="0" id="open-modal-create-client">
                        <?php endif;?>
                    <?php endif;?>

                    <?php $this->renderPartial('_new_client_modal_juridical',array('form_mdl' => $form_mdl)); ?>
                    <?php $this->renderPartial('_new_client_modal_physical',array('form_mdl' => $form_mdl)); ?>
                </div><!--/light-box-holder -->
            </div><!--/form-holder -->
        </div><!--/left -->
    </div><!--row -->
</div><!--/container -->