<?php /* @var $category ProductCardCategories */ ?>
<?php /* @var $rights UserRights */ ?>
<?php /* @var $this MainController */ ?>
<?php /* @var $pager CPagerComponent */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/invoice_list.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/paginator.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/category_list.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <div class="row filter-holder">
                <form>
                    <input id="name" type="text" placeholder="<?php echo $this->labels['name']; ?>">
                    <button class="filter-button-top"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search"></span></button>
                </form>
            </div><!--/filter-holder -->

            <div class="row table-holder">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->labels['name']; ?></th>
                        <th><?php echo $this->labels['actions'] ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($pager->formatted_array as $category): ?>
                        <tr>
                            <td><?php echo $category->id; ?></td>
                            <td><?php echo $category->name; ?></td>

                            <td>
                                <?php if($this->rights['products_edit']): ?>
                                    <?php echo CHtml::link($this->labels['edit'],'/products/editcat/id/'.$category->id,array('class' => 'actions action-edit')); ?>
                                <?php endif; ?>
                                <?php if($this->rights['products_delete']): ?>
                                    <?php echo CHtml::link($this->labels['delete'],'/products/deletecat/id/'.$category->id,array('class' => 'actions action-delete')); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php $pager->renderPages(); ?>
            </div><!--/table-holder -->
        </div>
    </div>
</div><!--/container -->
