<?php /* @var $service ServiceProcesses */ ?>
<?php /* @var $resolution ServiceResolutions */?>
<?php /* @var $problem_type ServiceProblemTypes */ ?>
<?php /* @var $problem_types array */ ?>
<?php /* @var $this ServicesController */ ?>
<?php /* @var $cs CClientScript */ ?>

<?php /* @var $cities array */ ?>
<?php /* @var $workers array */ ?>

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
                <div class="panel-body">
                    <table id="ticket-info" class="table table-bordered">
                        <tbody>
                        <tr>
                            <td><?php echo $this->labels['ticket creator']; ?></td>
                            <td><?php echo $service->userModifiedBy->name.' '.$service->userModifiedBy->surname;?></td>
                            <td><?php echo $this->labels['creation date']; ?></td>
                            <td><?php echo date('Y.m.d H:i',$service->date_created);?></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->labels['worker']; ?></td>
                            <td><?php echo $service->currentEmployee->name.' '.$service->currentEmployee->surname; ?></td>
                            <td>Edit</td>
                            <td></td>
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
                               <span class="label label-success">job done</span>
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
                                    <input type="hidden" name="problem_id" id="ed_problem_typeH" value="<?php echo $service->problem_type_id; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="#" id="ed_msg_ticket" class="editable"><?php echo $service->remark; ?></a>
                                    <input type="hidden" name="remark" id="ed_msg_ticketH" value="<?php echo $service->remark; ?>">
                                </td>
                            </tr>
                        </table>
                    </div><!--/ticket-problem-info -->

                    <hr>
                    <div class="col=md-12 btn-holder">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-danger active">
                                <input type="radio" name="options" id="option1" checked> Option 1
                            </label>
                            <label class="btn btn-danger">
                                <input type="radio" name="options" id="option2"> Option 2
                            </label>
                            <label class="btn btn-danger">
                                <input type="radio" name="options" id="option3"> Option 3
                            </label>
                            <label class="btn btn-danger">
                                <input type="radio" name="options" id="option3"> Option 4
                            </label>
                            <label class="btn btn-danger">
                                <input type="radio" name="options" id="option3"> Option 5
                            </label>
                        </div>
                    </div><!--/btn-holder -->

                    <hr>

                    <div class="col-sm-12 panel panel-default" id="refer_to">
                        <div id="tr_for_to" class=" clearfix form-group">
                            <label class="col-xs-3 col-sm-3 control-label" for="to"><?php echo $this->labels['forwarding']; ?>: </label>

                            <div class="col-sm-4 col-xs-4">
                                <select class="form-control ajax-filter-city">
                                    <?php foreach($cities as $id => $city): ?>
                                        <option value="<?php echo $id; ?>"><?php echo $city; ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>

                            <div class="col-sm-4 col-xs-4">
                                <select class="form-control filtered-users">
                                    <?php foreach($workers as $id => $worker): ?>
                                        <option value="<?php echo $id; ?>"><?php echo $worker; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-1 col-xs-1">
                                <button type="submit"><span class="glyphicon glyphicon-ok"></span></button>
                            </div>
                        </div><!--/tr_for_to -->

                        <div class="text-area_holder col-md-12">
                            <textarea name="resolution_remark"></textarea>
                        </div>
                    </div><!--/refer_to -->
                </div><!--/panel-body -->

            </div><!--/ticket-body -->

            <div class="tabbable">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#home" role="tab" data-toggle="tab">Comments</a></li>
                    <li><a href="#profile" role="tab" data-toggle="tab">ticket history</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <hr>
                    <div class="tab-pane active" id="home">comment</div>
                    <div class="tab-pane" id="profile">History</div>
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
                            <td><?php echo $this->labels['city']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->labels['street']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->labels['house']; ?></td>
                            <td></td>
                        </tr>
                    </table>
                </div><!--/panel-body -->
            </div><!--/customer-info -->
        </div>

    </div><!--row -->
</div>

