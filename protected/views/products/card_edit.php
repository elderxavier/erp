<?php /* @var $form CActiveForm */ ?>
<?php /* @var $form_mdl ProductCardForm */ ?>
<?php /* @var $categories_arr Array */ ?>
<?php /* @var $card ProductCards */ ?>
<?php /* @var $this ProductsController */ ?>
<?php /* @var $cs CClientScript */ ?>
<?php /* @var $file ProductFiles */ ?>

<?php /* @var $s_units array */ ?>
<?php /* @var $m_units array */ ?>

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
                <legend><?php echo $form->label($form_mdl,'units'); ?></legend>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'measure_units');?>
                    <?php echo $form->dropDownList($form_mdl,'measure_units_id',$m_units,array('class'=>'form-control','options' => array($card->measure_units_id =>array('selected'=>true))));?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'weight');?>
                    <?php echo $form->textField($form_mdl,'weight',array('class'=>'form-control', 'value' => $card->weight));?>
                    <?php echo $form->error($form_mdl,'weight'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'weight_net');?>
                    <?php echo $form->textField($form_mdl,'weight_net',array('class'=>'form-control', 'value' => $card->weight_net));?>
                    <?php echo $form->error($form_mdl,'weight_net'); ?>
                </div>
            </fieldset>
            <br>
            <fieldset>
                <legend><?php echo $form->label($form_mdl,'sizes'); ?></legend>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'size_units');?>
                    <?php echo $form->dropDownList($form_mdl,'size_units_id',$s_units,array('class'=>'form-control','options' => array($card->size_units_id =>array('selected'=>true))));?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'width');?>
                    <?php echo $form->textField($form_mdl,'width',array('class'=>'form-control', 'value' => $card->width));?>
                    <?php echo $form->error($form_mdl,'width'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'height');?>
                    <?php echo $form->textField($form_mdl,'height',array('class'=>'form-control', 'value' => $card->height));?>
                    <?php echo $form->error($form_mdl,'height'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'length');?>
                    <?php echo $form->textField($form_mdl,'length',array('class'=>'form-control', 'value' => $card->length));?>
                    <?php echo $form->error($form_mdl,'length'); ?>
                </div>
            </fieldset>

            <div class="form-group">
                <?php echo $form->label($form_mdl,'description');?>
                <?php echo $form->textArea($form_mdl,'description',array('class'=>'form-control', 'value' => $card->description));?>
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

                    <?php foreach($card->productFiles as $file): ?>
                        <tr id="file_id_<?php echo $file->id; ?>">
                            <td><?php echo $file->label; ?></td>
                            <td><?php echo $file->filename; ?></td>
                            <td><?php echo CHtml::link($this->labels['delete'],'/ajax/delfile/id/'.$file->id,array('class' => 'actions action-delete  ajax-del-file', 'spec-id' =>$file->id)); ?></td>
                        </tr>
                    <?php endforeach; ?>

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