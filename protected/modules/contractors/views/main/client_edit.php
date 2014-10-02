<?php /* @var $form CActiveForm */ ?>
<?php /* @var $this ContractorsController */ ?>
<?php /* @var $form_mdl ClientForm */ ?>
<?php /* @var $client Clients */ ?>


<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/add_product.css');
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-product-form','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'clearfix'))); ?>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'personal_code');?>
                <?php echo $form->textField($form_mdl,'personal_code',array('class'=>'form-control', 'value' => $client->personal_code));?>
                <?php echo $form->error($form_mdl,'personal_code'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'vat_code');?>
                <?php echo $form->textField($form_mdl,'vat_code',array('class'=>'form-control', 'value' => $client->vat_code));?>
                <?php echo $form->error($form_mdl,'vat_code'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'name');?>
                <?php echo $form->textField($form_mdl,'name',array('class'=>'form-control', 'value' => $client->name));?>
                <?php echo $form->error($form_mdl,'name'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'surname');?>
                <?php echo $form->textField($form_mdl,'surname',array('class'=>'form-control', 'value' => $client->surname));?>
                <?php echo $form->error($form_mdl,'surname'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'phone1');?>
                <?php echo $form->textField($form_mdl,'phone1',array('class'=>'form-control', 'value' => $client->phone1));?>
                <?php echo $form->error($form_mdl,'phone1'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'phone2');?>
                <?php echo $form->textField($form_mdl,'phone2',array('class'=>'form-control', 'value' => $client->phone2));?>
                <?php echo $form->error($form_mdl,'phone2'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'email1');?>
                <?php echo $form->textField($form_mdl,'email1',array('class'=>'form-control', 'value' => $client->email1));?>
                <?php echo $form->error($form_mdl,'email1'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'email2');?>
                <?php echo $form->textField($form_mdl,'email2',array('class'=>'form-control', 'value' => $client->email2));?>
                <?php echo $form->error($form_mdl,'email2'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'remark');?>
                <?php echo $form->textArea($form_mdl,'remark',array('class'=>'form-control', 'value' => $client->remark));?>
                <?php echo $form->error($form_mdl,'remark'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'remark_for_service');?>
                <?php echo $form->textArea($form_mdl,'remark_for_service',array('class'=>'form-control', 'value' => $client->remark_for_service));?>
                <?php echo $form->error($form_mdl,'remark_for_service'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'company'); ?>
                <?php if($client->type == 1): ?>
                    <input type="checkbox" name="ClientForm[company]" checked>
<!--                    --><?php //echo $form->checkBox($form_mdl,'company', array('checked')); ?>
                <?php else: ?>
                    <input type="checkbox" name="ClientForm[company]">
<!--                    --><?php //echo $form->checkBox($form_mdl,'company'); ?>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'company_name');?>
                <?php echo $form->textField($form_mdl,'company_name',array('class'=>'form-control', 'value' => $client->company_name));?>
                <?php echo $form->error($form_mdl,'company_name'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'company_code');?>
                <?php echo $form->textField($form_mdl,'company_code',array('class'=>'form-control', 'value' => $client->company_code));?>
                <?php echo $form->error($form_mdl,'company_code'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'country');?>
                <?php echo $form->textField($form_mdl,'country',array('class'=>'form-control', 'value' => $client->country));?>
                <?php echo $form->error($form_mdl,'country'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'city');?>
                <?php echo $form->textField($form_mdl,'city',array('class'=>'form-control', 'value' => $client->city));?>
                <?php echo $form->error($form_mdl,'city'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'street');?>
                <?php echo $form->textField($form_mdl,'street',array('class'=>'form-control', 'value' => $client->street));?>
                <?php echo $form->error($form_mdl,'street'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'building_nr');?>
                <?php echo $form->textField($form_mdl,'building_nr',array('class'=>'form-control', 'value' => $client->building_nr));?>
                <?php echo $form->error($form_mdl,'building_nr'); ?>
            </div>


            <button type="submit"><span><?php echo $this->labels['save']; ?></span><span class="glyphicon glyphicon-plus"></span></button>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>