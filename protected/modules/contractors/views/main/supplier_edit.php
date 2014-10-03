<?php /* @var $form CActiveForm */ ?>
<?php /* @var $this MainController */ ?>
<?php /* @var $form_mdl SupplierForm */ ?>
<?php /* @var $supplier Suppliers */ ?>


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
                <?php echo $form->label($form_mdl,'company_name');?>
                <?php echo $form->textField($form_mdl,'company_name',array('class'=>'form-control', 'value' => $supplier->company_name));?>
                <?php echo $form->error($form_mdl,'company_name'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'company_code');?>
                <?php echo $form->textField($form_mdl,'company_code',array('class'=>'form-control', 'value' => $supplier->company_code));?>
                <?php echo $form->error($form_mdl,'company_code'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'vat_code');?>
                <?php echo $form->textField($form_mdl,'vat_code',array('class'=>'form-control', 'value' => $supplier->vat_code));?>
                <?php echo $form->error($form_mdl,'vat_code'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'phone1');?>
                <?php echo $form->textField($form_mdl,'phone1',array('class'=>'form-control', 'value' => $supplier->phone1));?>
                <?php echo $form->error($form_mdl,'phone1'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'phone2');?>
                <?php echo $form->textField($form_mdl,'phone2',array('class'=>'form-control', 'value' => $supplier->phone2));?>
                <?php echo $form->error($form_mdl,'phone2'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'email1');?>
                <?php echo $form->textField($form_mdl,'email1',array('class'=>'form-control', 'value' => $supplier->email1));?>
                <?php echo $form->error($form_mdl,'email1'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'email2');?>
                <?php echo $form->textField($form_mdl,'email2',array('class'=>'form-control', 'value' => $supplier->email2));?>
                <?php echo $form->error($form_mdl,'email2'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'remark');?>
                <?php echo $form->textArea($form_mdl,'remark',array('class'=>'form-control', 'value' => $supplier->remark));?>
                <?php echo $form->error($form_mdl,'remark'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'country');?>
                <?php echo $form->textField($form_mdl,'country',array('class'=>'form-control', 'value' => $supplier->country));?>
                <?php echo $form->error($form_mdl,'country'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'city');?>
                <?php echo $form->textField($form_mdl,'city',array('class'=>'form-control', 'value' => $supplier->city));?>
                <?php echo $form->error($form_mdl,'city'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'street');?>
                <?php echo $form->textField($form_mdl,'street',array('class'=>'form-control', 'value' => $supplier->street));?>
                <?php echo $form->error($form_mdl,'street'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'building_nr');?>
                <?php echo $form->textField($form_mdl,'building_nr',array('class'=>'form-control', 'value' => $supplier->building_nr));?>
                <?php echo $form->error($form_mdl,'building_nr'); ?>
            </div>

            <button type="submit"><span><?php echo $this->labels['save']; ?></span><span class="glyphicon glyphicon-plus"></span></button>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>