<?php /* @var $operation OperationsOut */ ?>
<?php /* @var $this PdfController */ ?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<table width="100%">
    <tr>
        <td style="vertical-align: top;" height="80px" width="50%">
            <img src="/img/invoice_op_logo.png" width="250">
        </td>
        <td style="vertical-align: top;" height="80px" align="right" width="50%">
            <b><?php echo $this->labels['vat invoice']; ?></b><br>
            <i><?php echo $this->labels['invoice']; ?></i><br>
            <span style="font-size: 12px"><?php echo $this->labels['invoice code']; ?> <?php echo $operation->invoice_code; ?> <br><?php echo date('Y.m.d',$operation->invoice_date); ?></span>
        </td>
    </tr>
</table>
<br><br>
<table width="100%" cellspacing="0">
    <tr>
        <td class="seller-td-top" style="background-color: #d5d5d5;" align="center" width="45%"><b><u><?php echo $this->labels['seller']; ?></u></b></td>
        <td width="10%"></td>
        <td class="seller-td-top" style="background-color: #d5d5d5;" align="center" width="45%"><b><u><?php echo $this->labels['customer']; ?></u></b></td>
    </tr>
    <tr>
        <td class="seller-td-bottom" align="center" height="100px" width="45%">
            <b>
                UAB "INLUX SERVICE EUROPE"<br>
                Imones kodas 126105899<br>
                PVM moketojo kodas LT261058917<br>
                Z.Sirekausko g.15A-7, Vilnius LT<br>
                Perkunkemio g787<br>
                Vilnius<br>
                IBAN: LT5646546545435873483<br>
                SWIFT: CBVILY2X<br>
            </b>
        </td>
        <td height="100px" width="10%"></td>
        <td class="seller-td-bottom" align="center" height="100px" width="45%">
            <b>
                <?php if($operation->client->type == 1): ?>
                    <?php echo $this->labels['Ltd.']; ?> <?php echo $operation->client->company_name; ?><br>
                    <?php echo $this->labels['company code']; ?> <?php echo $operation->client->company_code; ?><br>
                    <?php echo $this->labels['vat code']; ?> <?php echo $operation->client->vat_code; ?><br>
                    <?php echo $this->labels['address']; ?>:<?php echo $operation->client->street; ?><br>
                    <?php echo $operation->client->city; ?><br>
                <?php else: ?>
                    <?php echo $operation->client->name.' '.$operation->client->surname; ?><br>
                    <?php echo $this->labels['personal code']; ?> <?php echo $operation->client->personal_code; ?><br>
                    <?php echo $this->labels['vat code']; ?> <?php echo $operation->client->vat_code; ?><br>
                    <?php echo $this->labels['address']; ?>:<?php echo $operation->client->street; ?><br>
                    <?php echo $operation->client->city; ?><br>
                <?php endif; ?>
            </b>
        </td>
    </tr>
</table>
<br>
<table class="prod-table" width="100%" cellspacing="0">
    <tr align="center">
        <td align="center" class="prod-td" width="30%"><?php echo $this->labels['name']; ?></td>
        <td align="center" class="prod-td" width="10%"><?php echo $this->labels['code']; ?></td>
        <td align="center" class="prod-td" width="10%"><?php echo $this->labels['units']; ?></td>
        <td align="center" class="prod-td" width="10%"><?php echo $this->labels['quantity']; ?></td>
        <td align="center" class="prod-td" width="15%"><?php echo $this->labels['price']; ?>(EUR)</td>
        <td align="center" class="prod-td" width="10%"><?php echo $this->labels['discount'];?> %</td>
        <td align="center" class="prod-td" width="15%"><?php echo $this->labels['sum']; ?></td>
    </tr>

    <?php foreach($operation->operationsOutItems as $prod_item): ?>
        <tr align="center">
            <td class="prod-td" width="30%"><?php echo $prod_item->productCard->product_name; ?></td>
            <td class="prod-td" width="10%"><?php echo $prod_item->productCard->product_code; ?></td>
            <td class="prod-td" width="10%"><?php echo $prod_item->productCard->measureUnits->name; ?></td>
            <td class="prod-td" width="10%"><?php echo $prod_item->qnt; ?></td>
            <td class="prod-td" width="15%"><?php echo $this->centsToPriceStr($prod_item->price); ?></td>
            <td class="prod-td" width="10%"><?php echo $prod_item->discount_percent; ?></td>
            <td class="prod-td" width="15%"><?php echo $this->centsToPriceStr($prod_item->calculateSum()); ?></td>
        </tr>
    <?php endforeach; ?>
    <?php foreach($operation->operationsOutOptItems as $opt_item): ?>
        <tr align="center">
            <td colspan="4" class="prod-td" width="30%"><?php echo $opt_item->optionCard->name ?></td>
            <td colspan="2" class="prod-td" width="15%"><?php echo $this->centsToPriceStr($opt_item->price); ?></td>
            <td class="prod-td" width="15%"><?php echo $this->centsToPriceStr($opt_item->price); ?></td>
        </tr>
    <?php endforeach ?>

    <tr>
        <td colspan="4"></td>
        <td class="prod-td" colspan="2"><?php echo $this->labels['total']; ?>:</td>
        <td class="prod-td" align="center"><?php echo $this->centsToPriceStr($operation->calculateTotalPrice(false)); ?></td>
    </tr>
    <tr>
        <td colspan="2"><?php echo $this->labels['payment due']; ?>:</td>
        <td align="center" colspan="2">99/99/9999</td>
        <td class="prod-td" colspan="2"><?php echo $this->labels['VAT'] ?> <?php echo $operation->vat->percent; ?>%</td>
        <td class="prod-td" align="center"><?php echo $this->centsToPriceStr($operation->calculateTotalPrice(true)-$operation->calculateTotalPrice(false)); ?></td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td class="prod-td" colspan="2"><?php echo $this->labels['with vat']; ?></td>
        <td class="prod-td" align="center" colspan="2"><?php echo $this->centsToPriceStr($operation->calculateTotalPrice(true)); ?></td>
    </tr>

</table>
<br>
<table width="60%">
    <tr>
        <td align="left" width="50%"><b><?php echo $this->labels['director']; ?></b></td>
        <td align="right" width="50%"><b>Aleksandras Krispinovicius</b></td>
    </tr>
</table>
<br>
<br>
<br>
<table width="100%">
    <tr><td style="border-bottom: 1px dotted #000000;"></td></tr>
    <tr><td style="font-size: 8px" align="center">(some small text at the bottom)</td></tr>
</table>
</body>
</html>