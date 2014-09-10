<?php /* @var $this StockController */ ?>
<?php /* @var $items ProductInStock */ ?>
<?php /* @var $filters array */ ?>
<?php /* @var $pager CPagerComponent */ ?>

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
    <?php foreach($items as $nr => $product): ?>
        <tr>
            <td><?php echo $nr; ?></td>
            <td><?php echo $product->productCard->product_name;?></td>
            <td><?php echo $product->productCard->product_code;?></td>
            <td><?php echo $product->stock->name." [".$product->stock->location->city_name."]"; ?></td>
            <td><?php echo $product->productCard->measureUnits->name; ?></td>
            <td><?php echo $product->qnt;?></td>
            <td>0</td>
            <td></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $pager->renderPages(); ?>


