<?php /* @var $form CActiveForm */ ?>
<?php /* @var $form_mdl ProductCardForm */ ?>
<?php /* @var $categories_arr Array */ ?>
<?php /* @var $card ProductCards */ ?>
<?php /* @var $this ProductsController */ ?>


<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/add_product.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/prod_cards.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-product-form','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'clearfix', 'enctype' => 'multipart/form-data'))); ?>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'product_code');?>
                <?php echo $form->textField($form_mdl,'product_code',array('class'=>'form-control', 'value' => ''));?>
                <?php echo $form->error($form_mdl,'product_code'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'product_name');?>
                <?php echo $form->textField($form_mdl,'product_name',array('class'=>'form-control', 'value' => ''));?>
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
                            <?php echo $form->radioButton($form_mdl,'units',array('value'=>'units','uncheckValue'=>null,'checked'=>true));?>
                            <?php echo $this->labels['units']; ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <?php echo $form->radioButton($form_mdl,'units',array('value'=>'kg','uncheckValue'=>null,'checked'=>false));?>
                            <?php echo $this->labels['kg']; ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <?php echo $form->radioButton($form_mdl,'units',array('value'=>'liters','uncheckValue'=>null,'checked'=>false));?>
                            <?php echo $this->labels['liters']; ?>
                        </label>
                    </div>
                </div>
            </fieldset>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'description');?>
                <?php echo $form->textArea($form_mdl,'description',array('class'=>'form-control', 'value' => ''));?>
                <?php echo $form->error($form_mdl,'description'); ?>
            </div>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'files');?>
                <table class="file-table form-control'">
                    <tr>
                        <td><?php echo $this->labels['label'];?></td>
                        <td><?php echo $this->labels['name'];?></td>
                        <td><?php echo $this->labels['actions'];?></td>
                    </tr>

                    <tr class="file-select">
                        <td colspan="3">
                            <input type="file" name="ProductCardForm[files][0]" class="form-control file-sel" spec-index="0">
                        </td>
                    </tr>
                </table>
                <?php echo $form->error($form_mdl,'files'); ?>
            </div>

            <button type="submit"><span><?php echo $this->labels['save']; ?></span><span class="glyphicon glyphicon-plus"></span></button>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

