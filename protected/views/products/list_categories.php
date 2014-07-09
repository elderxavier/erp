<?php /* @var $categories array */ ?>
<?php /* @var $category ProductCardCategories */ ?>
<?php /* @var $rights UserRights */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/table.css');
?>

<?php $this->renderPartial('//partials/_list',array('links' => ProductsController::GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="filters">
                filtr
            </div><!--/filters -->

            <div class="table-holder">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo Label::Get('name'); ?></th>
                        <th><?php echo Label::Get('date'); ?></th>
                        <th class="status"><?php echo Label::Get('status'); ?></th>
                        <th><?php echo Label::Get('actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($categories as $category): ?>
                        <tr>
                            <td><?php echo $category->id; ?></td>
                            <td><?php echo $category->name; ?></td>
                            <td><?php echo date('Y.m.d',$category->date_created); ?></td>

                            <td class="status">
                                <div class="btn-group btn-toggle">
                                    <button class="btn <?php if($category->status == 1):?>active btn-primary<?php else: ?>btn-default<?php endif; ?>">ON</button>
                                    <button class="btn <?php if($category->status == 0):?>active btn-primary<?php else: ?>btn-default<?php endif; ?>">OFF</button>
                                </div>
                            </td>

                            <td>
                                <?php $rights = Yii::app()->user->GetState('rights'); ?>
                                <?php if($rights->products_categories_delete): ?>
                                    <?php echo CHtml::link(Label::Get('delete'),Yii::app()->createUrl('products/deletecat',array('id' => $category->id)),array('class' => 'action-lnk')); ?>
                                <?php endif; ?>
                                <?php if($rights->products_categories_edit): ?>
                                    | <?php echo CHtml::link(Label::Get('edit'),Yii::app()->createUrl('products/editcat',array('id' => $category->id)),array('class' => 'action-lnk')); ?>
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
