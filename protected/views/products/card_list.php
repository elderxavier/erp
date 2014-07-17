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
                <form class="form-inline clearfix" action="#" method="post">
                    <div class="filter filter1">
                        <div>
                            <label>Filter1 :</label>
                            <input type="text" placeholder="product code">
                        </div>
                    </div><!--/filter1 -->


                    <div class="filter filter2">
                        <div class="form-group">
                            <select class="form-control">
                                <option selected="" value="">Choose category</option>
                                <option value="cat1">category 1</option>
                                <option value="cat2">category 2</option>
                            </select>
                        </div>
                    </div><!--/filter1 -->

                    <div class="filter filter3">
                        <div>
                            <label>Filter3 :</label>
                            <input type="text" placeholder="product name">
                        </div>
                    </div><!--/filter1 -->


                    <div class="filter filter4">
                        <div>
                            <button type="submit"><span>Filtruoti</span><span><img src="/images/filters_arrow.png" height="36" width="36"></span></button>
                        </div>
                    </div><!--/filter1 -->
                </form>
            </div>


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
                                    <?php echo CHtml::link($this->labels['edit'],'/'.$this->id.'/editcard/id/'.$card->id,array('class' => 'actions action-edit')); ?>
                                <?php endif; ?>
                                <?php if($this->rights['products_delete']): ?>
                                    <?php echo CHtml::link($this->labels['delete'],'/'.$this->id.'/deletecard/id/'.$card->id,array('class' => 'actions action-delete')); ?>
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
