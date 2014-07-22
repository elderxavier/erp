<?php /* @var $service ServiceProcesses */ ?>
<?php /* @var $services array */ ?>
<?php /* @var $this ServicesController */ ?>
<?php /* @var $cs CClientScript */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/table.css');
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <div class="table-holder">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->labels['opened']; ?></th>
                        <th><?php echo $this->labels['closed']; ?></th>
                        <th><?php echo $this->labels['status']; ?></th>
                        <th><?php echo $this->labels['problem']; ?></th>
                        <th><?php echo $this->labels['problem code']; ?></th>
                        <th><?php echo $this->labels['remark'];?></th>
                        <th><?php echo $this->labels['product code'];?></th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($services as $service): ?>
                        <tr>
                            <td><?php echo $service->id; ?></td>
                            <td><?php echo date('Y.m.d',$service->start_date); ?></td>
                            <td><?php echo date('Y.m.d',$service->close_date); ?></td>
                            <td><?php echo $service->statusLabel();?></td>
                            <td><?php echo $service->problemType->label;?></td>
                            <td><?php echo $service->problemType->problem_code;?></td>
                            <td><?php echo $service->remark; ?></td>
                            <td><?php echo $service->operation ? $service->operation->productCard->product_code : '-'; ?></td>

                            <td>
                                <?php if($this->rights['services_delete']): ?>
                                    <?php echo CHtml::link($this->labels['close'],'/services/close/id/'.$service->id,array('class' => 'actions action-delete')); ?>
                                <?php endif; ?>

                                <?php if($this->rights['services_edit']): ?>
                                    <?php echo CHtml::link($this->labels['close'],'/services/reopen/id/'.$service->id,array('class' => 'actions action-edit')); ?>
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