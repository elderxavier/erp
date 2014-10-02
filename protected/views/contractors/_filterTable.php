<?php /* @var $this AjaxController */ ?>
<?php /* @var $data Array */ ?>
<?php /* @var $type int */ ?>
<?php /* @var $next_c string */ ?>
<?php /* @var $next_a string */ ?>

<?php if($type == 1):?>
    <?php foreach($data as $row): ?>
        <tr>
            <td><a href="#" class="cust-link" data-link='<?php echo Yii::app()->createUrl('/contractors/custinfo',array('id' => $row['id'])); ?>'><?php echo $row['company_name'] ?></a></td>
            <td><?php echo $row['company_code']?></td>
            <td><?php echo implode(', ',array($row['country'],$row['city'],$row['street'])); ?></td>
        </tr>
    <?php endforeach;?>
<?php else:?>
    <?php foreach($data as $row): ?>
        <tr>
            <td><a href="#" class="cust-link" data-link='<?php echo Yii::app()->createUrl('/contractors/custinfo',array('id' => $row['id'])); ?>' ><?php echo $row['name'].' '.$row['surname']?></a></td>
            <td><?php echo $row['personal_code']?></td>
            <td><?php echo implode(', ',array($row['country'],$row['city'],$row['street'])); ?></td>
        </tr>
    <?php endforeach; ?>
<?php endif;?>