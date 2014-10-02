<?php /* @var $this ProductsController */ ?>
<?php /* @var $pager CPagerComponent */ ?>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th><?php echo $this->labels['name']; ?></th>
        <th><?php echo $this->labels['actions'] ?></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach($pager->formatted_array as $category): ?>
        <tr>
            <td><?php echo $category->id; ?></td>
            <td><?php echo $category->name; ?></td>

            <td>
                <?php if($this->rights['products_edit']): ?>
                    <?php echo CHtml::link($this->labels['edit'],'/'.$this->id.'/editcat/id/'.$category->id,array('class' => 'actions action-edit')); ?>
                <?php endif; ?>
                <?php if($this->rights['products_delete']): ?>
                    <?php echo CHtml::link($this->labels['delete'],'/'.$this->id.'/deletecat/id/'.$category->id,array('class' => 'actions action-delete')); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $pager->renderPages(); ?>