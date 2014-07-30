<?php /* @var $client Clients */ ?>
<?php /* @var $id int */ ?>

<h2><span class="glyphicon glyphicon-user"></span><?php echo $this->labels['customer information']; ?></h2>

<h3><?php echo $client->type == 1 ? $client->company_name : $client->name.' '.$client->surname; ?></h3>

<div class="cust-data">

    <input type="hidden" name="client[id]" value="<?php echo $id; ?>">

    <table width="100%">

        <tr>
            <td width="35%"><?php echo $this->labels['client type']; ?></td>
            <td width="65%">
                <a href="#" title="<?php echo $this->labels['client type']; ?>"  style="display:inline"><?php echo $client->type == 1 ? $this->labels['juridical'] : $this->labels['physical']; ?></a>
                <input type="hidden" value="<?php echo (int)$client->type; ?>" name="client[type]">
            </td>
        </tr>

        <?php if($client->type == 1): ?>
        <tr class="jur">
            <td><?php echo $this->labels['company name']; ?></td>
            <td>
                <a id="ed_companyName" class="text-editable" title="<?php echo $this->labels['company name']; ?>" href="#"><?php echo $client->company_name; ?></a>
                <input type="hidden" name="client[company_name]" value="<?php echo $client->company_name; ?>" id="ed_companyNameH">
            </td>
        </tr>
        <?php endif; ?>

        <?php if($client->type == 0): ?>
        <tr class="phys">
            <td><?php echo $this->labels['name']; ?></td>
            <td>
                <a id="ed_firstName" class="text-editable" title="<?php echo $this->labels['name']; ?>" href="#"><?php echo $client->name; ?></a>
                <input type="hidden" name="client[name]" value="<?php echo $client->name; ?>" id="ed_firstNameH">
            </td>
        </tr>

        <tr class="phys">
            <td><?php echo $this->labels['surname']; ?></td>
            <td>
                <a id="ed_Surname" class="text-editable" title="<?php echo $this->labels['surname']; ?>" href="#"><?php echo $client->surname; ?></a>
                <input type="hidden" name="client[surname]" value="<?php echo $client->surname; ?>" id="ed_SurnameH">
            </td>
        </tr>

        <tr class="phys">
            <td><?php echo $this->labels['personal code']; ?></td>
            <td>
                <a id="ed_PersonalCode" class="text-editable" title="<?php echo $this->labels['personal code']; ?>" href="#"><?php echo $client->personal_code; ?></a>
                <input type="hidden" name="client[personal_code]" value="<?php echo $client->personal_code; ?>" id="ed_PersonalCodeH">
            </td>
        </tr>
        <?php endif; ?>

        <?php if($client->type == 1): ?>
        <tr class="jur">
            <td><?php echo $this->labels['company code']; ?></td>
            <td>
                <a id="ed_CompanyCode" class="text-editable" title="<?php echo $this->labels['company code']; ?>" href="#"><?php echo $client->company_code; ?></a>
                <input type="hidden" name="client[company_code]" value="<?php echo $client->company_code; ?>" id="ed_CompanyCodeH">
            </td>
        </tr>
        <?php endif; ?>

        <tr class="both">
            <td><?php echo $this->labels['vat code']; ?></td>
            <td>
                <a id="ed_Vat" class="text-editable" title="<?php echo $this->labels['vat code']; ?>"  href="#"><?php echo $client->vat_code; ?></a>
                <input type="hidden" value="<?php echo $client->vat_code; ?>" name="client[vat_code]" id="ed_VatH">
            </td>
        </tr>

        <tr class="both hidden">
            <td><?php echo $this->labels['phone']; ?></td>
            <td>
                <a id="ed_Phone" class="text-editable" title="<?php echo $this->labels['phone']; ?>"  href="#"><?php echo $client->phone1; ?></a>
                <input type="hidden" value="<?php echo $client->phone1; ?>" name="client[phone1]" id="ed_PhoneH">
            </td>
        </tr>

        <tr class="both hidden">
            <td><?php echo $this->labels['email']; ?></td>
            <td>
                <a id="ed_Email" class="text-editable" title="<?php echo $this->labels['email']; ?>"  href="#"><?php echo $client->email1; ?></a>
                <input type="hidden" value="<?php echo $client->email1; ?>" name="client[email1]" id="ed_EmailH">
            </td>
        </tr>

        <tr class="both">
            <td><?php echo $this->labels['city']; ?></td>
            <td>
                <a id="ed_City" class="text-editable" title="<?php echo $this->labels['city']; ?>"  href="#"><?php echo $this->labels['empty']; ?></a>
                <input type="hidden" value="" name="client[city]" id="ed_CityH">
            </td>
        </tr>

        <tr class="both">
            <td><?php echo $this->labels['street']; ?></td>
            <td>
                <a id="ed_Street" class="text-editable" title="<?php echo $this->labels['street']; ?>" href="#"><?php echo $this->labels['empty']; ?></a>
                <input type="hidden" value="" name="client[street]" id="ed_StreetH">
            </td>
        </tr>

        <tr class="both">
            <td><?php echo $this->labels['house']; ?></td>
            <td>
                <a id="ed_House" class="text-editable" title="<?php echo $this->labels['house']; ?>" href="#"><?php echo $this->labels['empty']; ?></a>
                <input type="hidden" value="" name="client[house]" id="ed_HouseH">
            </td>
        </tr>
    </table>
    <br>
    <a class="make-new-client-link" href="/ajax/newclient/name/<?php echo $client->type == 1 ? $client->company_name : $client->name.' '.$client->surname; ?>">Make new</a>
</div><!--/cust-data -->