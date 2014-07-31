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

<div class="table-holder body-holder filtered-clients">
    <table class="table table-bordered table-hover">
        <tbody>
        <?php foreach($clients_rows as $row): ?>
            <tr>
                <td><a href="#" data-toggle="modal" data-target=".cust-info"><?php echo $row['type'] == 0 ? $row['name'].' '.$row['surname'] : $row['company_name']; ?></a></td>
                <td><?php echo $row['type'] == 0 ? $row['personal_code'] : $row['company_code']; ?></a></td>
                <td><?php echo '-'; ?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div><!--body-holder-->
<div class="new-cust-btn-holder">
    <button>New customer</button>
</div><!--/new-cust-btn-holder -->
