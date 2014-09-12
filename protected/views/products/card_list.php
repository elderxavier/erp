<?php /* @var $categories array */ ?>
<?php /* @var $measures array */ ?>
<?php /* @var $pager CPagerComponent */ ?>

<?php /* @var $rights UserRights */ ?>
<?php /* @var $this ProductsController */ ?>
<?php /* @var $card ProductCards */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/invoice_list.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/paginator.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/product_list.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <div class="row filter-holder">
                <form>
                    <input id="sel_code" type="text" placeholder="<?php echo $this->labels['product code']; ?>">
                    <input id="sel_name" type="text" placeholder="<?php echo $this->labels['name']; ?>" />
                    <select id="sel_category">
                        <option value=""><?php echo $this->labels['select category']; ?></option>
                        <?php foreach($categories as $id => $name): ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="sel_units">
                        <option value=""><?php echo $this->labels['select measure']; ?></option>
                        <?php foreach($measures as $id => $name): ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="sel_status">
                        <option value=""><?php echo $this->labels['select status']; ?></option>
                        <option value="1"><?php echo $this->labels['on']; ?></option>
                        <option value="0"><?php echo $this->labels['off']; ?></option>
                    </select>
                    <button class="filter-button-top"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search"></span></button>
                </form>
            </div><!--/filter-holder -->


            <div class="row table-holder">
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

                    <?php foreach($pager->formatted_array as $card): ?>
                        <tr>
                            <td><?php echo $card->id; ?></td>
                            <td><?php echo $card->product_code; ?></td>
                            <td><?php echo $card->product_name; ?></td>
                            <td><?php echo $card->category->name; ?></td>
                            <td><?php echo $card->measureUnits->name; ?></td>

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
                <?php $pager->renderPages(); ?>
            </div><!--/table-holder -->
        </div>
    </div>
</div><!--/container -->
