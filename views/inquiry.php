<?php include_once '../include/header.php'; ?>
<?php

$row = array();
$education = array();
$experiences = array();
$immigration_arr = array();
$english_test = array();
$relative_data = array();
$types = "tab";

$loginid = $objsession->get("log_admin_loginid");
$inquiry_id = 0;
$reg_id = 0;

if (isset($_GET['inquiry_id'])) {

    if (isset($_GET['tb_type'])) {

        if ($_GET['tb_type'] == "tabs") {
            $types = "tab";
        } else {
            $types = $_GET['tb_type'];
        }

    }

    $cond = '';
    $inquiry_id = $_GET['inquiry_id'];
    $cond = "inquiry_id=:inquiry_id";
    $params = array(":inquiry_id" => $inquiry_id);
    $row = $obj->fetchRow('inquiry_list', $cond, $params);

    $follow_up_data = $obj->fetchRow('follow_up', $cond, $params);

    $reg_id = $row['is_register'];

    $english_test = $obj->fetchRow('english_test', $cond, $params);
    $education = $obj->fetchRowAll('education_details', $cond, $params);
    $experiences = $obj->fetchRowAll('work_experiance_details', $cond, $params);
    $immigration_arr = $obj->fetchRow('immigration_details', $cond, $params);
    $relative_data = $obj->fetchRowAll('relationship_details', $cond, $params);
    if (!empty($experiences)) {

        for ($i = 0; $i < count($experiences); $i++) {

            $cond = "city_id=:city_id";
            $params = array(":city_id" => $experiences[$i]['city_id']);
            $cities = $obj->fetchRow('cities', $cond, $params);
            $experiences[$i]['city_id'] = $cities['name'];
        }
    }

    if (!empty($relative_data)) {
        for ($i = 0; $i < count($relative_data); $i++) {

            /*$cond = "state_id=:state_id";
            $params = array(":state_id" => $relative_data[$i]['immigration_state']);
            $states = $obj->fetchRow('states', $cond, $params);
            $relative_data[$i]['immigration_state'] = $states['name'];*/

            $cond = "state_id=:city_id";
            $params = array(":city_id" => $relative_data[$i]['immigration_city']);
            $cities = $obj->fetchRow('states', $cond, $params);
            $relative_data[$i]['immigration_city'] = $cities['name'];

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
$params = array(":category_name" => 'Visa Type', ":is_active" => 1);
$visatype = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'Immigration', ":is_active" => 1);
$immigration_status = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'Relationship', ":is_active" => 1);
$relationship = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'Exam', ":is_active" => 1);
$englishExam = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'medium', ":is_active" => 1);
$medium = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "types =:types AND is_active =:is_active";
$params = array(":types" => 0, ":is_active" => 1);
$reference = $obj->fetchRowAll('referance_list', $cond, $params);

