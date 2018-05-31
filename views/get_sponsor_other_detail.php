<?php
include_once '../common/config.php';

extract($_GET);
$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'migrate_name', ":is_active" => 1);
$reason_for_change = $obj->fetchRowAll('masters_list', $cond, $params);

$reasonData = array();
$familyData = array();
$gnameData = array();

if ($_GET) {

    $cond = "sponsor_id=:sponsor_id";
    $params = array(":sponsor_id" => $sponsor_id);
    $row = $obj->fetchRow('sponsor', $cond, $params);

    if ($row['reason_for_change'] != "") {
        $reasonData = explode(",", $row['reason_for_change']);
    }

    if ($row['family_name'] != "") {
        $familyData = explode(",", $row['family_name']);
    }

    if ($row['given_name'] != "") {
        $gnameData = explode(",", $row['given_name']);
    }

}

for ($i = 1; $i < count($reasonData); $i++) {
    ?>

    <div id="other_name_details_div01" class="detail1">
        <div class="input-field col s6 family_name">
            <input name="family_name[]" type="text"
                   class="validate" value="<?php echo $familyData[$i]; ?>">
            <label for="family_name[]">Family Name</label>
        </div>
        <div class="input-field col s6">
            <input name="given_name[]" type="text"
                   class="validate" value="<?php echo $gnameData[$i]; ?>">
            <label for="family_name[]">Given Name</label>
        </div>
        <div class="input-field col s10">
            <div class="input-field col s4">
                <label for="reason_for_change">Reason For Change</label>
            </div>
            <div class="input-field col s7">
                <select name="reason_for_change[]"
                        class="form-control validate" style="">
                    <option value="">---Select---</option>
                    <?php if (!empty($reason_for_change)) {
                        $selected = "";
                        for ($j = 0; $j < count($reason_for_change); $j++) {
                            if ($reasonData[$i] == $reason_for_change[$j]['name']) {
                                $selected = "selected";
                            }
                            ?>
                            <option <?php echo $selected; ?>
                                    value="<?php echo $reason_for_change[$j]['name']; ?>">
                                <?php echo ucfirst($reason_for_change[$j]['name']); ?></option>
                            <?php $selected = '';
                        }
                    } ?>
                </select>
            </div>
        </div>
        <div class="input-field col s2">
            <i class="fa fa-trash-o remove-details-div"></i>
        </div>
        <div class="clearfix"></div>
    </div>
<?php } ?>
