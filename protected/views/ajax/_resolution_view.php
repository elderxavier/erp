<?php /* @var $resolution ServiceResolutions */ ?>
<?php /* @var $this Controller */ ?>

<style>
    .modal-tbl-resolution td {padding: 5px;}
    .modal-tbl-resolution {width: 100%;}
    .modal-tbl-resolution tr td:first-child{width: 30%; background-color: #b1e4b1;}

</style>

<table class="modal-tbl-resolution" style="width: 100%" border="1">
    <tr>
        <td><?php echo $this->labels['client']; ?></td>
        <td><?php echo $resolution->serviceProcess->client->type == 1 ? $resolution->serviceProcess->client->company_name : $resolution->serviceProcess->client->name.' '.$resolution->serviceProcess->client->surname; ?></td>
    </tr>
    <tr>
        <td><?php echo $this->labels['worker']; ?></td>
        <td><?php echo $resolution->byEmployee->name.' '.$resolution->byEmployee->surname; ?></td>
    </tr>
    <tr>
        <td><?php echo $this->labels['message to worker']; ?></td>
        <td><?php echo $resolution->remark_for_employee; ?></td>
    </tr>
    <tr>
        <td><?php echo $this->labels['message by worker']; ?></td>
        <td><?php echo $resolution->remark_by_employee; ?></td>
    </tr>
    <tr>
        <td><?php echo $this->labels['completion time']; ?></td>
        <td><?php if($resolution->status == ServiceResolutions::$statuses['DONE']['id']) echo date('Y.m.d H:i',$resolution->date_changed); ?></td>
    </tr>
    <tr>
        <td><?php echo $this->labels['status']; ?></td>
        <td><?php echo $resolution->statusLabel(); ?></td>
    </tr>
</table>