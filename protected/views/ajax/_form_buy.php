<?php /* @var $this AjaxController */ ?>
<?php /* @var $supplier Suppliers */ ?>
<?php /* @var $stock Stocks */ ?>
<?php /* @var $product_params Array */ ?>
<?php /* @var $card ProductCards */ ?>
<?php /* @var $signer string */ ?>
<?php /* @var $invoice_code string */ ?>

<p><strong><?php echo $this->labels['supplier'] ?>:</strong></p>
<hr>
<p><?php echo $this->labels['name']; ?> - <?php echo $supplier->type == 1 ? $supplier->company_name : $supplier->name.' '.$supplier->surname; ?></p>
<p><?php echo $this->labels['personal/company code']; ?> - <?php echo $supplier->type == 1 ? $supplier->company_code : $supplier->personal_code; ?></p>
<p><?php echo $this->labels['phone']; ?> - <?php echo $supplier->phone1; ?></p>
<p><?php echo $this->labels['email']; ?> - <?php echo $supplier->email1; ?></p>
<p><?php echo $this->labels['remark']; ?> - <?php echo $supplier->remark; ?></p>
<p><?php echo $this->labels['signer']; ?> - <?php echo $signer;?></p>
<p><?php echo $this->labels['invoice code']; ?> - <?php echo $invoice_code; ?></p>
<hr>

<form method="post" action="<?php echo Yii::app()->createUrl('/buy/create'); ?>">
    <table border="1" style="width: 100%;">
        <tr>
            <th><?php echo $this->labels['product']; ?></th>
            <th><?php echo $this->labels['code']; ?></th>
            <th><?php echo $this->labels['quantity'];?></th>
            <th><?php echo $this->labels['price'];?></th>
            <th><?php echo $this->labels['total price']; ?></th>
        </tr>
        <?php $total = 0; ?>
        <?php foreach($product_params as $index => $params_arr): ?>

            <?php $card = $params_arr['obj']; ?>
            <?php $quantity = $params_arr['quantity']; ?>
            <?php $price = $params_arr['price']; ?>

            <input type="hidden" name="BuyForm[products][<?php echo $index; ?>][card_id]" value="<?php echo $card->id; ?>">
            <input type="hidden" name="BuyForm[products][<?php echo $index; ?>][quantity]" value="<?php echo $quantity; ?>">
            <input type="hidden" name="BuyForm[products][<?php echo $index; ?>][price]" value="<?php echo $price; ?>">

            <tr>
                <td><?php echo $card->product_name; ?></td>
                <td><?php echo $card->product_code; ?></td>
                <td><?php echo $quantity; ?></td>
                <td><?php echo number_format($price,2,'.',''); ?></td>
                <td><?php echo number_format($price*$quantity,2,'.','');?></td>
                <?php $total += $price*$quantity; ?>
            </tr>
        <?php endforeach;?>
        <tr>
            <td colspan="4"><?php echo $this->labels['total']; ?></td>
            <td><?php echo number_format($total,2,'.','');?></td>
        </tr>
    </table>

    <input type="hidden" name="BuyForm[supplier_id]" value="<?php echo $supplier->id; ?>">
    <input type="hidden" name="BuyForm[stock_id]" value="<?php echo $stock->id; ?>">
    <input type="hidden" name="BuyForm[signer]" value="<?php echo $signer; ?>">
    <input type="hidden" name="BuyForm[invoice_code]" value="<?php echo $invoice_code; ?>">

    <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
        <div class="ui-dialog-buttonset">
            <button type="submit"><?php echo $this->labels['save']; ?></button>
            <button class="close-modal-w" type="button"><?php echo $this->labels['cancel']; ?></button>
        </div>
    </div>
</form>