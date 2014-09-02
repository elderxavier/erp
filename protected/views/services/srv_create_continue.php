<?php /* @var $this ServicesController */ ?>
<?php /* @var $cs CClientScript */ ?>

<?php /* @var $form_mdl ServiceForm */?>
<?php /* @var $form CActiveForm */ ?>

<?php /* @var $problems Array */ ?>
<?php /* @var $cities Array */ ?>
<?php /* @var $workers Array */ ?>
<?php /* @var $client Clients */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap-editable.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/tickets_card.css');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap-datepicker.js',CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/service_continue.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row card-holder">

        <?php $form=$this->beginWidget('CActiveForm', array('enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'clearfix'))); ?>

            <div class="col-lg-5 col-md-5 col-sm-6 right-part">
                <div class="form-holder">
                    <h2><span class="glyphicon glyphicon-user"></span><?php echo $this->labels['customer information']; ?></h2>
                    <h3><?php echo $client->getFullName(); ?></h3>

                    <div class="cust-data">
                        <table width="100%">
                            <tr>
                                <td width="35%"><?php echo $this->labels['client type']; ?></td>
                                <td width="65%"><a id="ed_Type" href="#" style="display:inline"><?php echo $client->typeObj->name; ?></a></td>
                            </tr>
                            <tr>
                                <td><?php echo $this->labels['name']; ?></td>
                                <td><a href="#"><?php echo $client->name; ?></a></td>
                            </tr>

                            <tr>
                                <td><?php echo $this->labels['surname']; ?></td>
                                <td><a href="#"><?php echo $client->surname; ?></a></td>
                            </tr>

                            <tr>
                                <td><?php echo $this->labels['vat code']; ?></td>
                                <td><a href="#"><?php echo $client->vat_code; ?></a></td>
                            </tr>

                            <tr>
                                <td><?php echo $client->type == 0 ? $this->labels['personal code'] : $this->labels['company code']; ?></td>
                                <td><a href="#"><?php echo $client->getActiveCode(); ?></a></td>
                            </tr>

                            <tr>
                                <td><?php echo $this->labels['country'] ?></td>
                                <td><a  href="#"><?php echo $client->country; ?></a></td>
                            </tr>

                            <tr>
                                <td><?php echo $this->labels['city'] ?></td>
                                <td><a  href="#"><?php echo $client->city; ?></a></td>
                            </tr>

                            <tr>
                                <td><?php echo $this->labels['street'] ?></td>
                                <td><a href="#"><?php echo $client->street; ?></a></td>
                            </tr>

                            <tr>
                                <td><?php echo $this->labels['house']; ?></td>
                                <td><a href="#"><?php echo $client->building_nr; ?></a></td>
                            </tr>
                        </table>
                    </div><!--/cust-data -->
                </div><!--/form holder-->
            </div><!--/right -->

            <div class="col-lg-6 col-md-6 col-sm-6 left-part">
                <div class="form-holder">
                    <h5><?php echo $this->labels['client']; ?>: <?php echo $client->getFullName(); ?></h5>
                    <hr/>

                    <div class="form-group">
                        <?php echo $form->label($form_mdl,'problem_type_id');?>
                        <?php echo $form->dropDownList($form_mdl,'problem_type_id',$problems,array('class'=>'form-control'));?>
                    </div><!--/form-group -->

                    <div class="form-group">
                        <?php echo $form->label($form_mdl,'remark');?>
                        <?php echo $form->textArea($form_mdl,'remark',array('class' => 'form-control'));?>
                        <?php echo $form->error($form_mdl,'remark'); ?>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12 assign-section-wrapper">
                            <div><h5><?php echo $this->labels['assign job to']; ?>:</h5></div>
                            <div  class="col-sm-6">
                                <?php echo $form->label($form_mdl,'city_id');?>
                                <?php echo $form->dropDownList($form_mdl,'city_id',$cities,array('class'=>'form-control ajax-filter-city'));?>
                            </div>
                            <div class="col-sm-6">
                                <?php echo $form->label($form_mdl,'worker_id');?>
                                <?php echo $form->dropDownList($form_mdl,'worker_id',$workers,array('class'=>'form-control filtered-users'));?>
                            </div>
                        </div>
                        <div class="col-sm-12 assign-section-wrapper">
                            <div class="clearfix"><h5><?php echo $this->labels['select time'];?>:</h5></div>
                            <div class="col-sm-6">
                                <?php echo $form->label($form_mdl,'start_date');?>
                                <?php echo $form->textField($form_mdl,'start_date',array('class' => 'form-control date-picker-srv')) ?>
                                <?php echo $form->error($form_mdl,'start_date'); ?>
                            </div>
                            <div class="col-sm-6">
                                <?php echo $form->label($form_mdl,'close_date');?>
                                <?php echo $form->textField($form_mdl,'close_date',array('class' => 'form-control date-picker-srv')) ?>
                                <?php echo $form->error($form_mdl,'close_date'); ?>
                            </div>
                        </div><!--/asign-section-wrapper -->
                    </div><!--/row -->
                    <hr/>

                    <div class="form-group prioty-btn">
                        <?php echo $form->label($form_mdl,'select priority');?>
                        <div class="col-xs-12 btn-group" data-toggle="buttons">
                            <label class="btn btn-primary active">
                                <input type="radio" name="ServiceForm[priority]" value="low" id="option1" checked> <?php echo $this->labels['low']; ?>
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="ServiceForm[priority]" value="medium" id="option2"> <?php echo $this->labels['medium']; ?>
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="ServiceForm[priority]" value="high" id="option3"> <?php echo $this->labels['high']; ?>
                            </label>
                        </div>
                    </div><!--/form-group -->


                </div><!--/form-holder -->
            </div><!--/left -->
            <div class="btn-holder col-sm-12 clearfix">
                <button class="btn-submit" type="submit"><span><?php echo $this->labels['create ticket']; ?></span><span class="glyphicon glyphicon-chevron-right"></span></button>
                <button class="btn-reset" type="reset"><span><?php echo $this->labels['reset fields']; ?></span> <span class="glyphicon glyphicon-remove"></span></button>
            </div><!--/btn-holder -->
        <?php $this->endWidget(); ?>
    </div><!--row -->
</div><!--/container -->