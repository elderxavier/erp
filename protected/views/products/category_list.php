<?php /* @var $categories array */ ?>
<?php /* @var $category ProductCardCategories */ ?>
<?php /* @var $rights UserRights */ ?>
<?php /* @var $this ProductsController */ ?>

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
                        <th><?php echo $this->labels['name']; ?></th>
                        <th><?php echo $this->labels['date']; ?></th>
                        <th><?php echo $this->labels['actions'] ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($categories as $category): ?>
                        <tr>
                            <td><?php echo $category->id; ?></td>
                            <td><?php echo $category->name; ?></td>
                            <td><?php echo date('Y.m.d',$category->date_created); ?></td>

                            <td>
                                <?php if($this->rights['categories_edit']): ?>
                                    <?php echo CHtml::link($this->labels['delete'],Yii::app()->createUrl('products/deletecat',array('id' => $category->id)),array('class' => 'action-lnk')); ?>
                                <?php endif; ?>
                                <?php if($rights->rights['categories_delete']): ?>
                                    | <?php echo CHtml::link($this->labels['edit'],Yii::app()->createUrl('products/editcat',array('id' => $category->id)),array('class' => 'action-lnk')); ?>
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
