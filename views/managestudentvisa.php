<?php include_once '../include/header.php'; ?>
<?php

$row = array();
$education = array();
$experiences = array();
$financial = array();
$relative_data = array();
$event_data = array();
$types = "tab";

$loginid = $objsession->get("log_admin_loginid");
$inquiry_id = 0;
$reg_id = 0;

if (isset($_GET['client_id'])) {

    if (isset($_GET['tb_type'])) {

        if ($_GET['tb_type'] == "tabs") {
            $types = "tab";
        } else {
            $types = $_GET['tb_type'];
        }

    }

    $cond = '';
    $inquiry_id = $_GET['client_id'];
    $cond = "inquiry_id=:inquiry_id";
    $params = array(":inquiry_id" => $inquiry_id);
    $row = $obj->fetchRow('inquiry_list', $cond, $params);
    $reg_data = $obj->fetchRow('registration', $cond, $params);


    $sopData = $obj->fetchRow('student_details', $cond, $params);

    $reg_id = $row['is_register'];

    $passports = $obj->fetchRowAll('passpord_details', $cond, $params);
    $experiences = $obj->fetchRowAll('work_experiance_details', $cond, $params);
    $student_course = $obj->fetchRowAll('student_course', $cond, $params);


    $cond = "inquiry_id=:inquiry_id AND is_active =:is_active";
    $params = array(":inquiry_id" => $inquiry_id, ":is_active" => 1);
    $financial_sponsor = $obj->fetchRowAll('sponsor', $cond, $params);
    $insurance = $obj->fetchRowAll('insurance', $cond, $params);

    if (!empty($experiences)) {

        for ($i = 0; $i < count($experiences); $i++) {

            $cond = "city_id=:city_id";
            $params = array(":city_id" => $experiences[$i]['city_id']);
            $cities = $obj->fetchRow('cities', $cond, $params);
            $experiences[$i]['city_id'] = $cities['name'];
        }
    }

}

$cond = "is_active =:is_active";
$params = array(":is_active" => '1');

$referance_list = $obj->fetchRowAll('referance_list', $cond, $params);
$country = $obj->fetchRowAll('countries', $cond, $params);

$cond = "country_id =:country_id AND is_active =:is_active";
$params = array(":country_id" => 13, ":is_active" => '1');
$relative_state = $obj->fetchRowAll('states', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'Marital Status', ":is_active" => 1);
$marital_status = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'Business', ":is_active" => 1);
$businessType = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'migrate_name', ":is_active" => 1);
$reason_for_change = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'Visa Type', ":is_active" => 1);
$visatype = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'Immigration', ":is_active" => 1);
$immigration_status = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'Relationship', ":is_active" => 1);
$relationship = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'events', ":is_active" => 1);
$events = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "types =:types AND is_active =:is_active";
$params = array(":types" => 0, ":is_active" => 1);
$reference = $obj->fetchRowAll('referance_list', $cond, $params);

