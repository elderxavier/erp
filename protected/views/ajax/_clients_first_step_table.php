<?php /* @var $data array */ ?>
<?php foreach($data as $row): ?>
    <?php if($row['type'] == 1): ?>
        <tr>
            <td><a href="#" class="cust-link" data-link='/ajax/clientInfo/<?php echo $row['id'];?>'><?php echo $row['company_name'] ?></a></td>
            <td><?php echo $row['company_code']?></td>
            <td><?php echo $row['country'].', '.$row['city'].', '.$row['street'].', '.$row['building_nr'];?></td>
        </tr>
    <?php else: ?>
        <tr>
            <td><a href="#" class="cust-link" data-link='/ajax/clientInfo/<?php echo $row['id'];?>'><?php echo $row['name'].' '.$row['surname']; ?></a></td>
            <td><?php echo $row['personal_code']?></td>
            <td><?php echo $row['country'].', '.$row['city'].', '.$row['street'].', '.$row['building_nr'];?></td>
        </tr>
    <?php endif;?>
<?php endforeach;?>
