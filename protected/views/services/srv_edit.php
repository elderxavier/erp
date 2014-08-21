<?php /* @var $service ServiceProcesses */ ?>
<?php /* @var $resolution ServiceResolutions */?>
<?php /* @var $problem_type ServiceProblemTypes */ ?>
<?php /* @var $problem_types array */ ?>
<?php /* @var $this ServicesController */ ?>
<?php /* @var $cs CClientScript */ ?>
<?php /* @var $status ServiceProcessStatuses */ ?>

<?php /* @var $form_mdl SrvEditForm */ ?>
<?php /* @var $form CActiveForm */ ?>

<?php /* @var $cities array */ ?>
<?php /* @var $workers array */ ?>
<?php /* @var $statuses array */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/tickets_info.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap-editable.css');

$cs->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap-editable.js',CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/ticket_info.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row card-holder">
        <div id="#left-side" class="col-md-8">
            <div id="ticket_body" class="panel panel-default">
                <div class="panel-heading">
                    <h3><span class="glyphicon glyphicon-tasks"></span><?php echo $this->labels['ticket code']; ?><strong><?php echo $service->label; ?></strong></h3>
                </div><!--/panel-heading -->

                <?php $form=$this->beginWidget('CActiveForm', array('enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>''))); ?>

                <div class="panel-body">
                    <table id="ticket-info" class="table table-bordered">
                        <tbody>
                        <tr>
                            <td><?php echo $this->labels['ticket creator']; ?></td>
                            <td><?php echo $service->userCreatedBy->name.' '.$service->userCreatedBy->surname;?></td>
                            <td><?php echo $this->labels['creation date']; ?></td>
                            <td><?php echo date('Y.m.d H:i',$service->date_created);?></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->labels['worker']; ?></td>
                            <td><?php echo $service->currentEmployee->name.' '.$service->currentEmployee->surname; ?></td>
                            <td><?php echo $this->labels['last edit by']; ?></td>
                            <td><?php echo $service->userModifiedBy->name.' '.$service->userModifiedBy->surname;?></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->labels['client']; ?></td>
                            <td><?php echo $service->client->type == 1 ? $service->client->company_name : $service->client->name.' '.$service->client->surname; ?></td>
                            <td><?php echo $this->labels['last update'];?></td>
                            <td><?php echo date('Y.m.d H:i',$service->date_changed); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->labels['status']; ?></td>
                            <td>
                               <?php foreach($statuses as $status): ?>
                                   <?php if($status->id == $service->status->id): ?>
                                       <?php $class = "label-danger"; ?>
                                       <?php $status->system_id == 'SYS_CLOSED' ? $class = "label-success" : $class = "label-danger"; ?>
                                       <span class="label <?php echo $class; ?>"><?php echo $status->status_name; ?></span>
                                   <?php endif?>
                               <?php endforeach;?>
                            </td>
                            <td><?php echo $this->labels['priority']; ?></td>
                            <td>
                                <?php if($service->priority == 'low'): ?>
                                    <span class="label label-success"><?php echo $service->priority; ?></span>
                                <?php elseif($service->priority == 'medium'): ?>
                                    <span class="label label-success"><?php echo $service->priority; ?></span>
                                <?php elseif($service->priority == 'high'): ?>
                                    <span class="label label-danger"><?php echo $service->priority; ?></span>
                                <?php endif;?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>

                    <div id="ticket-problem-info" class="panel panel-default">
                        <table class="table table-bordered">
                            <tr>
                                <td><?php echo $this->labels['problem type']; ?></td>
                                <td>
                                    <a id="ed_problem_type" href="#" class="editable-prb" data-value="<?php echo $service->problem_type_id; ?>" data-source='<?php echo $problem_types; ?>' style="display:inline"></a>
                                    <input type="hidden" name="SrvEditForm[problem_type_id]" id="ed_problem_typeH" value="<?php echo $service->problem_type_id; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="#" id="ed_msg_ticket" class="editable"><?php echo $service->remark; ?></a>
                                    <input type="hidden" name="SrvEditForm[remark]" id="ed_msg_ticketH" value="<?php echo $service->remark; ?>">
                                </td>
                            </tr>
                        </table>
                    </div><!--/ticket-problem-info -->

                    <hr>
                    <div class="col=md-12 btn-holder">
                        <div class="btn-group" data-toggle="buttons">
                            <?php foreach($statuses as $status): ?>
                                <label class="btn btn-danger <?php if($status->id == $service->status->id): ?> active <?php endif;?>">
                                    <input type="radio" name="SrvEditForm[status]" value="<?php echo $status->id; ?>" id="option1" <?php if($status->id == $service->status->id): ?> checked <?php endif;?>> <?php echo $status->status_name; ?>
                                </label>
                            <?php endforeach;?>
                        </div>
                    </div><!--/btn-holder -->
                    <hr>

                    <div class="col-sm-12 panel panel-default" id="refer_to">
                        <div id="tr_for_to" class=" clearfix form-group">
                            <label class="col-xs-3 col-sm-3 control-label" for="to"><?php echo $this->labels['forwarding']; ?>: </label>

                            <div class="col-sm-4 col-xs-4">
                                <?php echo $form->dropDownList($form_mdl,'city_id',$cities,array('class'=>'form-control ajax-filter-city'));?>
                            </div>

                            <div class="col-sm-4 col-xs-4">
                                <?php echo $form->dropDownList($form_mdl,'worker_id',$workers,array('class'=>'form-control filtered-users'));?>
                            </div>

                            <div class="col-sm-1 col-xs-1">
                                <button type="submit"><span class="glyphicon glyphicon-ok"></span></button>
                            </div>
                        </div><!--/tr_for_to -->

                        <div class="text-area_holder col-md-12">
                            <?php echo $form->textArea($form_mdl,'message_to_worker');?>
                            <?php echo $form->error($form_mdl,'message_to_worker'); ?>
                        </div>
                    </div><!--/refer_to -->
                </div><!--/panel-body -->

                <?php $this->endWidget(); ?>

            </div><!--/ticket-body -->

            <div class="tabbable">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#home" role="tab" data-toggle="tab">Comments</a></li>
                    <li><a href="#profile" role="tab" data-toggle="tab"><?php echo $this->labels['ticket history']; ?></a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <hr>
                    <div class="tab-pane active" id="home">
                        comments
                    </div>
                    <div class="tab-pane" id="profile">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->labels['worker']; ?></th>
                                <th><?php echo $this->labels['status']; ?></th>
                                <th><?php echo $this->labels['created']; ?></th>
                                <th><?php echo $this->labels['changed']; ?></th>
                                <th><?php echo $this->labels['actions']; ?></th>
                            </tr>
                            <?php foreach($service->serviceResolutions as $resolution): ?>
                            <tr>
                                <td><?php echo $resolution->id; ?></td>
                                <td><?php echo $resolution->byEmployee->name.' '.$resolution->byEmployee->surname; ?></td>
                                <td><?php echo $resolution->statusLabel(); ?></td>
                                <td><?php echo date('Y.m.d',$resolution->date_created);?></td>
                                <td><?php echo date('Y.m.d',$resolution->date_changed);?></td>
                                <td>
                                    <?php echo CHtml::link($this->labels['view'],'/ajax/resolutionview/id/'.$resolution->id,array('class' => 'actions action-edit modal-link-opener', 'title' => $this->labels['information'])); ?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                            </thead>
                        </table>
                    </div>
                </div>
            </div><!--/tabbable -->
        </div>


        <div class="col-md-4">
            <div id="customor_info" class="panel panel-default">
                <div class="panel-heading">
                    <h4><span class="glyphicon glyphicon-user"></span><?php echo $this->labels['customer information']; ?></h4>
                </div><!--/panel-heading -->
                <div class="panel-body">
                    <h4><?php echo $service->client->type == 1 ? $service->client->company_name : $service->client->name.' '.$service->client->surname; ?></h4>
                    <table width="100%">
                        <tr>
                            <td><?php echo $this->labels['client type']; ?></td>
                            <td><?php echo $service->client->type == 1 ? $this->labels['juridical'] : $this->labels['physical']; ?></td>
                        </tr>
                        <?php if($service->client->type == 0): ?>
                        <tr>
                            <td><?php echo $this->labels['personal code']; ?></td>
                            <td><?php echo $service->client->personal_code; ?></td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <td><?php echo $this->labels['company code']; ?></td>
                            <td><?php echo $service->client->company_code; ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td><?php echo $this->labels['vat code']; ?></td>
                            <td><?php echo $service->client->vat_code; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->labels['phone']; ?></td>
                            <td><?php echo $service->client->phone1; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->labels['email']; ?></td>
                            <td><?php echo $service->client->email1; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->labels['country']; ?></td>
                            <td><?php echo $service->client->country; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->labels['city']; ?></td>
                            <td><?php echo $service->client->city; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->labels['street']; ?></td>
                            <td><?php echo $service->client->street; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->labels['house']; ?></td>
                            <td><?php echo $service->client->building_nr; ?></td>
                        </tr>
                    </table>
                </div><!--/panel-body -->
            </div><!--/customer-info -->
        </div>

    </div><!--row -->
</div>

