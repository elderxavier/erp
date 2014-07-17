    <?php $count=1; foreach($objProds as $prod):?>
    	<tr>
        	<td><?php echo $count ?></td>
            <td><?php echo $prod->product_code?></td>
            <td><?php echo $prod->product_name ?></td>
            <td><?php echo $prod->category->name ?>t</td>
            <td><?php echo $this->labels[$prod->units]; ?></td>
            
            <td class="status">
                <div prod_id ="<?php echo $prod->id; ?>" state="<?php echo $prod->status; ?>" class="btn-group btn-toggle">
                    <button class="btn <?php if($prod->status == 1):?>active btn-primary<?php else: ?>btn-default<?php endif; ?>">ON</button>
                    <button class="btn <?php if($prod->status == 0):?>active btn-primary<?php else: ?>btn-default<?php endif; ?>">OFF</button>
                </div>
            </td>
            
            <td>
                <?php if($this->rights['products_edit']): ?>
                    <?php echo CHtml::link($this->labels['edit'],'/products/editcard/'.$prod->id,array('class' => 'actions action-edit')); ?>
                <?php endif; ?>
                <?php if($this->rights['products_delete']): ?>
                    <?php echo CHtml::link($this->labels['delete'],'/products/deletecard/'.$prod->id,array('class' => 'actions action-delete')); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php $count++; endforeach;?>
    
