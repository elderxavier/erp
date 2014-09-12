<?php /* @var $this ProductsController */ ?>
<?php /* @var $clients Clients[] */ ?>

<?php if(empty($clients)): ?>
    <tr>
        <td colspan="3"><?php echo $this->labels['no data']; ?></td>
    </tr>
<?php else: ?>
    <?php foreach($clients as $client): ?>
        <tr>
            <td><?php echo $client->type == 1 ? $client->company_name : $client->name.' '.$client->surname; ?></td>
            <td><?php echo $client->email1; ?></td>
            <td>
                <a data-name="<?php echo $client->type == 1 ? $client->company_name : $client->name.' '.$client->surname; ?>" data-mail="<?php echo $client->email1; ?>" data-id="<?php echo $client->id; ?>" class="btn btn-default btn-sm add-prod" href="#">
                    <?php echo $this->labels['add to list']; ?>&nbsp;<span class="glyphicon glyphicon-share"></span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
