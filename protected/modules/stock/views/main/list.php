<?php /* @var $products ProductInStock[] */ ?>
<?php /* @var $this StockController */ ?>
<?php /* @var $cities array */ ?>
<?php /* @var $units array */ ?>
<?php /* @var $pager CPagerComponent */ ?>


<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/stock_list.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/paginator.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/stock.js',CClientScript::POS_END);
?>
   
<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>
  
	<div class="container-fluid  main-content-holder content-wrapper">

    	<div class="row filter-holder">
            <form method="post" action="#">
                <input id="prod-name" type="text" placeholder="<?php echo $this->labels['product name']; ?>">
                <input id="prod-code" type="text" placeholder="<?php echo $this->labels['product code']; ?>">

                <select id="stock-location">
                	<option value=""><?php echo $this->labels['stock location']; ?></option>
                    <?php foreach($cities as $id => $name): ?>
                        <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                    <?php endforeach ?>
                </select>
                <select id="measure-units">
                	<option value=""><?php echo $this->labels['measure units']; ?></option>
                    <?php foreach($units as $id => $name): ?>
                        <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                    <?php endforeach;?>
                </select>
                <button class="filter-button-top"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search"></span></button>
           </form> 
        </div><!--/filter-holder -->

        <div class="row table-holder">
        	<table class="table table-bordered table-striped table-hover">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th><?php echo $this->labels['product name']; ?></th>
                        <th><?php echo $this->labels['product code']; ?></th>
                        <th><?php echo $this->labels['stock']; ?></th>
                        <th><?php echo $this->labels['measure']; ?></th>
                        <th><?php echo $this->labels['quantity']; ?></th>
                        <th><?php echo $this->labels['refurbished'] ?></th>
                        <th><?php echo $this->labels['actions']; ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($pager->formatted_array as $nr => $product):?>
                	<tr>
                    	<td><?php echo $nr; ?></td>
                    	<td><?php echo $product->productCard->product_name;?></td>
                    	<td><?php echo $product->productCard->product_code;?></td>
                    	<td><?php echo $product->stock->name." [".$product->stock->location->city_name."]"; ?></td>
                    	<td><?php echo $product->productCard->measureUnits->name; ?></td>
                    	<td><?php echo $product->qnt;?></td>
                        <td>0</td>
                        <td></td>
                   </tr>
                   <?php endforeach;?>
                </tbody>
            </table>
            <?php $pager->renderPages(); ?>
        </div><!--/table-holder -->


        <div class="modals-holder">
        <!--/ modal area -->
        </div><!--/modals-holder -->
    </div><!--/container -->
