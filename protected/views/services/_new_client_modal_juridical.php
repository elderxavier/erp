<?php /* @var $this ServicesController */ ?>

<div class="modal new-customer-juridical" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header clearfix">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><?php echo $this->labels['new customer']; ?></h4>
            </div><!--/modal-header -->
            <form action="#" method="post">

                <div class="modal-body">
                    <div class="new-customer-table-holder">
                        <table>
                            <tr>
                                <td><label><?php echo $this->labels['name']; ?></label></td>
                                <td><input type="text" name="ClientForm[name]"><div class="errorMessage error">Error message</div></td>
                            </tr>

                            <tr>
                                <td><label><?php echo $this->labels['surname']; ?></label></td>
                                <td><input type="text" name="ClientForm[surname]"><div class="errorMessage error">Error message</div></td>
                            </tr>

                            <tr>
                                <td><label><?php echo $this->labels['phone']; ?></label></td>
                                <td><input type="text" name="ClientForm[phone1]"><div class="errorMessage error">Error message</div></td>
                            </tr>
                        </table>
                    </div><!--/new-customer-table-holder -->
                </div><!--/modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->labels['close']; ?><span class="glyphicon glyphicon-thumbs-down"></span></button>
                    <button type="button" class="btn btn-primary"><?php echo $this->labels['continue']; ?><span class="glyphicon glyphicon-share-alt"></span></button>
                </div><!--/modal-footer -->
            </form>
        </div><!--/modal-content -->
    </div><!--/modal-dioalog -->
</div><!--/moda new-customer -->