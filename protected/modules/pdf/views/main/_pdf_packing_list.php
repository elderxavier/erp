<?php /* @var $movement StockMovements */ ?>
<?php /* @var $this PdfController */ ?>

<html>
<head>
    <title></title>
</head>
<body>

<br><br>
<br><br>
<br><br>
<br><br>
<table width="100%">
    <tr>
        <td align="center" style="vertical-align: bottom;"><span style="font-size: 20px;"><i><?php echo strtoupper($this->labels['packing list']); ?></i></span></td>
    </tr>
</table>
<br>
<table width="100%" height="150">
    <tr>
        <td width="50%">
            <p><b><?php echo $this->labels['from stock']; ?></b></p>
            <p>
                <?php echo $movement->srcStock->name; ?><br>
                UAB "INLUX SERVICE EUROPE"<br>
                <?php echo $this->labels['company code']; ?> 123465465<br>
                <?php echo $movement->srcStock->location->city_name; ?>, <?php echo $movement->srcStock->address.', '.$movement->srcStock->post_code; ?>
            </p>
        </td>
        <td align="right" width="50%">
            <p><b><?php echo $this->labels['to stock']; ?></b></p>
            <p>
                <?php echo $movement->trgStock->name; ?><br>
                UAB "INLUX SERVICE EUROPE"<br>
                <?php echo $this->labels['company code']; ?> 123465465<br>
                <?php echo $movement->trgStock->location->city_name; ?>, <?php echo $movement->trgStock->address.', '.$movement->trgStock->post_code; ?>
            </p>
        </td>
    </tr>
</table>
<br>
<table class="tbl" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td width="50%"><?php echo $this->labels['name']; ?></td>
        <td width="10%"><?php echo $this->labels['quantity']; ?></td>
        <td width="10%"><?php echo $this->labels['dimensions']; ?></td>
        <td width="10%"><?php echo $this->labels['weight net']; ?> (Kg)</td>
        <td width=""><?php echo $this->labels['weight gross']; ?> (Kg)</td>
    </tr>
    <?php foreach($movement->stockMovementItems as $item): ?>
        <tr>
            <td><?php echo $item->productCard->product_name; ?></td>
            <td><?php echo $item->qnt.' ('.$item->productCard->measureUnits->name.')'; ?></td>
            <td><?php echo $item->productCard->width;?>x<?php echo $item->productCard->height; ?>x<?php echo $item->productCard->length; ?> (<?php echo $item->productCard->sizeUnits->name; ?>)</td>
            <td><?php echo $item->productCard->weight_net/1000; ?></td>
            <td><?php echo $item->productCard->weight/1000; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<table width="100%">
    <tr>
        <td align="right"><b><?php echo strtoupper($this->labels['total net weight']); ?></b></td>
        <td align="right"><?php echo $movement->calculateTotalWeight(true,true); ?> kg</td>
    </tr>
    <tr>
        <td align="right"><b><?php echo strtoupper($this->labels['total gross weight']); ?></b></td>
        <td align="right"><?php echo $movement->calculateTotalWeight(false,true); ?>  kg</td>
    </tr>
</table>

</body>
</html>