$cond = "types =:types AND is_active =:is_active";
$params = array(":types" => 1, ":is_active" => 1);
$sub_agent = $obj->fetchRowAll('referance_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'Currency', ":is_active" => 1);
$currency = $obj->fetchRowAll('masters_list', $cond, $params);

?>
<style type="text/css">
    .fa {
        padding: 0px !important;
    }

    .indicator {
        display: none;
    }

    .row .col.s3 {
        width: 14%;
    }

    .tabs .tab a {
        font-size: 12px;
    }
</style>
<div class="header">
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li><a href="<?php echo HTTP_SERVER; ?>clientsmanager">List of Clients</a></li>
        <li class="active">Manage Client</li>
    </ol>
</div>
<div id="page-inner">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="">

                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <input type="hidden" id="tab_name" value="<?php echo $types; ?>">
                                <ul class="tabs">
                                    <li class="tab col s3"><a
                                                class="<?php if ($types == "passport") { ?> active <?php } ?>"
                                                id="tab_passport"
                                                href="#passport">Passport</a>
                                    </li>
                                    <li class="tab col s3"><a
                                                class="<?php if ($types == "employment") { ?> active <?php } ?>"
                                                id="tab_employment"
                                                href="#employment">Employment</a>
                                    </li>
                                    <li class="tab col s3"><a
                                                class="<?php if ($types == "sop") { ?> active <?php } ?>"
                                                id="tab_sop"
                                                href="#sop">SOP</a>
                                    </li>
                                    <li class="tab col s3"><a
                                                class="<?php if ($types == "finance") { ?> active <?php } ?>"
                                                id="tab_finance" href="#finance">Finance & Sponsors</a></li>
                                    <li class="tab col s3"><a
                                                class="<?php if ($types == "education") { ?> active <?php } ?>"
                                                id="tab_education" href="#education">Education Provider & Cources</a>
                                    </li>
                                    <li class="tab col s3"><a
                                                class="<?php if ($types == "health") { ?> active <?php } ?>"
                                                id="tab_health" href="#health">Health Insurance</a>
                                    </li>
                                    <?php
                                    if ($objsession->get('log_admin_type') == "admin") {
                                        ?>
                                        <li class="tab col s3"><a
                                                    class="<?php if ($types == "commission") { ?> active <?php } ?>"
                                                    id="tab_commission"
                                                    href="#commission">Commission Reavaluble Form</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <div class="clearBoth"><br/></div>
                                <div id="passport" class="col s12">
                                    <form id="frmPassportDetails" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover"
                                                   id="passportTable">
                                                <thead>
                                                <tr>
                                                    <th>Number</th>
                                                    <th>Issue Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (count($passports)) {

                                                    for ($i = 0; $i < count($passports); $i++) {

                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td width="200"><?php echo $passports[$i]['passport_number']; ?></td>
                                                            <td style="width: 355px;"><?php echo date("d/m/Y", strtotime($passports[$i]['passport_issue_date'])); ?></td>
                                                            <td width="250"><?php echo date("d/m/Y", strtotime($passports[$i]['passport_expire_date'])); ?></td>
                                                            <td width="180">
                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $passports[$i]['passport_id']; ?>"
                                                                   class="update"
                                                                   onclick="editPassport('<?php echo $passports[$i]['passport_id']; ?>');"><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"

                                                                            aria-hidden="true"></i></a>
                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $passports[$i]['passport_id']; ?>"
                                                                   class="remove"><i
                                                                            style="padding: 5px;font-size: 20px;"
                                                                            class="fa fa-times"
                                                                            aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>

                                                    <?php }
                                                } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="clearfix"></div>
                                        <input id="login_id" name="login_id" type="hidden"
                                               value="<?php if (!empty($row)) {
                                                   echo $row['inquiry_id'];
                                               } else {
                                                   echo "0";
                                               } ?>">

                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="passport_id" name="passport_id" type="hidden" value="0">
                                                <input id="passport_number" name="passport_number" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="passport_number">Passport Number</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="passport_issue_date"
                                                       name="passport_issue_date" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="passport_issue_date">Issue Date</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="passport_expire_date"
                                                       name="passport_expire_date" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="passport_expire_date">Expire Date</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="input-field col s4">
                                                    <label for="passport_name">Name of Passport</label>
                                                </div>
                                                <div class="input-field col s4">
                                                    <div class="form-group">
                                                        <input class="with-gap name_flag"
                                                               name="name_flag"
                                                               type="radio" id="name_flag_yes"
                                                               value="0"/>
                                                        <label for="name_flag_yes">Same</label>

                                                        <input class="with-gap name_flag"
                                                               name="name_flag"
                                                               type="radio" id="name_flag_no"
                                                               value="1"/>
                                                        <label for="name_flag_no">Different</label>
                                                        <br/>
                                                        <span id="name_flag_msg"></span>
                                                    </div>
                                                </div>
                                                <div class="input-field col s4 passport_name_div"
                                                     style="display: none;">
                                                    <input id="passport_name" name="passport_name" type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="passport_name">Enter Name on Passport</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="input-field col s4">
                                                    <label for="passport_lost">Lost or Stolen Passport</label>
                                                </div>
                                                <div class="input-field col s4">
                                                    <div class="form-group">
                                                        <input class="with-gap passport_lost"
                                                               name="passport_lost"
                                                               type="radio" id="passport_lost_yes"
                                                               value="1"/>
                                                        <label for="passport_lost_yes">Yes</label>

                                                        <input class="with-gap passport_lost"
                                                               name="passport_lost"
                                                               type="radio" id="passport_lost_no"
                                                               value="0"/>
                                                        <label for="passport_lost_no">No</label>
                                                        <br/>
                                                        <span id="passport_lost_msg"></span>
                                                    </div>
                                                </div>
                                                <div class="input-field col s4 details_div" style="display: none;">
                                                    <input id="passport_details" name="passport_details" type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="passport_details">Details</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-6"></div>
                                            <div class="col-lg-3 text-right">
                                                <div class="form-group">
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           value="Add">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_passport_next">
                                                        Next
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div id="employment" class="col s12">
                                    <form id="frmExperiance" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover"
                                                   id="experienceTable">
                                                <thead>
                                                <tr>
                                                    <th>Company</th>
                                                    <th>Designation</th>
                                                    <th>Business Type</th>
                                                    <th>City</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (count($experiences)) {

                                                    for ($i = 0; $i < count($experiences); $i++) {

                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td width="200"><?php echo $experiences[$i]['name_of_cmp']; ?></td>
                                                            <td width="250"><?php if ($experiences[$i]['designations'] != "") {
                                                                    echo $experiences[$i]['designations'];
                                                                } else {
                                                                    echo $experiences[$i]['designation'];
                                                                } ?></td>
                                                            <td width="250"><?php echo $experiences[$i]['business_name']; ?></td>
                                                            <td width="250"><?php echo $experiences[$i]['city_id']; ?></td>
                                                            <td width="180">

                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $experiences[$i]['exp_id']; ?>"
                                                                   class="update"
                                                                   onclick="editExperience('<?php echo $experiences[$i]['exp_id']; ?>');"><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a>
                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $experiences[$i]['exp_id']; ?>"
                                                                   class="remove"><i
                                                                            style="padding: 5px !important;font-size: 20px;"
                                                                            class="fa fa-times" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>

                                                    <?php }
                                                } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s6">
                                                    <div class="form-group">

                                                        <input class="with-gap selft_employee"
                                                               name="selft_employee"
                                                               type="radio" checked id="selft_employee_yes"
                                                               value="1"/>
                                                        <label for="selft_employee_yes">Employee</label>

                                                        <input class="with-gap selft_employee"
                                                               name="selft_employee"
                                                               type="radio" id="selft_employee_no"
                                                               value="0"/>
                                                        <label for="selft_employee_no">Self Employee</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">

                                                <input id="exp_id" name="exp_id" type="hidden" value="0">

                                                <input id="name_of_cmp" name="name_of_cmp" type="text" class="validate"
                                                       value="">
                                                <label for="first_name">Employee Name</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="Business Type">Business Type</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <select name="business_name" class="form-control validate"
                                                            id="business_name">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($businessType)) {
                                                            $selected = "";
                                                            for ($i = 0; $i < count($businessType); $i++) {

                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $businessType[$i]['name']; ?>">
                                                                    <?php echo ucfirst($businessType[$i]['name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="country_id">Country</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <input type="hidden" id="expr_country_hidden" value="0">
                                                    <select name="expr_country_id" class="form-control validate"
                                                            id="expr_country_id"
                                                            onchange="load_expr_state();">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($country)) {
                                                            $selected = "";
                                                            for ($c = 0; $c < count($country); $c++) {

                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $country[$c]['country_id']; ?>">
                                                                    <?php echo ucfirst($country[$c]['name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                        <!-- <option value="0">Other</option>-->
                                                    </select>
                                                    <input type="text" name="other_expr_country" id="other_expr_country"
                                                           class="form-control validate"
                                                           placeholder="Other Country name"
                                                           style="margin:15px 0px;display:none;"
                                                           value="">
                                                </div>
                                            </div>
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="state_id">State</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <select name="state_expr_id" class="form-control validate"
                                                            id="state_expr_id"
                                                            onchange="load_expr_city();">
                                                        <option value="">---Select---</option>
                                                    </select>
                                                    <input type="text" name="other_expr_state" id="other_expr_state"
                                                           placeholder="Other State name"
                                                           style="margin:15px 0px;display:none;"
                                                           class="form-control validate"
                                                           value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="city_id">City</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <input type="hidden" id="city_expr_hidden" value="0">
                                                    <select name="city_expr_id" class="form-control validate"
                                                            id="city_expr_id"
                                                            onchange="load_expr_city_other();">
                                                        <option value="">---Select---</option>
                                                    </select>
                                                    <input type="text" name="other_expr_city" id="other_expr_city"
                                                           placeholder="Other City name"
                                                           style="margin:15px 0px;display:none;"
                                                           class="form-control validate"
                                                           value="">
                                                </div>

                                            </div>
                                            <div class="input-field col s6">
                                                <input id="pincode_number" name="pincode_number" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="first_name">Postalcode</label>

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">

                                            <div class="input-field col s2">
                                                <label for="add1">Address </label>
                                            </div>
                                            <div class="input-field col s10">
                                                <input id="exp_address1" name="exp_address1" type="text"
                                                       class="validate"
                                                       value="" placeholder="Address Line No 1">
                                                <input id="exp_address2" name="exp_address2" type="text"
                                                       class="validate"
                                                       value="" placeholder="Address Line No 2">
                                                <input id="exp_address3" name="exp_address3" type="text"
                                                       class="validate"
                                                       value="" placeholder="Address Line No 3">
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="email_address" name="email_address" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="email_address">Email Address</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="website" name="website" type="text" class="validate"
                                                       value="">
                                                <label for="website">Website</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="mobile_number_1" name="mobile_number_1" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="mobile_number_1">Mobile Number 1</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="mobile_number_2" name="mobile_number_2" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="mobile_number_2">Mobile Number 2</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row var-div">

                                            <div class="input-field col s2">
                                                <label for="work_task">Work Task</label>
                                            </div>
                                            <div class="input-field col s10 v-div">
                                                <input id="work_task0" name="work_task[]" type="text"
                                                       class="validate"
                                                       value="" placeholder="Work Task 1">
                                                <input id="work_task1" name="work_task[]" type="text"
                                                       class="validate"
                                                       value="" placeholder="Work Task 2">
                                                <input id="work_task2" name="work_task[]" type="text"
                                                       class="validate"
                                                       value="" placeholder="Work Task 3">
                                            </div>
                                            <div class="addButton">
                                                <a href="javascript:void(0);"
                                                   class="m-t-20 btn btn-primary add-language"
                                                   style="margin-top:  8px;float: right;">More</a>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <input id="designation" name="designations[]" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="designation">Designation</label>
                                            </div>
                                            <div class="input-field col s4">
                                                <input id="start_date" name="duration_start_date[]" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="start_date">Start Date</label>
                                            </div>
                                            <div class="input-field col s4 end_date_div">
                                                <input id="end_date" name="duration_end_date[]" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="end_date">End Date</label>
                                            </div>
                                            <div class="addButton">
                                                <a href="javascript:void(0);"
                                                   class="m-t-20 btn btn-primary" data-toggle="modal"
                                                   data-target="#myModal"
                                                   style="margin-top:  8px;float: right;">More</a>
                                            </div>
                                            <div class="clearfix"></div>
                                            <!--Load more designation-->
                                            <!-- Modal -->
                                            <div id="myModal" class="modal fade" role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
                                                            <h4 class="modal-title">Designation</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="duration_data"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="javascript:void(0);"
                                                               class="m-t-20 btn btn-primary add-duration">More</a>
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-12 text-right">
                                                <div class="form-group">
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           value="Add">
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_exper_pre">
                                                        Previous
                                                    </a>
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_exper_next">
                                                        Next
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="sop" class="col s12">
                                    <form id="frmCareer" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="row">
                                            <input id="exp_id" name="exp_id" type="hidden" value="0">

                                            <div class="input-field col s3">
                                                <label for="first_name">Personal Backgroud</label>
                                            </div>
                                            <div class="input-field col s9">
                                                <input id="personal_backgroud" name="personal_backgroud" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($sopData)) {
                                                           echo $sopData['personal_details'];
                                                       } ?>">
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="input-field col s3">
                                                <label for="first_name">Family Backgroud</label>
                                            </div>
                                            <div class="input-field col s9">
                                                <input id="family_backgroud" name="family_backgroud" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($sopData)) {
                                                           echo $sopData['family_details'];
                                                       } ?>">
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="input-field col s3">
                                                <label for="first_name">Education Details</label>
                                            </div>
                                            <div class="input-field col s9">
                                                <input id="education_details" name="education_details" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($sopData)) {
                                                           echo $sopData['education_details'];
                                                       } ?>">
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="input-field col s3">
                                                <label for="first_name">Cource Details</label>
                                            </div>
                                            <div class="input-field col s9">
                                                <input id="cource_details" name="cource_details" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($sopData)) {
                                                           echo $sopData['cource_details'];
                                                       } ?>">
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="input-field col s3">
                                                <label for="first_name">Univarsity / Institute Details</label>
                                            </div>
                                            <div class="input-field col s9">
                                                <input id="uni_details" name="uni_details" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($sopData)) {
                                                           echo $sopData['university_details'];
                                                       } ?>">
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="input-field col s3">
                                                <label for="first_name">Country Details</label>
                                            </div>
                                            <div class="input-field col s9">
                                                <input id="country_details" name="country_details" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($sopData)) {
                                                           echo $sopData['country_detils'];
                                                       } ?>">
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="input-field col s3">
                                                <label for="first_name">Future after complition of cource</label>
                                            </div>
                                            <div class="input-field col s9">
                                                <input id="future_details" name="future_details" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($sopData)) {
                                                           echo $sopData['future_details'];
                                                       } ?>">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_sop_pre">
                                                        Previous
                                                    </a>
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           value="Next">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="finance" class="col s12">
                                    <form id="frmTechnical" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover"
                                                   id="financeTable">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Relation</th>
                                                    <th>Annual Income</th>
                                                    <th>Address</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (count($financial_sponsor)) {

                                                    for ($i = 0; $i < count($financial_sponsor); $i++) {

                                                        $cond = "master_id=:master_id";
                                                        $params = array(":master_id" => $financial_sponsor[$i]['relation_id']);
                                                        $relationship_details = $obj->fetchRow('masters_list', $cond, $params);

                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td width="200"><?php echo $financial_sponsor[$i]['sponsor_name']; ?></td>
                                                            <td width="200"><?php echo $financial_sponsor[$i]['relation_id']; ?></td>
                                                            <td width="250"><?php echo $financial_sponsor[$i]['annual_income']; ?></td>
                                                            <td width="250"><?php echo $financial_sponsor[$i]['address']; ?></td>
                                                            <td width="180">

                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $financial_sponsor[$i]['sponsor_id']; ?>"
                                                                   class="update"
                                                                   onclick="editSponsor('<?php echo $financial_sponsor[$i]['sponsor_id']; ?>');"><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a>
                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $financial_sponsor[$i]['sponsor_id']; ?>"
                                                                   class="remove"><i
                                                                            style="padding: 5px !important;font-size: 20px;"
                                                                            class="fa fa-times" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>

                                                    <?php }
                                                } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="card-action">Sponsor Details</div>
                                        <div class="row">
                                            <div class="input-field col s6">

                                                <input id="sponsor_id" name="sponsor_id" type="hidden" value="0">

                                                <input id="sponsor_name" name="sponsor_name" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="first_name">Name</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="Business Type">Relation</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <select name="relation_id" class="form-control validate"
                                                            id="relation_id">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($relationship)) {
                                                            $selected = "";
                                                            for ($i = 0; $i < count($relationship); $i++) {

                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $relationship[$i]['name']; ?>">
                                                                    <?php echo ucfirst($relationship[$i]['name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">

                                            <div class="input-field col s2">
                                                <label for="add1">Address </label>
                                            </div>
                                            <div class="input-field col s10">
                                                <input id="sponsor_address1" name="exp_address1" type="text"
                                                       class="validate"
                                                       value="" placeholder="Address Line No 1">
                                                <input id="sponsor_address2" name="exp_address2" type="text"
                                                       class="validate"
                                                       value="" placeholder="Address Line No 2">
                                                <input id="sponsor_address3" name="exp_address3" type="text"
                                                       class="validate"
                                                       value="" placeholder="Address Line No 3">
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="date_of_birth" name="date_of_birth" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="email_address">Date of birth</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="annual_income" name="annual_income" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="website">Annual Income</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="input-field col s4">
                                                    <label for="other_names">Other Name</label>
                                                </div>
                                                <div class="input-field col s4">
                                                    <div class="form-group">
                                                        <input class="with-gap other_names"
                                                               name="other_names"
                                                               type="radio" id="other_names_yes"
                                                               value="family"/>
                                                        <label for="other_names_yes">Yes</label>

                                                        <input class="with-gap other_names"
                                                               name="other_names"
                                                               type="radio" id="other_names_no"
                                                               value="given"/>
                                                        <label for="other_names_no">No</label>
                                                        <br/>
                                                        <span id="other_names_msg"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row family_name" style="display: none;">
                                            <div id="other_name_details_div">
                                                <div class="input-field col s4 family_name">
                                                    <input id="family_name" name="family_name[]" type="text"
                                                           class="validate">
                                                    <label for="family_name">Family Name</label>
                                                </div>
                                                <div class="input-field col s4">
                                                    <input id="given_name" name="given_name[]" type="text"
                                                           class="validate">
                                                    <label for="family_name">Given Name</label>
                                                </div>
                                                <div class="input-field col s4">
                                                    <div class="input-field col s4">
                                                        <label for="reason_for_change">Reason For Change</label>
                                                    </div>
                                                    <div class="input-field col s7">
                                                        <select name="reason_for_change[]"
                                                                class="form-control validate"
                                                                id="reason_for_change">
                                                            <option value="">---Select---</option>
                                                            <?php if (!empty($reason_for_change)) {
                                                                $selected = "";
                                                                for ($i = 0; $i < count($reason_for_change); $i++) {

                                                                    ?>
                                                                    <option <?php echo $selected; ?>
                                                                            value="<?php echo $reason_for_change[$i]['master_id']; ?>">
                                                                        <?php echo ucfirst($reason_for_change[$i]['name']); ?></option>
                                                                    <?php $selected = '';
                                                                }
                                                            } ?>
                                                        </select>
                                                        <input type="text" name="other_reason" id="other_reason"
                                                               placeholder="Other Reason"
                                                               style="margin:15px 0px;display:none;"
                                                               class="form-control validate"
                                                               value="">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="addButton">
                                                <a href="javascript:void(0);" data-toggle="modal"
                                                   data-target="#popupOtherDetails"
                                                   class="m-t-20 btn btn-primary "
                                                   style="margin-top:  8px;float: right;">More</a>
                                            </div>
                                            <!--Load popup modal for add more other details-->
                                            <div id="popupOtherDetails" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                    data-dismiss="modal">&times;
                                                            </button>
                                                            <h4 class="modal-title">Other Details</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="more_other_details"></div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="javascript:void(0);"
                                                               class="m-t-20 btn btn-primary add-other-details">More</a>
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="card-action">Finance & Relationship to Student</div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="name_of_institute" name="name_of_institute" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="first_name">Name of Financial Intitution</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="institude_address" name="institude_address" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="first_name">Address</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="branch_name" name="branch_name[]" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="first_name">Branch Name</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="branch_code" name="branch_code[]" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="first_name">Branch Code</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="account_name" name="account_name[]" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="first_name">Account Name</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="account_number" name="account_number[]" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="first_name">Account Number</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="account_type" name="account_type[]" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="first_name">Account Type</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="balance_in_inr" name="balance_in_inr[]" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="first_name">Balance in INR</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="Business Type">Reference Rate</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <select name="referance_rate_type[]" class="form-control validate"
                                                            id="referance_rate_type">
                                                        <option value="">---Select---</option>
                                                        <option value="AUD">AUD - Australian Dollars</option>
                                                        <option value="USD">USD - American Dollars</option>
                                                        <option value="NZD">NZD - New Zealand Dollars</option>
                                                        <option value="CAD">CAD - Canadian Dollars</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="ref_rate" name="ref_rate[]" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="first_name">Current Rate of reference </label>
                                            </div>
                                        </div>
                                        <div class="row" id="balance_" style="display: none;">
                                            <div class="col s6">
                                                <label for="first_name">Available Balance in : </label>
                                                <input id="available_balance" name="available_balance[]" type="hidden"
                                                       class="validate"
                                                       value="">
                                            </div>
                                            <div class="col s6">
                                                <label id="available_balance_"></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s6">
                                            </div>
                                            <div class="col s6">
                                                <div class="addMoreTra">
                                                    <a href="javascript:void(0);" data-toggle="modal"
                                                       data-target="#popupMoreTra"
                                                       class="m-t-20 btn btn-primary"
                                                       style="margin-top:  8px;float: right;">More</a>
                                                </div>

                                                <!--Load popup modal for add more other details-->
                                                <div id="popupMoreTra" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal">&times;
                                                                </button>
                                                                <h4 class="modal-title">Bank Account Details</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="more_transaction_details"></div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="javascript:void(0);"
                                                                   class="m-t-20 btn btn-primary add-transaction">More</a>
                                                                <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Close
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-12 text-right">
                                                <div class="form-group">
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           value="Add">
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_financial_pre">
                                                        Previous
                                                    </a>
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_financial_next">
                                                        Next
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="education" class="col s12">
                                    <form id="frmCourse"
                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover"
                                                   id="studentTable">
                                                <thead>
                                                <tr>
                                                    <th>Campus</th>
                                                    <th>Course Name</th>
                                                    <th>Course Code</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (count($student_course)) {

                                                    for ($i = 0; $i < count($student_course); $i++) {

                                                        $cond = "country_id=:country_id";
                                                        $params = array(":country_id" => $student_course[$i]['country_id']);
                                                        $countries = $obj->fetchRow('countries', $cond, $params);

                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td width="250"><?php echo $student_course[$i]['campus']; ?></td>
                                                            <td width="250"><?php echo $student_course[$i]['course_name']; ?></td>
                                                            <td width="250"><?php echo $student_course[$i]['course_code']; ?></td>
                                                            <td width="180">

                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $student_course[$i]['course_id']; ?>"
                                                                   class="update"
                                                                   onclick="editCourse('<?php echo $student_course[$i]['course_id']; ?>');"><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a>
                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $student_course[$i]['course_id']; ?>"
                                                                   class="remove"><i
                                                                            style="padding: 5px !important;font-size: 20px;"
                                                                            class="fa fa-times" aria-hidden="true"></i></a>

                                                            </td>
                                                        </tr>

                                                    <?php }
                                                } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="course_id" name="course_id" type="hidden" value="0">
                                                <input id="campus" name="campus" type="text" class="validate"
                                                       value="">
                                                <label for="since">Campus</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <div class="input-field col s10">
                                                    <input id="no_of_semester" name="no_of_semester"
                                                           type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="no_of_semester">No. of Semester</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s10">
                                                    <input id="course_name" name="course_name"
                                                           type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="course_name">Course Name</label>
                                                </div>
                                            </div>
                                            <div class="input-field col s6">
                                                <div class="input-field col s10">
                                                    <input id="course_code" name="course_code"
                                                           type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="course_code">Course Code</label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s10">
                                                    <input id="course_start_date" name="start_date"
                                                           type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="course_start_date">Start Date</label>
                                                </div>
                                            </div>
                                            <div class="input-field col s6">
                                                <div class="input-field col s10">
                                                    <input id="course_end_date" name="end_date"
                                                           type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="course_end_date">End Date</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           value="Add">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <a class="waves-effect waves-light btn" id="btn_relative_pre">
                                                        Previous
                                                    </a>
                                                    <a class="waves-effect waves-light btn" id="btn_relative_next">
                                                        Next
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="health" class="col s12">
                                    <form id="frmHelth"
                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover"
                                                   id="healthTable">
                                                <thead>
                                                <tr>
                                                    <th>Provider Name</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (count($insurance)) {

                                                    for ($i = 0; $i < count($insurance); $i++) {

                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td width="200"><?php echo ucfirst($insurance[$i]['provider_name']); ?></td>
                                                            <td width="250"><?php echo $insurance[$i]['start_date']; ?></td>
                                                            <td width="250"><?php echo $insurance[$i]['end_date']; ?></td>
                                                            <td width="250"><?php echo $insurance[$i]['total_amount']; ?></td>
                                                            <td width="180">

                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $insurance[$i]['insurance_id']; ?>"
                                                                   class="update"
                                                                   onclick="editHealth('<?php echo $insurance[$i]['insurance_id']; ?>');"><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a>
                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $insurance[$i]['insurance_id']; ?>"
                                                                   class="remove"><i
                                                                            style="padding: 5px !important;font-size: 20px;"
                                                                            class="fa fa-times" aria-hidden="true"></i></a>

                                                            </td>
                                                        </tr>

                                                    <?php }
                                                } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="row">
                                            <div class="input-field col s6">

                                                <input id="insurance_id" name="insurance_id" type="hidden" value="0">

                                                <input id="provider_name" name="provider_name"
                                                       type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="provider_name">Provider Name</label>
                                            </div>
                                            <div class="input-field col s6">

                                                <input id="paid_to" name="paid_to"
                                                       type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="paid_to">Paid To</label>

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s10">
                                                    <input id="health_start_date" name="start_date"
                                                           type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="health_start_date">Start Date</label>
                                                </div>
                                            </div>
                                            <div class="input-field col s6">
                                                <div class="input-field col s10">
                                                    <input id="health_end_date" name="end_date"
                                                           type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="health_end_date">End Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s10">
                                                    <input id="total_amount" name="total_amount"
                                                           type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="total_amount">Total Amount</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           value="Add">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                                <?php
                                if ($objsession->get('log_admin_type') == "admin") {
                                    ?>
                                    <div id="commission" class="col s12">
                                        <form id="frmCommission"
                                              class="wizard clearfix fv-form fv-form-bootstrap"
                                              method="post">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover"
                                                       id="commitionTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Campus</th>
                                                        <th>Course Name</th>
                                                        <th>Course Code</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if (count($student_course)) {

                                                        for ($i = 0; $i < count($student_course); $i++) {

                                                            /*    $cond = "country_id=:country_id";
                                                                $params = array(":country_id" => $student_course[$i]['country_id']);
                                                                $countries = $obj->fetchRow('countries', $cond, $params);*/

                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td width="250"><?php echo $student_course[$i]['campus']; ?></td>
                                                                <td width="250"><?php echo $student_course[$i]['course_name']; ?></td>
                                                                <td width="250"><?php echo $student_course[$i]['course_code']; ?></td>
                                                                <td width="180">

                                                                    <a href="javascript:void(0);"
                                                                       data-id="<?php echo $student_course[$i]['course_id']; ?>"
                                                                       class="update"
                                                                       onclick="editCommition(<?php echo $student_course[$i]['course_id'] . ',' . $student_course[$i]['no_of_semester']; ?>);"><i
                                                                                style="padding: 0px;font-size: 20px;"
                                                                                class="fa fa-pencil-square-o"
                                                                                aria-hidden="true"></i></a>

                                                                </td>
                                                            </tr>

                                                        <?php }
                                                    } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="allSemester" style="display: none;">
                                                <input type="hidden" id="student_counrse_id" name="student_counrse_id"
                                                       value="0">
                                                <div class="noOfSemester"></div>
                                                <div class="clearfix"></div>
                                                <div class="row">
                                                    <div class="col-lg-3"></div>
                                                    <div class="col-lg-9 text-right">
                                                        <div class="form-group">
                                                            <input type="submit" class="waves-effect waves-light btn"
                                                                   value="Add">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </form>
                                    </div>
                                <?php } ?>
                                <div class="clearBoth"><br/></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden">
        <div id="other_name_details_div01" class="detail1">
            <div class="input-field col s6 family_name">
                <input name="family_name[]" type="text"
                       class="validate">
                <label for="family_name[]">Family Name</label>
            </div>
            <div class="input-field col s6">
                <input name="given_name[]" type="text"
                       class="validate">
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
                            for ($i = 0; $i < count($reason_for_change); $i++) {

                                ?>
                                <option <?php echo $selected; ?>
                                        value="<?php echo $reason_for_change[$i]['master_id']; ?>">
                                    <?php echo ucfirst($reason_for_change[$i]['name']); ?></option>
                                <?php $selected = '';
                            }
                        } ?>
                    </select>
                    <input type="text" name="other_reason" id="other_reason"
                           placeholder="Other Reason"
                           style="margin:15px 0px;display:none;"
                           class="form-control validate"
                           value="">
                </div>
            </div>
            <div class="input-field col s2">
                <i class="fa fa-trash-o remove-details-div"></i>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="modal fade" id="_followup" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="frmFollowup" class="wizard clearfix fv-form fv-form-bootstrap"
                          method="post">
                        <div class="card-action">Add Follow Up</div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="follow_up_id" name="follow_up_id" type="hidden" value="0">
                                <input id="date_of_follow" name="date_of_follow" type="text"
                                       class="validate"
                                       value="<?php if (!empty($follow_up_data)) {
                                           if (date("Y-m-d", strtotime($follow_up_data['date_of_follow'])) != "1970-01-01") {
                                               echo date("d-m-Y H:i", strtotime($follow_up_data['date_of_follow']));
                                           }
                                       } ?>">
                                <label for="date_of_follow">Date</label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-9 text-right">
                                <div class="form-group">

                                    <input type="submit" class="waves-effect waves-light btn"
                                           name="btn_follow_yes" value="Folloup">
                                    <a href="javascript:void(0);" id="btn_no_follow"
                                       class="waves-effect waves-li ght btn">
                                        Not Folloup
                                    </a>
                                    <button type="button" class="btn btn-success reload"
                                            data-dismiss="modal" aria-label="Close">Close
                                    </button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../include/footer.php'; ?>

<script src="<?php echo HTTP_SERVER; ?>assets/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<link href="<?php echo HTTP_SERVER; ?>assets/css/bootstrap-datetimepicker.css" rel="Stylesheet"
      type="text/css"/>

<script src="<?php echo HTTP_SERVER; ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo HTTP_SERVER; ?>assets/js/dataTables/dataTables.bootstrap.js"></script>

<script>

    var base_url = "<?php echo HTTP_SERVER; ?>";

    $(document).ready(function () {
        $('#financeTable').DataTable({
            "ordering": false,
            "columnDefs": [
                {"className": "dt-center", "targets": "_all"}
            ],
        });

        $('#experienceTable').DataTable({
            "ordering": false,
            "columnDefs": [
                {"className": "dt-center", "targets": "_all"}
            ],
        });

        $('#passportTable').DataTable({
            "ordering": false,
            "columnDefs": [
                {"className": "dt-center", "targets": "_all"}
            ],
        });

        $('#studentTable').DataTable({
            "ordering": false,
            "columnDefs": [
                {"className": "dt-center", "targets": "_all"}
            ],
        });

        $('#healthTable').DataTable({
            "ordering": false,
            "columnDefs": [
                {"className": "dt-center", "targets": "_all"}
            ],
        });
    });

    function parseDate(str) {
        var mdy = str.split('/')
        console.log(mdy);
        return new Date(mdy[2], mdy[1] - 1, mdy[0]);
    }

    function daydiff(first, second) {
        return (second - first) / (1000 * 60 * 60 * 24)
    }

    function CalculateDiff() {

        $("#duration").val("");
        var diff = daydiff(parseDate($('#start_held_on').val()), parseDate($('#end_held_on').val()));
        if (diff >= 0) {
            diff = diff + (1);
            $("#duration").val(diff);
        }
    }

    $(document).ready(function () {

        $('#date_of_inquiry').datetimepicker({
            autoclose: true,
            format: "dd-mm-yyyy hh:ii"
        });

        $('#date_of_birth').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        $('#start_date').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        $('#end_date').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        $('#from_travel').datetimepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            minView: 2
        });

        $('#to_travel').datetimepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            minView: 2
        });

        $('#passport_issue_date').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        $('#passport_expire_date').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        $('#family_passport_issue_date').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        $('#family_passport_expire_date').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        $("#course_start_date").datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2,
            onSelect: function (selected) {
                $("#course_end_date").datetimepicker("option", "minDate", selected)
            }
        });

        $("#course_end_date").datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2,
            onSelect: function (selected) {
                $("#course_start_date").datetimepicker("option", "maxDate", selected)
            }
        });

        $("#health_start_date").datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2,
            onSelect: function (selected) {
                $("#health_end_date").datetimepicker("option", "minDate", selected)
            }
        });

        $("#health_end_date").datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2,
            onSelect: function (selected) {
                $("#health_start_date").datetimepicker("option", "maxDate", selected)
            }
        });

        $('#marriage_date').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        var strAppend = '<div class="nrc"><input class="workTest validate" id="work_task" name="work_task[]" type="text"\n' +
            '                                                       class="validate"\n' +
            '                                                       value="" placeholder="Work Task"><i class=\"fa fa-trash-o remove-language\"></i></div>';
        $(document).on('click', '.add-language', function () {

            var totalLan = $('.var-div').find('.v-div').length;
            $('.remove-language').removeClass('hidden');
            $('.v-div').append(strAppend);
        });

        $(document).on('click', '.remove-details-div', function () {
            $(this).parent('div').parent('.detail1').remove();
        });

        $(document).on('click', '.remove-language', function () {
            $(this).parent('.nrc').remove();
        });

        var strTech = '<div class="tech-skill"><input id="technical_skill" name="technical_skill[]" type="text" class="" value="" placeholder="Technical Skill"><input id="technical_skill" name="technical_skill[]" type="text" class="" value="" placeholder="Technical Skill"><input id="technical_skill" name="technical_skill[]" type="text" class="" value="" placeholder="Technical Skill"><i class=\"fa fa-trash-o remove-tech-div\"></i></div>';
        $(document).on('click', '.tech-add', function () {
            $('.remove-tech-div').removeClass('hidden');
            $('.tech-v-div').append(strTech);
        });

        $(document).on('click', '.remove-tech-div', function () {
            $(this).parent('.tech-skill').remove();
        });

        var strPersonal = '<div class="pr-skill"><input id="personal_skill" name="personal_skill[]" type="text" value="" placeholder="Personal Skill" ><input id="personal_skill" name="personal_skill[]" type="text" value="" placeholder="Personal Skill" ><input id="personal_skill" name="personal_skill[]" type="text" value="" placeholder="Personal Skill" ><i class=\"fa fa-trash-o remove-pr-div\"></i></div>';
        $(document).on('click', '.personal-add', function () {
            $('.remove-pr-div').removeClass('hidden');
            $('.pr-v-div').append(strPersonal);
        });

        $(document).on('click', '.remove-pr-div', function () {
            $(this).parent('.pr-skill').remove();
        });

        var strAch = '<div class="pr-skill"><input id="achievement" name="achievement[]" type="text" value="" placeholder="Achiement Skill"><input id="achievement" name="achievement[]" type="text" value="" placeholder="Achiement Skill"><input id="achievement" name="achievement[]" type="text" value="" placeholder="Achiement Skill"><i class=\"fa fa-trash-o remove-pr-div\"></i></div>';

        $(document).on('click', '.achievement-add', function () {
            $('.remove-ach-div').removeClass('hidden');
            $('.ach-v-div').append(strAch);
        });

        $(document).on('click', '.remove-ach-div', function () {
            $(this).parent('.ach-skill').remove();
        });

        $(document).on('click', '.add-other-details', function () {

            $('#other_name_details_div01').clone().appendTo(".more_other_details");

        });

        var des_cnt = 1;
        $(document).on('click', '.add-duration', function () {

            var strDuration = '<div class="duration-skill"><div class="input-field col s4"><input id="designation' + des_cnt + '" name="designations[]" type="text" class="validate" value=""><label for="designation">Designation</label></div><div class="input-field col s4"><input id="duration_start_date' + des_cnt + '" name="duration_start_date[]" type="text" class="validate" value=""><label for="sd">Start Date</label></div><div class="input-field col s4"><input id="duration_end_date' + des_cnt + '" name="duration_end_date[]" type="text" class="validate" value=""><label for="ed">End Date</label></div><i class=\"fa fa-trash-o remove-duration-div\"></i></div>';

            $('.remove-duration-div').removeClass('hidden');
            $('.duration_data').append(strDuration);

            $('#duration_start_date' + des_cnt).datetimepicker({
                autoclose: true,
                format: "dd/mm/yyyy",
                minView: 2
            });

            $('#duration_end_date' + des_cnt).datetimepicker({
                autoclose: true,
                format: "dd/mm/yyyy",
                minView: 2
            });

            des_cnt++;
        });

        $(document).on('click', '.remove-duration-div', function () {
            $(this).parent('.duration-skill').remove();
        });

        var p_cnt = 1;
        $(document).on('click', '.add-passport', function () {

            var strPassort = '<div class="rev-passport"> <div class="row">\n' +
                '\t<div class="input-field col s6">\n' +
                '\t\t<input id="family_passport_number" name="family_passport_number[]" type="text"\n' +
                '\t\t\t   class="validate"\n' +
                '\t\t\t   value="">\n' +
                '\t\t<label for="family_passport_number">Passport Number</label>\n' +
                '\t</div>\n' +
                '\n' +
                '</div>\n' +
                '<div class="clearfix"></div>\n' +
                '<div class="row">\n' +
                '\t<div class="input-field col s6">\n' +
                '\t\t<input id="_issue_date' + p_cnt + '" name="family_passport_issue_date[]"\n' +
                '\t\t\t   type="text" class="validate family_issue_date"\n' +
                '\t\t\t   value="">\n' +
                '\t\t<label for="passport_issue_date">Passport Issue Date</label>\n' +
                '\t</div>\n' +
                '\t<div class="input-field col s6">\n' +
                '\t\t<input id="_expire_date' + p_cnt + '" name="family_passport_expire_date[]"\n' +
                '\t\t\t   type="text"\n' +
                '\t\t\t   class="validate family_expire_date"\n' +
                '\t\t\t   value="">\n' +
                '\t\t<label for="passport_expire_date">Passport Expiry Date</label>\n' +
                '\t</div>\n' +
                '</div><i class=\"fa fa-trash-o remove-passport-div\"></i></div>';

            $('.remove-passport-div').removeClass('hidden');
            $('.more_details').append(strPassort);

            $('#_issue_date' + p_cnt).datetimepicker({
                autoclose: true,
                format: "dd/mm/yyyy",
                minView: 2
            });

            $('#_expire_date' + p_cnt).datetimepicker({
                autoclose: true,
                format: "dd/mm/yyyy",
                minView: 2
            });
            p_cnt++;

        });

        var transaction_cnt = 1;
        $(document).on('click', '.add-transaction', function () {

            var strDuration = '<div class="rev-tra"><div class="row">\n' +
                '                                            <div class="input-field col s6">\n' +
                '                                                <input id="branch_name" name="branch_name[]" type="text"\n' +
                '                                                       class="validate"\n' +
                '                                                       value="">\n' +
                '                                                <label for="first_name">Branch Name</label>\n' +
                '                                            </div>\n' +
                '                                            <div class="input-field col s6">\n' +
                '                                                <input id="branch_code" name="branch_code[]" type="text"\n' +
                '                                                       class="validate"\n' +
                '                                                       value="">\n' +
                '                                                <label for="first_name">Branch Code</label>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="row">\n' +
                '                                            <div class="input-field col s6">\n' +
                '                                                <input id="account_name" name="account_name[]" type="text"\n' +
                '                                                       class="validate"\n' +
                '                                                       value="">\n' +
                '                                                <label for="first_name">Account Name</label>\n' +
                '                                            </div>\n' +
                '                                            <div class="input-field col s6">\n' +
                '                                                <input id="account_number" name="account_number[]" type="text"\n' +
                '                                                       class="validate"\n' +
                '                                                       value="">\n' +
                '                                                <label for="first_name">Account Number</label>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="row">\n' +
                '                                            <div class="input-field col s6">\n' +
                '                                                <input id="account_type" name="account_type[]" type="text"\n' +
                '                                                       class="validate"\n' +
                '                                                       value="">\n' +
                '                                                <label for="first_name">Account Type</label>\n' +
                '                                            </div>\n' +
                '                                            <div class="input-field col s6">\n' +
                '                                                <input id="balance_in_inr' + transaction_cnt + '" data-id="' + transaction_cnt + '" name="balance_in_inr[]" type="text"\n' +
                '                                                       class="validate currency_convert"\n' +
                '                                                       value="">\n' +
                '                                                <label for="first_name">Balance in INR</label>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="row">\n' +
                '                                            <div class="input-field col s6">\n' +
                '                                                <div class="input-field col s2">\n' +
                '                                                    <label for="Business Type">Reference Rate</label>\n' +
                '                                                </div>\n' +
                '                                                <div class="input-field col s10">\n' +
                '                                                    <select name="referance_rate_type[]" class="form-control currency_type validate"\n' +
                '                                                            id="referance_rate_type' + transaction_cnt + '">\n' +
                '                                                        <option value="">---Select---</option>\n' +
                '                                                        <option value="AUD">AUD</option>\n' +
                '                                                        <option value="USD">USD</option>\n' +
                '                                                        <option value="NZD">NZD</option>\n' +
                '                                                        <option value="CAD">CAD</option>\n' +
                '                                                    </select>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="input-field col s6">\n' +
                '                                                <input id="ref_rate' + transaction_cnt + '" data-id="' + transaction_cnt + '" name="ref_rate[]" type="text"\n' +
                '                                                       class="validate currency_convert"\n' +
                '                                                       value="">\n' +
                '                                                <label for="first_name">Current Rate of reference </label>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="row" id="balance_' + transaction_cnt + '" style="display: none;">\n' +
                '                                            <div class="col s6">\n' +
                '                                                <label for="first_name">Available Balance in : </label>\n' +
                '                                            </div>\n' +
                '                                            <div class="col s6">\n' +
                '                                                <input id="available_balance' + transaction_cnt + '" name="available_balance[]" type="hidden"\n' +
                '                                                       class="validate"\n' +
                '                                                       value=""><label id="available_balance_' + transaction_cnt + '"></label>\n' +
                '                                            </div>\n' +
                '                                        </div><i class="fa fa-trash-o remove-tra-div"></i></div>';

            $('.more_transaction_details').append(strDuration);

            transaction_cnt++;
        });

        $(document).on('click', '.remove-tra-div', function () {
            $(this).parent('.rev-tra').remove();
        });

        $('.family_expire_date').datetimepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            minView: 2
        });

        $(document).on('click', '.remove-passport-div', function () {
            $(this).parent('.rev-passport').remove();
        });

        /*format: "dd-mm-yyyy hh:ii"*/
        /*frmPassportDetails detail added in database using ajax call*/
        $("#frmPassportDetails").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                passport_number: "required",
            },
            messages: {
                passport_number: "Please enter your passport number",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "name_flag") {
                    error.insertAfter("#name_flag_msg");
                } else if (element.attr("name") == "passport_lost") {
                    error.insertAfter("#passport_lost_msg");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                var inquiry_id = $("#login_id").val();
                var passport_id = $("#passport_id").val();
                $.ajax({
                    type: "POST",
                    url: base_url + "submit_client_passport_data?inquiry_id=" + inquiry_id,
                    data: $("#frmPassportDetails").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            $('#frmPassportDetails .validate').val('');

                            var t = $('#passportTable').DataTable();

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {

                                $("#name_flag_yes").prop("checked", false);
                                $("#name_flag_no").prop("checked", false);
                                $(".details_div").hide();
                                $(".passport_name_div").hide();
                                $("#passport_lost_yes").prop("checked", false);
                                $("#passport_lost_no").prop("checked", false);

                                if (passport_id != "" && passport_id > 0) {
                                    $('#passportTable').dataTable().fnClearTable();

                                    var clk = "return confirm('Are you sure want to delete?')";

                                    for (var i = 0; i < response.data.length; i++) {

                                        var link = '<a href="javascript:void(0);" data-id="' + response.data[i].passport_id + '" class="update" onclick="editPassport(' + response.data[i].passport_id + ');" ><i\n' +
                                            '                                                                            style="padding: 0px;font-size: 20px;"\n' +
                                            '                                                                            class="fa fa-pencil-square-o"\n' +
                                            '\n' + 'aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' + response.data[i].passport_id + '" class="remove"><i\n' + 'style="padding: 5px;font-size: 20px;" class="fa fa-times"\n' +
                                            ' aria-hidden="true"></i></a>';

                                        t.row.add([
                                            response.data[i].passport_number,
                                            response.data[i].passport_issue_date,
                                            response.data[i].passport_expire_date,
                                            link
                                        ]).draw(false);
                                    }
                                    $("#passport_id").val('0');
                                } else {
                                    t.row.add([
                                        response.passport_number,
                                        response.passport_issue_date,
                                        response.passport_expire_date,
                                        response.link
                                    ]).draw(false);

                                }

                                $('html, body').animate({scrollTop: 0}, 1000);

                            } else {
                                window.location.href = "<?php echo HTTP_SERVER;?>viewinquiry/<?php echo $inquiry_id;?>/" + tab_name;
                            }

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        $('#frmPassportDetails').on('click', 'a.remove', function (e) {

            if (confirm('Are you sure want to delete?') == false) {
                return false;
            }

            var table = $('#passportTable').DataTable();
            table.row($(this).closest('tr')).remove().draw(false);

            var id = $(this).attr('data-id');


            $.ajax({
                type: "POST",
                url: base_url + "delete_passport_data?passport_id=" + id,
                dataType: "json",
                success: function (response) {

                    if (response.status == true) {

                    } else if (response.status == false) {
                        alert("Something went wrong...!");
                        return false;
                    }
                }
            });
        });

        $('#frmPassportDetails').on('change', '.name_flag', function (e) {

            var name_flag = $(this).val();
            $(".passport_name_div").hide();
            $("#passport_name").val("");

            if (name_flag == 1) {
                $(".passport_name_div").show();
            }
        });

        $('#frmPassportDetails').on('change', '.passport_lost', function (e) {

            var passport_lost = $(this).val();
            $(".details_div").hide();
            $("#passport_details").val("");

            if (passport_lost == 1) {
                $(".details_div").show();
            }
        });

        /*Commission detail added in database using ajax call*/
        $("#frmCommission").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                "sem_fees[]": "required",
            },
            messages: {
                "sem_fees[]": "Please enter semester fees",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "sem_fees[]") {
                    error.insertAfter("#sem_msg");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();
                var fees_id = $("#fees_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_commission_data?inquiry_id=" + inquiry_id + "&fees_id=" + fees_id,
                    data: $("#frmCommission").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {
                            $('html, body').animate({scrollTop: 0}, 1000);
                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        $('#frmRelaive').on('change', '#reason_for_change', function (e) {

            var reason_for_change = $(this).val();
            $("#other_reason").hide();

            if (reason_for_change == 0 && reason_for_change != "") {
                $("#other_reason").show();
                $("#other_reason").val('');
            }
        });

        /*Career detail added in database using ajax call*/
        $("#frmCareer").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                personal_backgroud: "required",
            },
            messages: {
                personal_backgroud: "Please enter personal backgroud",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_sop_data?inquiry_id=" + inquiry_id,
                    data: $("#frmCareer").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            $("#tab_finance").click();

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        /*Sponsor and Transaction detail added in database using ajax call*/
        $("#frmTechnical").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                sponsor_name: "required",
            },
            messages: {
                sponsor_name: "Please enter your sponsor name",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {
                var inquiry_id = $("#login_id").val();
                var sponsor_id = $("#sponsor_id").val();
                $.ajax({
                    type: "POST",
                    url: base_url + "submit_sponsor_transaction_data?inquiry_id=" + inquiry_id,
                    data: $("#frmTechnical").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            $('#frmTechnical .validate').val('');
                            $(".rev-tra").remove();
                            $("#balance_").hide();

                            var t = $('#financeTable').DataTable();

                            if (sponsor_id != "" && sponsor_id > 0) {

                                $('#financeTable').dataTable().fnClearTable();

                                var clk = "return confirm('Are you sure want to delete?')";

                                for (var i = 0; i < response.data.length; i++) {

                                    var link = '<a href="javascript:void(0);" data-id="' + response.data[i].sponsor_id + '" class="update" onclick="editSponsor(' + response.data[i].sponsor_id + ');" ><i\n style="padding: 0px;font-size: 20px;"\n class="fa fa-pencil-square-o"\n aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' + response.data[i].sponsor_id + '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';

                                    t.row.add([
                                        response.data[i].sponsor_name,
                                        response.data[i].relation_id,
                                        response.data[i].annual_income,
                                        response.data[i].address,
                                        link
                                    ]).draw(false);
                                }
                                $("#sponsor_id").val('0');
                            } else {
                                t.row.add([
                                    response.sponsor_name,
                                    response.relation_name,
                                    response.annual_income,
                                    response.address,
                                    response.link
                                ]).draw(false);
                            }

                            $('html, body').animate({scrollTop: 0}, 1000);

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        /*Personal detail added in database using ajax call*/
        $("#frmPersonal").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                "personal_skill1[]": "required",
            },
            messages: {
                "personal_skill1[]": "Please enter Personal skill"
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "personal_skill[]") {
                    error.insertAfter("#personal_msg");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_personalskill_data?inquiry_id=" + inquiry_id,
                    data: $("#frmPersonal").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {
                                $("#tab_archevements").click();
                            } else {
                                window.location.href = "<?php echo HTTP_SERVER;?>viewinquiry/<?php echo $inquiry_id;?>/" + tab_name;
                            }

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        /*Course detail added in database using ajax call*/
        $("#frmCourse").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                "campus": "required",
                no_of_semester: {
                    required: true,
                    number: true
                }
            },
            messages: {
                "campus": "Please enter campus name",
                no_of_semester: {
                    required: "Please enter semester",
                    number: "Enter only digit"
                }
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();
                var course_id = $("#course_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_course_data?inquiry_id=" + inquiry_id,
                    data: $("#frmCourse").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            $('#frmCourse .validate').val('');


                            var t = $('#studentTable').DataTable();

                            if (course_id != "" && course_id > 0) {

                                $('#studentTable').dataTable().fnClearTable();

                                var clk = "return confirm('Are you sure want to delete?')";

                                for (var i = 0; i < response.data.length; i++) {

                                    var link = '<a href="javascript:void(0);" data-id="' + response.data[i].course_id + '" class="update" onclick="editCourse(' + response.data[i].course_id + ');" ><i\n style="padding: 0px;font-size: 20px;"\n class="fa fa-pencil-square-o"\n aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' + response.data[i].course_id + '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';

                                    t.row.add([
                                        response.data[i].campus,
                                        response.data[i].course_name,
                                        response.data[i].course_code,
                                        link
                                    ]).draw(false);
                                }
                                $("#course_id").val('0');
                            } else {
                                t.row.add([
                                    response.campus,
                                    response.course_name,
                                    response.course_code,
                                    response.link
                                ]).draw(false);
                            }

                            $('html, body').animate({scrollTop: 0}, 1000);

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        /*Helth detail added in database using ajax call*/
        $("#frmHelth").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                "provider_name": "required",
            },
            messages: {
                "provider_name": "Please enter provider name",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();
                var insurance_id = $("#insurance_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_health_data?inquiry_id=" + inquiry_id,
                    data: $("#frmHelth").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            $('#frmHelth .validate').val('');


                            var t = $('#healthTable').DataTable();

                            if (insurance_id != "" && insurance_id > 0) {

                                $('#healthTable').dataTable().fnClearTable();

                                var clk = "return confirm('Are you sure want to delete?')";

                                for (var i = 0; i < response.data.length; i++) {

                                    var link = '<a href="javascript:void(0);" data-id="' + response.data[i].insurance_id + '" class="update" onclick="editHealth(' + response.data[i].insurance_id + ');" ><i\n style="padding: 0px;font-size: 20px;"\n class="fa fa-pencil-square-o"\n aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' + response.data[i].insurance_id + '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';

                                    t.row.add([
                                        response.data[i].provider_name,
                                        response.data[i].start_date,
                                        response.data[i].end_date,
                                        response.data[i].total_amount,
                                        link
                                    ]).draw(false);
                                }
                                $("#insurance_id").val('0');
                            } else {
                                t.row.add([
                                    response.provider_name,
                                    response.start_date,
                                    response.end_date,
                                    response.total_amount,
                                    response.link
                                ]).draw(false);
                            }

                            $('html, body').animate({scrollTop: 0}, 1000);

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        /*Experiance detail added in database using ajax call*/
        $("#frmExperiance").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                name_of_cmp: "required",
                /*business_name: "required",
                exp_address1: "required",
                expr_country_id: "required",
                state_expr_id: "required",
                city_expr_id: "required",
                pincode_number: "required",
                current_emp: "required",
                start_date: "required",
                end_date: "required"*/
            },
            messages: {
                name_of_cmp: "Please enter your employee name",
                /*business_name: "Please select your business",
                exp_address1: "Please enter your address",
                expr_country_id: "Please select country",
                state_expr_id: "Please select state",
                city_expr_id: "Please select city",
                pincode_number: "Please enter your postalcode",
                current_emp: "Please select current employee or not",
                start_date: "Please enter your start date",
                end_date: "Please enter your end date"*/
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "current_emp") {
                    error.insertAfter("#current_emp_msg");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                var inquiry_id = $("#login_id").val();
                var exp_id = $("#exp_id").val();
                $.ajax({
                    type: "POST",
                    url: base_url + "submit_client_experience_data?inquiry_id=" + inquiry_id,
                    data: $("#frmExperiance").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            $("#other_expr_country").hide();
                            $("#other_expr_state").hide();
                            $("#other_expr_city").hide();

                            $('#frmExperiance .validate').val('');
                            $("#current_emp_yes").prop('checked', false);
                            $("#current_emp_no").prop('checked', false);
                            $(".nrc").remove();
                            $(".duration-skill").remove();

                            var t = $('#experienceTable').DataTable();

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {

                                if (exp_id != "" && exp_id > 0) {

                                    $('#experienceTable').dataTable().fnClearTable();

                                    var clk = "return confirm('Are you sure want to delete?')";

                                    for (var i = 0; i < response.data.length; i++) {

                                        var link = '<a href="javascript:void(0);" data-id="' + response.data[i].exp_id + '" class="update" onclick="editExperience(' + response.data[i].exp_id + ');" ><i\n style="padding: 0px;font-size: 20px;"\n class="fa fa-pencil-square-o"\n aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' + response.data[i].exp_id + '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';

                                        t.row.add([
                                            response.data[i].name_of_cmp,
                                            response.data[i].designation,
                                            response.data[i].business_name,
                                            response.data[i].city_id,
                                            link
                                        ]).draw(false);
                                    }
                                    $("#exp_id").val('0');
                                } else {
                                    t.row.add([
                                        response.name_of_cmp,
                                        response.designation,
                                        response.business_name,
                                        response.city_id,
                                        response.link
                                    ]).draw(false);
                                }

                                $('html, body').animate({scrollTop: 0}, 1000);
                            } else {
                                window.location.href = "<?php echo HTTP_SERVER;?>viewinquiry/<?php echo $inquiry_id;?>/" + tab_name;
                            }

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        $('#frmExperiance').on('click', 'a.remove', function (e) {

            if (confirm('Are you sure want to delete?') == false) {
                return false;
            }

            var table = $('#experienceTable').DataTable();
            table.row($(this).closest('tr')).remove().draw(false);

            var id = $(this).attr('data-id');


            $.ajax({
                type: "POST",
                url: base_url + "delete_experience_data?exp_id=" + id,
                dataType: "json",
                success: function (response) {

                    if (response.status == true) {

                    } else if (response.status == false) {
                        alert("Something went wrong...!");
                        return false;
                    }
                }
            });
        });

        $('#frmTechnical').on('change', '.other_names', function (e) {

            var other_names = $(this).val();
            $(".family_name").hide();
            $(".given_name").hide();

            if (other_names == "family") {
                $(".family_name").show();
            } else if (other_names == "given") {
                $(".given_name").show();
            }
        });

        $('#frmTechnical').on('blur keyup', '#balance_in_inr', function (e) {

            var balance_in_inr = $(this).val();
            var referance_rate_type = $("#referance_rate_type").val();
            $("#balance_").hide();
            var ref_rate = $("#ref_rate").val();

            if (balance_in_inr > 0 && ref_rate > 0) {
                var ans = parseInt(balance_in_inr) / parseInt(ref_rate);
                console.log(ans);
                $("#balance_").show();
                $("#available_balance_").html(ans.toFixed(2) + " " + referance_rate_type);
                $("#available_balance").val(ans.toFixed(2));
            }
        });

        $('#frmTechnical').on('click', 'a.remove', function (e) {

            if (confirm('Are you sure want to delete?') == false) {
                return false;
            }

            var table = $('#financeTable').DataTable();
            table.row($(this).closest('tr')).remove().draw(false);

            var id = $(this).attr('data-id');

            $.ajax({
                type: "POST",
                url: base_url + "delete_sponsor_data?sponsor_id=" + id,
                dataType: "json",
                success: function (response) {

                    if (response.status == true) {

                    } else if (response.status == false) {
                        alert("Something went wrong...!");
                        return false;
                    }
                }
            });
        });

        $('#frmHelth').on('click', 'a.remove', function (e) {

            if (confirm('Are you sure want to delete?') == false) {
                return false;
            }

            var table = $('#healthTable').DataTable();
            table.row($(this).closest('tr')).remove().draw(false);

            var id = $(this).attr('data-id');

            $.ajax({
                type: "POST",
                url: base_url + "delete_health_data?insurance_id=" + id,
                dataType: "json",
                success: function (response) {

                    if (response.status == true) {

                    } else if (response.status == false) {
                        alert("Something went wrong...!");
                        return false;
                    }
                }
            });
        });

        $('#frmCourse').on('click', 'a.remove', function (e) {

            if (confirm('Are you sure want to delete?') == false) {
                return false;
            }

            var table = $('#studentTable').DataTable();
            table.row($(this).closest('tr')).remove().draw(false);

            var id = $(this).attr('data-id');

            $.ajax({
                type: "POST",
                url: base_url + "delete_course_data?course_id=" + id,
                dataType: "json",
                success: function (response) {

                    if (response.status == true) {

                    } else if (response.status == false) {
                        alert("Something went wrong...!");
                        return false;
                    }
                }
            });
        });

        $(document.body).on('blur keyup', '.currency_convert', function (e) {

            var id = $(this).data('id');

            var balance_in_inr = $("#balance_in_inr" + id).val();
            var ref_rate = $("#ref_rate" + id).val();
            $("#balance_" + id).hide();
            var referance_rate_type = $("#referance_rate_type" + id).val();

            if (parseInt(balance_in_inr) > 0 && parseInt(ref_rate) > 0) {

                var ans = parseInt(balance_in_inr) / parseInt(ref_rate);
                console.log(ans);
                $("#balance_" + id).show();
                $("#available_balance_" + id).html(ans.toFixed(2) + " " + referance_rate_type);
                $("#available_balance" + id).val(ans.toFixed(2));
            }
        });

        $('#frmTechnical').on('blur keyup', '#ref_rate', function (e) {

            var ref_rate = $(this).val();
            var referance_rate_type = $("#referance_rate_type").val();
            $("#balance_").hide();
            var balance_in_inr = $("#balance_in_inr").val();

            if (balance_in_inr > 0 && ref_rate > 0) {
                var ans = parseInt(balance_in_inr) / parseInt(ref_rate);
                console.log(ans);
                $("#balance_").show();
                $("#available_balance_").html(ans.toFixed(2) + " " + referance_rate_type);
                $("#available_balance").val(ans.toFixed(2));
            }
        });

        $(document).on('click', '.remove-meeting', function () {
            $(this).parent('.div-meeting').remove();
        });
        $('#frmCPD').on('click', '#btn_cpd_pre', function (e) {
            $("#tab_career").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmPassportDetails').on('click', '#btn_passport_next', function (e) {
            $("#tab_employment").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmExperiance').on('click', '#btn_exper_pre', function (e) {
            $("#tab_passport").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmExperiance').on('click', '#btn_exper_next', function (e) {
            $("#tab_sop").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmCareer').on('click', '#btn_sop_pre', function (e) {
            $("#tab_employment").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });


        $('#frmTechnical').on('click', '#btn_financial_pre', function (e) {
            $("#tab_sop").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmTechnical').on('click', '#btn_financial_next', function (e) {
            $("#tab_education").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmPersonal').on('click', '#btn_pr_pre', function (e) {
            $("#tab_technicalskill").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmImmigration').on('click', '#btn_immi_pre', function (e) {
            $("#tab_relative").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmCourse').on('click', '#btn_relative_pre', function (e) {
            $("#tab_finance").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmCourse').on('click', '#btn_relative_next', function (e) {
            $("#tab_health").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });
    });

    function editCommition(id, semester) {

        $(".noOfSemester").html("");
        $(".allSemester").hide();
        if (semester > 0) {

            $.ajax({
                type: "POST",
                url: base_url + "get_commition_data?course_id=" + id,
                dataType: "html",
                success: function (response) {

                    if (response != "") {

                        $('.noOfSemester').html(response);
                        $('#student_counrse_id').val(id);
                        if (semester > 0) {
                            for (var i = 1; i <= semester; i++) {
                                $('#invoice_date' + i).datetimepicker({
                                    autoclose: true,
                                    format: "dd/mm/yyyy",
                                    minView: 2
                                });
                            }
                        }

                        $(".allSemester").show();
                    }
                }
            });

        } else {
            $(".noOfSemester").html("<p>Please enter semester first</p>");
        }
    }

    function editPassport(id) {

        $("#passport_id").val(id);

        $.ajax({
            type: "POST",
            url: base_url + "get_passport_data?passport_id=" + id,
            dataType: "json",
            success: function (response) {

                if (response.status == true) {

                    $("#passport_number").val(response.passport_number);
                    $("#passport_issue_date").val(response.passport_issue_date);
                    $("#passport_expire_date").val(response.passport_expire_date);

                    $(".passport_name_div").hide();
                    $(".details_div").hide();

                    if (response.name_flag == 1) {
                        $("#name_flag_yes").prop("checked", false);
                        $("#name_flag_no").prop("checked", true);
                        $(".passport_name_div").show();
                        $("#passport_name").val(response.passport_name);

                    } else if (response.name_flag == 0) {
                        $("#name_flag_yes").prop("checked", true);
                        $("#name_flag_no").prop("checked", false);
                    }

                    if (response.passport_lost == 1) {
                        $("#passport_lost_yes").prop("checked", true);
                        $("#passport_lost_no").prop("checked", false);
                        $(".details_div").show();
                        $("#passport_details").val(response.details);
                    } else if (response.passport_lost == 0) {
                        $("#passport_lost_yes").prop("checked", false);
                        $("#passport_lost_no").prop("checked", true);
                    }

                } else if (response.status == false) {
                    alert("Something went wrong...!");
                    return false;
                }
            }
        });
    }

    function editSponsor(id) {

        $("#sponsor_id").val(id);

        $.ajax({
            type: "POST",
            url: base_url + "get_sponsor_data?sponsor_id=" + id,
            dataType: "json",
            success: function (response) {

                if (response.status == true) {

                    $("#sponsor_name").val(response.sponsor_name);
                    $("#relation_id").val(response.relation_id);
                    $("#sponsor_address1").val(response.exp_address1);
                    $("#sponsor_address1").val(response.exp_address1);
                    $("#sponsor_address2").val(response.exp_address2);
                    $("#sponsor_address3").val(response.exp_address3);
                    $("#date_of_birth").val(response.date_of_birth);
                    $("#annual_income").val(response.annual_income);
                    $("#name_of_institute").val(response.name_of_institute);
                    $("#institude_address").val(response.institude_address);
                    $("#branch_name").val(response.branch_name);
                    $("#branch_code").val(response.branch_code);
                    $("#account_name").val(response.account_name);
                    $("#account_number").val(response.account_number);
                    $("#account_type").val(response.account_type);
                    $("#balance_in_inr").val(response.balance_in_inr);
                    $("#referance_rate_type").val(response.referance_rate_type);
                    $("#ref_rate").val(response.ref_rate);
                    $("#name_of_institute").val(response.name_of_institute);
                    $("#institude_address").val(response.institude_address);


                    $(".family_name").hide();
                    $(".given_name").hide();

                    if (response.available_balance != "") {
                        $("#balance_").show();
                        $("#available_balance").val(response.available_balance);
                        $("#available_balance_").html(response.available_balance + " " + response.referance_rate_type);
                    }

                    $("#other_name_details_div").hide();
                    if (response.family_name != "") {
                        $(".family_name").show();
                        $("#other_names_yes").prop("checked", true);
                        $("#other_names_no").prop("checked", false);
                        $("#family_name").val(response.family_name);
                        $("#other_name_details_div").show();

                    }

                    if (response.given_name != "") {
                        $("#other_names_yes").prop("checked", true);
                        $("#other_names_no").prop("checked", false);
                        $(".given_name").show();
                        $(".family_name").show();
                        $("#given_name").val(response.given_name);
                        $("#other_name_details_div").show();
                    }

                    if (response.reason_for_change != "" && response.reason_for_change > 0) {
                        $("#reason_for_change").val(response.reason_for_change);
                    }

                    /*For Detail Ajax Call*/
                    $(".more_other_details").html("");
                    $.ajax({
                        type: "POST",
                        url: base_url + "get_sponsor_other_detail?sponsor_id=" + id,
                        dataType: "html",
                        success: function (response_) {
                            $(".more_other_details").append(response_);
                        }
                    });

                    /*For Detail Ajax Call*/
                    $(".more_transaction_details").html("");
                    $.ajax({
                        type: "POST",
                        url: base_url + "get_sponsor_tra_details?sponsor_id=" + id,
                        dataType: "html",
                        success: function (response_) {
                            $(".more_transaction_details").append(response_);
                        }
                    });


                } else if (response.status == false) {
                    alert("Something went wrong...!");
                    return false;
                }
            }
        });
    }

    function editCourse(id) {

        $("#course_id").val(id);

        $.ajax({
            type: "POST",
            url: base_url + "get_course_data?course_id=" + id,
            dataType: "json",
            success: function (response) {

                if (response.status == true) {

                    $("#name_of_intitute").val(response.name_of_intitute);
                    $("#course_country_id").val(response.country_id);
                    $("#designation").val(response.designation);
                    $("#campus").val(response.campus);
                    $("#course_add").val(response.address);
                    $("#course_phone_number").val(response.phone_number);
                    $("#fax_number").val(response.fax_number);
                    $("#course_email_address").val(response.email_address);
                    $("#web_url").val(response.web_url);
                    $("#course_name").val(response.course_name);
                    $("#course_code").val(response.course_code);
                    $("#course_start_date").val(response.start_date);
                    $("#course_end_date").val(response.end_date);
                    $("#no_of_semester").val(response.no_of_semester);

                } else if (response.status == false) {
                    alert("Something went wrong...!");
                    return false;
                }
            }
        });
    }

    function editHealth(id) {

        $("#insurance_id").val(id);

        $.ajax({
            type: "POST",
            url: base_url + "get_health_data?insurance_id=" + id,
            dataType: "json",
            success: function (response) {

                if (response.status == true) {

                    $("#provider_name").val(response.provider_name);
                    $("#paid_to").val(response.paid_to);
                    $("#health_start_date").val(response.start_date);
                    $("#health_end_date").val(response.end_date);
                    $("#total_amount").val(response.total_amount);

                } else if (response.status == false) {
                    alert("Something went wrong...!");
                    return false;
                }
            }
        });
    }

    function editExperience(id) {

        $("#exp_id").val(id);

        $.ajax({
            type: "POST",
            url: base_url + "get_experience_data?exp_id=" + id,
            dataType: "json",
            success: function (response) {

                $("#other_expr_country").hide();
                $("#other_expr_state").hide();
                $("#other_expr_city").hide();

                if (response.status == true) {

                    /* $(".end_date_div").show();

                     if (response.current_emp == 1) {
                         $(".end_date_div").hide();
                         $("#current_emp_yes").prop('checked', true);
                     } else {
                         $(".end_date_div").show();
                         $("#current_emp_no").prop('checked', true);
                     }*/

                    //$("#expr_country_id").val(response.country_id);
                    $("#expr_country_hidden").val(response.country_id);

                    load_country(response.country_id);
                    load_expr_state(response.state_id);
                    //$("#state_expr_id").val(response.state_id);
                    $("#city_expr_hidden").val(response.city_id);

                    $("#name_of_cmp").val(response.name_of_cmp);
                    $("#business_name").val(response.business_name);
                    $("#designation").val(response.designation);
                    $("#exp_address1").val(response.exp_address1);
                    $("#exp_address2").val(response.exp_address2);
                    $("#exp_address3").val(response.exp_address3);
                    $("#start_date").val(response.start_date);
                    $("#end_date").val(response.end_date);
                    $("#pincode_number").val(response.pincode_number);
                    $("#email_address").val(response.email_address);
                    $("#website").val(response.website);
                    $("#mobile_number_1").val(response.mobile_number_1);
                    $("#mobile_number_2").val(response.mobile_number_2);
                    $("#work_task0").val(response.work_task[0]);
                    $("#work_task1").val(response.work_task[1]);
                    $("#work_task2").val(response.work_task[2]);
                    var strText = "";
                    if (response.work_task.length > 0) {
                        for (var i = 0; i < response.work_task.length; i++) {
                            if (i > 2) {
                                if (response.work_task[i] != "") {
                                    strText += '<div class="nrc"><input value="' + response.work_task[i] + '" name="work_task[]" type="text" class="validate valid" value="" placeholder="Work Task" aria-invalid="false"></div>';
                                }
                            }
                        }
                    }

                    $(".v-div").append(strText);

                    var strDuration = "";
                    if (response.designations.length > 0) {
                        for (var i = 0; i < response.designations.length; i++) {
                            if (i > 0) {
                                if (response.designations[i] != "") {
                                    strDuration += '<div class="duration-skill"><div class="input-field col s4"><input id="designation' + i + '" name="designations[]" type="text" class="validate" value="' + response.designations[i] + '"><label for="designation">Designation</label></div><div class="input-field col s4"><input id="duration_start_date1' + i + '" name="duration_start_date[]" type="text" class="validate" value="' + response.start_from[i] + '"><label for="sd">Start Date</label></div><div class="input-field col s4"><input id="duration_end_date1' + i + '" name="duration_end_date[]" type="text" class="validate" value="' + response.end_to[i] + '"><label for="ed">End Date</label></div><i class=\"fa fa-trash-o remove-duration-div\"></i></div>';
                                }
                            }
                        }
                    }

                    $(".duration_data").append(strDuration);

                    if (response.designations.length > 0) {
                        for (var i = 0; i < response.designations.length; i++) {
                            if (i > 0) {
                                $('#duration_start_date1' + i).datetimepicker({
                                    autoclose: true,
                                    format: "dd/mm/yyyy",
                                    minView: 2
                                });

                                $('#duration_end_date1' + i).datetimepicker({
                                    autoclose: true,
                                    format: "dd/mm/yyyy",
                                    minView: 2
                                });
                            }
                        }
                    }

                } else if (response.status == false) {
                    alert("Something went wrong...!");
                    return false;
                }
            }
        });
    }

    function editRelative(id) {

        $("#relation_id").val(id);

        $.ajax({
            type: "POST",
            url: base_url + "get_family_data?relation_id=" + id,
            dataType: "json",
            success: function (response) {

                if (response.status == true) {

                    $("#applicant_name").val(response.applicant_name);
                    $("#relationship").val(response.relationship);
                    $("#relative_last_name").val(response.relative_last_name);
                    $("#reta_address1").val(response.reta_address1);
                    $("#reta_address2").val(response.reta_address2);
                    $("#reta_address3").val(response.reta_address3);
                    $("#date_of_birth").val(response.date_of_birth);
                    $(".migrate_data").hide();
                    $(".family_name").hide();
                    $(".given_name").hide();
                    $(".rev-passport").remove();
                    $("#marriage_date_div").hide();
                    if (response.relationship == 155 || response.relationship == 119) {
                        $("#marriage_date_div").show();
                        $("#marriage_date").val(response.marriage_date);
                    }
                    if (response.migrate_with_client == 1) {
                        $("#migrate_with_client_yes").prop("checked", true);
                        $("#migrate_with_client_no").prop("checked", false);
                        $(".migrate_data").show();

                        $("#family_passport_number").val(response.passport_number);
                        $("#family_passport_issue_date").val(response.passport_issue_date);
                        $("#family_passport_expire_date").val(response.passport_expire_date);

                        var strPassort = "";
                        if (response.passport_number_data.length > 0) {
                            for (var i = 0; i < response.passport_number_data.length; i++) {
                                if (i > 0) {

                                    if (response.passport_number_data[i] != "") {
                                        strPassort += '<div class="rev-passport"> <div class="row">\n' +
                                            '\t<div class="input-field col s6">\n' +
                                            '\t\t<input id="family_passport_number" value="' + response.passport_number_data[i] + '" name="family_passport_number[]" type="text"\n' +
                                            '\t\t\t   class="validate"\n' +
                                            '\t\t\t   value="">\n' +
                                            '\t\t<label for="family_passport_number">Passport Number</label>\n' +
                                            '\t</div>\n' +
                                            '\n' +
                                            '</div>\n' +
                                            '<div class="clearfix"></div>\n' +
                                            '<div class="row">\n' +
                                            '\t<div class="input-field col s6">\n' +
                                            '\t\t<input id="_issue_date' + i + '" value="' + response.passport_issue_date_data[i] + '" name="family_passport_issue_date[]"\n' +
                                            '\t\t\t   type="text" class="validate family_issue_date"\n' +
                                            '\t\t\t   value="">\n' +
                                            '\t\t<label for="passport_issue_date">Passport Issue Date</label>\n' +
                                            '\t</div>\n' +
                                            '\t<div class="input-field col s6">\n' +
                                            '\t\t<input id="_expire_date\'+i+\'" value="' + response.passport_expire_date_data[i] + '" name="family_passport_expire_date[]"\n' +
                                            '\t\t\t   type="text"\n' +
                                            '\t\t\t   class="validate family_expire_date"\n' +
                                            '\t\t\t   value="">\n' +
                                            '\t\t<label for="passport_expire_date">Passport Expiry Date</label>\n' +
                                            '\t</div>\n' +
                                            '</div><i class=\"fa fa-trash-o remove-passport-div\"></i></div>';
                                    }
                                }
                            }

                            $(".more_details").append(strPassort);

                            if (response.passport_number_data.length > 0) {
                                for (var i = 0; i < response.passport_number_data.length; i++) {
                                    if (i > 0) {

                                        $('#_issue_date' + i).datetimepicker({
                                            autoclose: true,
                                            format: "dd/mm/yyyy",
                                            minView: 2
                                        });

                                        $('#_expire_date' + i).datetimepicker({
                                            autoclose: true,
                                            format: "dd/mm/yyyy",
                                            minView: 2
                                        });
                                    }
                                }

                            }
                        }

                        $("#other_name_details_div").hide();
                        if (response.family_name != "") {
                            $(".family_name").show();
                            $("#other_names_yes").prop("checked", true);
                            $("#other_names_no").prop("checked", false);
                            $("#family_name").val(response.family_name);
                            $("#other_name_details_div").show();

                        }

                        if (response.given_name != "") {
                            $("#other_names_yes").prop("checked", true);
                            $("#other_names_no").prop("checked", false);
                            $(".given_name").show();
                            $(".family_name").show();
                            $("#given_name").val(response.given_name);
                            $("#other_name_details_div").show();
                        }

                        if (response.reason_for_change != "" && response.reason_for_change > 0) {
                            $("#reason_for_change").val(response.reason_for_change);
                        }

                        /*For Detail Ajax Call*/
                        $(".more_other_details").html("");
                        $.ajax({
                            type: "POST",
                            url: base_url + "get_family_other_detail?relation_id=" + id,
                            dataType: "html",
                            success: function (response_) {
                                $(".more_other_details").append(response_);
                            }
                        });

                    } else if (response.migrate_with_client == 0) {
                        $("#migrate_with_client_yes").prop("checked", false);
                        $("#migrate_with_client_no").prop("checked", true);
                    }


                    $("#immigration_status").val(response.immigration_status);
                    $("#relationship").val(response.relationship);

                } else if (response.status == false) {
                    alert("Something went wrong...!");
                    return false;
                }
            }
        });
    }

    function load_state() {

        $("#other_country").hide();
        $("#other_state").hide();
        $("#other_city").hide();

        var iCountryID = document.getElementById("country_id").value;
        document.getElementById("city_id").value = "";

        var iStateID = "";
        <?php if (!empty($row)) { ?>
        iStateID = <?php echo $row["state_id"]; ?>
        <?php } ?>

        if (iCountryID == 0 && iCountryID != "") {
            $("#other_country").show();
        }

        var xmlhttp;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("state_id").innerHTML = xmlhttp.responseText;
                load_city();
            }
        }
        xmlhttp.open("GET", "<?php echo HTTP_SERVER; ?>load_state?iCountryID=" + iCountryID + "&iStateID=" + iStateID, true);
        xmlhttp.send();
    }

    function load_city() {

        var iStateID = document.getElementById("state_id").value;
        var iCityID = "";
        <?php if (!empty($row)) { ?>
        iCityID = <?php echo $row["city_id"]; ?>
        <?php } ?>

            $("#other_state").hide();
        $("#other_city").hide();

        if (iStateID == 0 && iStateID != "") {
            $("#other_state").show();
        }

        var xmlhttp;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("city_id").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "<?php echo HTTP_SERVER; ?>load_city?iStateID=" + iStateID + "&iCityID=" + iCityID, true);
        xmlhttp.send();
    }

    function load_city_other() {

        var iCityID = document.getElementById("city_id").value;

        $("#other_city").hide();

        if (iCityID == 0 && iCityID != "") {
            $("#other_city").show();
        }
    }

    function load_country(cid = null) {

        var xmlhttp;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("expr_country_id").innerHTML = xmlhttp.responseText;
                $("#expr_country_id").val(cid);
            }
        }
        xmlhttp.open("GET", "<?php echo HTTP_SERVER; ?>load_country", true);
        xmlhttp.send();
    }

    function load_relative_state(state_id = null) {

        var xmlhttp;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("relative_state_id").innerHTML = xmlhttp.responseText;
                if (state_id != null) {
                    $("#relative_state_id").val(state_id);
                }
                load_relative_city();
            }
        }
        xmlhttp.open("GET", "<?php echo HTTP_SERVER; ?>load_state?iCountryID=13&iStateID=", true);
        xmlhttp.send();
    }

    function load_expr_state(sid = null) {

        $("#other_expr_country").hide();
        $("#other_expr_state").hide();
        $("#other_expr_city").hide();

        var iCountryID = document.getElementById("expr_country_id").value;

        if (iCountryID == "") {
            if ($("#expr_country_hidden").val() > 0) {
                iCountryID = $("#expr_country_hidden").val();
            }
        }

        document.getElementById("city_expr_id").value = "";

        var iStateID = "";
        <?php if (!empty($row)) { ?>
        iStateID = <?php echo $row["state_id"]; ?>
        <?php } ?>

        if (iCountryID == 0 && iCountryID != "") {
            $("#other_expr_country").show();
        }

        var xmlhttp;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("state_expr_id").innerHTML = xmlhttp.responseText;
                $("#state_expr_id").val(sid);
                load_expr_city();
            }
        }
        xmlhttp.open("GET", "<?php echo HTTP_SERVER; ?>load_state?iCountryID=" + iCountryID + "&iStateID=" + iStateID, true);
        xmlhttp.send();
    }

    function load_expr_city() {

        var iStateID = document.getElementById("state_expr_id").value;
        var iCityID = "";
        <?php if (!empty($row)) { ?>
        iCityID = <?php echo $row["city_id"]; ?>
        <?php } ?>

            $("#other_expr_state").hide();
        $("#other_expr_city").hide();

        if (iStateID == 0 && iStateID != "") {
            $("#other_expr_state").show();
        }

        var xmlhttp;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("city_expr_id").innerHTML = xmlhttp.responseText;
                if ($("#city_expr_hidden").val() != "" && $("#city_expr_hidden").val() > 0) {
                    $("#city_expr_id").val($("#city_expr_hidden").val());
                }
            }
        }
        xmlhttp.open("GET", "<?php echo HTTP_SERVER; ?>load_city?iStateID=" + iStateID + "&iCityID=" + iCityID, true);
        xmlhttp.send();
    }

    function load_expr_city_other() {

        var iCityID = document.getElementById("city_expr_id").value;

        $("#other_expr_city").hide();

        if (iCityID == 0 && iCityID != "") {
            $("#other_expr_city").show();
        }
    }

    function load_relative_city() {

        var iStateID = document.getElementById("relative_state_id").value;
        var iCityID = "";
        <?php if (!empty($row)) { ?>
        iCityID = <?php echo $row["inquiry_id"]; ?>
        <?php } ?>

            $("#other_relative_state").hide();
        $("#other_relative_city").hide();

        if (iStateID == 0 && iStateID != "") {
            $("#other_relative_state").show();
        }

        var xmlhttp;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("relative_city_id").innerHTML = xmlhttp.responseText;
                if ($("#relative_city_hidden").val() != "" && $("#relative_city_hidden").val() > 0) {
                    $("#relative_city_id").val($("#relative_city_hidden").val());
                }
            }
        }
        xmlhttp.open("GET", "<?php echo HTTP_SERVER; ?>load_city?iStateID=" + iStateID + "&iCityID=" + iCityID, true);
        xmlhttp.send();
    }

    function load_relative_city_other() {

        var iCityID = document.getElementById("relative_city_id").value;

        $("#other_relative_city").hide();

        if (iCityID == 0 && iCityID != "") {
            $("#other_relative_city").show();
        }
    }

    <?php if (!empty($row)) { ?>

    $(window).load(function () {
        //load_state();
        $(".tabs li").removeClass("disabled");
    });

    <?php } ?>

    <?php

    if (!empty($english_test)) {
    if ($english_test['applyed_for'] == 1) {
    ?>
    $(".applyed_for_div").show();
    <?php

    }
    }

    if (!empty($immigration_arr)) {
    if ($immigration_arr['visa_type_applied'] == 1) {
    ?>
    $("#visa_type_yes").prop('checked', true);
    $(".visa_div").show();
    <?php
    if ($immigration_arr['visa_granted'] == 1) {
    ?>
    $("#was_visa_type_yes").prop('checked', true);
    $(".did_travel").show();
    <?php
    if ($immigration_arr['is_travel'] == 1) {
    ?>
    $("#did_travel_yes").prop('checked', true);
    $(".travel_date").show();
    <?php

    } else {
    ?>
    $("#did_travel_no").prop('checked', true);
    <?php

    }
    } else {
    ?>
    $("#was_visa_type_no").prop('checked', true);
    <?php

    }
    } else {
    ?>
    $("#visa_type_no").prop('checked', true);
    <?php
    }
    }

    if (!empty($row)) {
    if ($row['reference_by'] == "0") {
    ?>
    $("#reference_by").val("0");
    $(".sub_agent_by").show();
    $("#sub_agent_by").val("<?php echo $row['sub_agent_by']; ?>");
    <?php

    } else {
    ?>
    $("#reference_by").val("<?php echo $row['reference_by']; ?>");
    <?php

    }
    }
    ?>

</script>