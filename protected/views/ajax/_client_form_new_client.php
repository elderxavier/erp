<?php /* @var $client Clients */ ?>
<?php /* @var $client_name string */ ?>
<?php /* @var $this Controller */ ?>

<h2><span class="glyphicon glyphicon-user"></span><?php echo $this->labels['customer information']; ?></h2>

<h3><?php echo $client_name; ?></h3>

<div class="cust-data">
    <table width="100%">
        <tr>
            <td width="35%"><?php echo $this->labels['client type']; ?></td>
            <td width="65%">
                <a id="ed_type" href="#" title="<?php echo $this->labels['client type']; ?>" data-emptytext="<?php echo $this->labels['select']; ?>"  data-source="{0: '<?php echo $this->labels['physical']; ?>', 1: '<?php echo $this->labels['juridical']; ?>'}" style="display:inline"></a>
                <input type="hidden" name="client[type]" id="ed_typeH">
            </td>
        </tr>

        <tr class="jur hidden">
            <td><?php echo $this->labels['company name']; ?></td>
            <td>
                <a id="ed_companyName" class="text-editable" data-name="<?php echo $this->labels['company name']; ?>" data-emptytext="<?php echo $this->labels['empty']; ?>" href="#"></a>
                <input type="hidden" name="client[company_name]" id="ed_companyNameH">
            </td>
        </tr>

        <tr class="phys hidden">
            <td><?php echo $this->labels['name']; ?></td>
            <td>
                <a id="ed_firstName" class="text-editable" data-name="<?php echo $this->labels['name']; ?>"  data-emptytext="<?php echo $this->labels['empty']; ?>" href="#"></a>
                <input type="hidden" name="client[name]" id="ed_firstNameH">
            </td>
        </tr>

        <tr class="phys hidden">
            <td><?php echo $this->labels['surname']; ?></td>
            <td>
                <a id="ed_Surname" class="text-editable" data-name="<?php echo $this->labels['surname']; ?>"  data-emptytext="<?php echo $this->labels['empty']; ?>" href="#"></a>
                <input type="hidden" name="client[surname]" id="ed_SurnameH">
            </td>
        </tr>

        <tr class="phys hidden">
            <td><?php echo $this->labels['personal code']; ?></td>
            <td>
                <a id="ed_PersonalCode" class="text-editable" data-name="<?php echo $this->labels['personal code']; ?>"  data-emptytext="<?php echo $this->labels['empty']; ?>" href="#"></a>
                <input type="hidden" name="client[personal_code]" id="ed_PersonalCodeH">
            </td>
        </tr>

        <tr class="jur hidden">
            <td><?php echo $this->labels['company code']; ?></td>
            <td>
                <a id="ed_CompanyCode" class="text-editable" data-name="<?php echo $this->labels['company code']; ?>"  data-emptytext="<?php echo $this->labels['empty']; ?>" href="#"></a>
                <input type="hidden" name="client[company_code]" id="ed_CompanyCodeH">
            </td>
        </tr>

        <tr class="both hidden">
            <td><?php echo $this->labels['vat code']; ?></td>
            <td>
                <a id="ed_Vat" class="text-editable" data-name="<?php echo $this->labels['vat code']; ?>"  data-emptytext="<?php echo $this->labels['empty']; ?>"  href="#"></a>
                <input type="hidden" name="client[vat]" id="ed_VatH">
            </td>
        </tr>

        <tr class="both hidden">
            <td><?php echo $this->labels['city']; ?></td>
            <td>
                <a id="ed_City" class="text-editable" data-name="<?php echo $this->labels['city']; ?>"  data-emptytext="<?php echo $this->labels['empty']; ?>"  href="#"></a>
                <input type="hidden" name="client[city]" id="ed_CityH">
            </td>
        </tr>

        <tr class="both hidden">
            <td><?php echo $this->labels['street']; ?></td>
            <td>
                <a id="ed_Street" class="text-editable" data-name="<?php echo $this->labels['street']; ?>"  data-emptytext="<?php echo $this->labels['empty']; ?>" href="#"></a>
                <input type="hidden" name="client[street]" id="ed_StreetH">
            </td>
        </tr>

        <tr class="both hidden">
            <td><?php echo $this->labels['house']; ?></td>
            <td>
                <a id="ed_House" class="text-editable" data-name="<?php echo $this->labels['house']; ?>"  data-emptytext="<?php echo $this->labels['empty']; ?>" href="#"></a>
                <input type="hidden" name="client[house]" id="ed_HouseH">
            </td>
        </tr>
    </table>

</div><!--/cust-data -->