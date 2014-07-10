<?php /* @var $card ProductCards */ ?>
<?php /* @var $categories array */ ?>
<?php /* @var $category ProductCardCategories */ ?>
<?php /* @var $this ProductsController */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/add_product.css');
?>

<?php $this->renderPartial('//partials/_list',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <form id="add-product-form" action="<?php echo Yii::app()->createUrl(Yii::app()->controller->id.'/updatecard') ?>" method="post">

                <?php if($card->isNewRecord): ?>
                    <input name="id" type="hidden" value="<?php echo $card->id; ?>">
                <?php endif;?>

                <div class="form-group">
                    <label for="product-code"><?php echo $this->labels['product code']; ?></label>
                    <input name="code" value="<?php echo $card->product_code; ?>" class="form-control" id="product-code" type="text" />
                </div>
                <div class="form-group">
                    <label><?php echo $this->labels['name']; ?></label>
                    <input name="name" value="<?php echo $card->product_name; ?>" class="form-control" type="text" />
                </div>

                <div class="form-group">
                    <label><?php echo $this->labels['category']; ?></label>


                    <select name="category_id" class="form-control">
<!--                        <option selected>--><?php //echo $this->labels['select']; ?><!--</option>-->
                        <?php foreach($categories as $category): ?>
                            <option <?php if($card->category_id == $category->id): ?>selected<?php endif;?> value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                        <?php endforeach;?>
                    </select>

                </div>

                <fieldset>
                    <legend><?php echo $this->labels['dimension units']; ?></legend>
                    <div class="form-group">
                        <div class="radio">
                            <label>
                                <input <?php if($card->units == 'units'): ?>checked<?php endif; ?> type="radio" name="dim_units" value="units">
                                <?php echo $this->labels['units']; ?>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input <?php if($card->units == 'kg'): ?>checked<?php endif; ?> type="radio" name="dim_units" value="kg">
                                <?php echo $this->labels['kg']; ?>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input <?php if($card->units == 'liters'): ?>checked<?php endif; ?> type="radio" name="dim_units" value="liters">
                                <?php echo $this->labels['liters']; ?>
                            </label>
                        </div>
                    </div><!--/form-group -->
                </fieldset>

                <div class="form-group">
                    <label><?php echo $this->labels['description']; ?></label>
                    <textarea name="description" class="form-control"><?php echo $card->description; ?></textarea>
                </div>
                <button type="submit"><span><?php echo $this->labels['save']; ?></span><span class="glyphicon glyphicon-plus"></span></button>
            </form>
        </div>
    </div>
</div>