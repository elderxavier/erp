<?php

/* @var $cs CClientScript */
/* @var $this SellController */
/* @var $form CActiveForm */
/* @var $form_mdl ClientForm */
?>

<div class="modal new-customer-juridical" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <?php if($form_mdl->hasErrors() && $form_mdl->company == 1):?><div class="opened-modal-new-customer-juridical"></div><?php endif; ?>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header clearfix">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $this->labels['close']; ?></span></button>
                <h4 class="modal-title"><?php echo $this->labels['new juridical client']; ?></h4>
            </div><!--/modal-header -->
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-product-form','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'clearfix'))); ?>
            <div class="modal-body">


                <div class="form-group">
                    <?php echo $form->label($form_mdl,'company_name');?>
                    <?php echo $form->textField($form_mdl,'company_name',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'company_name'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'company_code');?>
                    <?php echo $form->textField($form_mdl,'company_code',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'company_code'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'vat_code');?>
                    <?php echo $form->textField($form_mdl,'vat_code',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'vat_code'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'phone1');?>
                    <?php echo $form->textField($form_mdl,'phone1',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'phone1'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'email1');?>
                    <?php echo $form->textField($form_mdl,'email1',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'email1'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'remark');?>
                    <?php echo $form->textArea($form_mdl,'remark',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'remark'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'remark_for_service');?>
                    <?php echo $form->textArea($form_mdl,'remark_for_service',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'remark_for_service'); ?>
                </div>

                <input type="hidden" name="ClientForm[company]" value="1">

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'country');?>
                    <?php echo $form->textField($form_mdl,'country',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'country'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'city');?>
                    <?php echo $form->textField($form_mdl,'city',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'city'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'street');?>
                    <?php echo $form->textField($form_mdl,'street',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'street'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'building_nr');?>
                    <?php echo $form->textField($form_mdl,'building_nr',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'building_nr'); ?>
                </div>
            </div><!--/modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->labels['close']; ?><span class="glyphicon glyphicon-thumbs-down"></span></button>
                <button type="submit" class="btn btn-primary"><?php echo $this->labels['continue']; ?><span class="glyphicon glyphicon-share-alt"></span></button>
            </div><!--/modal-footer -->
            <?php $this->endWidget(); ?>
        </div><!--/modal-content -->
    </div><!--/modal-dioalog -->
</div><!--/moda new-customer -->