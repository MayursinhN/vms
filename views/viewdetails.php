<?php include_once '../include/header.php'; ?>
<?php

$row = array();
$education = array();
$experiences = array();
$immigration_arr = array();
$english_test = array();
$relative_data = array();

$loginid = $objsession->get("log_admin_loginid");
$inquiry_id = 0;
$reg_id = 0;

if (isset($_GET['inquiry_id'])) {
    $cond = '';
    $inquiry_id = $_GET['inquiry_id'];
    $cond = "inquiry_id=:inquiry_id";
    $params = array(":inquiry_id" => $inquiry_id);
    $row = $obj->fetchRow('inquiry_list', $cond, $params);

    $cond_ = "state_id=:state_id";
    $params_ = array(":state_id" => $row['state_id']);

    $state = $obj->fetchRow('states', $cond_, $params_);


    $cond_ = "city_id=:city_id";
    $params_ = array(":city_id" => $row['city_id']);
    $city = $obj->fetchRow('cities', $cond_, $params_);

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

            $cond = "state_id=:state_id";
            $params = array(":state_id" => $relative_data[$i]['immigration_state']);
            $states = $obj->fetchRow('states', $cond, $params);
            $relative_data[$i]['immigration_state'] = $states['name'];

            $cond = "city_id=:city_id";
            $params = array(":city_id" => $relative_data[$i]['immigration_city']);
            $cities = $obj->fetchRow('cities', $cond, $params);
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

$cond = "category_name =:category_name";
$params = array(":category_name" => 'Marital Status');
$marital_status = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name";
$params = array(":category_name" => 'Business');
$businessType = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name";
$params = array(":category_name" => 'Visa Type');
$visatype = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name";
$params = array(":category_name" => 'Immigration');
$immigration_status = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name";
$params = array(":category_name" => 'Relationship');
$relationship = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name";
$params = array(":category_name" => 'Exam');
$englishExam = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name";
$params = array(":category_name" => 'Reference');
$reference = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name";
$params = array(":category_name" => 'Subagent');
$sub_agent = $obj->fetchRowAll('masters_list', $cond, $params);

?>
<style type="text/css">
    .fa {
        padding: 0px !important;
    }

    .row .col.s3 {
        width: 12%;
    }

    .tabs .tab a {
        font-size: 12px;
    }
</style>
<div class="header">
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li><a href="<?php echo HTTP_SERVER; ?>registrationmanager">View Registered User</a></li>
        <li class="active">Details</li>
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
                                <ul class="tabs">
                                    <li class="tab col s3"><a class="active" id="tab_personal"
                                                              href="#personal">Personal</a>
                                    </li>
                                    <li class="tab col s3 "><a id="tab_education"
                                                                       href="#education">Education</a>
                                    </li>
                                    <li class="tab col s3 "><a id="tab_experiance"
                                                                       href="#experiance">Work Experiance</a>
                                    </li>
                                    <li class="tab col s3 "><a id="tab_enlish" href="#enlish">English
                                            Proficiency</a></li>
                                    <li class="tab col s3 "><a id="tab_relative" href="#relative">Relative in
                                            Australian</a></li>
                                    <li class="tab col s3 "><a id="tab_immigration" href="#immigration">Immigration
                                            Hisory</a>
                                    </li>
                                    <li class="tab col s3 "><a id="tab_interastedin" href="#interastedin">Interasted
                                            In</a>
                                    </li>
                                    <li class="tab col s3 "><a id="tab_reference"
                                                                       href="#reference">Reference</a>
                                    </li>
                                </ul>
                                <div class="clearBoth"><br/></div>
                                <div id="personal" class="col s12">
                                    <form id="frmPersonal" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
                                        <div class="row">
                                            <div class="col s2">
                                                <label for="first_name">First Name</label>
                                            </div>
                                            <div class=" col s3">
                                                <?php if (!empty($row)) {
                                                    echo $row['first_name'];
                                                } ?>
                                            </div>

                                            <div class=" col s2">
                                                <label for="first_name"> Middel Name</label>
                                            </div>
                                            <div class=" col s3"><?php if (!empty($row)) {
                                                    echo $row['middle_name'];
                                                } ?></div>
                                            <div class=" col s2">
                                                <label for="first_name">Last Name</label>
                                            </div>
                                            <div class=" col s3"><?php if (!empty($row)) {
                                                    echo $row['last_name'];
                                                } ?></div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="input-field col s2">
                                                <label for="gender">Gender</label>
                                            </div>
                                            <div class="input-field col s4">
                                                <div class="form-group">
                                                    <?php

                                                    if (!empty($row)) {
                                                        if ($row['gender'] == "Female") {
                                                            echo "Female";
                                                        }

                                                        if ($row['gender'] == "Male") {
                                                            echo "Male";
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">

                                            <div class="col s2">
                                                <label for="gender">Inquiry Date</label>
                                            </div>
                                            <div class="col s4">
                                                <?php if (!empty($row)) {
                                                    echo date("d-m-Y H:i", strtotime($row['inquiry_date']));
                                                } ?>
                                            </div>

                                            <div class="col s2">
                                                <label for="gender">Date of Birth</label>
                                            </div>
                                            <div class="col s4">
                                                <?php if (!empty($row)) {
                                                    echo date("d-m-Y", strtotime($row['date_of_birth']));
                                                } ?>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">

                                            <div class="col s2">
                                                <label for="gender">Place of Birth</label>
                                            </div>
                                            <div class="col s4">
                                                <?php if (!empty($row)) {
                                                    echo $row['place_of_birth'];
                                                } ?>
                                            </div>
                                            <div class="col s2">
                                                <label for="gender">Address</label>
                                            </div>
                                            <div class="col s4">
                                                <?php if (!empty($row)) {
                                                    echo $row['address'];
                                                } ?>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="row">
                                            <div class="col s2">
                                                <label for="gender">Country</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($country)) {
                                                    $selected = "";
                                                    for ($c = 0; $c < count($country); $c++) {
                                                        if (!empty($row)) {
                                                            if ($row['country_id'] == $country[$c]['country_id']) {

                                                                ?>
                                                                <?php echo ucfirst($country[$c]['name']); ?>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                } ?>
                                            </div>
                                            <div class="col s2">
                                                <label for="gender">State</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($state)) {
                                                    echo $state['name'];
                                                } ?>
                                            </div>
                                            <div class="col s2">
                                                <label for="gender">City</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($city)) {
                                                    echo $city['name'];
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">

                                            <div class="col s2">
                                                <label for="gender">Postalcode</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($row)) {
                                                    echo $row['postalcode'];
                                                } ?>
                                            </div>

                                            <div class="col s2">
                                                <label for="gender">Email</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($row)) {
                                                    echo $row['email_address'];
                                                } ?>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="row">

                                            <div class="col s2">
                                                <label for="gender">Mobile Number</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($row)) {
                                                    echo $row['mobile_number'];
                                                } ?>
                                            </div>
                                            <div class="col s2">
                                                <label for="gender">Phone Number</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($row)) {
                                                    echo $row['phone_number'];
                                                } ?>
                                            </div>

                                            <div class="col s2">
                                                <label for="gender">Marrital Status</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($marital_status)) {
                                                    $selected = "";
                                                    for ($i = 0; $i < count($marital_status); $i++) {
                                                        if (!empty($row)) {
                                                            if ($row['marital_status'] == $marital_status[$i]['name']) {
                                                                $selected = 'selected="selected"';

                                                                ?>
                                                                <?php echo ucfirst($marital_status[$i]['name']); ?>
                                                                <?php $selected = '';
                                                            }
                                                        }
                                                    }
                                                } ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="education" class="col s12">
                                    <form id="frmEducation" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">

                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover" id="eduTable">
                                                <thead>
                                                <tr>
                                                    <th>Name of Degree</th>
                                                    <th>Name of Center</th>
                                                    <th>Paased Year</th>
                                                    <th>Percentage</th>
                                                    <th>Class</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (count($education)) {

                                                    for ($i = 0; $i < count($education); $i++) {

                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td width="200"><?php echo $education[$i]['name_of_degree']; ?></td>
                                                            <td width="250"><?php echo $education[$i]['name_of_center']; ?></td>
                                                            <td width="250"><?php echo $education[$i]['passed_on']; ?></td>
                                                            <td width="250"><?php echo $education[$i]['percentage']; ?></td>
                                                            <td width="250"><?php echo $education[$i]['passed_class']; ?></td>
                                                        </tr>

                                                    <?php }
                                                } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div id="experiance" class="col s12">
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
                                                        </tr>

                                                    <?php }
                                                } ?>

                                                </tbody>
                                            </table>
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
                                                        <label for="applyed_for_yesx">Yes</label>

                                                        <input class="with-gap applyed_for"
                                                               name="applyed_for"
                                                               type="radio" id="applyed_for_no"
                                                               value="0" <?php echo $no; ?> />
                                                        <label for="applyed_for_nox">No</label>
                                                        <br/>
                                                        <span id="applyed_for_msg"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row applyed_for_div" style="display: none;">
                                            <div class="col s6">
                                                <div class="col s2">
                                                    <label for="test_type">Exam</label>
                                                </div>
                                                <div class="col s10">
                                                        <?php if (!empty($englishExam)) {
                                                            $selected = "";
                                                            for ($c = 0; $c < count($englishExam); $c++) {
                                                                if (!empty($row)) {
                                                                    if ($english_test['test_type'] == $englishExam[$c]['master_id']) {
                                                                        $selected = 'selected="selected"';

                                                                ?>
                                                                    <?php echo ucfirst($englishExam[$c]['category_name']); ?>
                                                                <?php
                                                                    }
                                                                }
                                                            }
                                                        } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row applyed_for_div" style="display: none;">

                                            <div class="col s2">
                                                <label for="listening">Listening</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($english_test)) {
                                                    echo $english_test['listening'];
                                                } ?>
                                            </div>
                                            <div class="col s2">
                                                <label for="listening">Reading</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($english_test)) {
                                                    echo $english_test['reading'];
                                                } ?>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row applyed_for_div" style="display: none;">

                                            <div class="col s2">
                                                <label for="listening">Writing</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($english_test)) {
                                                    echo $english_test['writing'];
                                                } ?>
                                            </div>

                                            <div class="col s2">
                                                <label for="listening">Speaking</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($english_test)) {
                                                    echo $english_test['speaking'];
                                                } ?>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row applyed_for_div" style="display: none;">


                                            <div class="col s2">
                                                <label for="listening">Proficiency Date</label>
                                            </div>
                                            <div class="col s3">
                                                <?php if (!empty($english_test)) {
                                                    echo date("d-m-Y",strtotime($english_test['proficiency_date']));
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                                <div id="relative" class="col s12">
                                    <form id="frmRelaive" class="wizard clearfix fv-form fv-form-bootstrap"
                                          method="post">
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
                                                        </tr>

                                                    <?php }
                                                } ?>

                                                </tbody>
                                            </table>
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

                                                        <input class="with-gap Visa type applie"
                                                               name="visa_type_applied"
                                                               type="radio" id="visa_type_yes"
                                                               value="1"/>
                                                        <label for="visa_type_yes1">Yes</label>

                                                        <input class="with-gap visa_type_applied"
                                                               name="visa_type_applied"
                                                               type="radio" id="visa_type_no"
                                                               value="0"/>
                                                        <label for="visa_type_no1">No</label>
                                                        <br/>
                                                        <span id="visa_type_applied_msg"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s6 visa_div " style="display: none;">
                                                <div class="col s2">
                                                    <label for="listening">Country</label>
                                                </div>
                                                <div class="col s3">
                                                    <?php if (!empty($immigration_arr)) {
                                                        echo $immigration_arr['applied_country'];
                                                    } ?>
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
                                                        <label for="was_visa_type_yes11">Yes</label>

                                                        <input class="with-gap was_visa_type" name="visa_granted"
                                                               type="radio" id="was_visa_type_no1"
                                                               value="0"/>
                                                        <label for="was_visa_type_no11">No</label>

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
                                                               type="radio" id="did_travel_yes1"
                                                               value="1"/>
                                                        <label for="did_travel_yes01">Yes</label>

                                                        <input class="with-gap did_tralrl_rb" name="did_travel"
                                                               type="radio" id="did_travel_no01"
                                                               value="0"/>
                                                        <label for="did_travel_no1">No</label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="clearfix"></div>
                                        <div class="row travel_date" style="display: none;">
                                            <div class="col s12">

                                                <div class="col s3">
                                                    <label for="listening">From Date</label>
                                                </div>
                                                <div class="col s4">
                                                    <?php if (!empty($immigration_arr)) {
                                                        if ($immigration_arr['from_date'] != "1970-01-01") {
                                                            echo date("d-m-Y", strtotime($immigration_arr['from_date']));
                                                        }
                                                    } ?>
                                                </div>

                                                <div class="col s3">
                                                    <label for="listening">To Date</label>
                                                </div>
                                                <div class="col s4">
                                                    <?php if (!empty($immigration_arr)) {
                                                        if ($immigration_arr['to_date'] != "1970-01-01") {
                                                            echo date("d-m-Y", strtotime($immigration_arr['to_date']));
                                                        }
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col s12">

                                                <div class="col s4">
                                                    <label for="listening">Previously Assign By</label>
                                                </div>
                                                <div class="col s3">
                                                    <?php if (!empty($immigration_arr)) {
                                                        echo $immigration_arr['previous_assign'];
                                                    } ?>
                                                </div>
                                                <div class="col s2">
                                                    <label for="listening">Remark</label>
                                                </div>
                                                <div class="col s4">
                                                    <?php if (!empty($immigration_arr)) {
                                                        echo $immigration_arr['remark'];
                                                    } ?>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col s6">

                                                <div class="col s4">
                                                    <label for="listening">Passport Number</label>
                                                </div>
                                                <div class="col s3">
                                                    <?php if (!empty($immigration_arr)) {
                                                        echo $immigration_arr['passport_number'];
                                                    } ?>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col s12">

                                                <div class="col s4">
                                                    <label for="listening">Passport Issue Date</label>
                                                </div>
                                                <div class="col s3">
                                                    <?php if (!empty($immigration_arr)) {
                                                        if ($immigration_arr['passport_expir_date'] != "1970-01-01") {
                                                            echo date("d-m-Y", strtotime($immigration_arr['passport_expir_date']));
                                                        }
                                                    } ?>
                                                </div>

                                                <div class="col s4">
                                                    <label for="listening">Passport Expiry Date</label>
                                                </div>
                                                <div class="col s3">
                                                    <?php if (!empty($immigration_arr)) {
                                                        if ($immigration_arr['passport_issue_date'] != "1970-01-01") {
                                                            echo date("d-m-Y", strtotime($immigration_arr['passport_issue_date']));
                                                        }
                                                    } ?>
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
                                            <div class="col s6">
                                                <div class="col s2">
                                                    <label for="country_id">Country</label>
                                                </div>
                                                <div class="col s10">


                                                        <?php if (!empty($country)) {
                                                            $selected = "";
                                                            for ($c = 0; $c < count($country); $c++) {
                                                                if (!empty($row)) {
                                                                    if ($row['interasted_country_id'] == $country[$c]['country_id']) {
                                                                        $selected = 'selected="selected"';

                                                                ?>

                                                                    <?php echo ucfirst($country[$c]['name']); ?>
                                                                <?php $selected = '';
                                                                    }
                                                                }
                                                            }
                                                        } ?>
                                                </div>
                                            </div>
                                            <div class="col s6">
                                                <div class="col s2">
                                                    <label for="Visa Type">Visa Type</label>
                                                </div>
                                                <div class="col s10">

                                                        <?php if (!empty($visatype)) {
                                                            $selected = "";
                                                            for ($i = 0; $i < count($visatype); $i++) {
                                                                if (!empty($row)) {
                                                                    if ($row['visa_type'] == $visatype[$i]['name']) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                    <?php echo ucfirst($visatype[$i]['name']); ?>
                                                                <?php $selected = '';
                                                            }
                                                        } ?>
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
                                            <div class="col s6">
                                                <div class="col s4">
                                                    <label for="reference_by">Reference By</label>
                                                </div>
                                                <div class="input-field col s2">

                                                        <?php
                                                        if (!empty($reference)) {
                                                            $selected = "";
                                                            for ($c = 0; $c < count($reference); $c++) {
                                                                if (!empty($row)) {
                                                                    if ($row['reference_by'] == $reference[$c]['name']) {
                                                                        $selected = 'selected="selected"';

                                                                ?>
                                                                    <?php echo ucfirst($reference[$c]['name']); ?>
                                                                <?php $selected = '';
                                                                    }
                                                                }
                                                            }
                                                        } ?>
                                                </div>
                                            </div>
                                            <div class="col s6 sub_agent_by" style="display: none;">
                                                <div class="col s3">
                                                    <label for="Sub Agent">Sub Agent</label>
                                                </div>
                                                <div class="col s4">
                                                        <?php if (!empty($sub_agent)) {
                                                            $selected = "";
                                                            for ($i = 0; $i < count($sub_agent); $i++) {
                                                                if (!empty($row)) {
                                                                    if ($row['sub_agent_by'] == $sub_agent[$i]['name']) {
                                                                        $selected = 'selected="selected"';

                                                                ?>
                                                                    <?php echo ucfirst($sub_agent[$i]['name']); ?>
                                                                <?php $selected = '';
                                                                    }
                                                                }
                                                            }
                                                        } ?>
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

    var base_url = "<?php echo HTTP_SERVER;?>";

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
            format: "dd-mm-yyyy",
            minView: 2
        });

        $('#start_date').datetimepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            minView: 2
        });

        $('#end_date').datetimepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
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
            format: "dd-mm-yyyy",
            minView: 2
        });

        $('#passport_expir_date').datetimepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            minView: 2
        });

        $('#proficiency_date').datetimepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            minView: 2
        });

        $('#date_of_follow').datetimepicker({
            autoclose: true,
            format: "dd-mm-yyyy hh:ii"
        });

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
                address: "required",
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
                address: "Please enter address",
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

                        //var json = JSON.stringify(response);

                        if (response.status == true) {

                            $(".tabs li").removeClass("disabled");
                            $("#tab_education").click();

                            $("#login_id").val(response.id);

                            $('html, body').animate({scrollTop: 0}, 1000);
                            return false;

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

                            if (education_id != "" && education_id > 0) {
                                $('#eduTable').dataTable().fnClearTable();

                                var clk = "return confirm('Are you sure want to delete?')";

                                for (var i = 0; i < response.data.length; i++) {

                                    var link = '<div class="btn-group"><button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button><ul class="dropdown-menu"><li><a href="javascript:void(0);" data-id="' + response.data[i].education_id + '" class="update" onclick="editEdution(' + response.data[i].education_id + ');" >Edit</a></li><li><a href="javascript:void(0);" data-id="' + response.data[i].education_id + '" onclick="' + clk + '" class="remove">Delete</a></li></ul></div>';

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

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        $('#frmEducation').on('click', 'a.remove', function (e) {

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

                $.ajax({
                    type: "POST",
                    url: base_url + "submit_immigration_data?inquiry_id=" + inquiry_id + "&immi_id=" + immi_id,
                    data: $("#frmImmigration").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            $('#immi_id_hidden').val(response.id);
                            $("#tab_interastedin").click();

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
                exp_address: "required",
                expr_country_id: "required",
                state_expr_id: "required",
                city_expr_id: "required",
                pincode_number: "required",
                current_emp: "required",
                start_date: "required",
                end_date: "required"
            },
            messages: {
                name_of_cmp: "Please enter your company name",
                designation: "Please enter your designation",
                business_name: "Please select your business",
                exp_address: "Please enter your address",
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

                            if (exp_id != "" && exp_id > 0) {

                                $('#experienceTable').dataTable().fnClearTable();

                                var clk = "return confirm('Are you sure want to delete?')";

                                for (var i = 0; i < response.data.length; i++) {

                                    var link = '<div class="btn-group"><button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button><ul class="dropdown-menu"><li><a href="javascript:void(0);" data-id="' + response.data[i].exp_id + '" class="update" onclick="editExperience(' + response.data[i].exp_id + ');" >Edit</a></li><li><a href="javascript:void(0);" data-id="' + response.data[i].exp_id + '" onclick="' + clk + '" class="remove">Delete</a></li></ul></div>';

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

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        $('#frmExperiance').on('click', 'a.remove', function (e) {

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
                relative_city_id: "required",
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
                relative_city_id: "Please select city",
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

                            $('#frmRelaive .validate').val('');

                            var t = $('#relativeTable').DataTable();

                            if (relation_id != "" && relation_id > 0) {

                                $('#relativeTable').dataTable().fnClearTable();

                                var clk = "return confirm('Are you sure want to delete?')";

                                for (var i = 0; i < response.data.length; i++) {

                                    var link = '<div class="btn-group"><button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button><ul class="dropdown-menu"><li><a href="javascript:void(0);" data-id="' + response.data[i].relation_id + '" class="update" onclick="editRelative(' + response.data[i].relation_id + ');" >Edit</a></li><li><a href="javascript:void(0);" data-id="' + response.data[i].relation_id + '" onclick="' + clk + '" class="remove">Delete</a></li></ul></div>';

                                    t.row.add([
                                        response.data[i].full_name_,
                                        response.data[i].since,
                                        response.data[i].relationship,
                                        response.data[i].relative_stete,
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
                                    response.relative_stete,
                                    response.relative_city,
                                    response.immigration_status,
                                    response.link
                                ]).draw(false);
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

                            $("#tab_reference").click();

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

                            $('#english_id_hidden').val(response.id);
                            $("#tab_relative").click();

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
                            if (response.reg_id > 0) {
                                window.location.href = "<?php echo HTTP_SERVER;?>registrationmanager";
                            } else {
                                window.location.href = "<?php echo HTTP_SERVER;?>inquirymanager";
                            }

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

                            window.location.href = "<?php echo HTTP_SERVER;?>inquirymanager";

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

                        window.location.href = "<?php echo HTTP_SERVER;?>inquirymanager";

                    } else if (response.status == false) {
                        alert("Something went wrong...!");
                        return false;
                    }
                }
            });
        });

        $('#frmEducation').on('click', '#btn_edu_pre', function (e) {
            $("#tab_personal").click();
        });

        $('#frmEducation').on('click', '#btn_edu_next', function (e) {
            $("#tab_experiance").click();
        });

        $('#frmExperiance').on('click', '#btn_exper_pre', function (e) {
            $("#tab_education").click();
        });

        $('#frmExperiance').on('click', '#btn_exper_next', function (e) {
            $("#tab_enlish").click();
        });

        $('#frmEnglish').on('click', '#btn_enlish_pre', function (e) {
            $("#tab_experiance").click();
        });

        $('#frmRelaive').on('click', '#btn_relative_pre', function (e) {
            $("#tab_enlish").click();
        });

        $('#frmRelaive').on('click', '#btn_relative_next', function (e) {
            $("#tab_immigration").click();
        });

        $('#frmImmigration').on('click', '#btn_immi_pre', function (e) {
            $("#tab_relative").click();
        });

        $('#frmInterastedin').on('click', '#btn_interastedin_pre', function (e) {
            $("#tab_immigration").click();
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
                    $("#exp_address").val(response.address);
                    $("#start_date").val(response.start_date);
                    $("#end_date").val(response.end_date);
                    $("#pincode_number").val(response.pincode_number);

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

                $("#other_relative_state").hide();
                $("#other_relative_city").hide();

                if (response.status == true) {

                    $("#relative_city_hidden").val(response.immigration_city);
                    $("#relative_state_hidden").val(response.immigration_state);
                    load_relative_state(response.immigration_state);


                    $("#relative_first_name").val(response.relative_first_name);
                    $("#relative_middel_name").val(response.relative_middel_name);
                    $("#relative_last_name").val(response.relative_last_name);
                    $("#relative_address").val(response.relative_address);
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
        <?php if ( !empty($row) ) { ?>
        iStateID = <?php echo $row["state_id"];?>
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
        xmlhttp.open("GET", "<?php echo HTTP_SERVER;?>load_state?iCountryID=" + iCountryID + "&iStateID=" + iStateID, true);
        xmlhttp.send();
    }

    function load_city() {

        var iStateID = document.getElementById("state_id").value;
        var iCityID = "";
        <?php if ( !empty($row) ) { ?>
        iCityID = <?php echo $row["city_id"];?>
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
        xmlhttp.open("GET", "<?php echo HTTP_SERVER;?>load_city?iStateID=" + iStateID + "&iCityID=" + iCityID, true);
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
        xmlhttp.open("GET", "<?php echo HTTP_SERVER;?>load_country", true);
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
        xmlhttp.open("GET", "<?php echo HTTP_SERVER;?>load_state?iCountryID=13&iStateID=", true);
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
        <?php if ( !empty($row) ) { ?>
        iStateID = <?php echo $row["state_id"];?>
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
        xmlhttp.open("GET", "<?php echo HTTP_SERVER;?>load_state?iCountryID=" + iCountryID + "&iStateID=" + iStateID, true);
        xmlhttp.send();
    }

    function load_expr_city() {

        var iStateID = document.getElementById("state_expr_id").value;
        var iCityID = "";
        <?php if ( !empty($row) ) { ?>
        iCityID = <?php echo $row["city_id"];?>
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
        xmlhttp.open("GET", "<?php echo HTTP_SERVER;?>load_city?iStateID=" + iStateID + "&iCityID=" + iCityID, true);
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
        <?php if ( !empty($row) ) { ?>
        iCityID = <?php echo $row["inquiry_id"];?>
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
        xmlhttp.open("GET", "<?php echo HTTP_SERVER;?>load_city?iStateID=" + iStateID + "&iCityID=" + iCityID, true);
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
    $("#sub_agent_by").val("<?php echo $row['sub_agent_by'];?>");
    <?php

    }   else {
    ?>
    $("#reference_by").val("<?php echo $row['reference_by'];?>");
    <?php

    }
    }
    ?>

</script>