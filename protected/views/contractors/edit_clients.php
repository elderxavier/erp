<?php /* @var $client Clients */ ?>
<?php /* @var $this ContractorsController */ ?>
<?php /* @var $errors array */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/add_product.css');
?>

<?php if($errors): ?><?php Debug::out($errors); ?><?php endif;?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <form id="add-product-form" action="<?php echo Yii::app()->createUrl($this->id.'/updateclient') ?>" method="post">

                <input type="hidden" name="id" value="<?php echo $client->id; ?>">

                <div class="form-group">
                    <label for="personal_code"><?php echo $this->labels['personal code']; ?></label>
                    <input name="personal_code" value="<?php echo $client->personal_code; ?>" class="form-control" id="personal_code" type="text" />
                </div>

                <div class="form-group">
                    <label for="vat_code"><?php echo $this->labels['vat code']; ?></label>
                    <input name="vat_code" value="<?php echo $client->vat_code; ?>" class="form-control" id="vat_code" type="text" />
                </div>

                <div class="form-group">
                    <label for="name"><?php echo $this->labels['name']; ?></label>
                    <input name="name" value="<?php echo $client->name; ?>" class="form-control" id="name" type="text" />
                </div>

                <div class="form-group">
                    <label for="surname"><?php echo $this->labels['surname']; ?></label>
                    <input name="surname" value="<?php echo $client->surname; ?>" class="form-control" id="surname" type="text" />
                </div>

                <div class="form-group">
                    <label for="phone_1"><?php echo $this->labels['phone'].' 1'; ?></label>
                    <input name="phone_1" value="<?php echo $client->phone1; ?>" class="form-control" id="phone_1" type="text" />
                </div>

                <div class="form-group">
                    <label for="phone_2"><?php echo $this->labels['phone'].' 2'; ?></label>
                    <input name="phone_2" value="<?php echo $client->phone2; ?>" class="form-control" id="phone_2" type="text" />
                </div>

                <div class="form-group">
                    <label for="email_1"><?php echo $this->labels['email'].' 1'; ?></label>
                    <input name="email_1" value="<?php echo $client->email1; ?>" class="form-control" id="email_1" type="text" />
                </div>

                <div class="form-group">
                    <label for="email_2"><?php echo $this->labels['email'].' 2'; ?></label>
                    <input name="email_2" value="<?php echo $client->email2; ?>" class="form-control" id="email_2" type="text" />
                </div>

                <div class="form-group">
                    <label><?php echo $this->labels['remark']; ?></label>
                    <textarea name="remark" class="form-control"><?php echo $client->remark; ?></textarea>
                </div>

                <div class="form-group">
                    <label><?php echo $this->labels['remark for service']; ?></label>
                    <textarea name="remark_service" class="form-control"><?php echo $client->remark_for_service; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="company"><?php echo $this->labels['company']; ?></label>
                    <input <?php if($client->type == 1): ?> checked <?php endif;?> id="company" name="company" type="checkbox">
                </div>

                <div class="form-group">
                    <label for="company_name"><?php echo $this->labels['company name']; ?></label>
                    <input name="company_name" value="<?php echo $client->company_name; ?>" class="form-control" id="company_name" type="text" />
                </div>

                <div class="form-group">
                    <label for="company_code"><?php echo $this->labels['company code']; ?></label>
                    <input name="company_code" value="<?php echo $client->company_code; ?>" class="form-control" id="company_code" type="text" />
                </div>

                <button type="submit"><span><?php echo $this->labels['save']; ?></span><span class="glyphicon glyphicon-plus"></span></button>
            </form>
        </div>
    </div>
</div>