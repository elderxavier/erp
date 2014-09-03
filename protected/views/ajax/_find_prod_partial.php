<?php /* @var $rows array */  ?>
<?php /* @var $this AjaxController */ ?>

<?php foreach($rows as $row): ?>
    <tr>
        <td><?php echo $row['product_name']; ?></td>
        <td><?php echo $row['product_code']; ?></td>
        <td>
            <a data-name="<?php echo $row['product_name']; ?>" data-code="<?php echo $row['product_code']; ?>" data-unit="<?php echo $row['units']; ?>" data-id="<?php echo $row['id']; ?>" class="btn btn-default btn-sm add-prod" href="#">
                <?php echo $this->labels['add to list']; ?>&nbsp;<span class="glyphicon glyphicon-share"></span>
            </a>
        </td>
    </tr>
<?php endforeach; ?>

