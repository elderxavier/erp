<?php /* @var $invoices OperationsOut[] */ ?>
<?php /* @var $this SellController */ ?>
<?php /* @var $cities array */ ?>
<?php /* @var $types array */ ?>
<?php /* @var $statuses array */ ?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/invoice_list.css');
//$cs->registerScriptFile(Yii::app()->baseUrl.'/js/buy-ops.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('//partials/_sub_menu',array('links' => $this->GetSubMenu(), 'params' => array())); ?>

<div class="container-fluid  main-content-holder content-wrapper">
    <div class="row filter-holder">
        <form>
            <input type="text" placeholder="<?php echo $this->labels['invoice code']; ?>">
            <input type="text" placeholder="<?php echo $this->labels['client name']; ?>">
            <select>
                <option disabled selected value=""><?php echo $this->labels['client type']; ?></option>
                <option value=""><?php echo $this->labels['all']; ?></option>
                <?php foreach($types as $id => $type): ?>
                    <option value="<?php echo $id; ?>"><?php echo $type; ?></option>
                <?php endforeach;?>
            </select>
            <select>
                <option disabled selected value=""><?php echo $this->labels['city']; ?></option>
                <option value=""><?php echo $this->labels['all']; ?></option>
                <?php foreach($cities as $id => $city): ?>
                    <option value="<?php echo $id; ?>"><?php echo $city; ?></option>
                <?php endforeach;?>
            </select>
            <input type="text" placeholder="<?php echo $this->labels['date from']; ?>">
            <input type="text" placeholder="<?php echo $this->labels['date to']; ?>">
            <select>
                <option value=""><?php echo $this->labels['delivery status']; ?></option>
                <?php foreach($statuses as $id => $status): ?>
                    <option value="<?php echo $id; ?>"><?php echo $status; ?></option>
                <?php endforeach;?>
            </select>
            <button><?php echo $this->labels['search']; ?><span class="glyphicon glyphicon-search"></span></button>
        </form>
    </div><!--/filter-holder -->
    <div class="row table-holder">
        <table class="table table-bordered table-striped table-hover" >
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo $this->labels['operation id']; ?></th>
                <th><?php echo $this->labels['client']; ?></th>
                <th><?php echo $this->labels['client type']; ?></th>
                <th><?php echo $this->labels['city']; ?></th>
                <th><?php echo $this->labels['created']; ?></th>
                <th><?php echo $this->labels['invoice code']; ?></th>
                <th><?php echo $this->labels['PDF']; ?></th>
                <th><?php echo $this->labels['delivery status']; ?></th>
                <th><?php echo $this->labels['actions']; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($invoices as $nr => $operation): ?>
                <tr>
                    <td><?php echo $nr + 1; ?></td>
                    <td><a href="#" data-toggle="modal" data-id="<?php echo $operation->id; ?>" data-target="#invoiceInfo"><?php echo $operation->id; ?></a></td>
                    <td><?php echo $operation->client->getFullName(); ?></td>
                    <td><?php echo $operation->client->type == 1 ? $this->labels['juridical'] : $this->labels['physical']; ?></td>
                    <td><?php echo $operation->stock->location->city_name; ?></td>
                    <td><?php echo date('Y.m.d G:i',$operation->date_created); ?></td>
                    <td><?php echo $operation->invoice_code; ?></td>
                    <td><a href="#"><?php echo $this->labels['generate pdf']; ?></a></td>
                    <td><?php echo $operation->status->name; ?></td>
                    <td><a href="#"><?php echo $this->labels['send invoice']; ?></a></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div><!--/table-holder -->

    <div class="modals-holder">
        <div class="invoice-ready">

            <div class="modal fade" id="invoiceInfo" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Invoice : 213232323</h4>
                        </div><!--/.modal-heafer -->
                        <div class="modal-body">
                            <div class="supl-header">
                                <table class="table table-bordered" width="100%">
                                    <tr>
                                        <td>company</td>
                                        <td>inclusion</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>compaany code</td>
                                        <td>2324234</td>
                                        <td>Vat code </td>
                                        <td>fdghhfdhg</td>
                                    </tr>
                                    <tr>
                                        <td>Adress</td>
                                        <td colspan="3">Vilnius, kapsu g 8, LT-21345</td>
                                    </tr>
                                </table>
                            </div><!--/supl-header -->
                            <div class="modal-prod-list-holder">
                                <table class="table table-bordered" width="100%">
                                    <thead>
                                    <tr>
                                        <th>product name</th>
                                        <th>prod code</th>
                                        <th>units</th>
                                        <th>quant</th>
                                        <th>price (EUR)</th>
                                        <th>discount %</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Product 1</td>
                                        <td>prd 12345677</td>
                                        <td>litr</td>
                                        <td>123</td>
                                        <td>213321</td>
                                        <td>10</td>
                                    </tr>

                                    <tr>
                                        <td>Product 1</td>
                                        <td>prd 12345677</td>
                                        <td>litr</td>
                                        <td>123</td>
                                        <td>213321</td>
                                        <td>5</td>
                                    </tr>
                                    <tr class="total">
                                        <td colspan="3"></td>
                                        <td colspan="2">Total :</td>
                                        <td>700 EUR</td>
                                    </tr>
                                    <tr class="total-with-vat">
                                        <td colspan="3"></td>
                                        <td colspan="2">Total 21% VAT :</td>
                                        <td>700 EUR</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div><!--/modal-prod-list-holder -->
                        </div><!--/modal-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close<span class="glyphicon glyphicon-thumbs-down"></span></button>
                        </div><!--/modal-footer -->
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div><!--/invoice-ready -->

    </div><!--/modals-holder -->

</div><!--/container -->