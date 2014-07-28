<?php /* @var $service ServiceProcesses */ ?>
<?php /* @var $services array */ ?>
<?php /* @var $this ServicesController */ ?>
<?php /* @var $cs CClientScript */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/tickets_list.css');
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <div class="row widgets-holder">
                <div class="col-lg-6 col-md-6 widget1 wdg">1</div><!--/widget1 -->
                <div class="col-lg-6 col-md-6 widget2 wdg">2</div><!--/widget2 -->
            </div>

            <div class="table-holder">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->labels['priority']; ?></th>
                        <th><?php echo $this->labels['problem']; ?></th>
                        <th><?php echo $this->labels['client']; ?></th>
                        <th><?php echo $this->labels['created']; ?></th>
                        <th><?php echo $this->labels['creator']; ?></th>
                        <th><?php echo $this->labels['worker'];?></th>
                        <th><?php echo $this->labels['time left'];?></th>
                        <th><?php echo $this->labels['status'];?></th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($services as $service): ?>
                        <tr>
                            <td><?php echo $service->id; ?></td>
                            <td><?php echo $service->priority; ?></td>
                            <td><?php echo $service->problemType->label; ?></td>
                            <td><?php echo $service->client->type == 0 ? $service->client->name.' '.$service->client->surname : $service->client->company_name; ?></td>
                            <td><?php echo time('Y.m.d',$service->date_created); ?></td>
                            <td><?php echo $service->userModifiedBy->name.' '.$service->userModifiedBy->surname; ?></td>
                            <td><?php echo $service->currentEmployee->name.' '.$service->currentEmployee->surname; ?></td>
                            <td><?php echo $service->timeLeft('days d hours h minutes m seconds s'); ?></td>
                            <td><?php echo $service->statusLabel(); ?></td>

                            <td>
                                <?php if($this->rights['services_delete']): ?>
                                    <?php echo CHtml::link($this->labels['close'],'/services/close/id/'.$service->id,array('class' => 'actions action-delete')); ?>
                                <?php endif; ?>

                                <?php if($this->rights['services_edit']): ?>
                                    <?php echo CHtml::link($this->labels['edit'],'/services/edit/id/'.$service->id,array('class' => 'actions action-edit')); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!--/table-holder -->
        </div>
    </div>
</div><!--/container -->