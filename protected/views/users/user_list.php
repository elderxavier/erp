<?php /* @var $user Users */?>
<?php /* @var $users Array */ ?>
<?php /* @var $this UsersController */ ?>
<?php /* @var $pager CPagerComponent */ ?>

<?php /* @var $cities Array */ ?>
<?php /* @var $positions Array */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/user_list.js',CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/invoice_list.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/paginator.css');
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="row filter-holder">
                <form>
                    <input id="name-surname" type="text" placeholder="<?php echo $this->labels['name or surname']; ?>">
                    <select id="position_id">
                        <option value=""><?php echo $this->labels['select position']; ?></option>
                        <?php foreach($positions as $id => $name): ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="city_id">
                        <option value=""><?php echo $this->labels['select city']; ?></option>
                        <?php foreach($cities as $id => $name): ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button id="search-btn"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search"></span></button>
                </form>
            </div><!--/filter-holder -->
            <div class="table-holder">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->labels['name']; ?></th>
                        <th><?php echo $this->labels['surname']; ?></th>
                        <th><?php echo $this->labels['position']; ?></th>
                        <th><?php echo $this->labels['city']; ?></th>
                        <th><?php echo $this->labels['actions'] ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($pager->formatted_array as $user): ?>
                        <tr>
                            <td><?php echo $user->id; ?></td>
                            <td><?php echo $user->name; ?></td>
                            <td><?php echo $user->surname; ?></td>
                            <td><?php echo $user->position ? $user->position->name : '-'; ?></td>
                            <td><?php echo $user->city ? $user->city->city_name : '-'; ?></td>
                            <td>
                                <?php if($this->rights['users_edit']): ?>
                                    <?php echo CHtml::link($this->labels['edit'],'/'.$this->id.'/edit/id/'.$user->id,array('class' => 'actions action-edit')); ?>
                                <?php endif; ?>
                                <?php if($this->rights['users_delete']): ?>
                                    <?php echo CHtml::link($this->labels['delete'],'/'.$this->id.'/delete/id/'.$user->id,array('class' => 'actions action-delete')); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php $pager->renderPages();?>
            </div><!--/table-holder -->
        </div>
    </div>
</div><!--/container -->
