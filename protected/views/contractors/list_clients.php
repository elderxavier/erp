<?php /* @var $clients array */ ?>
<?php /* @var $client Clients */ ?>
<?php /* @var $rights UserRights */ ?>
<?php /* @var $this ContractorsController */ ?>
<?php /* @var $table_actions array */ ?>

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
                        <th><?php echo $this->labels['name']; ?></th>
                        <th><?php echo $this->labels['date']; ?></th>
                        <th><?php echo $this->labels['actions'] ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($clients as $client): ?>
                        <tr>
                            <td><?php echo $client->id; ?></td>
                            <td><?php echo $client->name; ?></td>
                            <td><?php echo date('Y.m.d',$client->date_created); ?></td>

                            <td>
                                <?php $this->renderPartial('//partials/_table_actions',array('links' => $table_actions , 'params' => array('id' => $client->id), 'separator' => '')); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!--/table-holder -->
        </div>
    </div>
</div><!--/container -->
