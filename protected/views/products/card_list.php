<?php /* @var $categories array */ ?>
<?php /* @var $category ProductCardCategories */ ?>
<?php /* @var $rights UserRights */ ?>
<?php /* @var $this ProductsController */ ?>
<?php /* @var $cards array */?>
<?php /* @var $card ProductCards */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/table.css');
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <div class="filters clearfix">
                <div class="filter filter1">
                    <div>
                        <label><?php echo $this->labels['product code']; ?> :</label>
                        <input name="cod" type="text" />
                    </div>
                </div><!--/filter1 -->

                <div class="filter filter1">
                    <div>
                        <label><?php echo $this->labels['category']; ?> :</label>
                        <input name="cat" type="text" />
                    </div>
                </div><!--/filter1 -->


                <div class="filter filter2">
                    <div>
                        <label><?php echo $this->labels['name']; ?> :</label>
                        <input name="nam" type="text" />
                    </div>
                    <div>
                        <button type="submit"><span class="hidden-xs"><?php echo $this->labels['filter']; ?></span><span><img src="/images/filters_arrow.png" height="36" width="36" /></span></button>
                    </div>
                </div><!--/filter1 -->
            </div><!--/filters -->

            <div class="table-holder">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->labels['product code']; ?></th>
                        <th><?php echo $this->labels['name']; ?></th>
                        <th><?php echo $this->labels['category']; ?></th>
                        <th><?php echo $this->labels['dimension units']; ?></th>
                        <th class="status"><?php echo $this->labels['status']; ?></th>
                        <th><?php echo $this->labels['actions'] ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($cards as $card): ?>
                        <tr>
                            <td><?php echo $card->id; ?></td>
                            <td><?php echo $card->product_code; ?></td>
                            <td><?php echo $card->product_name; ?></td>
                            <td><?php echo $card->category->name; ?></td>
                            <td><?php echo $this->labels[$card->units]; ?></td>

                            <td class="status">
                                <div prod_id ="<?php echo $card->id; ?>" state="<?php echo $card->status; ?>" class="btn-group btn-toggle">
                                    <button class="btn <?php if($card->status == 1):?>active btn-primary<?php else: ?>btn-default<?php endif; ?>">ON</button>
                                    <button class="btn <?php if($card->status == 0):?>active btn-primary<?php else: ?>btn-default<?php endif; ?>">OFF</button>
                                </div>
                            </td>

                            <td>
                                <?php if($this->rights['products_edit']): ?>
                                    <?php echo CHtml::link($this->labels['delete'],Yii::app()->createUrl('products/deletecard',array('id' => $category->id)),array('class' => 'action-lnk')); ?>
                                <?php endif; ?>
                                <?php if($rights->rights['products_delete']): ?>
                                    | <?php echo CHtml::link($this->labels['edit'],Yii::app()->createUrl('products/editcard',array('id' => $category->id)),array('class' => 'action-lnk')); ?>
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
