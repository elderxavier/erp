<?php /* @var $pager CPagerComponent */ ?>
<?php /* @var $supplier Suppliers */ ?>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th><?php echo $this->labels['personal/company code']; ?></th>
        <th><?php echo $this->labels['name']; ?></th>
        <th><?php echo $this->labels['email']; ?></th>
        <th><?php echo $this->labels['phone']; ?></th>
        <th><?php echo $this->labels['address']; ?></th>
        <th><?php echo $this->labels['actions']; ?></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach($pager->formatted_array as $supplier): ?>
        <tr>
            <td><?php echo $supplier->id;?></td>
            <td><?php echo $supplier->company_code;?></td>
            <td><?php echo $supplier->company_name;?></td>
            <td><?php echo $supplier->email1;?></td>
            <td><?php echo $supplier->phone1;?></td>
            <td><?php echo $supplier->getAddressFormatted(', ') ?></td>
            <td>
                <?php if($this->rights['suppliers_edit']): ?>
                    <?php echo CHtml::link($this->labels['edit'],'/contractors/editsupp/id/'.$supplier->id,array('class' => 'actions action-edit')); ?>
                <?php endif; ?>
                <?php if($this->rights['suppliers_delete']): ?>
                    <?php echo CHtml::link($this->labels['delete'],'/cpntractors/deletesupp/id/'.$supplier->id,array('class' => 'actions action-delete')); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $pager->renderPages(); ?>
