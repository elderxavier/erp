<?php /* @var $invoices Array */ ?>
<?php /* @var $invoice InvoicesIn */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/table.css');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/buy-ops.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <div class="table-holder">
                <table class="table table-bordered table-striped table-hover">
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

                    <?php foreach($invoices as $invoice): ?>
                        <tr>
                            <td><?php echo $invoice->id; ?></td>
                            <td><?php echo $invoice->invoice_code; ?></td>
                            <td><?php echo $invoice->supplier->company_name;?></td>
                            <td><?php echo date('Y.m.d',$invoice->date_created); ?></td>

                            <td>
                                <?php if($this->rights['purchases_see']): ?>
                                    <?php echo CHtml::link('view','/ajax/viewinvoicein/id/'.$invoice->id,array('class' => 'actions action-edit modal-link-opener')); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!--/table-holder -->
        </div>
    </div>
</div><!--/container -->