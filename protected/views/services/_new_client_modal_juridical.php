<?php /* @var $this ServicesController */ ?>

<div class="modal new-customer-juridical" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header clearfix">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><?php echo $this->labels['new customer']; ?></h4>
            </div><!--/modal-header -->
            <form id="Juridical" class="modal-new-client-form" action="<?php echo $this->createUrl('/services/continuefromnew'); ?>" method="post">

                <div class="modal-body">
                    <div class="new-customer-table-holder">
                        <table>

                            <tr>
                                <td><label><?php echo $this->labels['name']; ?></label></td>
                                <td><input type="text" name="ClientJuridical[name]"><div id="Juridical_name_err" class="errorMessage error hidden"><?php echo $this->labels['this filed is required']; ?></div></td>
                            </tr>

                            <tr>
                                <td><label><?php echo $this->labels['surname']; ?></label></td>
                                <td><input type="text" name="ClientJuridical[surname]"><div id="Juridical_surname_err" class="errorMessage error hidden"><?php echo $this->labels['this filed is required']; ?></div></td>
                            </tr>

                            <tr>
                                <td><label><?php echo $this->labels['vat code']; ?></label></td>
                                <td><input type="text" name="ClientJuridical[vat_code]"><div id="Juridical_vat_code_err" class="errorMessage error hidden"><?php echo $this->labels['this filed is required']; ?></div></td>
                            </tr>

                            <tr>
                                <td><label><?php echo $this->labels['company code']; ?></label></td>
                                <td><input type="text" name="ClientJuridical[company_code]"><div id="Juridical_company_code_err" class="errorMessage error hidden"><?php echo $this->labels['this filed is required']; ?></div></td>
                            </tr>

                            <tr>
                                <td><label><?php echo $this->labels['company name']; ?></label></td>
                                <td><input type="text" name="ClientJuridical[company_name]"><div id="Juridical_company_name_err" class="errorMessage error hidden"><?php echo $this->labels['this filed is required']; ?></div></td>
                            </tr>

                            <tr>
                                <td><label><?php echo $this->labels['phone']; ?></label></td>
                                <td><input type="text" name="ClientJuridical[phone1]"><div id="Juridical_phone1_err" class="errorMessage error hidden"><?php echo $this->labels['this filed is required']; ?></div></td>
                            </tr>

                            <tr>
                                <td><label><?php echo $this->labels['email']; ?></label></td>
                                <td><input type="text" name="ClientJuridical[email1]"><div id="Juridical_email1_err" class="errorMessage error hidden"><?php echo $this->labels['this filed is required']; ?></div></td>
                            </tr>

                            <tr>
                                <td><label><?php echo $this->labels['remark']; ?></label></td>
                                <td>
                                    <textarea name="ClientJuridical[remark]"></textarea>
                                    <div id="Juridical_remark_err" class="errorMessage error hidden"><?php echo $this->labels['this filed is required']; ?></div>
                                </td>
                            </tr>

                        </table>
                    </div><!--/new-customer-table-holder -->
                </div><!--/modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->labels['close']; ?><span class="glyphicon glyphicon-thumbs-down"></span></button>
                    <button type="submit" class="btn btn-primary"><?php echo $this->labels['continue']; ?><span class="glyphicon glyphicon-share-alt"></span></button>
                </div><!--/modal-footer -->
            </form>
        </div><!--/modal-content -->
    </div><!--/modal-dioalog -->
</div><!--/moda new-customer -->