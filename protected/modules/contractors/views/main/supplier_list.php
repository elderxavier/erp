<?php /* @var $pager CPagerComponent */ ?>
<?php /* @var $supplier Suppliers */ ?>
<?php /* @var $rights UserRights */ ?>
<?php /* @var $this MainController */ ?>
<?php /* @var $table_actions array */ ?>
<?php /* @var $cities array */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/invoice_list.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/paginator.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/supplier_list.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <div class="row filter-holder">
                <form>
                    <input id="code" type="text" placeholder="<?php echo $this->labels['company code']; ?>">
                    <input id="name" type="text" placeholder="<?php echo $this->labels['company name']; ?>">
                    <input id="email" type="text" placeholder="<?php echo $this->labels['email']; ?>">
                    <select id="city_name">
                        <option value=""><?php echo $this->labels['select city']; ?></option>
                        <?php foreach($cities as $name): ?>
                            <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="filter-button-top"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search"></span></button>
                </form>
            </div><!--/filter-holder -->

            <div class="row table-holder">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->labels['personal/company code']; ?></th>
                        <th><?php echo $this->labels['name']; ?></th>
                        <th><?php echo $this->labels['email']; ?></th>
                        <th><?php echo $this->labels['phone']; ?></th>
                        <th><?php echo $this->labels['address']; ?></th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($pager->formatted_array as $supplier): ?>
                        <tr>
                            <td><?php echo $supplier->id;?></td>
                            <td><?php echo $supplier->company_code;?></td>
                            <td><?php echo $supplier->company_name;?></td>
                            <td><?php echo $supplier->email1;?></td>
                            <td><?php echo $supplier->phone1;?></td>
                            <td><?php echo $supplier->getAddressFormatted(', ') ?></td>
                            <td>
                                <?php if($this->rights['suppliers_edit']): ?>
                                    <?php echo CHtml::link($this->labels['edit'],'/contractors/editsupp/id/'.$supplier->id,array('class' => 'actions action-edit')); ?>
                                <?php endif; ?>
                                <?php if($this->rights['suppliers_delete']): ?>
                                    <?php echo CHtml::link($this->labels['delete'],'/contractors/deletesupp/id/'.$supplier->id,array('class' => 'actions action-delete')); ?>
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
