<?php /* @var $categories array */ ?>
<?php /* @var $category ProductCardCategories */ ?>
<?php /* @var $rights UserRights */ ?>
<?php /* @var $this ProductsController */ ?>
<?php /* @var $table_actions array */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/table.css');
?>

<?php $this->renderPartial('//partials/_list',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

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
                        <th><?php echo $this->labels['name']; ?></th>
                        <th><?php echo $this->labels['date']; ?></th>
                        <th class="status"><?php echo $this->labels['status']; ?></th>
                        <th><?php echo $this->labels['actions'] ?></th>
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
                                <?php $this->renderPartial('//partials/_table_actions',array('links' => $table_actions , 'params' => array('id' => $category->id), 'separator' => '|')); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!--/table-holder -->
        </div>
    </div>
</div><!--/container -->
