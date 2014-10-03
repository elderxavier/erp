<?php /* @var $this ProductsController */ ?>
<?php /* @var $pager CPagerComponent */ ?>

    <table class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th><?php echo $this->labels['product code']; ?></th>
            <th><?php echo $this->labels['name']; ?></th>
            <th><?php echo $this->labels['category']; ?></th>
            <th><?php echo $this->labels['dimension units']; ?></th>
            <th class="status"><?php echo $this->labels['status']; ?></th>
            <th><?php echo $this->labels['actions'] ?></th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($pager->formatted_array as $card): ?>
            <tr>
                <td><?php echo $card->id; ?></td>
                <td><?php echo $card->product_code; ?></td>
                <td><?php echo $card->product_name; ?></td>
                <td><?php echo $card->category->name; ?></td>
                <td><?php echo $card->measureUnits->name; ?></td>

                <td class="status">
                    <div prod_id ="<?php echo $card->id; ?>" state="<?php echo $card->status; ?>" class="btn-group btn-toggle">
                        <button class="btn <?php if($card->status == 1):?>active btn-primary<?php else: ?>btn-default<?php endif; ?>">ON</button>
                        <button class="btn <?php if($card->status == 0):?>active btn-primary<?php else: ?>btn-default<?php endif; ?>">OFF</button>
                    </div>
                </td>

                <td>
                    <?php if($this->rights['products_edit']): ?>
                        <?php echo CHtml::link($this->labels['edit'],'/'.$this->id.'/editcard/id/'.$card->id,array('class' => 'actions action-edit')); ?>
                    <?php endif; ?>
                    <?php if($this->rights['products_delete']): ?>
                        <?php echo CHtml::link($this->labels['delete'],'/'.$this->id.'/deletecard/id/'.$card->id,array('class' => 'actions action-delete')); ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php $pager->renderPages(); ?>