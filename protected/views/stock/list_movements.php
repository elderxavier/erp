<?php /* @var $movements StockMovements[] */ ?>
<?php /* @var $this StockController */ ?>
<?php /* @var $stocks array */ ?>
<?php /* @var $pager CPagerComponent */ ?>


<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/stock_list.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/paginator.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/stock_movements.js',CClientScript::POS_END);
?>
   
<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row filter-holder">
        <form method="post" action="#">

            <input id="mov-id" type="text" placeholder="<?php echo $this->labels['movement id']; ?>">

            <select id="from-stock">
                <option value=""><?php echo $this->labels['from stock']; ?></option>
                <?php foreach($stocks as $id => $name): ?>
                    <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                <?php endforeach;?>
            </select>

            <select id="to-stock">
                <option value=""><?php echo $this->labels['to stock']; ?></option>
                <?php foreach($stocks as $id => $name): ?>
                    <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                <?php endforeach;?>
            </select>

            <input class="date-picker-cl" id="date-from" type="text" placeholder="<?php echo $this->labels['date from']; ?>">
            <input class="date-picker-cl" id="date-to" type="text" placeholder="<?php echo $this->labels['date to']; ?>">

            <button class="filter-button-top"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search"></span></button>
        </form>
    </div><!--/filter-holder -->

    <div class="row table-holder">
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
            <?php foreach($pager->formatted_array as $nr => $movement): ?>
                <tr>
                    <td><?php echo $nr+1; ?></td>
                    <td><?php echo $movement->id; ?></td>
                    <td><?php echo $movement->srcStock->name.' ['.$movement->srcStock->location->city_name.']'; ?></td>
                    <td><?php echo $movement->trgStock->name.' ['.$movement->trgStock->location->city_name.']'; ?></td>
                    <td><?php echo $movement->car_brand.' - '.$movement->car_number; ?></td>
                    <td><?php echo date('Y.m.d H:i',$movement->date); ?></td>
                    <td><?php echo $movement->status->name; ?></td>
                    <td>
                        <a href="<?php echo Yii::app()->createUrl('/stock/movementinfo', array('id' => $movement->id)); ?>"><?php echo ($movement->status_id != 2 && $movement->status_id != 5) ? $this->labels['change status'] : $this->labels['view info']; ?></a>
                        <a class="pdf-gen-link" href="<?php echo Yii::app()->createUrl('/pdf/packinglist',array('id' => $movement->id)); ?>"><?php echo $this->labels['generate pdf']; ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php $pager->renderPages(); ?>
    </div><!--/table-holder -->

    <div class="modals-holder">
    </div><!--/modals-holder -->

</div><!--/container -->
<iframe class="file-load-frame" style="display: none; width: 0; height: 0" src=""></iframe>