$cond = "types =:types AND is_active =:is_active";
$params = array(":types" => 1, ":is_active" => 1);
$sub_agent = $obj->fetchRowAll('referance_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'Proficiency', ":is_active" => 1);
$proficiency_type = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active AND doc_id =:doc_id ORDER BY indexs DESC";
$params = array(":category_name" => 'PaymentStage', ":is_active" => 1, ":doc_id" => 1);
$PaymentStage = $obj->fetchRowAll('masters_list', $cond, $params);

?>
<style type="text/css">
    .fa {
        padding: 0px !important;
    }

    .row .col.s3 {
        width: 12%;
    }

    .indicator {
        display: none;
    }

    .tabs .tab a {
        font-size: 12px;
    }
</style>
<div class="header">
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <?php
        if ($reg_id > 0) {
            ?>
            <li><a href="<?php echo HTTP_SERVER; ?>clientsmanager">List of Clients</a></li>
            <?php
        } else {
            ?>
            <li><a href="<?php echo HTTP_SERVER; ?>inquirymanager">List of Inquiry</a></li>
            <?php
        }
        ?>
        <li class="active">Manage Inquiry</li>
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
                                                class="<?php if ($types == "personal") { ?> active <?php } ?>"
                                                id="tab_personal"
                                                href="#personal">Personal</a>
                                    </li>
                                    <li class="tab col s3 disabled"><a
                                                class="<?php if ($types == "education") { ?> active <?php } ?>"
                                                id="tab_education"
                                                href="#education">Education</a>
                                    </li>
                                    <li class="tab col s3 disabled"><a
                                                class="<?php if ($types == "experiance") { ?> active <?php } ?>"
                                                id="tab_experiance"
                                                href="#experiance">Work Experiance</a>
                                    </li>
                                    <li class="tab col s3 disabled"><a
                                                class="<?php if ($types == "enlish") { ?> active <?php } ?>"
                                                id="tab_enlish" href="#enlish">English
                                            Proficiency</a></li>
                                    <li class="tab col s3 disabled"><a
                                                class="<?php if ($types == "relative") { ?> active <?php } ?>"
                                                id="tab_relative" href="#relative">Relative in
                                            Australian</a></li>
                                    <li class="tab col s3 disabled"><a
                                                class="<?php if ($types == "immigration") { ?> active <?php } ?>"
                                                id="tab_immigration" href="#immigration">Immigration
                                            Hisory</a>
                                    </li>
                                    <li class="tab col s3 disabled"><a
                                                class="<?php if ($types == "interastedin") { ?> active <?php } ?>"
                                                id="tab_interastedin" href="#interastedin">Interasted
                                            In</a>
                                    </li>
                                    <li class="tab col s3 disabled"><a
                                                class="<?php if ($types == "reference") { ?> active <?php } ?>"
                                                id="tab_reference"
                                                href="#reference">Reference</a>
                                    </li>
                                </ul>
                                <div class="clearBoth"><br/></div>
                                <div id="personal" class="col s12">
                                    <form id="frmPersonal" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="email_address" name="email_address" type="text"
                                                       class="validate fetchAppData"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['email_address'];
                                                       } ?>">
                                                <label for="email_address">Email</label>


                                            </div>
                                            <div class="input-field col s6">
                                                <input id="mobile_number" name="mobile_number" type="text"
                                                       class="validate fetchAppData"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['mobile_number'];
                                                       } ?>">
                                                <label for="mobile_number">Mobile Number</label>


                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">

                                                <input id="login_id" name="login_id" type="hidden"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['inquiry_id'];
                                                       } else {
                                                           echo "0";
                                                       } ?>">
                                                <input id="reg_id" name="reg_id" type="hidden"
                                                       value="<?php if ($reg_id > 0) {
                                                           echo $reg_id;
                                                       } else {
                                                           echo "0";
                                                       } ?>">

                                                <input id="first_name" name="first_name" type="text" class="validate"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['first_name'];
                                                       } ?>">
                                                <label for="first_name">First Name</label>
                                            </div>
                                            <!--<div class="input-field col s6">
                                                <input id="middle_name" name="middle_name" type="text" class="validate"
                                                       value="<?php /*if (!empty($row)) {
                                                           echo $row['middle_name'];
                                                       } */ ?>">
                                                <label for="middle_name">Middel Name</label>
                                            </div>-->
                                            <div class="input-field col s6">
                                                <input id="last_name" name="last_name" type="text" class="validate"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['last_name'];
                                                       } ?>">
                                                <label for="last_name">Last Name</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <?php
                                            if ($reg_id > 0) {
                                                ?>
                                                <div class="input-field col s6">
                                                    <input id="adharcard_number" name="adharcard_number" type="text"
                                                           class="validate"
                                                           value="<?php if (!empty($row)) {
                                                               echo $row['adharcard_number'];
                                                           } ?>">
                                                    <label for="adharcard_number">Adhar Card Number</label>
                                                </div>
                                            <?php } ?>
                                            <div class="input-field col s1">
                                                <label for="gender">Gender</label>
                                            </div>
                                            <div class="input-field col s4">
                                                <div class="form-group">
                                                    <?php
                                                    $male = 'checked=""';
                                                    $female = '';
                                                    if (!empty($row)) {
                                                        if ($row['gender'] == "Female") {
                                                            $female = 'checked=""';
                                                        }

                                                        if ($row['gender'] == "Male") {
                                                            $male = 'checked=""';
                                                        }
                                                    }
                                                    ?>
                                                    <input class="with-gap" name="gender"
                                                           type="radio" <?php echo $male; ?> id="test1"
                                                           value="Male"/>
                                                    <label for="test1">Male</label>

                                                    <input class="with-gap" name="gender"
                                                           type="radio" <?php echo $female; ?> id="test2"
                                                           value="Female"/>
                                                    <label for="test2">Female</label>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="date_of_birth" name="date_of_birth" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($row)) {
                                                           echo date("d/m/Y", strtotime($row['date_of_birth']));
                                                       } ?>">
                                                <label for="date_of_birth">Date of Birth</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="place_of_birth" name="place_of_birth" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['place_of_birth'];
                                                       } ?>">
                                                <label for="place_of_birth">Place of Birth</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="country_id">Country</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <select name="country_id" class="form-control" id="country_id"
                                                            onchange="load_state();">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($country)) {
                                                            $selected = "";
                                                            for ($c = 0; $c < count($country); $c++) {
                                                                if (!empty($row)) {
                                                                    if ($row['country_id'] == $country[$c]['country_id']) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $country[$c]['country_id']; ?>">
                                                                    <?php echo ucfirst($country[$c]['name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                        <!--<option value="0">Other</option>-->
                                                    </select>
                                                    <input type="text" name="other_country" id="other_country"
                                                           class="form-control"
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
                                                    <select name="state_id" class="form-control" id="state_id"
                                                            onchange="load_city();">
                                                        <option value="">---Select---</option>
                                                    </select>
                                                    <input type="text" name="other_state" id="other_state"
                                                           placeholder="Other State name"
                                                           style="margin:15px 0px;display:none;" class="form-control"
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
                                                    <select name="city_id" class="form-control" id="city_id"
                                                            onchange="load_city_other();">
                                                        <option value="">---Select---</option>
                                                    </select>
                                                    <input type="text" name="other_city" id="other_city"
                                                           placeholder="Other City name"
                                                           style="margin:15px 0px;display:none;" class="form-control"
                                                           value="">
                                                </div>

                                            </div>
                                            <div class="input-field col s6">

                                                <input id="postalcode" name="postalcode" type="text" class="validate"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['postalcode'];
                                                       } ?>">
                                                <label for="first_name">Postalcode</label>

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">

                                            <div class="input-field col s2">
                                                <label for="add1">Address </label>
                                            </div>
                                            <div class="input-field col s10">
                                                <input id="address1" name="address1" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['address1'];
                                                       } ?>" placeholder="Address Line No 1">
                                                <input id="address2" name="address2" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['address2'];
                                                       } ?>" placeholder="Address Line No 2">
                                                <input id="address3" name="address3" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['address3'];
                                                       } ?>" placeholder="Address Line No 3">
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="phone_number" name="phone_number" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['phone_number'];
                                                       } ?>">
                                                <label for="phone_number">Phone Number</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="country_id">Marrital Status</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <select name="marital_status" class="form-control"
                                                            id="marital_status">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($marital_status)) {
                                                            $selected = "";
                                                            for ($i = 0; $i < count($marital_status); $i++) {
                                                                if (!empty($row)) {
                                                                    if ($row['marital_status'] == $marital_status[$i]['name']) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $marital_status[$i]['name']; ?>">
                                                                    <?php echo ucfirst($marital_status[$i]['name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           value="Next">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="education" class="col s12">
                                    <form id="frmEducation" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="row">
                                            <div class="input-field col s6">

                                                <input id="education_id" name="education_id" type="hidden" value="0">

                                                <input id="name_of_degree" name="name_of_degree" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="name_of_degree">Qualification</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="name_of_center" name="name_of_center" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="name_of_center">Board / Institude / University</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="Medium">Medium</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <select name="medium" class="form-control validate"
                                                            id="medium">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($medium)) {
                                                            $selected = "";
                                                            for ($i = 0; $i < count($medium); $i++) {
                                                                ?>
                                                                <option value="<?php echo $medium[$i]['master_id']; ?>">
                                                                    <?php echo ucfirst($medium[$i]['name']); ?></option>
                                                                <?php
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="passed_on" name="passed_on" type="text" class="validate"
                                                       value="">
                                                <label for="middle_name">Passed Year</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="percentage" name="percentage" type="text" class="validate"
                                                       value="">
                                                <label for="percentage">Percentage</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="passed_class" name="passed_class" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="passed_class">Passed Class</label>
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
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover" id="eduTable">
                                                <thead>
                                                <tr>
                                                    <th>Qualification</th>
                                                    <th>Board / Institude / University</th>
                                                    <th>Paased Year</th>
                                                    <th>Percentage</th>
                                                    <th>Class</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (count($education)) {

                                                    for ($i = 0; $i < count($education); $i++) {

                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td width="200"><?php echo $education[$i]['name_of_degree']; ?></td>
                                                            <td style="width: 355px;"><?php echo $education[$i]['name_of_center']; ?></td>
                                                            <td width="250"><?php echo $education[$i]['passed_on']; ?></td>
                                                            <td width="250"><?php echo $education[$i]['percentage']; ?></td>
                                                            <td width="250"><?php echo $education[$i]['passed_class']; ?></td>
                                                            <td width="180">
                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $education[$i]['education_id']; ?>"
                                                                   class="update"
                                                                   onclick="editEdution('<?php echo $education[$i]['education_id']; ?>');"><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"

                                                                            aria-hidden="true"></i></a>
                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $education[$i]['education_id']; ?>"
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
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_edu_pre">
                                                        Previous
                                                    </a>
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_edu_next">
                                                        Next
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="experiance" class="col s12">
                                    <form id="frmExperiance" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
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
                                                <input id="designation" name="designation" type="text" class="validate"
                                                       value="">
                                                <label for="designation">Designation</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
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
                                                        <!--<option value="0">Other</option>-->
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
                                            <div class="input-field col s1">
                                                <label for="gender">Current Employee</label>
                                            </div>
                                            <div class="input-field col s4">
                                                <div class="form-group">

                                                    <input class="with-gap current_emp" name="current_emp"
                                                           type="radio" id="current_emp_yes"
                                                           value="1"/>
                                                    <label for="current_emp_yes">Yes</label>

                                                    <input class="with-gap current_emp" name="current_emp"
                                                           type="radio" id="current_emp_no"
                                                           value="0"/>
                                                    <label for="current_emp_no">No</label><br/>
                                                    <span id="current_emp_msg"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="start_date" name="start_date" type="text" class="validate"
                                                       value="">
                                                <label for="start_date">Start Date</label>
                                            </div>
                                            <div class="input-field col s6 end_date_div" style="display: none;">
                                                <input id="end_date" name="end_date" type="text" class="validate"
                                                       value="">
                                                <label for="end_date">End Date</label>
                                            </div>
                                        </div>
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
                                                            <td width="250"><?php echo $experiences[$i]['designation']; ?></td>
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
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
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
                                <div id="enlish" class="col s12">
                                    <form id="frmEnglish" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="card-action">English Proficiency</div>

                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s6">
                                                    <label for="applyed_for">Apeared in any english proficiency
                                                        test</label>
                                                </div>
                                                <div class="input-field col s4">
                                                    <div class="form-group">
                                                        <input type="hidden" id="english_id_hidden"
                                                               value="<?php if (!empty($english_test)) {
                                                                   echo $english_test['test_id'];
                                                               } ?>">

                                                        <?php
                                                        $yes = '';
                                                        $no = '';
                                                        if (!empty($english_test)) {
                                                            if ($english_test['applyed_for'] == 1) {
                                                                $yes = 'checked=""';
                                                            }

                                                            if ($english_test['applyed_for'] == 0) {
                                                                $no = 'checked=""';
                                                            }
                                                        }
                                                        ?>

                                                        <input class="with-gap applyed_for"
                                                               name="applyed_for"
                                                               type="radio" id="applyed_for_yes"
                                                               value="1"
                                                            <?php echo $yes; ?>
                                                        />
                                                        <label for="applyed_for_yes">Yes</label>

                                                        <input class="with-gap applyed_for"
                                                               name="applyed_for"
                                                               type="radio" id="applyed_for_no"
                                                               value="0" <?php echo $no; ?> />
                                                        <label for="applyed_for_no">No</label>
                                                        <br/>
                                                        <span id="applyed_for_msg"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row applyed_for_div" style="display: none;">
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="test_type">Exam</label>
                                                </div>
                                                <div class="input-field col s10">

                                                    <select name="test_type" class="form-control validate"
                                                            id="test_type">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($englishExam)) {
                                                            $selected = "";
                                                            for ($c = 0; $c < count($englishExam); $c++) {
                                                                if (!empty($row)) {
                                                                    if ($english_test['test_type'] == $englishExam[$c]['master_id']) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $englishExam[$c]['master_id']; ?>">
                                                                    <?php echo ucfirst($englishExam[$c]['name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row applyed_for_div" style="display: none;">
                                            <div class="input-field col s6">
                                                <input id="listening" name="listening" type="text" class="validate"
                                                       value="<?php if (!empty($english_test)) {
                                                           echo $english_test['listening'];
                                                       } ?>">
                                                <label for="listening">Listening</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="reading" name="reading" type="text" class="validate"
                                                       value="<?php if (!empty($english_test)) {
                                                           echo $english_test['reading'];
                                                       } ?>">
                                                <label for="reading">Reading</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row applyed_for_div" style="display: none;">
                                            <div class="input-field col s6">
                                                <input id="writing" name="writing" type="text" class="validate"
                                                       value="<?php if (!empty($english_test)) {
                                                           echo $english_test['writing'];
                                                       } ?>">
                                                <label for="writing">Writing</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="speaking" name="speaking" type="text" class="validate"
                                                       value="<?php if (!empty($english_test)) {
                                                           echo $english_test['speaking'];
                                                       } ?>">
                                                <label for="speaking">Speaking</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row applyed_for_div" style="display: none;">
                                            <div class="input-field col s6">

                                                <div class="input-field col s2">
                                                    <label for="proficiency_type">Proficiency</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <select name="proficiency_type" class="form-control validate"
                                                            id="proficiency_type">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($proficiency_type)) {
                                                            $selected = "";
                                                            for ($c = 0; $c < count($proficiency_type); $c++) {
                                                                if (!empty($english_test)) {
                                                                    if ($english_test['proficiency_type'] == $proficiency_type[$c]['name']) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $proficiency_type[$c]['name']; ?>">
                                                                    <?php echo ucfirst($proficiency_type[$c]['name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="proficiency_date" name="proficiency_date" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($english_test)) {
                                                           if ($english_test['proficiency_date'] != "1970-01-01" && $english_test['proficiency_date'] != "0000-00-00") {
                                                               echo date("d/m/Y", strtotime($english_test['proficiency_date']));
                                                           }
                                                       } ?>">
                                                <label for="proficiency_date">Exam Date</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_enlish_pre">
                                                        Previous
                                                    </a>
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           name="btn_enlish_next" value="Next">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="relative" class="col s12">
                                    <form id="frmRelaive" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s6">
                                                    <label for="country_id">Do you have relative in Australia ?</label>
                                                </div>
                                                <div class="input-field col s6">
                                                    <div class="form-group">

                                                        <input class="with-gap relative_have_au"
                                                               name="relative_have_au"
                                                               type="radio" id="relative_have_au_yes"
                                                               value="1"/>
                                                        <label for="relative_have_au_yes">Yes</label>

                                                        <input class="with-gap relative_have_au"
                                                               name="relative_have_au"
                                                               type="radio" checked id="relative_have_au_no"
                                                               value="0"/>
                                                        <label for="relative_have_au_no">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div id="relative_in_ausi" style="display: none;">
                                            <div class="row">
                                                <div class="input-field col s6">

                                                    <input id="relation_id" name="relation_id" type="hidden" value="0">

                                                    <input id="relative_first_name" name="relative_first_name"
                                                           type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="relative_first_name">First Name</label>
                                                </div>
                                                <div class="input-field col s6">
                                                    <input id="relative_last_name" name="relative_last_name" type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="relative_last_name">Last Name</label>
                                                </div>
                                                <!--<div class="input-field col s6">
                                                    <input id="relative_middel_name" name="relative_middel_name"
                                                           type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="relative_middel_name">Middel Name</label>
                                                </div>-->
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="row">
                                                <div class="input-field col s6">
                                                    <input id="since" name="since" type="text" class="validate"
                                                           value="">
                                                    <label for="since">Since</label>
                                                </div>
                                                <div class="input-field col s6">
                                                    <input id="ret_postal_code" name="ret_postal_code" type="text"
                                                           class="validate"
                                                           value="">
                                                    <label for="since">Postalcode</label>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="row">
                                                <div class="input-field col s6">
                                                    <div class="input-field col s10">
                                                        <input type="hidden" id="relative_state_hidden" value="0">
                                                        <!--<select name="relative_state_id" class="form-control validate"
                                                                id="relative_state_id"
                                                                onchange="load_relative_city();">
                                                            <option value="">---Select---</option>
                                                            <?php /*if (!empty($relative_state)) {
                                                                $selected = "";
                                                                for ($c = 0; $c < count($relative_state); $c++) {

                                                                    */ ?>
                                                                    <option <?php /*echo $selected; */ ?>
                                                                            value="<?php /*echo $relative_state[$c]['state_id']; */ ?>">
                                                                        <?php /*echo ucfirst($relative_state[$c]['name']); */ ?></option>
                                                                    <?php /*$selected = '';
                                                                }
                                                            } */ ?>
                                                            <option value="0">Other</option>

                                                        </select>-->
                                                        <input id="relative_state_id" name="relative_state_id"
                                                               type="text"
                                                               class="validate"
                                                               value="">
                                                        <label for="since">Subhub name</label>
                                                    </div>
                                                </div>
                                                <div class="input-field col s6">
                                                    <div class="input-field col s2">
                                                        <label for="city_id">City</label>
                                                    </div>
                                                    <div class="input-field col s10">
                                                        <input type="hidden" id="relative_city_hidden" value="0">
                                                        <select name="relative_city_id" class="form-control validate"
                                                                id="relative_city_id"
                                                                onchange="load_relative_city_other();">
                                                            <option value="">---Select---</option>
                                                            <?php if (!empty($relative_state)) {
                                                                $selected = "";
                                                                for ($c = 0; $c < count($relative_state); $c++) {

                                                                    ?>
                                                                    <option <?php echo $selected; ?>
                                                                            value="<?php echo $relative_state[$c]['state_id']; ?>">
                                                                        <?php echo ucfirst($relative_state[$c]['name']); ?></option>
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
                                                    <input id="reta_address1" name="reta_address1" type="text"
                                                           class="validate"
                                                           value="" placeholder="Address Line No 1">
                                                    <input id="reta_address2" name="reta_address2" type="text"
                                                           class="validate"
                                                           value="" placeholder="Address Line No 2">
                                                    <input id="reta_address3" name="reta_address3" type="text"
                                                           class="validate"
                                                           value="" placeholder="Address Line No 3">
                                                </div>

                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="row">

                                                <div class="input-field col s6">
                                                    <div class="input-field col s4">
                                                        <label for="Immigration Status">Immigration Status</label>
                                                    </div>
                                                    <div class="input-field col s8">
                                                        <select name="immigration_status" class="form-control validate"
                                                                id="immigration_status">
                                                            <option value="">---Select---</option>
                                                            <?php if (!empty($immigration_status)) {
                                                                $selected = "";
                                                                for ($i = 0; $i < count($immigration_status); $i++) {

                                                                    ?>
                                                                    <option <?php echo $selected; ?>
                                                                            value="<?php echo $immigration_status[$i]['name']; ?>">
                                                                        <?php echo ucfirst($immigration_status[$i]['name']); ?></option>
                                                                    <?php $selected = '';
                                                                }
                                                            } ?>
                                                        </select>
                                                    </div>
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
                                                <div class="col-lg-3"></div>
                                                <div class="col-lg-9 text-right">
                                                    <div class="form-group">
                                                        <input type="submit" class="waves-effect waves-light btn"
                                                               value="Add">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover"
                                                   id="relativeTable">
                                                <thead>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <th>Since</th>
                                                    <th>Relationship</th>
                                                    <th>State</th>
                                                    <th>City</th>
                                                    <th>Immigration Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (count($relative_data)) {

                                                    for ($i = 0; $i < count($relative_data); $i++) {

                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td width="200"><?php echo ucfirst($relative_data[$i]['first_name']) . " " . ucfirst($relative_data[$i]['middle_name']) . " " . ucfirst($relative_data[$i]['last_name']); ?></td>
                                                            <td width="250"><?php echo $relative_data[$i]['since']; ?></td>
                                                            <td width="250"><?php echo $relative_data[$i]['relationship']; ?></td>
                                                            <td width="250"><?php echo $relative_data[$i]['immigration_state']; ?></td>
                                                            <td width="250"><?php echo $relative_data[$i]['immigration_city']; ?></td>
                                                            <td width="250"><?php echo $relative_data[$i]['immigration_status']; ?></td>
                                                            <td width="180">

                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $relative_data[$i]['relation_id']; ?>"
                                                                   class="update"
                                                                   onclick="editRelative('<?php echo $relative_data[$i]['relation_id']; ?>');"><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a>
                                                                <a href="javascript:void(0);"
                                                                   data-id="<?php echo $relative_data[$i]['relation_id']; ?>"
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
                                <div id="immigration" class="col s12">
                                    <form id="frmImmigration" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="card-action">
                                            Previous Immigration / Visa History
                                        </div>

                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s4">
                                                    <input type="hidden" id="immi_id_hidden"
                                                           value="<?php if (!empty($immigration_arr)) {
                                                               echo $immigration_arr['immigration_id'];
                                                           } else {
                                                               echo "0";
                                                           } ?>">
                                                    <label for="country_id">Visa type applied</label>
                                                </div>
                                                <div class="input-field col s8">
                                                    <div class="form-group">

                                                        <input class="with-gap visa_type_applied"
                                                               name="visa_type_applied"
                                                               type="radio" id="visa_type_yes"
                                                               value="1"/>
                                                        <label for="visa_type_yes">Yes</label>

                                                        <input class="with-gap visa_type_applied"
                                                               name="visa_type_applied"
                                                               type="radio" id="visa_type_no"
                                                               value="0"/>
                                                        <label for="visa_type_no">No</label>
                                                        <br/>
                                                        <span id="visa_type_applied_msg"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-field col s6 visa_div " style="display: none;">

                                                <div class="input-field col s2">
                                                    <label for="country_id">Country</label>
                                                </div>
                                                <div class="input-field col s10">

                                                    <select name="applied_country" class="form-control validate"
                                                            id="applied_country">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($country)) {
                                                            $selected = "";
                                                            for ($c = 0; $c < count($country); $c++) {
                                                                if (!empty($immigration_arr)) {
                                                                    if ($immigration_arr['applied_country'] == $country[$c]['country_id']) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $country[$c]['country_id']; ?>">
                                                                    <?php echo ucfirst($country[$c]['name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                        <!--<option value="0">Other</option>-->
                                                    </select>
                                                    <input type="text" name="other_applied_country"
                                                           id="other_applied_country"
                                                           class="form-control validate"
                                                           placeholder="Other Country name"
                                                           style="margin:15px 0px;display:none;"
                                                           value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6 visa_div" style="display: none;">
                                                <div class="input-field col s4">
                                                    <label for="country_id">Was Visa Granted</label>
                                                </div>
                                                <div class="input-field col s8">
                                                    <div class="form-group">

                                                        <input class="with-gap was_visa_type" name="visa_granted"
                                                               type="radio" id="was_visa_type_yes"
                                                               value="1"/>
                                                        <label for="was_visa_type_yes">Yes</label>

                                                        <input class="with-gap was_visa_type" name="visa_granted"
                                                               type="radio" id="was_visa_type_no"
                                                               value="0"/>
                                                        <label for="was_visa_type_no">No</label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row did_travel" style="display: none;">
                                            <div class="input-field col s6">
                                                <div class="input-field col s4">
                                                    <label for="country_id">Did Travel</label>
                                                </div>
                                                <div class="input-field col s8">
                                                    <div class="form-group">

                                                        <input class="with-gap did_tralrl_rb" name="did_travel"
                                                               type="radio" id="did_travel_yes"
                                                               value="1"/>
                                                        <label for="did_travel_yes">Yes</label>

                                                        <input class="with-gap did_tralrl_rb" name="did_travel"
                                                               type="radio" id="did_travel_no"
                                                               value="0"/>
                                                        <label for="did_travel_no">No</label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="clearfix"></div>
                                        <div class="row travel_date" style="display: none;">
                                            <div class="input-field col s6">
                                                <input id="from_travel" name="from_travel" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($immigration_arr)) {
                                                           if ($immigration_arr['from_date'] != "1970-01-01") {
                                                               echo date("d/m/Y", strtotime($immigration_arr['from_date']));
                                                           }
                                                       } ?>">
                                                <label for="from_travel">From Date</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="to_travel" name="to_travel" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($immigration_arr)) {
                                                           if ($immigration_arr['to_date'] != "1970-01-01") {
                                                               echo date("d/m/Y", strtotime($immigration_arr['to_date']));
                                                           }
                                                       } ?>">
                                                <label for="to_travel">To Date</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="previously_assign_by" name="previously_assign_by" type="text"
                                                       class="validate"
                                                       value="<?php if (!empty($immigration_arr)) {
                                                           echo $immigration_arr['previous_assign'];
                                                       } ?>">
                                                <label for="previously_assign_by">Previously Assign By</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="remark" name="remark" type="text" class="validate"
                                                       value="<?php if (!empty($immigration_arr)) {
                                                           echo $immigration_arr['remark'];
                                                       } ?>">
                                                <label for="remark">Remark</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_immi_pre">
                                                        Previous
                                                    </a>
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           name="btn_immi_next" value="Next">
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div id="interastedin" class="col s12">
                                    <form id="frmInterastedin" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="card-action">Interasted In</div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="country_id">Country</label>
                                                </div>
                                                <div class="input-field col s10">

                                                    <select name="immi_country_id" class="form-control validate"
                                                            id="immi_country_id">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($country)) {
                                                            $selected = "";
                                                            for ($c = 0; $c < count($country); $c++) {
                                                                if (!empty($row)) {
                                                                    if ($row['interasted_country_id'] == $country[$c]['country_id']) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $country[$c]['country_id']; ?>">
                                                                    <?php echo ucfirst($country[$c]['name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                        <!--<option value="0">Other</option>-->
                                                    </select>
                                                    <input type="text" name="other_immi_country" id="other_immi_country"
                                                           class="form-control validate"
                                                           placeholder="Other Country name"
                                                           style="margin:15px 0px;display:none;"
                                                           value="">
                                                </div>
                                            </div>
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="Visa Type">Visa Type</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <select name="visa_type" class="form-control validate"
                                                            id="visa_type">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($visatype)) {
                                                            $selected = "";
                                                            for ($i = 0; $i < count($visatype); $i++) {
                                                                if (!empty($row)) {
                                                                    if ($row['visa_type'] == $visatype[$i]['master_id']) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $visatype[$i]['master_id']; ?>">
                                                                    <?php echo ucfirst($visatype[$i]['name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn"
                                                       id="btn_interastedin_pre">
                                                        Previous
                                                    </a>
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           name="btn_interastedin_next" value="Next">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="reference" class="col s12">
                                    <form id="frmReference" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="card-action">Reference By</div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <div class="input-field col s2">
                                                    <label for="reference_by">Reference By</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <select name="reference_by" class="form-control validate"
                                                            id="reference_by">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($reference)) {
                                                            $selected = "";
                                                            for ($c = 0; $c < count($reference); $c++) {
                                                                if (!empty($row)) {
                                                                    if ($row['reference_by'] == $reference[$c]['ref_id']) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $reference[$c]['ref_id']; ?>">
                                                                    <?php echo ucfirst($reference[$c]['ref_name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                        <option value="0">Sub Agent</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="input-field col s6 sub_agent_by" style="display: none;">
                                                <div class="input-field col s2">
                                                    <label for="Sub Agent">Sub Agent</label>
                                                </div>
                                                <div class="input-field col s10">
                                                    <select name="sub_agent_by" class="form-control validate"
                                                            id="sub_agent_by">
                                                        <option value="">---Select---</option>
                                                        <?php if (!empty($sub_agent)) {
                                                            $selected = "";
                                                            for ($i = 0; $i < count($sub_agent); $i++) {
                                                                if (!empty($row)) {
                                                                    if ($row['sub_agent_by'] == $sub_agent[$i]['ref_id']) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?>
                                                                        value="<?php echo $sub_agent[$i]['ref_id']; ?>">
                                                                    <?php echo ucfirst($sub_agent[$i]['ref_name']); ?></option>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9 text-right">
                                                <div class="form-group">
                                                    <input type="submit" class="waves-effect waves-light btn"
                                                           name="btn_reference_save" id="btn_reference_save"
                                                           value="Save">
                                                    <a href="javascript:void(0);" id="reg_ref_save"
                                                       style="display: none;">Save</a>
                                                    <?php if ($reg_id == 0): ?>
                                                        <a class="waves-effect waves-light btn reg_btn_pop">Contunue To
                                                            Register</a>
                                                        <a href="#_followup" data-toggle="modal"
                                                           class="waves-effect waves-light btn">Add Follow Up</a>
                                                    <?php endif; ?>
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
                                               echo date("d/m/Y H:i", strtotime($follow_up_data['date_of_follow']));
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

    <!--Registration form-->
    <button type="button" data-backdrop="static" data-keyboard="false" class="btn btn-info btn-lg" id="btn_reg_clk"
            data-toggle="modal" data-target="#reg_passport"
            style="display: none;">Open Modal
    </button>
    <!-- Modal -->
    <div id="reg_passport" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form id="reg_form" method="post">
                <input id="passport_id" name="passport_id" type="hidden" value="0">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Passport Details</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="input-field col s6">
                                <input id="passport_number" name="passport_number" type="text"
                                       class="validate"
                                       value="">
                                <label for="passport_number">Passport Number</label>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="passport_issue_date" name="passport_issue_date" type="text" class="validate"
                                       value="">
                                <label for="passport_issue_date">Passport Issue Date</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="passport_expire_date" name="passport_expire_date" type="text"
                                       class="validate"
                                       value="">
                                <label for="passport_expire_date">Passport Expiry Date</label>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-default" name="btn_reg_btn" value="Next">
                        <button type="button" class="btn btn-default" id="btn_reg_btn_close" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--Second Form -->

    <button type="button" class="btn btn-info btn-lg" id="btn_second_clk" data-toggle="modal"
            data-target="#reg_payment_stage"
            style="display: none;">Open Modal
    </button>
    <!-- Modal -->
    <div id="reg_payment_stage" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form id="pay_stage_form" method="post">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Estimate of Fees</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <input id="stage_id" name="stage_id" type="hidden" value="0">
                            <div class="input-field col s12">
                                <div class="add-payment-stage">
                                    <?php
                                    if (!empty($PaymentStage)) {

                                        for ($i = 0; $i < count($PaymentStage); $i++) {
                                            ?>
                                            <div class="input-field col s6">
                                                <input id="master_id" name="master_id[]" type="hidden"
                                                       value="<?php echo $PaymentStage[$i]['master_id']; ?>">
                                                <input id="paymentFees" name="paymentFees[]" type="text"
                                                       class="validate"
                                                       value="">
                                                <label for="<?php echo $PaymentStage[$i]['name']; ?>"><?php echo $PaymentStage[$i]['name']; ?></label>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <span id="fees-msg"></span>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default" name="btn_paystage_btn">Register</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
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
            format: "dd/mm/yyyy",
            minView: 2
        });

        $('#to_travel').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        $('#passport_issue_date').datetimepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            minView: 2
        });

        $('#passport_expire_date').datetimepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            minView: 2
        });

        $('#proficiency_date').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        $('#date_of_follow').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy"
        });

        $('.fetchAppData').on('keyup keypress blur change', function (e) {

            var email_mobile_data = $(this).val();

            $("#first_name").val("");
            $("#phone_number").val("");

            if (email_mobile_data != "") {

                $.ajax({
                    type: "POST",
                    url: base_url + "get_app_details?email_mobile_data=" + email_mobile_data,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {
                            $("#first_name").val(response.name);

                            if ($("#email_address").val() == "") {
                                $("#email_address").val(response.email_address);
                            }
                            if ($("#mobile_number").val() == "") {
                                $("#mobile_number").val(response.mobile_no1);
                            }
                            $("#phone_number").val(response.mobile_no2);
                        }
                    }
                });
            }
        });

        /*format: "dd-mm-yyyy hh:ii"*/
        /*Personal detail added in database using ajax call*/
        $("#frmPersonal").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                email_address: {
                    required: true,
                },
                first_name: "required",
                date_of_birth: "required",
                date_of_inquiry: "required",
                /*address1: "required",*/
                country_id: "required",
                state_id: "required",
                city_id: "required",
            },
            messages: {
                email_address: {
                    required: "Please enter email address",
                    /*remote: 'Your email is registered yet. Please enter another email'*/
                },
                first_name: "Please enter your first name",
                date_of_birth: "Please enter your birthdat",
                date_of_inquiry: "Please enter your inquiry date",
                /*address1: "Please enter address",*/
                country_id: "Please select your country",
                state_id: "Please select state",
                city_id: "Please select city",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_personal_data",
                    data: $("#frmPersonal").serialize(),
                    dataType: "json",
                    success: function (response) {

                        if (response.status == true) {

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {

                                $(".tabs li").removeClass("disabled");
                                $("#tab_education").click();

                                $("#login_id").val(response.id);

                                $('html, body').animate({scrollTop: 0}, 1000);
                                return false;

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

        /*Education detail added in database using ajax call*/
        $("#frmEducation").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                name_of_degree: "required",
                name_of_center: "required",
                medium: "required",
                passed_on: "required",
                percentage: "required",
                passed_class: "required",
            },
            messages: {
                name_of_degree: "Please enter your degree name",
                name_of_center: "Please enter your center name",
                medium: "Please enter your exam medium",
                passed_on: "Please enter your passed year",
                percentage: "Please enter your percentage",
                passed_class: "Please enter your passed class",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {
                var inquiry_id = $("#login_id").val();
                var education_id = $("#education_id").val();
                $.ajax({
                    type: "POST",
                    url: base_url + "submit_education_data?inquiry_id=" + inquiry_id,
                    data: $("#frmEducation").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            $('#frmEducation .validate').val('');

                            var t = $('#eduTable').DataTable();

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {

                                if (education_id != "" && education_id > 0) {
                                    $('#eduTable').dataTable().fnClearTable();

                                    var clk = "return confirm('Are you sure want to delete?')";

                                    for (var i = 0; i < response.data.length; i++) {

                                        var link = '<a href="javascript:void(0);" data-id="' + response.data[i].education_id + '" class="update" onclick="editEdution(' + response.data[i].education_id + ');" ><i\n' +
                                            '                                                                            style="padding: 0px;font-size: 20px;"\n' +
                                            '                                                                            class="fa fa-pencil-square-o"\n' +
                                            '\n' + 'aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' + response.data[i].education_id + '" class="remove"><i\n' + 'style="padding: 5px;font-size: 20px;" class="fa fa-times"\n' +
                                            ' aria-hidden="true"></i></a>';

                                        t.row.add([
                                            response.data[i].name_of_degree,
                                            response.data[i].name_of_center,
                                            response.data[i].passed_on,
                                            response.data[i].percentage,
                                            response.data[i].passed_class,
                                            link
                                        ]).draw(false);
                                    }
                                    $("#education_id").val('0');
                                } else {
                                    t.row.add([
                                        response.name_of_degree,
                                        response.name_of_center,
                                        response.passed_on,
                                        response.percentage,
                                        response.passed_class,
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

        $('#frmEducation').on('click', 'a.remove', function (e) {

            if (confirm('Are you sure want to delete?') == false) {
                return false;
            }

            var table = $('#eduTable').DataTable();
            table.row($(this).closest('tr')).remove().draw(false);

            var id = $(this).attr('data-id');


            $.ajax({
                type: "POST",
                url: base_url + "delete_education_data?education_id=" + id,
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

        $('#frmExperiance').on('change', '.current_emp', function (e) {

            var emp = $(this).val();
            $(".end_date_div").show();
            $("#end_date").val("");

            if (emp == 1) {
                $(".end_date_div").hide();
                $("#end_date").val("12-12-2012");
            }
        });

        $('#frmImmigration').on('change', '.visa_type_applied', function (e) {

            var visa = $(this).val();
            $(".visa_div").hide();
            $(".did_travel").hide();
            $(".travel_date").hide();

            $("#was_visa_type_no").prop('checked', true);
            $("#did_travel_no").prop('checked', true);

            if (visa == 1) {
                $(".visa_div").show();
            }
        });

        $('#frmImmigration').on('change', '.was_visa_type', function (e) {

            var visa_grant = $(this).val();
            $(".did_travel").hide();
            $(".travel_date").hide();

            if (visa_grant == 1) {
                $(".did_travel").show();
            }
        });

        $('#frmImmigration').on('change', '.did_tralrl_rb', function (e) {

            var did_travel = $(this).val();
            $(".travel_date").hide();

            if (did_travel == 1) {
                $(".travel_date").show();
            }
        });

        $('#frmInterastedin').on('change', '#immi_country_id', function (e) {

            var immi_country_id = $(this).val();
            $("#other_immi_country").hide();

            if (immi_country_id == 0 && immi_country_id != "") {
                $("#other_immi_country").show();
                $("#other_immi_country").val('');
            } else {
                $("#other_immi_country").val('other');
            }
        });

        $('#frmImmigration').on('click', '#btn_con_no', function (e) {
            $("#passport_number").focus();
            $(".modal-header .close").click();
        });

        $('#frmImmigration').on('click', '#btn_con_yes', function (e) {

            var inquiry_id = $("#login_id").val();
            var immi_id = $("#immi_id_hidden").val();

            $.ajax({
                type: "POST",
                url: base_url + "submit_immigration_data?inquiry_id=" + inquiry_id + "&immi_id=" + immi_id,
                data: $("#frmImmigration").serialize(),
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status == true) {

                        $('#immi_id_hidden').val(response.id);
                        $(".modal-header .close").click();
                        $("#tab_interastedin").click();

                    } else if (response.status == false) {
                        alert("Something went wrong...!");
                        return false;
                    }
                }
            });

        });

        /*Immigration detail added in database using ajax call*/
        $("#frmImmigration").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                visa_type_applied: "required",
            },
            messages: {
                visa_type_applied: "Please select visa type applied",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "visa_type_applied") {
                    error.insertAfter("#visa_type_applied_msg");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {

                var inquiry_id = $("#login_id").val();
                var immi_id = $("#immi_id_hidden").val();
                var passport_number = $("#passport_number").val()

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_immigration_data?inquiry_id=" + inquiry_id + "&immi_id=" + immi_id,
                    data: $("#frmImmigration").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {

                                $('#immi_id_hidden').val(response.id);
                                $("#tab_interastedin").click();
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

        /*Experiance detail added in database using ajax call*/
        $("#frmExperiance").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                name_of_cmp: "required",
                designation: "required",
                business_name: "required",
                /*exp_address1: "required",*/
                expr_country_id: "required",
                state_expr_id: "required",
                city_expr_id: "required",
                pincode_number: "required",
                current_emp: "required",
                start_date: "required",
                end_date: "required"
            },
            messages: {
                name_of_cmp: "Please enter your employee name",
                designation: "Please enter your designation",
                business_name: "Please select your business",
                /*exp_address1: "Please enter your address",*/
                expr_country_id: "Please select country",
                state_expr_id: "Please select state",
                city_expr_id: "Please select city",
                pincode_number: "Please enter your postalcode",
                current_emp: "Please select current employee or not",
                start_date: "Please enter your start date",
                end_date: "Please enter your end date"
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
                    url: base_url + "submit_experience_data?inquiry_id=" + inquiry_id,
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

        $("#frmRelaive").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                relative_first_name: "required",
                relative_middel_name: "required",
                relative_last_name: "required",
                relative_state_id: "required",
                since: {
                    required: true,
                    number: true
                },
                immigration_status: "required",
                relationship: "required"

            },
            messages: {
                relative_first_name: "Please enter your first name",
                relative_middel_name: "Please enter your middel name",
                relative_last_name: "Please enter your last name",
                relative_state_id: "Please select subhub",
                since: {
                    required: "Please enter since",
                    number: "Enter only number"
                },
                immigration_status: "Please select immigration status",
                relationship: "Please select relationship"
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {
                var inquiry_id = $("#login_id").val();
                var relation_id = $("#relation_id").val();
                $.ajax({
                    type: "POST",
                    url: base_url + "submit_relative_data?inquiry_id=" + inquiry_id,
                    data: $("#frmRelaive").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            $("#other_relative_state").hide();
                            $("#other_relative_city").hide();

                            $("#relative_have_au_yes").prop('checked', false);
                            $("#relative_have_au_no").prop('checked', true);
                            $("#relative_in_ausi").hide();

                            $('#frmRelaive .validate').val('');

                            var t = $('#relativeTable').DataTable();

                            var tab_name = $("#tab_name").val();

                            if (tab_name == "tab") {

                                if (relation_id != "" && relation_id > 0) {

                                    $('#relativeTable').dataTable().fnClearTable();

                                    var clk = "return confirm('Are you sure want to delete?');";

                                    for (var i = 0; i < response.data.length; i++) {

                                        var link = '<a href="javascript:void(0);" data-id="' + response.data[i].relation_id + '" class="update" onclick="editRelative(' + response.data[i].relation_id + ');" ><i\n style="padding: 0px;font-size: 20px;"\n class="fa fa-pencil-square-o"\n aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' + response.data[i].relation_id + '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';

                                        t.row.add([
                                            response.data[i].full_name_,
                                            response.data[i].since,
                                            response.data[i].relationship,
                                            response.data[i].immigration_state,
                                            response.data[i].relative_city,
                                            response.data[i].immigration_status,
                                            link
                                        ]).draw(false);
                                    }

                                } else {
                                    t.row.add([
                                        response.full_name,
                                        response.since,
                                        response.relationship,
                                        response.immigration_state,
                                        response.relative_city,
                                        response.immigration_status,
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
                url: base_url + "delete_relative_data?relative_id=" + id,
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
                                    window.location.href = "<?php echo HTTP_SERVER; ?>clientsmanager";
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

                            $.ajax({
                                type: "POST",
                                url: base_url + "get_paymnet_stages?inquiry_id=" + inquiry_id,
                                data: $("#reg_form").serialize(),
                                dataType: "json",
                                success: function (response) {
                                    console.log(response);
                                    if (response.status == true) {

                                        if (response.data.length > 0) {

                                            var strData = "";
                                            $(".add-payment-stage").html("");
                                            for (var i = 0; i < response.data.length; i++) {
                                                strData += '<div class="input-field col s6">\n' +
                                                    '                                                <input id="master_id" name="master_id[]" type="hidden"\n' +
                                                    '                                                       value="' + response.data[i].master_id + '">\n' +
                                                    '                                                <input id="paymentFees" name="paymentFees[]" type="text"\n' +
                                                    '                                                       class="validate"\n' +
                                                    '                                                       value="">\n' +
                                                    '                                                <label for="' + response.data[i].name + '">' + response.data[i].name + '</label></div>';
                                            }
                                        }
                                        $(".add-payment-stage").html(strData);
                                        $("#btn_second_clk").click();
                                    } else if (response.status == false) {
                                        alert("Something went wrong...!");
                                        return false;
                                    }
                                }
                            });

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
                "paymentFees[]": "required",
            },
            messages: {
                "paymentFees[]": "Please enter estimate fees",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            errorPlacement: function (error, element) {

                if (element.attr("name") == "paymentFees[]") {
                    error.insertAfter("#fees-msg");
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
                            window.location.href = "<?php echo HTTP_SERVER; ?>clientsmanager";

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
                var reference_by = "";
                var sub_agent_by = "";


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

        $('#frmFollowup').on('click', '#btn_no_follow', function (e) {
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
        });

        $('#frmEducation').on('click', '#btn_edu_pre', function (e) {
            $("#tab_personal").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmEducation').on('click', '#btn_edu_next', function (e) {
            $("#tab_experiance").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmExperiance').on('click', '#btn_exper_pre', function (e) {
            $("#tab_education").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmExperiance').on('click', '#btn_exper_next', function (e) {
            $("#tab_enlish").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmEnglish').on('click', '#btn_enlish_pre', function (e) {
            $("#tab_experiance").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmRelaive').on('click', '#btn_relative_pre', function (e) {
            $("#tab_enlish").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmRelaive').on('change', '.relative_have_au', function (e) {

            var relative_have_au = $(this).val();
            $("#relative_in_ausi").hide();

            if (relative_have_au == 1) {
                $("#relative_in_ausi").show();
            }
        });

        $('#frmRelaive').on('click', '#btn_relative_next', function (e) {
            $("#tab_immigration").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmImmigration').on('click', '#btn_immi_pre', function (e) {
            $("#tab_relative").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#frmInterastedin').on('click', '#btn_interastedin_pre', function (e) {
            $("#tab_immigration").click();
            $('html, body').animate({scrollTop: 0}, 1000);
        });

        $('#ret_postal_code').on('keyup keypress blur change', function (e) {
            var ret_postal_code = $(this).val();
            $("#relative_state_id").val("");

            if (ret_postal_code > 0) {

                $.ajax({
                    type: "POST",
                    url: base_url + "get_suburs_postalcode?ret_postal_code=" + ret_postal_code,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {
                            $("#relative_state_id").val(response.relative_state_name);
                        }
                    }
                });
            }
        });
    });

    function editEdution(id) {

        $("#education_id").val(id);

        $.ajax({
            type: "POST",
            url: base_url + "get_education_data?education_id=" + id,
            dataType: "json",
            success: function (response) {

                if (response.status == true) {

                    $("#name_of_degree").val(response.name_of_degree);
                    $("#name_of_center").val(response.name_of_center);
                    $("#medium").val(response.medium);
                    $("#passed_on").val(response.passed_on);
                    $("#percentage").val(response.percentage);
                    $("#passed_class").val(response.passed_class);
                    $('html, body').animate({scrollTop: 0}, 1000);

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

                    $(".end_date_div").show();

                    if (response.current_emp == 1) {
                        $(".end_date_div").hide();
                        $("#current_emp_yes").prop('checked', true);
                    } else {
                        $(".end_date_div").show();
                        $("#current_emp_no").prop('checked', true);
                    }

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
                    $('html, body').animate({scrollTop: 0}, 1000);

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
            url: base_url + "get_relative_data?relation_id=" + id,
            dataType: "json",
            success: function (response) {

                $("#other_relative_city").hide();

                $("#relative_have_au_yes").prop('checked', true);
                $("#relative_have_au_no").prop('checked', false);
                $("#relative_in_ausi").show();

                if (response.status == true) {

                    $("#relative_state_id").val(response.immigration_state);
                    $("#relative_city_id").val(response.immigration_city);
                    //load_relative_state(response.immigration_state);


                    $("#relative_first_name").val(response.relative_first_name);
                    $("#relative_middel_name").val(response.relative_middel_name);
                    $("#relative_last_name").val(response.relative_last_name);
                    $("#reta_address1").val(response.reta_address1);
                    $("#reta_address2").val(response.reta_address2);
                    $("#reta_address3").val(response.reta_address3);
                    $("#ret_postal_code").val(response.postalcode);
                    $("#since").val(response.since);
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
        load_state();
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