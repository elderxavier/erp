<?php /* @var $this StockController */ ?>
<?php /* @var $products ProductInStock[] */ ?>

<?php if(!empty($products)): ?>
    <?php foreach($products as $item): ?>
        <tr>
            <td><?php echo $item->productCard->product_name; ?></td>
            <td><?php echo $item->productCard->product_code;?></td>
            <td class="quant"><?php echo $item->qnt; ?></td>
            <td>
                <a data-name="<?php echo $item->productCard->product_name; ?>" data-code="<?php echo $item->productCard->product_code;?>" data-quant='<?php echo $item->qnt; ?>' data-dimension="<?php echo $item->productCard->sizeUnits->name; ?>" data-sizes="<?php echo $item->productCard->width.'x'.$item->productCard->height.'x'.$item->productCard->length; ?>" data-wghnet="<?php echo $item->productCard->weight_net; ?>" data-wghgross="<?php echo $item->productCard->weight; ?>" data-unit="<?php echo $item->productCard->measureUnits->name; ?>" data-id="<?php echo $item->productCard->id; ?>" class="btn btn-default btn-sm add-prod clearfix" href="#">
                    <?php echo $this->labels['add to list']; ?>&nbsp;<span class="glyphicon glyphicon-share"></span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else:?>
    <tr>
        <td colspan="4"><?php echo $this->labels['no data']; ?></td>
    </tr>
<?php endif;?>