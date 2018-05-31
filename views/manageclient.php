<?php include_once '../include/header.php'; ?>
<?php

$row = array();
$education = array();
$experiences = array();
$immigration_arr = array();
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
    $cond = "inquiry_id=:inquiry_id AND is_active =:is_active";
    $params = array(":inquiry_id" => $inquiry_id, ":is_active" => 1);

    $row = $obj->fetchRow('inquiry_list', $cond, $params);
    $reg_data = $obj->fetchRow('registration', $cond, $params);
    $follow_up_data = $obj->fetchRow('follow_up', $cond, $params);

    $reg_id = $row['is_register'];

    $passports = $obj->fetchRowAll('passpord_details', $cond, $params);
    $event_data = $obj->fetchRow('events', $cond, $params);

    $english_test = $obj->fetchRow('english_test', $cond, $params);
    $education = $obj->fetchRowAll('education_details', $cond, $params);
    $experiences = $obj->fetchRowAll('work_experiance_details', $cond, $params);
    $immigration_arr = $obj->fetchRow('immigration_details', $cond, $params);
    $relative_data = $obj->fetchRowAll('familydetails', $cond, $params);
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

$cond = "category_name =:category_name AND is_active =:is_active AND doc_id =:doc_id";
$params = array(":category_name" => 'PaymentStage', ":is_active" => 1, ":doc_id" => 1);

