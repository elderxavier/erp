<?php /* @var $form CActiveForm */ ?>
<?php /* @var $form_mdl UserForm */ ?>
<?php /* @var $this UsersController */ ?>
<?php /* @var $user Users */ ?>
<?php /* @var $positions Array */ ?>
<?php /* @var $roles Array */ ?>


<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/add_user.css');
?>


<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">
                <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-user-form','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'clearfix'))); ?>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'username');?>
                    <?php echo $form->textField($form_mdl,'username',array('class'=>'form-control', 'value' => $user->username));?>
                    <?php echo $form->error($form_mdl,'username'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'password');?>
                    <?php echo $form->textField($form_mdl,'password',array('class'=>'form-control', 'value' => $user->password, 'type' => 'password'));?>
                    <?php echo $form->error($form_mdl,'password'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'repeat_password');?>
                    <?php echo $form->textField($form_mdl,'repeat_password',array('class'=>'form-control', 'value' => $user->password, 'type' => 'password'));?>
                    <?php echo $form->error($form_mdl,'repeat_password'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'email');?>
                    <?php echo $form->textField($form_mdl,'email',array('class'=>'form-control', 'value' => $user->email));?>
                    <?php echo $form->error($form_mdl,'email'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'name');?>
                    <?php echo $form->textField($form_mdl,'name',array('class'=>'form-control', 'value' => $user->name));?>
                    <?php echo $form->error($form_mdl,'name'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'surname');?>
                    <?php echo $form->textField($form_mdl,'surname',array('class'=>'form-control', 'value' => $user->surname));?>
                    <?php echo $form->error($form_mdl,'surname'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'position');?>
                    <?php echo $form->dropDownList($form_mdl,'position_id',$positions,array('class'=>'form-control','options' => array($user->position_id =>array('selected'=>true))));?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'phone');?>
                    <?php echo $form->textField($form_mdl,'phone',array('class'=>'form-control', 'value' => $user->phone));?>
                    <?php echo $form->error($form_mdl,'phone'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'address');?>
                    <?php echo $form->textArea($form_mdl, 'address',array('class'=>'form-control', 'value' => $user->address)); ?>
                    <?php echo $form->error($form_mdl,'address'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'remark');?>
                    <?php echo $form->textArea($form_mdl, 'remark',array('class'=>'form-control', 'value' => $user->remark)); ?>
                    <?php echo $form->error($form_mdl,'remark'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label($form_mdl,'role');?>
                    <?php echo $form->dropDownList($form_mdl,'role',$roles,array('class'=>'form-control','options' => array($user->role =>array('selected'=>true))));?>
                </div>

                <div class="form-group">
                    <label><?php echo $form->label($form_mdl,'rights');?></label>
                </div>



                <fieldset>
                    <legend><?php echo $this->labels['product cards']; ?></legend>
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="products_delete"><?php echo $this->labels['delete'] ?>
                        </label>

                        <label class="checkbox-inline">
                            <input type="checkbox" name="products_edit"><?php echo $this->labels['edit'] ?>
                        </label>

                        <label class="checkbox-inline">
                            <input type="checkbox" name="products_add"><?php echo $this->labels['create'] ?>
                        </label>

                        <label class="checkbox-inline">
                            <input type="checkbox" name="products_see"><?php echo $this->labels['see'] ?>
                        </label>
                    </div><!--/form-group -->
                </fieldset>

                <fieldset>
                    <legend><?php echo $this->labels['product categories']; ?></legend>
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="del">Delete
                        </label>

                        <label class="checkbox-inline">
                            <input type="checkbox" name="del">Edit
                        </label>

                        <label class="checkbox-inline">
                            <input type="checkbox" name="del">Create
                        </label>
                    </div><!--/form-group -->
                </fieldset>

                <fieldset>
                    <legend><?php echo $this->labels['clients']; ?></legend>
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="del">Delete
                        </label>

                        <label class="checkbox-inline">
                            <input type="checkbox" name="del">Edit
                        </label>

                        <label class="checkbox-inline">
                            <input type="checkbox" name="del">Create
                        </label>
                    </div><!--/form-group -->
                </fieldset>

                <fieldset>
                    <legend><?php echo $this->labels['suppliers']; ?></legend>
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="del">Delete
                        </label>

                        <label class="checkbox-inline">
                            <input type="checkbox" name="del">Edit
                        </label>

                        <label class="checkbox-inline">
                            <input type="checkbox" name="del">Create
                        </label>
                    </div><!--/form-group -->
                </fieldset>

                <button type="submit"><span>save</span><span class="glyphicon glyphicon-plus"></span></button>
                <?php $this->endWidget(); ?>
        </div>
    </div>
</div>