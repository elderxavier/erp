<?php /* @var $category ProductCardCategories */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/add_product.css');
?>

<?php if($category != null): ?>
    <input type="hidden" name="id" value="<?php echo $category->id; ?>">
<?php else: ?>
    <?php $category = new ProductCardCategories(); ?>
<?php endif; ?>

<?php $this->renderPartial('//partials/_list',array('links' => ProductsController::GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <form id="add-product-form" action="<?php echo Yii::app()->createUrl(Yii::app()->controller->id.'/updatecat'); ?>" method="post" role="form">

                <div class="form-group">
                    <label for="category-name"><?php echo Label::Get('Category name'); ?></label>
                    <input value="<?php echo $category->name; ?>" name="category_name" class="form-control" id="category-name" type="text">
                </div>

                <div class="form-group">
                    <label for="status"><?php echo Label::Get('Status'); ?></label>
                    <select id="status" class="form-control" name="status">
                        <option <?php if($category->status == 0): ?> selected <?php endif; ?> value="<?php echo 0; ?>"><?php echo Label::Get('hidden'); ?></option>
                        <option <?php if($category->status == 1): ?> selected <?php endif;?> value="<?php echo 1; ?>"><?php echo Label::Get('visible'); ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="remark"><?php echo Label::Get('remark'); ?></label>
                    <textarea id="remark" class="form-control" style="margin: 0px 488px 0px 0px; height: 57px; width: 453px;"><?php echo $category->remark; ?></textarea>
                </div>

                <button type="submit"><span><?php echo Label::Get('save'); ?></span><span class="glyphicon glyphicon-plus"></span></button>
            </form>
        </div>
    </div>
</div>