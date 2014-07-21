<?php /* @var $ops array */ ?>
<?php /* @var $operation OperationsIn */ ?>
<?php /* @var $this Controller */ ?>

<table border="1" style="width: 100%;">
    <tr>
        <th><?php echo $this->labels['products']; ?></th>
        <th><?php echo $this->labels['quantity'];?></th>
        <th><?php echo $this->labels['price'];?></th>
        <th><?php echo $this->labels['stock'];?></th>
        <th><?php echo $this->labels['date'];?></th>
    </tr>
    <?php foreach($ops as $operation): ?>
        <tr>
            <td><?php echo $operation->productCard->product_name; ?></td>
            <td><?php echo $operation->qnt;?></td>
            <td><?php echo $this->centsToPriceStr($operation->price); ?></td>
            <td><?php echo $operation->stock->name; ?></td>
            <td><?php echo date('Y.m.d',$operation->date); ?></td>
        </tr>
    <?php endforeach;?>
</table>
