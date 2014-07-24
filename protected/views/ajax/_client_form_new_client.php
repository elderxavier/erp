<?php /* @var $client Clients */ ?>
<?php /* @var $client_name string */ ?>

<h2><span class="glyphicon glyphicon-user"></span><?php echo $this->labels['customer information']; ?></h2>

<h3><?php echo $client_name; ?></h3>

<div class="cust-data">
    <table width="100%">
        <tr>
            <td width="35%"><?php echo $this->labels['client type']; ?></td>
            <td width="65%">
                <a id="ed_type" href="#" title="<?php echo $this->labels['client type']; ?>" data-source="{0: '<?php echo $this->labels['physical']; ?>', 1: '<?php echo $this->labels['juridical']; ?>'}" style="display:inline"><?php echo $this->labels['physical']; ?></a>
                <input type="hidden" name="client[type]" id="ed_typeH">
            </td>
        </tr>

        <tr class="jur hidden">
            <td><?php echo $this->labels['company name']; ?></td>
            <td>
                <a id="ed_companyName" class="text-editable" title="<?php echo $this->labels['company name']; ?>" href="#"><?php echo $this->labels['empty']; ?></a>
                <input type="hidden" name="client[company_name]" id="ed_companyNameH">
            </td>
        </tr>

        <tr class="phys">
            <td><?php echo $this->labels['name']; ?></td>
            <td>
                <a id="ed_firstName" class="text-editable" title="<?php echo $this->labels['name']; ?>" href="#"><?php echo $this->labels['empty']; ?></a>
                <input type="hidden" name="client[name]" id="ed_firstNameH">
            </td>
        </tr>

        <tr class="phys">
            <td><?php echo $this->labels['surname']; ?></td>
            <td>
                <a id="ed_Surname" class="text-editable" title="<?php echo $this->labels['surname']; ?>" href="#"><?php echo $this->labels['empty']; ?></a>
                <input type="hidden" name="client[surname]" id="ed_SurnameH">
            </td>
        </tr>

        <tr class="phys">
            <td><?php echo $this->labels['personal code']; ?></td>
            <td>
                <a id="ed_PersonalCode" class="text-editable" title="<?php echo $this->labels['personal code']; ?>" href="#"><?php echo $this->labels['empty']; ?></a>
                <input type="hidden" name="client[personal_code]" id="ed_PersonalCodeH">
            </td>
        </tr>

        <tr class="jur hidden">
            <td><?php echo $this->labels['company code']; ?></td>
            <td>
                <a id="ed_CompanyCode" class="text-editable" title="<?php echo $this->labels['company code']; ?>" href="#"><?php echo $this->labels['empty']; ?></a>
                <input type="hidden" name="client[company_code]" id="ed_CompanyCodeH">
            </td>
        </tr>

        <tr class="both">
            <td><?php echo $this->labels['vat code']; ?></td>
            <td>
                <a id="ed_Vat" class="text-editable" title="<?php echo $this->labels['vat code']; ?>"  href="#"><?php echo $this->labels['empty']; ?></a>
                <input type="hidden" name="client[vat]" id="ed_VatH">
            </td>
        </tr>

        <tr class="both">
            <td><?php echo $this->labels['city']; ?></td>
            <td>
                <a id="ed_City" class="text-editable" title="<?php echo $this->labels['city']; ?>"  href="#"><?php echo $this->labels['empty']; ?></a>
                <input type="hidden" name="client[city]" id="ed_CityH">
            </td>
        </tr>

        <tr class="both">
            <td><?php echo $this->labels['street']; ?></td>
            <td>
                <a id="ed_Street" class="text-editable" title="<?php echo $this->labels['street']; ?>" href="#"><?php echo $this->labels['empty']; ?></a>
                <input type="hidden" name="client[street]" id="ed_StreetH">
            </td>
        </tr>

        <tr class="both">
            <td><?php echo $this->labels['house']; ?></td>
            <td>
                <a id="ed_House" class="text-editable" title="<?php echo $this->labels['house']; ?>" href="#"><?php echo $this->labels['empty']; ?></a>
                <input type="hidden" name="client[house]" id="ed_HouseH">
            </td>
        </tr>
    </table>

</div><!--/cust-data -->