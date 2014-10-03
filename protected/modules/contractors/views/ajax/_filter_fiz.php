<?php /* @var $this AjaxController */ ?>

<div class="form-inline">
    <div class="form-group filter-group">
        <label><?php echo $this->labels['filter']; ?></label>
        <input type="text" class="form-control client-filter by-name">
        <input type="text" class="form-control client-filter by-number">
        <button id="filter-search" class="form-control clearfix"><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search text-right"></span></button>
    </div><!--/form-group -->
</div><!--/form-inline -->


<div class="table-holder header-holder">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><?php echo $this->labels['name']; ?></th>
                <th><?php echo $this->labels['personal code']; ?></th>
                <th><?php echo $this->labels['address']; ?></th>
            </tr>
        </thead>
    </table> 
</div><!--/table-header-holder -->
<div class="table-holder body-holder">
    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <td colspan="3" class="text-center"><h5><?php echo $this->labels['no data']; ?></h5></td>
            </tr>                  
        </tbody>
    </table>
</div><!--body-holder-->

<div class="new-cust-btn-holder">
	<button data-toggle="modal" data-target=".new-customer-physical"><?php echo $this->labels['new person']; ?><span class="glyphicon glyphicon-plus-sign"></span></button>
</div><!--/new-cust-btn-holder -->