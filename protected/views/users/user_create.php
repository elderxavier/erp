<?php /* @var $form CActiveForm */ ?>
<?php /* @var $form_mdl UserForm */ ?>
<?php /* @var $this UsersController */ ?>
<?php /* @var $user Users */ ?>
<?php /* @var $positions Array */ ?>
<?php /* @var $roles Array */ ?>
<?php /* @var $cities Array*/ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/add_user.css');
?>


<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">
                <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-user-form','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'clearfix', 'enctype'=>'multipart/form-data'))); ?>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'username');?>
                    <?php echo $form->textField($form_mdl,'username',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'username'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'password');?>
                    <?php echo $form->textField($form_mdl,'password',array('class'=>'form-control', 'type' => 'password'));?>
                    <?php echo $form->error($form_mdl,'password'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'repeat_password');?>
                    <?php echo $form->textField($form_mdl,'repeat_password',array('class'=>'form-control', 'type' => 'password'));?>
                    <?php echo $form->error($form_mdl,'repeat_password'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'email');?>
                    <?php echo $form->textField($form_mdl,'email',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'email'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'name');?>
                    <?php echo $form->textField($form_mdl,'name',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'name'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'surname');?>
                    <?php echo $form->textField($form_mdl,'surname',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'surname'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'position');?>
                    <?php echo $form->dropDownList($form_mdl,'position_id',$positions,array('class'=>'form-control'));?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'phone');?>
                    <?php echo $form->textField($form_mdl,'phone',array('class'=>'form-control'));?>
                    <?php echo $form->error($form_mdl,'phone'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'address');?>
                    <?php echo $form->textArea($form_mdl, 'address',array('class'=>'form-control')); ?>
                    <?php echo $form->error($form_mdl,'address'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'remark');?>
                    <?php echo $form->textArea($form_mdl, 'remark',array('class'=>'form-control')); ?>
                    <?php echo $form->error($form_mdl,'remark'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'role');?>
                    <?php echo $form->dropDownList($form_mdl,'role',$roles,array('class'=>'form-control'));?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'city_id');?>
                    <?php echo $form->dropDownList($form_mdl,'city_id',$cities,array('class'=>'form-control'));?>
                </div>

                <div class="form-group">
                    <label><?php echo $form->label($form_mdl,'rights');?></label>
                </div>

                <?php $this->renderPartial('//partials/_right_edit_list',array('all_rights' => $this->GetRightsSettings(),'current_rights' => array(),'form_name' => 'UserForm')); ?>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'avatar');?>
                    <?php echo $form->fileField($form_mdl,'avatar', array('class' => 'form-control')); ?>
                    <?php echo $form->error($form_mdl,'avatar'); ?>
                </div>

                <button type="submit"><span><?php echo $this->labels['save'] ?></span><span class="glyphicon glyphicon-plus"></span></button>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>