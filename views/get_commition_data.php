<?php
include_once '../common/config.php';

extract($_GET);
$cond = "is_active =:is_active";
$params = array(":is_active" => 1);
$organization = $obj->fetchRowAll('organization', $cond, $params);

$cond = "course_id =:course_id";
$params = array(":course_id" => $course_id);
$course_details = $obj->fetchRow('student_course', $cond, $params);
$student_fees = $obj->fetchRow('student_fees', $cond, $params);

$semArray = array(1 => 'First', 2 => 'Second', 3 => 'Third', 4 => 'Forth', 5 => 'Fifth', 6 => 'Six', 7 => 'Sevent', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten');
$arrFees = array();
$arrCommition = array();
$arrInvoiceData = array();
$arrInstitute = array();

if (!empty($student_fees)) {
    if ($student_fees['sem_fees'] != "") {
        $arrFees = explode(',', $student_fees['sem_fees']);
    }

    if ($student_fees['commission'] != "") {
        $arrCommition = explode(',', $student_fees['commission']);
    }

    if ($student_fees['invoice_date'] != "") {
        $arrInvoiceData = explode(',', $student_fees['invoice_date']);
    }

    if ($student_fees['institute_id'] != "") {
        $arrInstitute = explode(',', $student_fees['institute_id']);
    }
}

if ($course_details['no_of_semester'] > 0) {
    $cnt = 0;
    ?>
    <input type="hidden" name="fees_id" id="fees_id" value="<?php if (!empty($student_fees)) {
        echo $student_fees['fees_id'];
    } else {
        echo "0";
    } ?> ">
    <?php
    for ($i = 1; $i <= $course_details['no_of_semester']; $i++) {
        ?>

        <div class="input-field col s6 family_name">
            <input name="sem_inx[]" id="sem_inx<?php echo $i; ?>" value="<?php echo $i; ?>" type="hidden">
            <input name="sem_fees[]" id="sem_fees<?php echo $i; ?>" type="text"
                   class="validate" value="<?php if (!empty($arrFees)) {
                if (isset($arrFees[$cnt])) {
                    echo $arrFees[$cnt];
                }
            } ?>">
            <label for="sem_list[]"><?php echo $semArray[$i]; ?> sem fees</label>
            <span id="sem_msg"></span>
        </div>
        <div class="input-field col s6">
            <input name="commission[]" id="commission<?php echo $i; ?>" type="text"
                   class="validate" value="<?php if (!empty($arrCommition)) {
                if (isset($arrCommition[$cnt])) {
                    echo $arrCommition[$cnt];
                }
            } ?>">
            <label for="commission[]">Commission</label>
        </div>
        <div class="input-field col s6">
            <input name="invoice_date[]" id="invoice_date<?php echo $i; ?>" type="text"
                   class="validate" value="<?php if (!empty($arrInvoiceData)) {
                if (isset($arrInvoiceData[$cnt])) {
                    echo $arrInvoiceData[$cnt];
                }
            } ?>">
            <label for="invoice_date[]">Date to generate invoice</label>
        </div>
        <div class="input-field col s6">
            <div class="input-field col s4">
                <label for="reason_for_change">Institute</label>
            </div>
            <div class="input-field col s7">
                <select name="institute_id[]" id="institute_id"
                        class="form-control validate" style="">
                    <option value="">---Select---</option>
                    <?php if (!empty($organization)) {
                        $selected = "";
                        for ($j = 0; $j < count($organization); $j++) {
                            if ($arrInstitute[$cnt] == $organization[$j]['institute_id']) {
                                $selected = "selected";
                            }
                            ?>
                            <option <?php echo $selected; ?>
                                    value="<?php echo $organization[$j]['institute_id']; ?>">
                                <?php echo ucfirst($organization[$j]['name_of_intitute']); ?></option>
                            <?php $selected = '';
                        }
                    } ?>
                </select>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php $cnt++;
    }
}
?>
