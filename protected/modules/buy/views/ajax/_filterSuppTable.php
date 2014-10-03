<?php /* @var $data array */ ?>

<?php foreach($data as $row): ?>
    <tr>
        <td><a href="#" class="cust-link" data-link='/buy/ajax/sellinfo/<?php echo $row['id'];?>'><?php echo $row['company_name'] ?></a></td>
        <td><?php echo $row['company_code']?></td>
        <td><?php echo $row['country'].', '.$row['city'].', '.$row['street'].', '.$row['building_nr'];?></td>
    </tr>
<?php endforeach;?>
