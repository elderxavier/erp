<?php /* @var $this StockController */ ?>
<?php /* @var $pages int */ ?>
<?php /* @var $current_page int */ ?>
<?php /* @var $items ProductInStock */ ?>
<?php /* @var $filters array */ ?>

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

<div class="pages-holder">
    <ul class="paginator">
        <?php for($i = 0; $i < $pages; $i++): ?>
            <li class="<?php if(($i+1) == $current_page): ?>current-page<?php endif; ?> links-pages"><?php echo ($i+1) ?></li>
        <?php endfor; ?>
    </ul>
</div>



