<?php
include_once '../common/config.php';

extract($_GET);
$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'Currency', ":is_active" => 1);
$currency = $obj->fetchRowAll('masters_list', $cond, $params);

$reasonData = array();
$familyData = array();
$gnameData = array();

if ($_GET) {

    $cond = "sponsor_id=:sponsor_id";
    $params = array(":sponsor_id" => $sponsor_id);
    $financial = $obj->fetchRow('financial', $cond, $params);

    $branchData = array();

    if ($financial['branch_name'] != "") {
        $branchData = explode(",", $financial['branch_name']);
    }

    $branchCodeData = array();

    if ($financial['branch_code'] != "") {
        $branchCodeData = explode(",", $financial['branch_code']);
    }

    $accountData = array();

    if ($financial['account_name'] != "") {
        $accountData = explode(",", $financial['account_name']);
    }

    $accountNumData = array();

    if ($financial['account_number'] != "") {
        $accountNumData = explode(",", $financial['account_number']);
    }

    $accountTypeData = array();

    if ($financial['account_type'] != "") {
        $accountTypeData = explode(",", $financial['account_type']);
    }

    $balanceData = array();

    if ($financial['balance_in_inr'] != "") {
        $balanceData = explode(",", $financial['balance_in_inr']);
    }

    $referanceData = array();

    if ($financial['referance_rate_type'] != "") {
        $referanceData = explode(",", $financial['referance_rate_type']);
    }

    $refData = array();

    if ($financial['ref_rate'] != "") {
        $refData = explode(",", $financial['ref_rate']);
    }

    $availableData = array();

    if ($financial['available_balance'] != "") {
        $availableData = explode(",", $financial['available_balance']);
    }
}

for ($i = 1; $i < count($branchData); $i++) {
    ?>

    <div class="rev-tra">
        <div class="row">
            <div class="input-field col s6">
                <input id="branch_name" name="branch_name[]" type="text"
                       class="validate"
                       value="<?php if (!empty($branchData)) {
                           echo $branchData[$i];
                       } ?>">
                <label for="first_name">Branch Name</label>
            </div>
            <div class="input-field col s6">
                <input id="branch_code" name="branch_code[]" type="text"
                       class="validate"
                       value="<?php if (!empty($branchCodeData)) {
                           echo $branchCodeData[$i];
                       } ?>">
                <label for="first_name">Branch Code</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input id="account_name" name="account_name[]" type="text"
                       class="validate"
                       value="<?php if (!empty($accountData)) {
                           echo $accountData[$i];
                       } ?>">
                <label for="first_name">Account Name</label>
            </div>
            <div class="input-field col s6">
                <input id="account_number" name="account_number[]" type="text"
                       class="validate"
                       value="<?php if (!empty($accountNumData)) {
                           echo $accountNumData[$i];
                       } ?>">
                <label for="first_name">Account Number</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input id="account_type" name="account_type[]" type="text"
                       class="validate"
                       value="<?php if (!empty($accountTypeData)) {
                           echo $accountTypeData[$i];
                       } ?>">
                <label for="first_name">Account Type</label>
            </div>
            <div class="input-field col s6">
                <input data-id="<?php echo $i;?>" id="balance_in_inr<?php echo $i;?>" name="balance_in_inr[]" type="text"
                       class="validate currency_convert"
                       value="<?php if (!empty($balanceData)) {
                           echo $balanceData[$i];
                       } ?>">
                <label for="first_name">Balance in INR</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <div class="input-field col s2">
                    <label for="Business Type">Reference Rate</label>
                </div>
                <div class="input-field col s10">
                    <select name="referance_rate_type[]" class="form-control validate currency_convert"
                            id="referance_rate_type<?php echo $i;?>">
                        <option value="">---Select---</option>
                        <option <?php if ($referanceData[$i] == 'AUD'){ echo "selected";}?>  value="AUD">AUD - Australian Dollars</option>
                        <option <?php if ($referanceData[$i] == 'USD'){ echo "selected";}?> value="USD">USD - American Dollars</option>
                        <option <?php if ($referanceData[$i] == 'NZD'){ echo "selected";}?> value="NZD">NZD - New Zealand Dollars</option>
                        <option <?php if ($referanceData[$i] == 'CAD'){ echo "selected";}?> value="CAD">CAD - Canadian Dollars</option>
                    </select>
                </div>
            </div>
            <div class="input-field col s6">
                <input data-id="<?php echo $i;?>" id="ref_rate<?php echo $i;?>" name="ref_rate[]" type="text"
                       class="validate currency_convert"
                       value="<?php if (!empty($refData)) {
                           echo $refData[$i];
                       } ?>">
                <label for="first_name">Current Rate of reference </label>
            </div>
        </div>
        <div class="row" id="balance_<?php echo $i;?>">
            <div class="col s6">
                <label for="first_name">Available Balance in : </label>
                <input id="available_balance<?php echo $i;?>" name="available_balance[]" type="hidden"
                       class="validate"
                       value="<?php if (!empty($availableData)) {
                           echo $availableData[$i];
                       } ?>">
            </div>
            <div class="col s6">
                <label id="available_balance_<?php echo $i;?>"><?php if (!empty($availableData)) {
                        echo $availableData[$i]. " ".$referanceData[$i];
                    } ?></label>
            </div>
        </div><i class="fa fa-trash-o remove-tra-div"></i>
        <div class="clearfix"></div>
    </div>
<?php } ?>