?>
<style type="text/css">
    .fa {
        padding: 0px !important;
    }

    .indicator {
        display: none;
    }

    .row .col.s3 {
        width: 11%;
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
                                                class="<?php if ($types == "career") { ?> active <?php } ?>"
                                                id="tab_career"
                                                href="#career">Career</a>
                                    </li>
                                    <li class="tab col s3"><a
                                                class="<?php if ($types == "cpd") { ?> active <?php } ?>"
                                                id="tab_cpd" href="#cpd">CPD</a></li>
                                    <li class="tab col s3"><a
                                                class="<?php if ($types == "technicalskill") { ?> active <?php } ?>"
                                                id="tab_technicalskill" href="#technicalskill">Technical Skill</a></li>
                                    <li class="tab col s3 disabled"><a
                                                class="<?php if ($types == "personal_skill") { ?> active <?php } ?>"
                                                id="tab_personal_skill" href="#personal_skill">Personal Skill</a>
                                    </li>
                                    <li class="tab col s3"><a
                                                class="<?php if ($types == "archevements") { ?> active <?php } ?>"
                                                id="tab_archevements" href="#archevements">Archevements</a>
                                    </li>
                                    <li class="tab col s3"><a
                                                class="<?php if ($types == "familly") { ?> active <?php } ?>"
                                                id="tab_familly"
                                                href="#familly">Familly</a>
                                    </li>
                                    <li class="tab col s3"><a
                                                class="<?php if ($types == "meeting") { ?> active <?php } ?>"
                                                id="tab_meeting"
                                                href="#meeting">Meeting</a>
                                    </li>
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
                                <div id="career" class="col s12">
                                    <form id="frmCareer" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="row">
                                            <textarea id="career_overview" name="career_overview"
                                                      placeholder="Career Orverview"
                                                      style="height: 250px;"><?php if (!empty($reg_data)) {
                                                    echo $reg_data['career_overview'];
                                                } ?></textarea>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_career_pre">
                                                        Previous
                                                    </a>
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           value="Next">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="cpd" class="col s12">
                                    <form id="frmCPD" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <input type="hidden" id="event_id" name="event_id"
                                               value="<?php if (!empty($event_data)) {
                                                   echo $event_data['event_id'];
                                               } else {
                                                   echo "0";
                                               } ?>">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="input-field col s2">
                                                    <label for="test_type">Event</label>
                                                </div>
                                                <div class="input-field col s5">
                                                    <select name="master_id" class="form-control validate"
                                                            id="master_id">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($events)) {
                                                            $selected = "";
                                                            for ($c = 0; $c < count($events); $c++) {
                                                                if (!empty($event_data)) {
                                                                    if ($event_data['master_id'] == $events[$c]['master_id']) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $events[$c]['master_id']; ?>">
                                                                    <?php echo ucfirst($events[$c]['name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                        <option value="0">Other</option>
                                                    </select>
                                                </div>

                                                <div class="input-field col s4 other_event" style="display: none;">
                                                    <input id="other_event_name" name="other_event_name" type="text"
                                                           class="validate">
                                                    <label for="event_data">Event Name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <input id="start_held_on" name="start_held_on" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($event_data)) {
                                                           if ($event_data['start_date'] != "1970-01-01" && $event_data['start_date'] != "0000-00-00") {
                                                               echo date("d/m/Y", strtotime($event_data['start_date']));
                                                           }
                                                       } ?>">
                                                <label for="proficiency_date">Start Date</label>
                                            </div>
                                            <div class="input-field col s4">
                                                <input id="end_held_on" name="end_held_on" onchange="CalculateDiff();"
                                                       onblur="CalculateDiff();"
                                                       type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($event_data)) {
                                                           if ($event_data['end_date'] != "1970-01-01" && $event_data['end_date'] != "0000-00-00") {
                                                               echo date("d/m/Y", strtotime($event_data['end_date']));
                                                           }
                                                       } ?>">
                                                <label for="proficiency_date">End Date</label>
                                            </div>
                                            <div class="input-field col s4">
                                                <input id="duration" name="duration" type="text" class="validate"
                                                       value="<?php if (!empty($event_data)) {
                                                           echo $event_data['duration'];
                                                       } ?>">
                                                <label for="duration">Duration</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="title" name="title" type="text" class="validate"
                                                       value="<?php if (!empty($event_data)) {
                                                           echo $event_data['title'];
                                                       } ?>">
                                                <label for="title">Topic</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="place" name="place" type="text" class="validate"
                                                       value="<?php if (!empty($event_data)) {
                                                           echo $event_data['place'];
                                                       } ?>">
                                                <label for="place">Place</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_cpd_pre">
                                                        Previous
                                                    </a>
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           name="btn_enlish_next" value="Next">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="technicalskill" class="col s12">
                                    <form id="frmTechnical" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="row tech-var-div">

                                            <div class="input-field col s2">
                                                <label for="technical_skill">Technical Skill</label>
                                            </div>
                                            <div class="input-field col s10 tech-v-div">
                                                <?php
                                                if ($reg_data['technical_skill'] != "") {
                                                    $techSkill = explode(",", $reg_data['technical_skill']);
                                                    foreach ($techSkill as $val) {
                                                        if ($val != "") {
                                                            ?>
                                                            <input id="technical_skill" name="technical_skill[]"
                                                                   type="text"
                                                                   class=""
                                                                   value="<?php echo $val; ?>"
                                                                   placeholder="Technical Skill">
                                                            <?php
                                                        }
                                                    }

                                                } else {
                                                    ?>
                                                    <input id="technical_skill" name="technical_skill[]" type="text"
                                                           class=""
                                                           value="" placeholder="Technical Skill">
                                                    <input id="technical_skill" name="technical_skill[]" type="text"
                                                           class=""
                                                           value="" placeholder="Technical Skill">
                                                    <input id="technical_skill" name="technical_skill[]" type="text"
                                                           class=""
                                                           value="" placeholder="Technical Skill">
                                                    <?php

                                                }
                                                ?>

                                            </div>
                                            <span id="tech_msg"></span>
                                            <div class="addButton">
                                                <a href="javascript:void(0);"
                                                   class="m-t-20 btn btn-primary tech-add"
                                                   style="margin-top:  8px;float: right;">More</a>
                                            </div>

                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <a class="waves-effect waves-light btn" id="btn_technical_pre">
                                                        Previous
                                                    </a>
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           name="btn_tech_next" value="Next">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="personal_skill" class="col s12">
                                    <form id="frmPersonal" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="row pr-var-div">

                                            <div class="input-field col s2">
                                                <label for="personal_skill">Personal Skill</label>
                                            </div>
                                            <div class="input-field col s10 pr-v-div">
                                                <?php
                                                if ($reg_data['personal_skill'] != "") {
                                                    $personal_skill = explode(",", $reg_data['personal_skill']);
                                                    foreach ($personal_skill as $val) {
                                                        if ($val != "") {
                                                            ?>
                                                            <input id="personal_skill" name="personal_skill[]"
                                                                   type="text"
                                                                   class=""
                                                                   value="<?php echo $val; ?>"
                                                                   placeholder="Personal Skill">
                                                            <?php
                                                        }
                                                    }

                                                } else {
                                                    ?>
                                                    <input id="personal_skill" name="personal_skill[]" type="text"
                                                           class=""
                                                           value="" placeholder="Personal Skill">
                                                    <input id="personal_skill" name="personal_skill[]" type="text"
                                                           class=""
                                                           value="" placeholder="Personal Skill">
                                                    <input id="personal_skill" name="personal_skill[]" type="text"
                                                           class=""
                                                           value="" placeholder="Personal Skill">
                                                    <?php

                                                }
                                                ?>

                                            </div>
                                            <span id="personal_msg"></span>
                                            <div class="addButton">
                                                <a href="javascript:void(0);"
                                                   class="m-t-20 btn btn-primary personal-add"
                                                   style="margin-top:  8px;float: right;">More</a>
                                            </div>

                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <a class="waves-effect waves-light btn" id="btn_pr_pre">
                                                        Previous
                                                    </a>
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           name="btn_tech_next" value="Next">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="archevements" class="col s12">
                                    <form id="frmAchiement" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="row ach-var-div">

                                            <div class="input-field col s2">
                                                <label for="personal_skill">Achiements</label>
                                            </div>
                                            <div class="input-field col s10 ach-v-div">
                                                <?php
                                                if ($reg_data['achievement'] != "") {
                                                    $achievement = explode(",", $reg_data['achievement']);
                                                    foreach ($achievement as $val) {
                                                        if ($val != "") {
                                                            ?>
                                                            <input id="achievement" name="achievement[]"
                                                                   type="text"
                                                                   class=""
                                                                   value="<?php echo $val; ?>"
                                                                   placeholder="Achiement Skill">
                                                            <?php
                                                        }
                                                    }

                                                } else {
                                                    ?>
                                                    <input id="achievement" name="achievement[]" type="text"
                                                           class=""
                                                           value="" placeholder="Achiement Skill">
                                                    <input id="achievement" name="achievement[]" type="text"
                                                           class=""
                                                           value="" placeholder="Achiement Skill">
                                                    <input id="achievement" name="achievement[]" type="text"
                                                           class=""
                                                           value="" placeholder="Achiement Skill">
                                                    <?php

                                                }
                                                ?>

                                            </div>
                                            <span id="achievement_msg"></span>
                                            <div class="addButton">
                                                <a href="javascript:void(0);"
                                                   class="m-t-20 btn btn-primary achievement-add"
                                                   style="margin-top:  8px;float: right;">More</a>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <a class="waves-effect waves-light btn" id="btn_ach_pre">
                                                        Previous
                                                    </a>
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           name="btn_ach_next" value="Next">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="familly" class="col s12">
                                    <form id="frmRelaive" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <input id="relation_id" name="relation_id" type="hidden" value="0">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover"
                                                   id="relativeTable">
                                                <thead>
                                                <tr>
                                                    <th>Applicant Name</th>
                                                    <th>Relationship</th>
                                                    <th>Address</th>
                                                    <th>Date of Birth</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (count($relative_data)) {

                                                    for ($i = 0; $i < count($relative_data); $i++) {

                                                        $cond = "master_id =:master_id";
                                                        $params = array(":master_id" => $relative_data[$i]['master_id']);
                                                        $raltionName = $obj->fetchRow('masters_list', $cond, $params);

                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td width="200"><?php echo ucfirst($relative_data[$i]['applicant_name']); ?></td>
                                                            <td width="250"><?php echo $raltionName['name']; ?></td>
                                                            <td width="250"><?php echo $relative_data[$i]['address']; ?></td>
                                                            <td width="250"><?php echo date("d/m/Y", strtotime($relative_data[$i]['date_of_birth'])); ?></td>
                                                            <td width="180">
                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $relative_data[$i]['family_id']; ?>"
                                                                   class="update"
                                                                   onclick="editRelative('<?php echo $relative_data[$i]['family_id']; ?>');"><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a>
                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $relative_data[$i]['family_id']; ?>"
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
                                        <div id="relative_in_ausi">
                                            <div class="row">
                                                <div class="input-field col s6">

                                                    <input id="family_id" name="family_id" type="hidden" value="0">

                                                    <input id="applicant_name" name="applicant_name"
                                                           type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="applicant_name">Applicant Name</label>
                                                </div>
                                                <div class="input-field col s6">
                                                    <div class="input-field col s4">
                                                        <label for="Relationship">Relationship</label>
                                                    </div>
                                                    <div class="input-field col s8">
                                                        <select name="relationship" class="form-control validate"
                                                                id="relationship">
                                                            <option value="">---Select---</option>
                                                            <?php if (!empty($relationship)) {
                                                                $selected = "";
                                                                for ($i = 0; $i < count($relationship); $i++) {

                                                                    ?>
                                                                    <option <?php echo $selected; ?>
                                                                            value="<?php echo $relationship[$i]['master_id']; ?>">
                                                                        <?php echo ucfirst($relationship[$i]['name']); ?></option>
                                                                    <?php $selected = '';
                                                                }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="row" id="marriage_date_div" style="display: none;">
                                                <div class="input-field col s6">
                                                    <input id="marriage_date" name="marriage_date" type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="marriage_date">Marriage Date</label>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="row">
                                                <div class="input-field col s2">
                                                    <label for="add1">Address </label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <input id="reta_address1" name="familyAddress[]" type="text"
                                                           class="validate"
                                                           value="" placeholder="Address Line No 1">
                                                    <input id="reta_address2" name="familyAddress[]" type="text"
                                                           class="validate"
                                                           value="" placeholder="Address Line No 2">
                                                    <input id="reta_address3" name="familyAddress[]" type="text"
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
                                                    <label for="date_of_birth">Date of Birth</label>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <div class="input-field col s4">
                                                        <label for="migrate_with_client">Migration with client</label>
                                                    </div>
                                                    <div class="input-field col s4">
                                                        <div class="form-group">
                                                            <input class="with-gap migrate_with_client"
                                                                   name="migrate_with_client"
                                                                   type="radio" id="migrate_with_client_yes"
                                                                   value="1"/>
                                                            <label for="migrate_with_client_yes">Yes</label>

                                                            <input class="with-gap migrate_with_client"
                                                                   name="migrate_with_client"
                                                                   type="radio" id="migrate_with_client_no"
                                                                   value="0"/>
                                                            <label for="migrate_with_client_no">No</label>
                                                            <br/>
                                                            <span id="migrate_with_client_msg"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div style="display: none;" class="migrate_data">
                                                <div class="row">
                                                    <div class="input-field col s6">
                                                        <input id="family_passport_number"
                                                               name="family_passport_number[]"
                                                               type="text"
                                                               class="validate"
                                                               value="">
                                                        <label for="family_passport_number">Passport Number</label>
                                                    </div>

                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="row">
                                                    <div class="input-field col s6">
                                                        <input id="family_passport_issue_date"
                                                               name="family_passport_issue_date[]"
                                                               type="text" class="validate"
                                                               value="">
                                                        <label for="family_passport_issue_date">Passport Issue
                                                            Date</label>
                                                    </div>
                                                    <div class="input-field col s6">
                                                        <input id="family_passport_expire_date"
                                                               name="family_passport_expire_date[]"
                                                               type="text"
                                                               class="validate"
                                                               value="">
                                                        <label for="family_passport_expire_date">Passport Expiry
                                                            Date</label>
                                                    </div>
                                                    <div class="addButton">
                                                        <a href="javascript:void(0);" data-toggle="modal"
                                                           data-target="#popuoPassport"
                                                           class="m-t-20 btn btn-primary"
                                                           style="margin-top:  8px;float: right;">More</a>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>

                                                <!--Load popup modal for add more passport details-->
                                                <div id="popuoPassport" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal">&times;
                                                                </button>
                                                                <h4 class="modal-title">Passport Details</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="more_details"></div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="javascript:void(0);"
                                                                   class="m-t-20 btn btn-primary add-passport">More</a>
                                                                <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Close
                                                                </button>
                                                            </div>
                                                        </div>

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
                                                       class="m-t-20 btn btn-primary"
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
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           value="Add">
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
                                <div id="meeting" class="col s12">
                                    <form id="frmMeeting" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="row">

                                            <div class="input-field col s2">
                                                <label for="personal_skill">Client Question</label>
                                            </div>
                                            <div class="input-field col s10 pr-v-div">
                                                <input id="client_question" name="client_question[]" type="text"
                                                       class=""
                                                       value="" placeholder="Client Question">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">

                                            <div class="input-field col s2">
                                                <label for="personal_skill">UBP Answer</label>
                                            </div>
                                            <div class="input-field col s10 pr-v-div">
                                                <input id="ubp_answer" name="ubp_answer[]" type="text"
                                                       class="ubp_answer"
                                                       value="" placeholder="UBP Answer">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="ubp_meeting"></div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <a class="waves-effect waves-light btn"
                                                       id="btn_meeting_next_quetion">
                                                        NEXT
                                                    </a>
                                                    <a class="waves-effect waves-light btn" data-toggle="modal"
                                                       data-target="#meetingModal" id="btn_meeting_save">
                                                        SAVE
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div id="meetingModal" class="modal fade" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            &times;
                                                        </button>
                                                        <h4 class="modal-title">Client Meeting</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>You want to leave client meeting ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn btn-default"
                                                               name="btn_meeting_save" id="btn_meeting_save_form"
                                                               value="Yes"/>
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">No
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </form>
                                </div>
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
        $('#eduTable').DataTable({
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

        $('#relativeTable').DataTable({
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

        $("#start_held_on").datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2,
            onSelect: function (selected) {
                $("#end_held_on").datetimepicker("option", "minDate", selected)
            }
        });
        $("#end_held_on").datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2,
            onSelect: function (selected) {
                $("#start_held_on").datetimepicker("option", "maxDate", selected)
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

        /*cpd detail added in database using ajax call*/
        $("#frmCPD").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                event_id: "required",
            },
            messages: {
                event_id: "Please select event",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();
                var event_id = $("#event_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_cpd_data?inquiry_id=" + inquiry_id + "&event_id=" + event_id,
                    data: $("#frmCPD").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {
                                $("#event_id").val(response.id);
                                $("#tab_technicalskill").click();
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

        $('#frmRelaive').on('change', '#reason_for_change', function (e) {

            var reason_for_change = $(this).val();
            $("#other_reason").hide();

            if (reason_for_change == 0 && reason_for_change != "") {
                $("#other_reason").show();
                $("#other_reason").val('');
            }
        });


        $('#frmCPD').on('change', '#master_id', function (e) {

            var event_id = $(this).val();
            $(".other_event").hide();

            if (event_id == 0 && event_id != "") {
                $(".other_event").show();
                $("#other_event_name").val('');
            }
        });
        /*Career detail added in database using ajax call*/
        $("#frmCareer").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                career_overview: "required",
            },
            messages: {
                career_overview: "Please enter career overview",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_career_data?inquiry_id=" + inquiry_id,
                    data: $("#frmCareer").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {
                                $("#tab_cpd").click();
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

        /*Technical detail added in database using ajax call*/
        $("#frmTechnical").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                "technical_skill1[]": "required",
            },
            messages: {
                "technical_skill1[]": "Please enter technical skill"
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "technical_skill[]") {
                    error.insertAfter("#tech_msg");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_technical_data?inquiry_id=" + inquiry_id,
                    data: $("#frmTechnical").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            $('#frmTechnical .validate').val('');

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {
                                $("#tab_personal_skill").click();
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

        /*Achiement detail added in database using ajax call*/
        $("#frmAchiement").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                "achievement1[]": "required",
            },
            messages: {
                "achievement1[]": "Please enter achiements"
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "achievement[]") {
                    error.insertAfter("#achievement_msg");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_achiement_data?inquiry_id=" + inquiry_id,
                    data: $("#frmAchiement").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {
                                $("#tab_familly").click();
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

        $('#frmRelaive').on('change', '.migrate_with_client', function (e) {

            var migrate_with_client = $(this).val();
            $(".migrate_data").hide();

            if (migrate_with_client == 1) {
                $(".migrate_data").show();
            }
        });

        $('#frmRelaive').on('change', '.other_names', function (e) {

            var other_names = $(this).val();
            $(".family_name").hide();
            $(".given_name").hide();

            if (other_names == "family") {
                $(".family_name").show();
            } else if (other_names == "given") {
                $(".given_name").show();
            }
        });

        $("#frmRelaive").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                applicant_name: "required",
                /*relationship: "required",
                date_of_birth: "required"*/
            },
            messages: {
                applicant_name: "Please enter applicant name",
                /*relationship: "Please select relationship",
                date_of_birth: "Please enter your date of birth"*/
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {
                var inquiry_id = $("#login_id").val();
                var relation_id = $("#relation_id").val();
                $.ajax({
                    type: "POST",
                    url: base_url + "submit_family_data?inquiry_id=" + inquiry_id,
                    data: $("#frmRelaive").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            var otherName = "";

                            if ($("#other_reason").val() != "") {
                                otherName = $("#other_reason").val();
                            }

                            if (otherName != "") {
                                $("#reason_for_change").append("<option value='" + response.reason_for_change + "'>" + otherName + "</option>"
                                )
                                ;
                            }

                            $("#relation_id").val("0");

                            $('#frmRelaive .validate').val('');
                            $(".rev-passport").remove();

                            $("#migrate_with_client_yes").prop("checked", false);
                            $("#migrate_with_client_no").prop("checked", false);
                            $("#other_reason").hide();
                            $(".given_name").hide();
                            $(".family_name").hide();
                            $(".migrate_data").hide();
                            $("#other_names_yes").prop("checked", false);
                            $("#other_names_no").prop("checked", false);

                            var t = $('#relativeTable').DataTable();

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {

                                if (relation_id != "" && relation_id > 0) {

                                    $('#relativeTable').dataTable().fnClearTable();

                                    var clk = "return confirm('Are you sure want to delete?');";

                                    for (var i = 0; i < response.data.length; i++) {

                                        var link = '<a href="javascript:void(0);" data-id="' + response.data[i].family_id + '" class="update" onclick="editRelative(' + response.data[i].family_id + ');" ><i\n style="padding: 0px;font-size: 20px;"\n class="fa fa-pencil-square-o"\n aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' + response.data[i].family_id + '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';

                                        t.row.add([
                                            response.data[i].applicant_name,
                                            response.data[i].relation,
                                            response.data[i].address,
                                            response.data[i].date_of_birth,
                                            link
                                        ]).draw(false);
                                    }

                                } else {
                                    t.row.add([
                                        response.applicant_name,
                                        response.relation,
                                        response.address,
                                        response.date_of_birth,
                                        response.link
                                    ]).draw(false);
                                }
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

        $('#frmRelaive').on('click', 'a.remove', function (e) {

            if (confirm('Are you sure want to delete?') == false) {
                return false;
            }

            var table = $('#relativeTable').DataTable();
            table.row($(this).closest('tr')).remove().draw(false);

            var id = $(this).attr('data-id');


            $.ajax({
                type: "POST",
                url: base_url + "delete_family_data?relative_id=" + id,
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

        /*Interasted in detail added in database using ajax call*/
        $("#frmInterastedin").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                immi_country_id: "required",
                visa_type: "required",
            },
            messages: {
                immi_country_id: "Please enter your intersted country",
                visa_type: "Please select visa type",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_interastedin_data?inquiry_id=" + inquiry_id,
                    data: $("#frmInterastedin").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {

                                $("#tab_reference").click();

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

        $('#frmEnglish').on('change', '.applyed_for', function (e) {

            var applyed_for = $(this).val();
            $(".applyed_for_div").hide();

            if (applyed_for == 1) {
                $(".applyed_for_div").show();
            }
        });

        $("#frmEnglish").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                applyed_for: "required",
            },
            messages: {
                applyed_for: "Please select english proficiency test",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "applyed_for") {
                    error.insertAfter("#applyed_for_msg");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();
                var english_id = $("#english_id_hidden").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_english_data?inquiry_id=" + inquiry_id + "&english_id=" + english_id,
                    data: $("#frmEnglish").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {

                                $('#english_id_hidden').val(response.id);
                                $("#tab_relative").click();

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

        $('#frmReference').on('change', '#reference_by', function (e) {

            var reference_by = $(this).val();
            $(".sub_agent_by").hide();

            if (reference_by == 0 && reference_by != "") {
                $(".sub_agent_by").show();
            }
        });

        $('#frmImmigration').on('change', '#applied_country', function (e) {

            var applied_country = $(this).val();
            $("#other_applied_country").hide();

            if (applied_country == 0 && applied_country != "") {
                $("#other_applied_country").show();
            }
        });

        /*reference in detail added in database using ajax call*/
        $("#frmReference").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                reference_by: "required",
            },
            messages: {
                reference_by: "Please select your reference",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_reference_data?inquiry_id=" + inquiry_id,
                    data: $("#frmReference").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {

                                if (response.reg_id > 0) {
                                    window.location.href = "<?php echo HTTP_SERVER; ?>registrationmanager";
                                } else {
                                    window.location.href = "<?php echo HTTP_SERVER; ?>inquirymanager";
                                }

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

        $("#reg_ref_save").click(function () {
            var inquiry_id = $("#login_id").val();

            $.ajax({
                type: "POST",
                url: base_url + "submit_reference_data?inquiry_id=" + inquiry_id,
                data: $("#frmReference").serialize(),
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status == true) {

                    } else if (response.status == false) {
                        alert("Something went wrong...!");
                        return false;
                    }
                }
            });
        });

        $(".reg_btn_pop").click(function () {
            $("#reg_ref_save").click();
            $("#btn_reg_clk").click();
        });

        $("#reg_form").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                passport_number: "required",
            },
            messages: {
                passport_number: "Please enter passport number",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "applyed_for") {
                    error.insertAfter("#applyed_for_msg");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_passport_data?inquiry_id=" + inquiry_id,
                    data: $("#reg_form").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            $("#btn_reg_btn_close").click();
                            $("#btn_second_clk").click();


                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        $("#pay_stage_form").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                consultant_fees: "required",
            },
            messages: {
                consultant_fees: "Please enter consultant fees",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "applyed_for") {
                    error.insertAfter("#applyed_for_msg");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_paystage_data?inquiry_id=" + inquiry_id,
                    data: $("#pay_stage_form").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {
                            window.location.href = "<?php echo HTTP_SERVER; ?>registrationmanager";

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        $("#frmFollowup").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                date_of_follow: "required",
            },
            messages: {
                date_of_follow: "Please select your follo up date",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();
                var follow_up_id = $("#follow_up_id").val();
                var reference_by = $("#reference_by").val();
                var sub_agent_by = $("#sub_agent_by").val();


                $.ajax({
                    type: "POST",
                    url: base_url + "submit_folloup_data?inquiry_id=" + inquiry_id + "&follow_up_id=" + follow_up_id + "&sub_agent_by=" + sub_agent_by + "&reference_by=" + reference_by,
                    data: $("#frmFollowup").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            window.location.href = "<?php echo HTTP_SERVER; ?>inquirymanager";

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        $('#frmMeeting').on('click', '#btn_meeting_save_form', function (e) {
            var inquiry_id = $("#login_id").val();

            $.ajax({
                type: "POST",
                url: base_url + "submit_meeting_data?inquiry_id=" + inquiry_id,
                data: $("#frmMeeting").serialize(),
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status == true) {

                        window.location.href = "<?php echo HTTP_SERVER; ?>clientsmanager";

                    } else if (response.status == false) {
                        alert("Something went wrong...!");
                        return false;
                    }
                }
            });
        });

        /*$('#frmMeeting').on('blur', '.ubp_answer', function (e) {
            $(this).toggleClass("ubp_answer");
        });*/

        $('#frmMeeting').on('click', '#btn_meeting_next_quetion', function (e) {

            var strMeeting = '<div class="div-meeting"><div class="row"><div class="input-field col s2"><label for="personal_skill">Client Question</label></div><div class="input-field col s10 pr-v-div"><input id="client_question" name="client_question[]" type="text" class="" value="" placeholder="Client Question"></div></div><div class="clearfix"></div><div class="row"><div class="input-field col s2"><label for="personal_skill">UBP Answer</label></div><div class="input-field col s10 pr-v-div"><input id="ubp_answer" name="ubp_answer[]" type="text" class="ubp_answer" value="" placeholder="UBP Answer"></div></div><i class=\"fa fa-trash-o remove-meeting\"></i></div>';
            $('.remove-language').removeClass('hidden');
            $('.ubp_meeting').append(strMeeting);
        });

        $('#frmMeeting').on('blur', '.ubp_answer', function (e) {

            var txtVal = $(this).val();

            if (txtVal != "") {
                var strMeeting = '<div class="div-meeting"><div class="row"><div class="input-field col s2"><label for="personal_skill">Client Question</label></div><div class="input-field col s10 pr-v-div"><input id="client_question" name="client_question[]" type="text" class="" value="" placeholder="Client Question"></div></div><div class="clearfix"></div><div class="row"><div class="input-field col s2"><label for="personal_skill">UBP Answer</label></div><div class="input-field col s10 pr-v-div"><input id="ubp_answer" name="ubp_answer[]" type="text" class="ubp_answer" value="" placeholder="UBP Answer"></div></div><i class=\"fa fa-trash-o remove-meeting\"></i></div>';
                $('.remove-language').removeClass('hidden');
                $('.ubp_meeting').append(strMeeting);
                $(this).toggleClass("ubp_answer");
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
            $("#tab_career").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmCareer').on('click', '#btn_career_pre', function (e) {
            $("#tab_employment").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmRelaive').on('change', '#relationship', function (e) {

            var relationship = $(this).val();
            $("#marriage_date_div").hide();

            if (relationship == 155 || relationship == 119) {
                $("#marriage_date_div").show();
            }
        });

        $('#frmTechnical').on('click', '#btn_technical_pre', function (e) {
            $("#tab_cpd").click();
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

        $('#frmAchiement').on('click', '#btn_ach_pre', function (e) {
            $("#tab_personal_skill").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmRelaive').on('click', '#btn_relative_pre', function (e) {
            $("#tab_archevements").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmRelaive').on('click', '#btn_relative_next', function (e) {
            $("#tab_meeting").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });
    });

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