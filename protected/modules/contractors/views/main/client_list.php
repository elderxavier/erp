<?php /* @var $client Clients */ ?>
<?php /* @var $rights UserRights */ ?>
<?php /* @var $this ContractorsController */ ?>
<?php /* @var $pager CPagerComponent */ ?>

<?php /* @var $types array */ ?>
<?php /* @var $cities array */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/invoice_list.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/paginator.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/client_list.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <div class="row filter-holder">
                <form>
                    <input id="code" type="text" placeholder="<?php echo $this->labels['personal / company code']; ?>">
                    <input id="name" type="text" placeholder="<?php echo $this->labels['name or surname']; ?>">
                    <input id="email" type="text" placeholder="<?php echo $this->labels['email']; ?>">
                    <select id="type_id">
                        <option value=""><?php echo $this->labels['select type']; ?></option>
                        <?php foreach($types as $id => $name): ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                        <?php endforeach;?>
                    </select>
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
                        <th><?php echo $this->labels['personal / company code']; ?></th>
                        <th><?php echo $this->labels['type']; ?></th>
                        <th><?php echo $this->labels['name']; ?></th>
                        <th><?php echo $this->labels['email']; ?></th>
                        <th><?php echo $this->labels['phone']; ?></th>
                        <th><?php echo $this->labels['address']; ?></th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($pager->formatted_array as $client): ?>
                        <tr>
                            <td><?php echo $client->id; ?></td>
                            <td><?php echo $client->type == 1 ? $client->company_code : $client->personal_code; ?></td>
                            <td><?php echo $client->type == 1 ? $this->labels['juridical'] : $this->labels['physical']; ?></td>
                            <td><?php echo $client->type == 1 ? $client->company_name : $client->name.' '.$client->surname; ?></td>
                            <td><?php echo $client->email1; ?></td>
                            <td><?php echo $client->phone1; ?></td>
                            <td><?php echo $client->getAddressFormatted(', '); ?></td>
                            <td>
                                <?php if($this->rights['clients_edit']): ?>
                                    <?php echo CHtml::link($this->labels['edit'],'/'.$this->id.'/editclient/id/'.$client->id,array('class' => 'actions action-edit')); ?>
                                <?php endif; ?>
                                <?php if($this->rights['clients_delete']): ?>
                                    <?php echo CHtml::link($this->labels['delete'],'/'.$this->id.'/deleteclient/id/'.$client->id,array('class' => 'actions action-delete')); ?>
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
