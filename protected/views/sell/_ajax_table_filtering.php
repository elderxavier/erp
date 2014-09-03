<?php /* @var $this SellController */ ?>
<?php /* @var $operations OperationsOut[] */ ?>

<?php foreach($operations as $nr => $operation): ?>
    <tr id="op_id_<?php echo $operation->id;?>">
        <td><?php echo $nr + 1; ?></td>
        <td><a class="info-open-lnk" href="<?php echo Yii::app()->createUrl('/ajax/operationoutinfo',array('id' => $operation->id)); ?>" data-toggle="modal" data-id="<?php echo $operation->id; ?>" data-target="#invoiceInfo"><?php echo $operation->id; ?></a></td>
        <td><?php echo $operation->client->getFullName(); ?></td>
        <td><?php echo $operation->client->typeObj->name; ?></td>
        <td><?php echo $operation->stock->location->city_name; ?></td>
        <td><?php echo date('Y.m.d G:i',$operation->date_created); ?></td>
        <td class="invoice-code"><?php echo $operation->invoice_code; ?></td>
        <td><a class="gen-pdf" data-id="<?php echo $operation->id; ?>" href="<?php echo Yii::app()->createUrl('sell/generate',array('id' => $operation->id)); ?>"><?php echo $this->labels['generate pdf']; ?></a></td>
        <td><?php echo $operation->status->name; ?></td>
        <td><a href="#"><?php echo $this->labels['send invoice']; ?></a></td>
    </tr>
<?php endforeach;?>
