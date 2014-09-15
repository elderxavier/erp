<?php /* @var $card ProductCards */ ?>
<?php /* @var $templates MailTemplates[] */ ?>
<?php /* @var $this ProductsController */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/prod_letter.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/prod-letter.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>


<div class="container-fluid  main-content-holder content-wrapper">
<div class="row card-holder">

    <div class="col-sm-6 left-part">

        <div class="filter-holder">
            <h4><?php echo $this->labels['search client']; ?></h4>
            <div class="filter-inputs-holder">
                <input id="cli-name" type="text" placeholder="<?php echo $this->labels['client name']; ?>" />
                <input id="cli-code" type="text" placeholder="<?php echo $this->labels['personal / company code']; ?>" />
                <button class="filter-btn"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search text-right"></span></button>
            </div>
            <div class="product-table-holder">
                <table width="100%" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><?php echo $this->labels['client name']; ?></th>
                        <th><?php echo $this->labels['email']; ?></th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                    </thead>
                    <tbody class="filtered-body">
                    </tbody>
                </table>

            </div><!--/product-table-holder -->
            <h4><?php echo $this->labels['email templates']; ?></h4>
            <div class="transport-option-holder">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><?php echo $this->labels['name']; ?></th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($templates as $template): ?>
                        <tr>
                            <td><?php echo $template->name; ?></td>
                            <td>
                                <a data-name="<?php echo $template->name; ?>" data-id="<?php echo $template->id; ?>" class="btn btn-default btn-sm add-option" href="#">
                                    <?php echo $this->labels['add to list']; ?>&nbsp;<span class="glyphicon glyphicon-share"></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!--/tranport-table0holder-->

        </div><!--/filter-holder -->
    </div><!--/left-part -->

    <div class="col-lg-6 col-md-6 col-sm-6 pull-right">
        <div class="table-holder">
            <h4><?php echo $this->labels['product info']; ?></h4>
            <table  class="table table-bordered">
                <tbody>

                <tr>
                    <td><?php echo $this->labels['product name']; ?></td>
                    <td><?php echo $card->product_name; ?></td>
                    <td><?php echo $this->labels['product code']; ?></td>
                    <td><?php echo $card->product_code; ?></td>
                </tr>

                <tr>
                    <td><?php echo $this->labels['measure']; ?></td>
                    <td><?php echo $card->measureUnits->name; ?></td>
                    <td><?php echo $this->labels['size units']; ?></td>
                    <td><?php echo $card->sizeUnits->name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->labels['weight net'] ?> (Kg)</td>
                    <td><?php echo $card->weight_net/1000; ?></td>
                    <td><?php echo $this->labels['weight gross']; ?> (Kg)</td>
                    <td><?php echo $card->weight/1000; ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->labels['sizes'].' ('.$card->sizeUnits->name.')'; ?></td>
                    <td colspan="3"><?php echo $card->weight.'x'.$card->height.'x'.$card->length; ?></td>
                </tr>
                </tbody>
            </table>
            <input type="hidden" id="prod-hidden-id" value="<?php echo $card->id; ?>">
        </div><!--/table-holder -->


        <div id="email-create-section">
            <h4><?php echo $this->labels['to']; ?>:</h4>
            <div id="address-to-section" class="clearfix">
                <ul id="emails-to-holder">
                    <li id="empty-list"><?php echo $this->labels['put here user emails']; ?></li>
                </ul><!--emails-to-holder -->
            </div>
            <div id="text-holder-area">
                <textarea class="template-text-area"></textarea>
            </div><!--/product-holder-area -->

            <div id="files-section">
                <h5><?php echo $this->labels['available files']; ?></h5>
                <ul class="clearfix">
                    <?php foreach($card->productFiles as $file): ?>
                        <li> <input class="files" data-id="<?php echo $file->id; ?>" name="files[<?php echo $file->id; ?>]" type="checkbox"> <span><?php echo $file->label; ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div><!--/files-section -->
        </div><!--/email-create-section -->

    </div><!--/left -->
    <div class="btn-holder col-sm-12 clearfix text-right">
        <button class="btn-submit" data-toggle="modal" data-target="#letterReady"><span><?php echo $this->labels['create letter']; ?></span><span class="glyphicon glyphicon-chevron-right"></span></button>
    </div><!--/btn-holder -->
</div><!--row -->
<div class="modals-holder">
    <div class="letter-ready">

        <div class="modal fade" id="letterReady" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="<?php echo Yii::app()->createUrl('/products/sendletter'); ?>">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $this->labels['close']; ?></span></button>
                            <h4 class="modal-title"><?php echo $this->labels['letter']; ?></h4>
                        </div><!--/.modal-heafer -->

                        <div class="modal-body">
                            Some text here
                        </div><!--/modal-body -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->labels['close']; ?><span class="glyphicon glyphicon-thumbs-down"></span></button>
                            <button type="submit" class="btn btn-primary"><?php echo $this->labels['send'];  ?><span class="glyphicon glyphicon-share-alt"></span></button>
                        </div><!--/modal-footer -->
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div><!--/letter-ready -->

</div><!--/modals-holder -->
</div><!--/container -->