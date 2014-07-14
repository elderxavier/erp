<?php /* @var $this ProductsController */ ?>
<?php /* @var $form_mdl ProductCategoryForm */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $category ProductCardCategories*/ ?>

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
                    <?php echo $form->label($form_mdl,'name');?>
                    <?php echo $form->textField($form_mdl,'name',array('class'=>'form-control', 'value' => $category->name));?>
                    <?php echo $form->error($form_mdl,'name'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'remark');?>
                    <?php echo $form->textArea($form_mdl,'remark',array('class'=>'form-control', 'value' => $category->remark));?>
                    <?php echo $form->error($form_mdl,'remark'); ?>
                </div>

                <button type="submit"><span><?php echo $this->labels['save']; ?></span><span class="glyphicon glyphicon-plus"></span></button>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>