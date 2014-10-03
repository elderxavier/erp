<?php /* @var $invoices OperationsIn[] */ ?>
<?php /* @var $this MainController */ ?>
<?php /* @var $pager CPagerComponent */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/invoice_list.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/paginator.css');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/buy_list.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row filter-holder">
        <form>
            <input id="invoice-nr" type="text" placeholder="<?php echo $this->labels['invoice code']; ?>">
            <input id="supplier-name" type="text" placeholder="<?php echo $this->labels['supplier name']; ?>">
            <input class="date-picker-cl" id="date-from" type="text" placeholder="<?php echo $this->labels['date from']; ?>">
            <input class="date-picker-cl" id="date-to" type="text" placeholder="<?php echo $this->labels['date to']; ?>">
            <button id="search-btn"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search"></span></button>
        </form>
    </div><!--/filter-holder -->
    <div class="row table-holder">
        <table class="table table-bordered table-striped table-hover" >
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo $this->labels['invoice code']; ?></th>
                <th><?php echo $this->labels['supplier']; ?></th>
                <th><?php echo $this->labels['date']; ?></th>
                <th><?php echo $this->labels['actions'] ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($pager->formatted_array as $invoice): ?>
                <tr>
                    <td><?php echo $invoice->id; ?></td>
                    <td><a class="open-info-lnk" href="<?php echo Yii::app()->createUrl('/buy/ajax/ajaxinfo',array('id' => $invoice->id)); ?>" data-toggle="modal" data-target="#invoiceInfo"><?php echo $invoice->invoice_code; ?></a></td>
                    <td><?php echo $invoice->supplier->company_name;?></td>
                    <td><?php echo date('Y.m.d',$invoice->date_created); ?></td>
                    <td><a href="#"><?php echo $this->labels['edit']; ?></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php $pager->renderPages(); ?>
    </div><!--/table-holder -->

    <div class="modals-holder">
        <div class="invoice-ready">
            <div class="modal fade" id="invoiceInfo" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div><!--/invoice-ready -->
    </div><!--/modals-holder -->

</div><!--/container -->