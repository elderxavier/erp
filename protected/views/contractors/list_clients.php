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
                        <th><?php echo $this->labels['personal code']; ?></th>
                        <th><?php echo $this->labels['company']; ?></th>
                        <th><?php echo $this->labels['name']; ?></th>
                        <th><?php echo $this->labels['date of contract']; ?></th>
                        <th><?php echo $this->labels['signer name']; ?></th>
                        <th><?php echo $this->labels['phone']; ?></th>
                        <th><?php echo $this->labels['email']; ?></th>
                        <th><?php echo $this->labels['payment method']; ?></th>
                        <th><?php echo $this->labels['next service date']; ?></th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($clients as $client): ?>
                        <tr>
                            <td><?php echo $client->id; ?></td>
                            <td><?php echo $client->type = 1 ? $client->company_code : $client->personal_code; ?></td>
                            <td><?php echo $client->type = 1 ? $this->labels['yes'] : $this->labels['no']; ?></td>
                            <td><?php echo $client->firstInvoice ? date('Y.m.d',$client->firstInvoice->date_created) : '-'; ?></td>
                            <td><?php echo $client->firstInvoice ? $client->firstInvoice->signer_name : '-'; ?></td>
                            <td><?php echo $client->phone1; ?></td>
                            <td><?php echo $client->email1; ?></td>
                            <td><?php echo $client->firstInvoice ? $client->firstInvoice->paymentMethod->name : '-'; ?></td>
                            <td><?php echo $client->nextService ? $client->next_service_date : '-'; ?></td>
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
