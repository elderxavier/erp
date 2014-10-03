<?php /* @var $data Suppliers */ ?>
<?php /* @var $this Controller */ ?>

<div class="modal-header clearfix">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $this->labels['close']; ?></span></button>
    <h4 class="modal-title"><?php echo $data->company_name; ?></h4>
</div><!--/modal-header -->

<div class="modal-body">
    <div class="cust-info-table">
        <h5><?php echo $this->labels['info']; ?></h5>
        <table>
            <tr>
                <td><?php echo $this->labels['company name']; ?></td>
                <td><?php echo $data->company_name; ?></td>
            </tr>

            <tr>
                <td><?php echo $this->labels['company code']; ?></td>
                <td><?php echo $data->company_code?></td>
            </tr>
            <tr>
                <td><?php echo $this->labels['vat code']; ?></td>
                <td><?php echo $data->vat_code?></td>
            </tr>
            <tr>
                <td><?php echo $this->labels['phone']; ?></td>
                <td><?php echo $data->phone1; echo ' ,'.$data->phone2; ?></td>
            </tr>
            <tr>
                <td><?php echo $this->labels['email']; ?></td>
                <td><?php echo $data->email1; echo ($data->email2)? ' ,'.$data->email2 : ''; ?></td>
            </tr>
            <tr>
                <td><?php echo $this->labels['address']; ?></td>
                <td><?php echo $data->country.', '.$data->city.', '.$data->street.', '.$data->building_nr; ?></td>
            </tr>
        </table>
    </div><!--/cust-info-table -->
</div><!--/modoal-body -->

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->labels['close']; ?><span class="glyphicon glyphicon-thumbs-down"></span></button>
    <a href="/buy/createinvoice/<?php echo $data->id ?>" type="button" class="btn btn-primary"><?php echo $this->labels['continue']; ?><span class="glyphicon glyphicon-share-alt"></span></a>
</div><!--/modal-footer -->