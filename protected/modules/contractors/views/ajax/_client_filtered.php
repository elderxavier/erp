<?php /* @var $pager CPagerComponent */ ?>
<?php /* @var $client Clients */ ?>

    <table class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th><?php echo $this->labels['personal / company code']; ?></th>
            <th><?php echo $this->labels['type']; ?></th>
            <th><?php echo $this->labels['name']; ?></th>
            <th><?php echo $this->labels['email']; ?></th>
            <th><?php echo $this->labels['phone']; ?></th>
            <th><?php echo $this->labels['address']; ?></th>
            <th><?php echo $this->labels['actions']; ?></th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($pager->formatted_array as $client): ?>
            <tr>
                <td><?php echo $client->id; ?></td>
                <td><?php echo $client->type == 1 ? $client->company_code : $client->personal_code; ?></td>
                <td><?php echo $client->type == 1 ? $this->labels['juridical'] : $this->labels['physical']; ?></td>
                <td><?php echo $client->type == 1 ? $client->company_name : $client->name.' '.$client->surname; ?></td>
                <td><?php echo $client->email1; ?></td>
                <td><?php echo $client->phone1; ?></td>
                <td><?php echo $client->getAddressFormatted(', '); ?></td>
                <td>
                    <?php if($this->rights['clients_edit']): ?>
                        <?php echo CHtml::link($this->labels['edit'],'/contractors/editclient/id/'.$client->id,array('class' => 'actions action-edit')); ?>
                    <?php endif; ?>
                    <?php if($this->rights['clients_delete']): ?>
                        <?php echo CHtml::link($this->labels['delete'],'/contractors/deleteclient/id/'.$client->id,array('class' => 'actions action-delete')); ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php $pager->renderPages(); ?>