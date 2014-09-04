<?php /* @var $this StockController */ ?>
<?php /* @var $items ProductInStock[] */ ?>

<?php foreach($items as $nr => $product): ?>
    <tr>
        <td><?php echo $nr; ?></td>
        <td><?php echo $product->productCard->product_name;?></td>
        <td><?php echo $product->productCard->product_code;?></td>
        <td><?php echo $product->stock->name." [".$product->stock->location->city_name."]"; ?></td>
        <td><?php echo $product->productCard->units; ?></td>
        <td><?php echo $product->qnt;?></td>
        <td>0</td>
        <td></td>
    </tr>
<?php endforeach; ?>



