<?php /* @var $this StockController */ ?>
<?php /* @var $products ProductInStock[] */ ?>
<?php /* @var $pages int */ ?>
<?php /* @var $current_page int */ ?>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th><?php echo $this->labels['product name']; ?></th>
        <th><?php echo $this->labels['product code']; ?></th>
        <th><?php echo $this->labels['stock']; ?></th>
        <th><?php echo $this->labels['measure']; ?></th>
        <th><?php echo $this->labels['quantity']; ?></th>
        <th><?php echo $this->labels['refurbished'] ?></th>
        <th><?php echo $this->labels['actions']; ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($products as $nr => $product):?>
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
    <?php endforeach;?>
    </tbody>
</table>

<div class="pages-holder">
    <ul class="paginator">
        <?php for($i = 0; $i < $pages; $i++): ?>
            <li class="<?php if(($i+1) == $current_page): ?>current-page<?php endif; ?> links-pages"><?php echo ($i+1) ?></li>
        <?php endfor; ?>
    </ul>
</div>



