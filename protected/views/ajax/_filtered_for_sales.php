<?php /* @var $items ProductInStock[] */ ?>
<?php /* @var $this AjaxController */ ?>

<?php if(!empty($items)): ?>
    <?php foreach($items as $item): ?>
        <tr>
            <td><?php echo $item->productCard->product_name; ?></td>
            <td><?php echo $item->productCard->product_code; ?></td>
            <td class="quant"><?php echo $item->qnt;?></td>
            <td>
                <?php if($item->stock->location->id == Yii::app()->user->getState('city_id')): ?>
                    <a data-name="<?php echo $item->productCard->product_name; ?>" data-code="<?php echo $item->productCard->product_code; ?>" data-quant='<?php echo $item->qnt;?>' data-unit="vnt" data-id="<?php echo $item->productCard->id;?>" class="btn btn-default btn-sm add-prod clearfix" href="#">
                        <?php echo $this->labels['add to list']; ?>&nbsp;<span class="glyphicon glyphicon-share"></span>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else:?>
    <tr>
        <td colspan="3"><?php echo $this->labels['no data']; ?></td>
    </tr>
<?php endif;?>