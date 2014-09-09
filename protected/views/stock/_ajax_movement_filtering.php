<?php /* @var $this StockController */ ?>
<?php /* @var $pages int */ ?>
<?php /* @var $current_page int */ ?>
<?php /* @var $items StockMovements */ ?>
<?php /* @var $filters array */ ?>

<table class="table table-bordered table-striped table-hover" >
    <thead>
    <tr>
        <th>#</th>
        <th><?php echo $this->labels['movement id']; ?></th>
        <th><?php echo $this->labels['from stock']; ?></th>
        <th><?php echo $this->labels['to stock']; ?></th>
        <th><?php echo $this->labels['transport']; ?></th>
        <th><?php echo $this->labels['date']; ?></th>
        <th><?php echo $this->labels['status']; ?></th>
        <th><?php echo $this->labels['actions']; ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($items as $nr => $movement): ?>
        <tr>
            <td><?php echo $nr+1; ?></td>
            <td><?php echo $movement->id; ?></td>
            <td><?php echo $movement->srcStock->name.' ['.$movement->srcStock->location->city_name.']'; ?></td>
            <td><?php echo $movement->trgStock->name.' ['.$movement->trgStock->location->city_name.']'; ?></td>
            <td><?php echo $movement->car_brand.' - '.$movement->car_number; ?></td>
            <td><?php echo date('Y.m.d H:i',$movement->date); ?></td>
            <td><?php echo $movement->status->name; ?></td>
            <td><a href="<?php echo Yii::app()->createUrl('/stock/movementinfo', array('id' => $movement->id)); ?>"><?php echo ($movement->status_id != 2 && $movement->status_id != 5) ? $this->labels['change status'] : $this->labels['view info']; ?></a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="pages-holder">
    <ul class="paginator">
        <?php for($i = 0; $i < $pages; $i++): ?>
            <li class="<?php if(($i+1) == $current_page): ?>current-page<?php endif; ?> links-pages"><?php echo ($i+1) ?></li>
        <?php endfor; ?>
    </ul>
</div>


