<?php /* @var $this AjaxController */ ?>
<?php /* @var $clients_rows Array */ ?>

<div class="table-holder header-holder">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th><?php echo $this->labels['name']; ?></th>
            <th><?php echo $this->labels['code']; ?></th>
            <th><?php echo $this->labels['address'];?></th>
        </tr>
        </thead>
    </table>
</div><!--/table-header-holder -->
<div class="table-holder body-holder">
    <table class="table table-bordered table-hover">
        <tbody>
        <?php if(!empty($clients_rows)): ?>
            <?php foreach($clients_rows as $row): ?>
                <tr>
                    <td><a href="/ajax/clientmodal/<?php echo $row['id']; ?>" data-toggle="modal" data-target=".cust-info" class="load-modal-client"><?php echo $row['type'] == 0 ? $row['name'].' '.$row['surname'] : $row['company_name']; ?></a></td>
                    <td><?php echo $row['type'] == 0 ? $row['personal_code'] : $row['company_code']; ?></a></td>
                    <td><?php echo '-'; ?></td>
                </tr>
            <?php endforeach;?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center"><h5><?php echo $this->labels['no data']; ?></h5></td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div><!--body-holder-->
<div class="new-cust-btn-holder">
    <button data-toggle="modal" data-target=".new-customer-juridical"><?php echo $this->labels['new customer']; ?><span class="glyphicon glyphicon-plus-sign"></span></button>
</div>
