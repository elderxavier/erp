<?php /* @var $form CActiveForm */ ?>
<?php /* @var $form_mdl ProductCardForm */ ?>
<?php /* @var $categories_arr Array */ ?>
<?php /* @var $card ProductCards */ ?>
<?php /* @var $this ProductsController */ ?>


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
                <?php echo $form->label($form_mdl,'product_code');?>
                <?php echo $form->textField($form_mdl,'product_code',array('class'=>'form-control', 'value' => $card->product_code));?>
                <?php echo $form->error($form_mdl,'product_code'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'product_name');?>
                <?php echo $form->textField($form_mdl,'product_name',array('class'=>'form-control', 'value' => $card->product_name));?>
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
                            <input type="radio" name="ProductCardForm[units]" value="units" <?php if($card->units == 'units'): ?>checked<?php endif; ?>>
<!--                            --><?php //echo $form->radioButton($form_mdl,'units',array('value' => 'units', 'checked' => 'checked')); ?>
                            <?php echo $this->labels['units']; ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="ProductCardForm[units]" value="kg" <?php if($card->units == 'kg'): ?>checked<?php endif; ?>>
<!--                            --><?php //echo $form->radioButton($form_mdl,'units',array('value' => 'kg')); ?>
                            <?php echo $this->labels['kg']; ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="ProductCardForm[units]" value="liters" <?php if($card->units == 'liters'): ?>checked<?php endif; ?>>
<!--                            --><?php //echo $form->radioButton($form_mdl,'units',array('value' => 'liters')); ?>
                            <?php echo $this->labels['liters']; ?>
                        </label>
                    </div>
                </div>
            </fieldset>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'description');?>
                <?php echo $form->textArea($form_mdl,'description',array('class'=>'form-control', 'value' => $card->description));?>
                <?php echo $form->error($form_mdl,'description'); ?>
            </div>

            <button type="submit"><span><?php echo $this->labels['save']; ?></span><span class="glyphicon glyphicon-plus"></span></button>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>