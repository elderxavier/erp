<?php /* @var $invoices Array */ ?>
<?php /* @var $invoice InvoicesIn */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/table.css');
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
                        <th><?php echo $this->labels['code']; ?></th>
                        <th><?php echo $this->labels['supplier']; ?></th>
                        <th><?php echo $this->labels['date']; ?></th>
                        <th><?php echo $this->labels['actions'] ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($invoices as $invoice): ?>
                        <tr>
                            <td><?php echo $invoice->id; ?></td>
                            <td><?php echo $invoice->supplier->name; ?></td>
                            <td><?php echo date('Y.m.d',$invoice->date_created); ?></td>

                            <td>
<!--                                --><?php //if($this->rights['products_edit']): ?>
<!--                                    --><?php //echo CHtml::link($this->labels['edit'],'/'.$this->id.'/editcat/id/'.$category->id,array('class' => 'actions action-edit')); ?>
<!--                                --><?php //endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!--/table-holder -->
        </div>
    </div>
</div><!--/container -->