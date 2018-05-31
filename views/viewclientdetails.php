<?php include_once '../include/header.php'; ?>
<?php

$row = array();
$education = array();
$experiences = array();
$immigration_arr = array();
$english_test = array();
$relative_data = array();
$event_data = array();

$loginid = $objsession->get("log_admin_loginid");
$inquiry_id = 0;
$reg_id = 0;
$types = "personal";

if (isset($_GET['tb_type'])) {
    $types = $_GET['tb_type'];
}

if (isset($_GET['inquiry_id'])) {
    $cond = '';
    $inquiry_id = $_GET['inquiry_id'];
    $cond = "inquiry_id=:inquiry_id";
    $params = array(":inquiry_id" => $inquiry_id);
    $row = $obj->fetchRow('inquiry_list', $cond, $params);
    $reg_data = $obj->fetchRow('registration', $cond, $params);

    $cond_ = "state_id=:state_id";
    $params_ = array(":state_id" => $row['state_id']);

    $state = $obj->fetchRow('states', $cond_, $params_);


    $cond_ = "city_id=:city_id";
    $params_ = array(":city_id" => $row['city_id']);
    $city = $obj->fetchRow('cities', $cond_, $params_);

    $follow_up_data = $obj->fetchRow('follow_up', $cond, $params);

    $reg_id = $row['is_register'];
    $passports = $obj->fetchRowAll('passpord_details', $cond, $params);
    $event_data = $obj->fetchRow('events', $cond, $params);

    $english_test = $obj->fetchRow('english_test', $cond, $params);
    $meetings = $obj->fetchRowAll('meetings', $cond, $params);
    $education = $obj->fetchRowAll('education_details', $cond, $params);
    $experiences = $obj->fetchRowAll('work_experiance_details', $cond, $params);
    $immigration_arr = $obj->fetchRow('immigration_details', $cond, $params);
    $relative_data = $obj->fetchRowAll('relationship_details', $cond, $params);
    $relative_data_client = $obj->fetchRowAll('familydetails', $cond, $params);

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

$cond = "types =:types AND is_active =:is_active";
$params = array(":types" => 0, ":is_active" => 1);
$reference = $obj->fetchRowAll('referance_list', $cond, $params);

$cond = "types =:types AND is_active =:is_active";
$params = array(":types" => 1, ":is_active" => 1);
$sub_agent = $obj->fetchRowAll('referance_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'Proficiency', ":is_active" => 1);
$proficiency_type = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'PaymentStage', ":is_active" => 1);
$PaymentStage = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'medium', ":is_active" => 1);
$medium = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'events', ":is_active" => 1);
$events = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active";
$params = array(":category_name" => 'migrate_name', ":is_active" => 1);
$reason_for_change = $obj->fetchRowAll('masters_list', $cond, $params);
?>
<style type="text/css">
    .fa {
        padding: 0px !important;
    }

    .row .col.s3 {
        width: 12%;
    }

    .tabs {
        height: auto;
    }

    .tabs .tab a {
        font-size: 12px;
    }

    .indicator {
        display: none;
    }

    label {
        font-size: 14px;
    }
</style>
<div class="header">
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <?php
        if ($row['is_register'] > 0) {
            ?>
            <li><a href="<?php echo HTTP_SERVER; ?>clientsmanager">List of Clients</a></li>
            <?php
        } else {
            ?>
            <li><a href="<?php echo HTTP_SERVER; ?>inquirymanager">List of Inquiry</a></li>
            <?php
        }
        ?>
        <li class="active">View Inquiry Details</li>
    </ol>
</div>
<div id="page-inner">

    <div class="row">
        <div class="col-lg-12">
            <?php if ($objsession->get('ads_message') != "") {
                ?>
                <div class="alert alert-success">
                    <?php echo $objsession->get('ads_message'); ?>
                </div>
                <?php $objsession->remove('ads_message');
            } ?>
            <div class="card">
                <div class="">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <ul class="tabs">
                                    <li class="tab col s3"><a
                                                class="<?php if ($types == "personal") { ?> active <?php } ?>"
                                                id="tab_personal"
                                                href="#personal">Personal</a>
                                    </li>
                                    <li class="tab col s3 "><a
                                                class="<?php if ($types == "education") { ?> active <?php } ?>"
                                                id="tab_education"
                                                href="#education">Education</a>
                                    </li>
                                    <li class="tab col s3 "><a
                                                class="<?php if ($types == "enlish") { ?> active <?php } ?>"
                                                id="tab_enlish" href="#enlish">English
                                            Proficiency</a></li>
                                    <li class="tab col s3 "><a
                                                class="<?php if ($types == "relative") { ?> active <?php } ?>"
                                                id="tab_relative" href="#relative">Relative in
                                            Australian</a></li>
                                    <li class="tab col s3 "><a
                                                class="<?php if ($types == "immigration") { ?> active <?php } ?>"
                                                id="tab_immigration" href="#immigration">Immigration
                                            Hisory</a>
                                    </li>
                                    <li class="tab col s3 "><a
                                                class="<?php if ($types == "interastedin") { ?> active <?php } ?>"
                                                id="tab_interastedin" href="#interastedin">Interasted
                                            In</a>
                                    </li>
                                    <li class="tab col s3 "><a
                                                class="<?php if ($types == "reference") { ?> active <?php } ?>"
                                                id="tab_reference"
                                                href="#reference">Reference</a>
                                    </li>
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
                                <div id="personal" class="col s12">
                                    <div class="row">
                                        <div class="col s2">
                                            <label for="gender">Client ID : </label>
                                        </div>
                                        <div class="col s3">
                                            <?php if (!empty($row)) {
                                                echo "#" . $row['inquiry_id'];
                                            } ?>
                                        </div>
                                        <input id="login_id" name="login_id" type="hidden"
                                               value="<?php if (!empty($row)) {
                                                   echo $row['inquiry_id'];
                                               } else {
                                                   echo "0";
                                               } ?>">

                                        <div class="col s2">
                                            <label for="gender">Registered Date</label>
                                        </div>
                                        <div class="col s4">
                                            <?php if (!empty($reg_data)) {
                                                echo date("d/m/Y", strtotime($reg_data['created_date']));
                                            } ?>
                                        </div>

                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col s2">
                                            <label for="first_name">First Name</label>
                                        </div>
                                        <div class=" col s3">
                                            <span id="first_name"><?php if (!empty($row)) {
                                                    echo $row['first_name'];
                                                } ?></span>
                                        </div>
                                        <div class=" col s2">
                                            <label for="first_name">Last Name</label>
                                        </div>
                                        <div class=" col s3">
                                            <span id="last_name"><?php if (!empty($row)) {
                                                    echo $row['last_name'];
                                                } ?></span></div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class=" col s2">
                                            <label for="gender">Gender</label>
                                        </div>
                                        <div class=" col s3">
                                            <div class="form-group">
                                                <span id="gender">
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
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col s2">
                                            <label for="gender">Date of Birth</label>
                                        </div>
                                        <div class="col s4">
                                            <span id="date_of_birth_lbl">
                                            <?php if (!empty($row)) {
                                                echo date("d/m/Y", strtotime($row['date_of_birth']));
                                            } ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">

                                        <div class="col s2">
                                            <label for="gender">Place of Birth</label>
                                        </div>
                                        <div class="col s3">
                                            <span id="place_of_birth">
                                            <?php if (!empty($row)) {
                                                echo $row['place_of_birth'];
                                            } ?>
                                            </span>

                                        </div>
                                        <div class="col s2">
                                            <label for="gender">Address</label>
                                        </div>
                                        <div class="col s4">
                                            <span id="address1">
                                            <?php if (!empty($row)) {
                                                $add = "";
                                                if ($row['address1'] != "") {
                                                    $add .= $row['address1'];
                                                }
                                                if ($row['address2'] != "") {
                                                    $add .= "," . $row['address2'];
                                                }
                                                if ($row['address3'] != "") {
                                                    $add .= "," . $row['address3'];
                                                }
                                                echo $add;
                                            } ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col s2">
                                            <label for="gender">Country</label>
                                        </div>
                                        <div class="col s3">
                                            <span id="country_name">
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
                                            </span>

                                        </div>
                                        <div class="col s2">
                                            <label for="gender">State</label>
                                        </div>
                                        <div class="col s3">
                                            <span id="state_name">
                                            <?php if (!empty($state)) {
                                                echo $state['name'];
                                            } ?>
                                            </span>

                                        </div>
                                        <div class="col s2">
                                            <label for="gender">City</label>
                                        </div>
                                        <div class="col s3">
                                            <span id="city_name">
                                            <?php if (!empty($city)) {
                                                echo $city['name'];
                                            } ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">

                                        <div class="col s2">
                                            <label for="gender">Postalcode</label>
                                        </div>
                                        <div class="col s3">
                                             <span id="postalcode">
                                            <?php if (!empty($row)) {
                                                echo $row['postalcode'];
                                            } ?>
                                            </span>
                                        </div>

                                        <div class="col s2">
                                            <label for="gender">Email</label>
                                        </div>
                                        <div class="col s3">
                                             <span id="email_address">
                                            <?php if (!empty($row)) {
                                                echo $row['email_address'];
                                            } ?>
                                            </span>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">

                                        <div class="col s2">
                                            <label for="gender">Mobile Number</label>
                                        </div>
                                        <div class="col s3">
                                            <span id="mobile_number">
                                            <?php if (!empty($row)) {
                                                echo $row['mobile_number'];
                                            } ?>
                                            </span>

                                        </div>
                                        <div class="col s2">
                                            <label for="gender">Phone Number</label>
                                        </div>
                                        <div class="col s3">
                                            <span id="phone_number">
                                            <?php if (!empty($row)) {
                                                echo $row['phone_number'];
                                            } ?>
                                            </span>

                                        </div>

                                        <div class="col s2">
                                            <label for="gender">Marrital Status</label>
                                        </div>
                                        <div class="col s3">
                                            <span id="marital_status">
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
                                            </span>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#personalPopup"
                                       class="waves-effect waves-light btn">
                                        EDIT
                                    </a>

                                    <!-- Edit Personal Data in edit mode -->
                                    <div id="personalPopup" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Personal Data</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmPersonal"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                                          method="post">
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

                                                                <input id="first_name" name="first_name" type="text"
                                                                       class="validate"
                                                                       value="<?php if (!empty($row)) {
                                                                           echo $row['first_name'];
                                                                       } ?>">
                                                                <label for="first_name">First Name</label>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <input id="last_name" name="last_name" type="text"
                                                                       class="validate"
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
                                                                    <input id="adharcard_number" name="adharcard_number"
                                                                           type="text"
                                                                           class="validate"
                                                                           value="<?php if (!empty($row)) {
                                                                               echo $row['adharcard_number'];
                                                                           } ?>">
                                                                    <label for="adharcard_number">Adhar Card
                                                                        Number</label>
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
                                                                           type="radio" <?php echo $female; ?>id="test2"
                                                                           value="Female"/>
                                                                    <label for="test2">Female</label>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="input-field col s6">
                                                                <input id="date_of_birth" name="date_of_birth"
                                                                       type="text"
                                                                       class="validate"
                                                                       value="<?php if (!empty($row)) {
                                                                           echo date("d/m/Y", strtotime($row['date_of_birth']));
                                                                       } ?>">
                                                                <label for="date_of_birth">Date of Birth</label>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <input id="place_of_birth" name="place_of_birth"
                                                                       type="text"
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
                                                                    <select name="country_id" class="form-control"
                                                                            id="country_id"
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
                                                                    </select>
                                                                    <input type="text" name="other_country"
                                                                           id="other_country"
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
                                                                    <select name="state_id" class="form-control"
                                                                            id="state_id"
                                                                            onchange="load_city();">
                                                                        <option value="">---Select---</option>
                                                                    </select>
                                                                    <input type="text" name="other_state"
                                                                           id="other_state"
                                                                           placeholder="Other State name"
                                                                           style="margin:15px 0px;display:none;"
                                                                           class="form-control"
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
                                                                    <select name="city_id" class="form-control"
                                                                            id="city_id"
                                                                            onchange="load_city_other();">
                                                                        <option value="">---Select---</option>
                                                                    </select>
                                                                    <input type="text" name="other_city" id="other_city"
                                                                           placeholder="Other City name"
                                                                           style="margin:15px 0px;display:none;"
                                                                           class="form-control"
                                                                           value="">
                                                                </div>

                                                            </div>
                                                            <div class="input-field col s6">

                                                                <input id="postalcode" name="postalcode" type="text"
                                                                       class="validate"
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
                                                                <input id="email_address" name="email_address"
                                                                       type="text"
                                                                       class="validate"
                                                                       value="<?php if (!empty($row)) {
                                                                           echo $row['email_address'];
                                                                       } ?>">
                                                                <label for="email_address">Email</label>


                                                            </div>
                                                            <div class="input-field col s6">
                                                                <input id="mobile_number" name="mobile_number"
                                                                       type="text"
                                                                       class="validate"
                                                                       value="<?php if (!empty($row)) {
                                                                           echo $row['mobile_number'];
                                                                       } ?>">
                                                                <label for="mobile_number">Mobile Number</label>


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
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           value="Save">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="btn_personal_close"
                                                            class="btn btn-default" data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="education" class="col s12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="eduTable">
                                            <thead>
                                            <tr>
                                                <th>Name of Degree</th>
                                                <th>Name of Center</th>
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
                                                        <td width="250"><?php echo $education[$i]['name_of_center']; ?></td>
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
                                                        </td>
                                                    </tr>

                                                <?php }
                                            } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!--Load education data for edit mode-->
                                    <button type="button" style="display: none;" class="btn btn-info btn-lg"
                                            data-toggle="modal" data-target="#popupEducation" id="btnpopupEducation">
                                        Open Modal
                                    </button>
                                    <!-- Modal -->
                                    <div id="popupEducation" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Education Details</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmEducation"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                                          method="post">
                                                        <div class="row">
                                                            <div class="input-field col s6">

                                                                <input id="education_id" name="education_id"
                                                                       type="hidden" value="0">

                                                                <input id="name_of_degree" name="name_of_degree"
                                                                       type="text"
                                                                       class="validate"
                                                                       value="">
                                                                <label for="name_of_degree">Qualification</label>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <input id="name_of_center" name="name_of_center"
                                                                       type="text"
                                                                       class="validate"
                                                                       value="">
                                                                <label for="name_of_center">Board / Institude /
                                                                    University</label>
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
                                                                <input id="passed_on" name="passed_on" type="text"
                                                                       class="validate"
                                                                       value="">
                                                                <label for="middle_name">Passed Year</label>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="input-field col s6">
                                                                <input id="percentage" name="percentage" type="text"
                                                                       class="validate"
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
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           value="SAVE">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" id="btnEducationClose"
                                                            data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="enlish" class="col s12">

                                    <div class="card-action">English Proficiency</div>

                                    <div class="row">
                                        <div class=" col s12">
                                            <div class="col s6">
                                                <label for="applyed_for">Apeared in any english proficiency
                                                    test</label>
                                            </div>
                                            <div class=" col s4">
                                                <div class="form-group">
                                                    <input type="hidden" id="english_id_hidden"
                                                           value="<?php if (!empty($english_test)) {
                                                               echo $english_test['test_id'];
                                                           } ?>">

                                                    <span id="exam_yes">
                                                            <?php
                                                            $yes = '';
                                                            $no = '';
                                                            if (!empty($english_test)) {
                                                                if ($english_test['applyed_for'] == 1) {
                                                                    $yes = 'Yes';
                                                                }

                                                                if ($english_test['applyed_for'] == 0) {
                                                                    $no = 'No';
                                                                }
                                                            }
                                                            ?>
                                                        <label for="applyed_for_yesx"><?php echo $yes; ?></label>
                                                        <label for="applyed_for_nox"><?php echo $no; ?></label>
                                                        </span>


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
                                                    <span id="test_type">
                                                        <?php if (!empty($englishExam)) {
                                                            $selected = "";
                                                            for ($c = 0; $c < count($englishExam); $c++) {
                                                                if (!empty($row)) {
                                                                    if ($english_test['test_type'] == $englishExam[$c]['master_id']) {
                                                                        $selected = 'selected="selected"';

                                                                        ?>
                                                                        <?php echo ucfirst($englishExam[$c]['name']); ?>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        } ?>
                                                    </span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row applyed_for_div" style="display: none;">

                                        <div class="col s2">
                                            <label for="listening">Listening</label>
                                        </div>
                                        <div class="col s3">
                                                <span id="listening_">
                                                    <?php if (!empty($english_test)) {
                                                        echo $english_test['listening'];
                                                    } ?>
                                                </span>

                                        </div>
                                        <div class="col s2">
                                            <label for="listening">Reading</label>
                                        </div>
                                        <div class="col s3">
                                                <span id="reading_">
                                                    <?php if (!empty($english_test)) {
                                                        echo $english_test['reading'];
                                                    } ?>
                                                </span>

                                        </div>

                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row applyed_for_div" style="display: none;">

                                        <div class="col s2">
                                            <label for="listening">Writing</label>
                                        </div>
                                        <div class="col s3">
                                                <span id="writing_">
                                                    <?php if (!empty($english_test)) {
                                                        echo $english_test['writing'];
                                                    } ?>
                                                </span>

                                        </div>

                                        <div class="col s2">
                                            <label for="listening">Speaking</label>
                                        </div>
                                        <div class="col s3">
                                                 <span id="speaking_">
                                                    <?php if (!empty($english_test)) {
                                                        echo $english_test['speaking'];
                                                    } ?>
                                                </span>

                                        </div>

                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row applyed_for_div" style="display: none;">

                                        <div class="col s2">
                                            <label for="listening">Proficiency Date</label>
                                        </div>
                                        <div class="col s3">
                                                <span id="proficiency_type_">
                                                    <?php if (!empty($english_test)) {
                                                        echo $english_test['proficiency_type'];
                                                    } ?>
                                                </span>

                                        </div>

                                        <div class="col s2">
                                            <label for="listening">Exam Date</label>
                                        </div>
                                        <div class="col s3">
                                                <span id="proficiency_date_">
                                                   <?php if (!empty($english_test)) {
                                                       echo date("d/m/Y", strtotime($english_test['proficiency_date']));
                                                   } ?>
                                                </span>

                                        </div>
                                    </div>

                                    <!-- English Proficiency-->
                                    <div id="popupEnglish" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Englih Proficiency</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmEnglish"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                                          method="post">
                                                        <div class="row">
                                                            <div class="input-field col s12">
                                                                <div class="input-field col s6">
                                                                    <label for="applyed_for">Apeared in any english
                                                                        proficiency
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

                                                                        <input class="with-gap applyed_for_"
                                                                               name="applyed_for"
                                                                               type="radio" id="applyed_for_yes"
                                                                               value="1"
                                                                            <?php echo $yes; ?>
                                                                        />
                                                                        <label for="applyed_for_yes">Yes</label>

                                                                        <input class="with-gap applyed_for_"
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
                                                        <div class="row applyed_for_div_" style="display: none;">
                                                            <div class="input-field col s6">
                                                                <div class="input-field col s2">
                                                                    <label for="test_type">Exam</label>
                                                                </div>
                                                                <div class="input-field col s10">

                                                                    <select name="test_type"
                                                                            class="form-control validate"
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
                                                        <div class="row applyed_for_div_" style="display: none;">
                                                            <div class="input-field col s6">
                                                                <input id="listening" name="listening" type="text"
                                                                       class="validate"
                                                                       value="<?php if (!empty($english_test)) {
                                                                           echo $english_test['listening'];
                                                                       } ?>">
                                                                <label for="listening">Listening</label>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <input id="reading" name="reading" type="text"
                                                                       class="validate"
                                                                       value="<?php if (!empty($english_test)) {
                                                                           echo $english_test['reading'];
                                                                       } ?>">
                                                                <label for="reading">Reading</label>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row applyed_for_div_" style="display: none;">
                                                            <div class="input-field col s6">
                                                                <input id="writing" name="writing" type="text"
                                                                       class="validate"
                                                                       value="<?php if (!empty($english_test)) {
                                                                           echo $english_test['writing'];
                                                                       } ?>">
                                                                <label for="writing">Writing</label>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <input id="speaking" name="speaking" type="text"
                                                                       class="validate"
                                                                       value="<?php if (!empty($english_test)) {
                                                                           echo $english_test['speaking'];
                                                                       } ?>">
                                                                <label for="speaking">Speaking</label>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row applyed_for_div_" style="display: none;">
                                                            <div class="input-field col s6">

                                                                <div class="input-field col s4">
                                                                    <label for="proficiency_type">Proficiency</label>
                                                                </div>
                                                                <div class="input-field col s8">
                                                                    <select name="proficiency_type"
                                                                            class="form-control validate"
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
                                                                <input id="proficiency_date" name="proficiency_date"
                                                                       type="text"
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
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           name="btn_enlish_next" value="SAVE">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"
                                                            id="btnEnglishClose">Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#popupEnglish"
                                       class="waves-effect waves-light btn" id="btn_edu_pre">
                                        EDIT
                                    </a>
                                </div>
                                <div id="relative" class="col s12">
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

                                                        </td>
                                                    </tr>

                                                <?php }
                                            } ?>

                                            </tbody>
                                        </table>
                                    </div>

                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal"
                                            data-target="#popupRelative" style="display: none;" id="btn_relative_popup">
                                        Open Modal
                                    </button>

                                    <!-- Modal -->
                                    <div id="popupRelative" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Relative in Australia</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmRelaive"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                                          method="post">
                                                        <div class="row">
                                                            <div class="input-field col s12">
                                                                <div class="input-field col s6">
                                                                    <label for="country_id">Do you have relative in
                                                                        Australia ?</label>
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
                                                                               type="radio" checked
                                                                               id="relative_have_au_no"
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

                                                                    <input id="relation_id" name="relation_id"
                                                                           type="hidden" value="0">

                                                                    <input id="relative_first_name"
                                                                           name="relative_first_name"
                                                                           type="text"
                                                                           class="validate"
                                                                           value="">
                                                                    <label for="relative_first_name">First Name</label>
                                                                </div>
                                                                <div class="input-field col s6">
                                                                    <input id="relative_last_name"
                                                                           name="relative_last_name" type="text"
                                                                           class="validate"
                                                                           value="">
                                                                    <label for="relative_last_name">Last Name</label>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="row">
                                                                <div class="input-field col s6">
                                                                    <input id="since" name="since" type="text"
                                                                           class="validate"
                                                                           value="">
                                                                    <label for="since">Since</label>
                                                                </div>
                                                                <div class="input-field col s6">
                                                                    <input id="ret_postal_code" name="ret_postal_code"
                                                                           type="text"
                                                                           class="validate"
                                                                           value="">
                                                                    <label for="since">Postalcode</label>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="row">
                                                                <div class="input-field col s6">
                                                                    <div class="input-field col s10">
                                                                        <input type="hidden" id="relative_state_hidden"
                                                                               value="0">
                                                                        <input id="relative_state_id"
                                                                               name="relative_state_id"
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
                                                                        <input type="hidden" id="relative_city_hidden"
                                                                               value="0">
                                                                        <select name="relative_city_id"
                                                                                class="form-control validate"
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
                                                                    <input id="reta_address1" name="reta_address1"
                                                                           type="text"
                                                                           class="validate"
                                                                           value="" placeholder="Address Line No 1">
                                                                    <input id="reta_address2" name="reta_address2"
                                                                           type="text"
                                                                           class="validate"
                                                                           value="" placeholder="Address Line No 2">
                                                                    <input id="reta_address3" name="reta_address3"
                                                                           type="text"
                                                                           class="validate"
                                                                           value="" placeholder="Address Line No 3">
                                                                </div>

                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="row">

                                                                <div class="input-field col s6">
                                                                    <div class="input-field col s4">
                                                                        <label for="Immigration Status">Immigration
                                                                            Status</label>
                                                                    </div>
                                                                    <div class="input-field col s8">
                                                                        <select name="immigration_status"
                                                                                class="form-control validate"
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
                                                                        <select name="relationship"
                                                                                class="form-control validate"
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
                                                                        <input type="submit"
                                                                               class="waves-effect waves-light btn"
                                                                               value="SAVE">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"
                                                            id="btn_relative_close">Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="immigration" class="col s12">
                                    <div class="card-action">
                                        Previous Immigration / Visa History
                                    </div>
                                    <div class="row">
                                        <div class="col s6">
                                            <div class="col s4">
                                                <input type="hidden" id="immi_id_hidden"
                                                       value="<?php if (!empty($immigration_arr)) {
                                                           echo $immigration_arr['immigration_id'];
                                                       } else {
                                                           echo "0";
                                                       } ?>">
                                                <label for="country_id">Visa type applied</label>
                                            </div>
                                            <div class="col s8">
                                                <div class="form-group">
                                                    <span id="visaGrant">
                                                        <?php

                                                        if ($immigration_arr['visa_type_applied'] == 1) {
                                                            echo "Yes";
                                                        }
                                                        if ($immigration_arr['visa_type_applied'] == 0) {
                                                            echo "No";
                                                        }
                                                        ?>
                                                    </span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s6 visa_div " <?php if ($immigration_arr['visa_type_applied'] == 0) { ?> style="display: none;" <?php } ?> >
                                            <div class="col s2">
                                                <label for="listening">Country</label>
                                            </div>
                                            <div class="col s5">
                                                <span id="visa_country">
                                                <?php if (!empty($immigration_arr)) {
                                                    $selected = "";
                                                    for ($c = 0; $c < count($country); $c++) {
                                                        if (!empty($row)) {
                                                            if ($immigration_arr['applied_country'] == $country[$c]['country_id']) {
                                                                $selected = 'selected="selected"';

                                                                ?>

                                                                <?php echo ucfirst($country[$c]['name']); ?>
                                                                <?php $selected = '';
                                                            }
                                                        }
                                                    }
                                                } ?>
                                                    </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class=" col s6 visa_div" <?php if ($immigration_arr['visa_granted'] == 0) { ?> style="display: none;" <?php } ?> >
                                            <div class=" col s4">
                                                <label for="country_id">Was Visa Granted</label>
                                            </div>
                                            <div class=" col s8">
                                                <div class="form-group">

                                                    <span id="visa_was">
                                                        <?php

                                                        if ($immigration_arr['visa_granted'] == 1) {
                                                            echo "Yes";
                                                        }
                                                        if ($immigration_arr['visa_granted'] == 0) {
                                                            echo "No";
                                                        }
                                                        ?>
                                                    </span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row did_travel" <?php if ($immigration_arr['is_travel'] == 0) { ?> style="display: none;" <?php } ?>>
                                        <div class=" col s6">
                                            <div class=" col s4">
                                                <label for="country_id">Did Travel</label>
                                            </div>
                                            <div class=" col s8">
                                                <div class="form-group">

                                                    <span id="travel_">
                                                        <?php

                                                        if ($immigration_arr['is_travel'] == 1) {
                                                            echo "Yes";
                                                        }
                                                        if ($immigration_arr['is_travel'] == 0) {
                                                            echo "No";
                                                        }
                                                        ?>
                                                    </span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="clearfix"></div>
                                    <div class="row travel_date" <?php if ($immigration_arr['is_travel'] == 0) { ?> style="display: none;" <?php } ?>>
                                        <div class="col s12">

                                            <div class="col s3">
                                                <label for="listening">From Date</label>
                                            </div>
                                            <div class="col s4">
                                                <span id="f_date">
                                                    <?php if (!empty($immigration_arr)) {
                                                        if ($immigration_arr['from_date'] != "1970-01-01") {
                                                            echo date("d/m/Y", strtotime($immigration_arr['from_date']));
                                                        }
                                                    } ?>
                                                </span>
                                            </div>

                                            <div class="col s3">
                                                <label for="listening">To Date</label>
                                            </div>
                                            <div class="col s4">
                                                <span id="t_date">
                                                    <?php if (!empty($immigration_arr)) {
                                                        if ($immigration_arr['to_date'] != "1970-01-01") {
                                                            echo date("d/m/Y", strtotime($immigration_arr['to_date']));
                                                        }
                                                    } ?>
                                                </span>

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
                                                <span id="previous_assign_">
                                                   <?php if (!empty($immigration_arr)) {
                                                       echo $immigration_arr['previous_assign'];
                                                   } ?>
                                                </span>

                                            </div>
                                            <div class="col s2">
                                                <label for="listening">Remark</label>
                                            </div>
                                            <div class="col s4">
                                                <span id="remark_">
                                                  <?php if (!empty($immigration_arr)) {
                                                      echo $immigration_arr['remark'];
                                                  } ?>
                                                </span>

                                            </div>

                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div id="immi_popup_form" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Previous Immigration / Visa History</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmImmigration"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                                          method="post">
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

                                                                        <input class="with-gap visa_type_applied_"
                                                                               name="visa_type_applied"
                                                                               type="radio" id="visa_type_yes_"
                                                                               value="1"/>
                                                                        <label for="visa_type_yes_">Yes</label>

                                                                        <input class="with-gap visa_type_applied_"
                                                                               name="visa_type_applied"
                                                                               type="radio" id="visa_type_no_"
                                                                               value="0"/>
                                                                        <label for="visa_type_no_">No</label>
                                                                        <br/>
                                                                        <span id="visa_type_applied_msg"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="input-field col s6 visa_div_ "
                                                                 style="display: none;">

                                                                <div class="input-field col s2">
                                                                    <label for="country_id">Country</label>
                                                                </div>
                                                                <div class="input-field col s10">

                                                                    <select name="applied_country"
                                                                            class="form-control validate"
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
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="input-field col s6 visa_div_"
                                                                 style="display: none;">
                                                                <div class="input-field col s4">
                                                                    <label for="country_id">Was Visa Granted</label>
                                                                </div>
                                                                <div class="input-field col s8">
                                                                    <div class="form-group">

                                                                        <input class="with-gap was_visa_type_"
                                                                               name="visa_granted"
                                                                               type="radio" id="was_visa_type_yes_"
                                                                               value="1"/>
                                                                        <label for="was_visa_type_yes_">Yes</label>

                                                                        <input class="with-gap was_visa_type_"
                                                                               name="visa_granted"
                                                                               type="radio" id="was_visa_type_no_"
                                                                               value="0"/>
                                                                        <label for="was_visa_type_no_">No</label>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row did_travel_" style="display: none;">
                                                            <div class="input-field col s6">
                                                                <div class="input-field col s4">
                                                                    <label for="country_id">Did Travel</label>
                                                                </div>
                                                                <div class="input-field col s8">
                                                                    <div class="form-group">

                                                                        <input class="with-gap did_tralrl_rb_"
                                                                               name="did_travel"
                                                                               type="radio" id="did_travel_yes_"
                                                                               value="1"/>
                                                                        <label for="did_travel_yes_">Yes</label>

                                                                        <input class="with-gap did_tralrl_rb_"
                                                                               name="did_travel"
                                                                               type="radio" id="did_travel_no_"
                                                                               value="0"/>
                                                                        <label for="did_travel_no_">No</label>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>

                                                        <div class="clearfix"></div>
                                                        <div class="row travel_date_" style="display: none;">
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
                                                                <input id="previously_assign_by"
                                                                       name="previously_assign_by" type="text"
                                                                       class="validate"
                                                                       value="<?php if (!empty($immigration_arr)) {
                                                                           echo $immigration_arr['previous_assign'];
                                                                       } ?>">
                                                                <label for="previously_assign_by">Previously Assign
                                                                    By</label>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <input id="remark" name="remark" type="text"
                                                                       class="validate"
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
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           name="btn_immi_next" value="SAVE">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="btnImmClose" class="btn btn-default"
                                                            data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <a href="javascript:void();" data-toggle="modal" data-target="#immi_popup_form"
                                       class="waves-effect waves-light btn" id="btn_edu_pre">
                                        EDIT
                                    </a>
                                </div>
                                <div id="interastedin" class="col s12">

                                    <div class="card-action">Interasted In</div>
                                    <div class="row">
                                        <div class="col s6">
                                            <div class="col s2">
                                                <label for="country_id">Country</label>
                                            </div>
                                            <div class="col s10">
                                                    <span id="in_country">
                                                        <?php if (!empty($country)) {
                                                            $selected = "";
                                                            for ($c = 0;
                                                                 $c < count($country);
                                                                 $c++) {
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
                                                    </span>
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <div class="col s2">
                                                <label for="Visa Type">Visa Type</label>
                                            </div>
                                            <div class="col s10">
                                                    <span id="int_visa">
                                                        <?php if (!empty($visatype)) {
                                                            $selected = "";
                                                            for ($i = 0;
                                                                 $i < count($visatype);
                                                                 $i++) {
                                                                if (!empty($row)) {
                                                                    if ($row['visa_type'] == $visatype[$i]['name']) {
                                                                        $selected = 'selected="selected"';

                                                                        ?>
                                                                        <?php echo ucfirst($visatype[$i]['name']); ?>
                                                                        <?php $selected = '';
                                                                    }
                                                                }
                                                            }
                                                        } ?>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <!-- Modal -->
                                    <div id="popupInterasted" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Interasted In</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmInterastedin"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                                          method="post">
                                                        <div class="row">
                                                            <div class="input-field col s6">
                                                                <div class="input-field col s2">
                                                                    <label for="country_id">Country</label>
                                                                </div>
                                                                <div class="input-field col s10">

                                                                    <select name="immi_country_id"
                                                                            class="form-control validate"
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
                                                                    <input type="text" name="other_immi_country"
                                                                           id="other_immi_country"
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
                                                                    <select name="visa_type"
                                                                            class="form-control validate"
                                                                            id="visa_type">
                                                                        <option value="">---Select---</option>
                                                                        <?php if (!empty($visatype)) {
                                                                            $selected = "";
                                                                            for ($i = 0; $i < count($visatype); $i++) {
                                                                                if (!empty($row)) {
                                                                                    if ($row['visa_type'] == $visatype[$i]['name']) {
                                                                                        $selected = 'selected="selected"';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                <option <?php echo $selected; ?>
                                                                                        value="<?php echo $visatype[$i]['name']; ?>">
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
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           name="btn_interastedin_next" value="SAVE">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="btn_int_close" class="btn btn-default"
                                                            data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <a href="javascript:void()" data-toggle="modal" data-target="#popupInterasted"
                                       class="waves-effect waves-light btn" id="btn_edu_pre">
                                        EDIT
                                    </a>
                                </div>
                                <div id="reference" class="col s12">
                                    <div class="row">
                                        <div class="col s6">
                                            <div class="col s4">
                                                <label for="reference_by">Reference By</label>
                                            </div>
                                            <div class=" col s4">
                                                    <span id="ref_name">
                                                        <?php
                                                        if (!empty($reference)) {
                                                            $selected = "";
                                                            for ($c = 0;
                                                                 $c < count($reference);
                                                                 $c++) {
                                                                if (!empty($row)) {
                                                                    if ($row['reference_by'] == $reference[$c]['ref_id'] && $row['reference_by'] != 0) {
                                                                        $selected = 'selected="selected"';

                                                                        ?>
                                                                        <?php echo ucfirst($reference[$c]['ref_name']); ?>
                                                                        <?php $selected = '';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        if ($row['reference_by'] == 0) {
                                                            echo "Sub Agent";
                                                        }
                                                        ?>
                                                    </span>
                                            </div>
                                        </div>
                                        <div class="col s6 sub_agent_by" style="display: none;">
                                            <div class="col s4">
                                                <label for="Sub Agent">Sub Agent</label>
                                            </div>
                                            <div class="col s4">
                                                    <span id="sub_name">
                                                        <?php if (!empty($sub_agent)) {
                                                            $selected = "";
                                                            for ($i = 0;
                                                                 $i < count($sub_agent);
                                                                 $i++) {
                                                                if (!empty($row)) {
                                                                    if ($row['sub_agent_by'] == $sub_agent[$i]['ref_id']) {
                                                                        $selected = 'selected="selected"';

                                                                        ?>
                                                                        <?php echo ucfirst($sub_agent[$i]['ref_name']); ?>
                                                                        <?php $selected = '';
                                                                    }
                                                                }
                                                            }
                                                        } ?>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <!-- Referance popup -->
                                    <div id="popupreferance" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Reference</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmReference"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                                          method="post">
                                                        <div class="card-action">Reference By</div>
                                                        <div class="row">
                                                            <div class="input-field col s6">
                                                                <div class="input-field col s2">
                                                                    <label for="reference_by">Reference By</label>
                                                                </div>
                                                                <div class="input-field col s10">
                                                                    <select name="reference_by"
                                                                            class="form-control validate"
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
                                                            <div class="input-field col s6 sub_agent_by"
                                                                 style="display: none;">
                                                                <div class="input-field col s2">
                                                                    <label for="Sub Agent">Sub Agent</label>
                                                                </div>
                                                                <div class="input-field col s10">
                                                                    <select name="sub_agent_by"
                                                                            class="form-control validate"
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
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           name="btn_reference_save"
                                                                           id="btn_reference_save"
                                                                           value="Save">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="btn_ref_close" class="btn btn-default"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <a href="javascript:void()" data-toggle="modal" data-target="#popupreferance"
                                       class="waves-effect waves-light btn" id="btn_edu_pre">
                                        EDIT
                                    </a>

                                </div>
                                <div id="passport" class="col s12">
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
                                                        </td>
                                                    </tr>

                                                <?php }
                                            } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Popup passport details -->
                                    <div id="popupPassport" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Passport Details</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmPassportDetails"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                                          method="post">

                                                        <div class="clearfix"></div>
                                                        <input id="login_id" name="login_id" type="hidden"
                                                               value="<?php if (!empty($row)) {
                                                                   echo $row['inquiry_id'];
                                                               } else {
                                                                   echo "0";
                                                               } ?>">

                                                        <div class="row">
                                                            <div class="input-field col s6">
                                                                <input id="passport_id" name="passport_id" type="hidden"
                                                                       value="0">
                                                                <input id="passport_number" name="passport_number"
                                                                       type="text"
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
                                                                    <input id="passport_name" name="passport_name"
                                                                           type="text"
                                                                           class="validate"
                                                                           value="">
                                                                    <label for="passport_name">Enter Name on
                                                                        Passport</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="input-field col s12">
                                                                <div class="input-field col s4">
                                                                    <label for="passport_lost">Lost or Stolen
                                                                        Passport</label>
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
                                                                <div class="input-field col s4 details_div"
                                                                     style="display: none;">
                                                                    <input id="passport_details" name="passport_details"
                                                                           type="text"
                                                                           class="validate"
                                                                           value="">
                                                                    <label for="passport_details">Details</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="col-lg-6"></div>
                                                            <div class="col-lg-6 text-right">
                                                                <div class="form-group">
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           value="SAVE">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" id="btnPassportClose"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <button type="button" class="btn btn-info btn-lg" id="popupPassportOpen"
                                            style="display: none;" data-toggle="modal" data-target="#popupPassport">Open
                                        Modal
                                    </button>
                                </div>
                                <div id="employment" class="col s12">
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
                                                        </td>
                                                    </tr>

                                                <?php }
                                            } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="clearfix"></div>
                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal"
                                            data-target="#popupEmp" id="btnEmpOpen" style="display: none;">Open Modal
                                    </button>
                                    <!-- Modal -->
                                    <div id="popupEmp" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Employment Data</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmExperiance"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                                          method="post">
                                                        <div class="row">
                                                            <div class="input-field col s12">
                                                                <div class="input-field col s6">
                                                                    <div class="form-group">

                                                                        <input class="with-gap selft_employee"
                                                                               name="selft_employee"
                                                                               type="radio" checked
                                                                               id="selft_employee_yes"
                                                                               value="1"/>
                                                                        <label for="selft_employee_yes">Employee</label>

                                                                        <input class="with-gap selft_employee"
                                                                               name="selft_employee"
                                                                               type="radio" id="selft_employee_no"
                                                                               value="0"/>
                                                                        <label for="selft_employee_no">Self
                                                                            Employee</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="input-field col s6">

                                                                <input id="exp_id" name="exp_id" type="hidden"
                                                                       value="0">

                                                                <input id="name_of_cmp" name="name_of_cmp" type="text"
                                                                       class="validate"
                                                                       value="">
                                                                <label for="first_name">Employee Name</label>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <div class="input-field col s2">
                                                                    <label for="Business Type">Business Type</label>
                                                                </div>
                                                                <div class="input-field col s10">
                                                                    <select name="business_name"
                                                                            class="form-control validate"
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
                                                                    <input type="hidden" id="expr_country_hidden"
                                                                           value="0">
                                                                    <select name="expr_country_id"
                                                                            class="form-control validate"
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
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <div class="input-field col s2">
                                                                    <label for="state_id">State</label>
                                                                </div>
                                                                <div class="input-field col s10">
                                                                    <select name="state_expr_id"
                                                                            class="form-control validate"
                                                                            id="state_expr_id"
                                                                            onchange="load_expr_city();">
                                                                        <option value="">---Select---</option>
                                                                    </select>
                                                                    <input type="text" name="other_expr_state"
                                                                           id="other_expr_state"
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
                                                                    <input type="hidden" id="city_expr_hidden"
                                                                           value="0">
                                                                    <select name="city_expr_id"
                                                                            class="form-control validate"
                                                                            id="city_expr_id"
                                                                            onchange="load_expr_city_other();">
                                                                        <option value="">---Select---</option>
                                                                    </select>
                                                                    <input type="text" name="other_expr_city"
                                                                           id="other_expr_city"
                                                                           placeholder="Other City name"
                                                                           style="margin:15px 0px;display:none;"
                                                                           class="form-control validate"
                                                                           value="">
                                                                </div>

                                                            </div>
                                                            <div class="input-field col s6">
                                                                <input id="pincode_number" name="pincode_number"
                                                                       type="text"
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
                                                                <input id="email_address" name="email_address"
                                                                       type="text"
                                                                       class="validate"
                                                                       value="">
                                                                <label for="email_address">Email Address</label>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <input id="website" name="website" type="text"
                                                                       class="validate"
                                                                       value="">
                                                                <label for="website">Website</label>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="input-field col s6">
                                                                <input id="mobile_number_1" name="mobile_number_1"
                                                                       type="text"
                                                                       class="validate"
                                                                       value="">
                                                                <label for="mobile_number_1">Mobile Number 1</label>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <input id="mobile_number_2" name="mobile_number_2"
                                                                       type="text"
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
                                                                <input id="designation" name="designations[]"
                                                                       type="text"
                                                                       class="validate"
                                                                       value="">
                                                                <label for="designation">Designation</label>
                                                            </div>
                                                            <div class="input-field col s4">
                                                                <input id="start_date" name="duration_start_date[]"
                                                                       type="text"
                                                                       class="validate"
                                                                       value="">
                                                                <label for="start_date">Start Date</label>
                                                            </div>
                                                            <div class="input-field col s4 end_date_div">
                                                                <input id="end_date" name="duration_end_date[]"
                                                                       type="text"
                                                                       class="validate"
                                                                       value="">
                                                                <label for="end_date">End Date</label>
                                                            </div>
                                                            <div class="addButton">
                                                                <a href="javascript:void(0);"
                                                                   class="m-t-20 btn btn-primary add-duration">More</a>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!--Load more designation-->
                                                            <div class="duration_data"></div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="col-lg-12 text-right">
                                                                <div class="form-group">
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           value="SAVE">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="btnEmpClose" class="btn btn-default"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div id="career" class="col s12">
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <label for="passport_lost">Career Overview</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <div class="form-group">
                                                <span id="c_overview"><?php if (!empty($reg_data)) {
                                                        echo $reg_data['career_overview'];
                                                    } ?></span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <a href="javascript:void()" data-toggle="modal" data-target="#popupCareer"
                                       class="waves-effect waves-light btn">
                                        EDIT
                                    </a>
                                    <!-- Modal -->
                                    <div id="popupCareer" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Career Overview</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmCareer"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
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
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           value="SAVE">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" id="btnCareerClose"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="cpd" class="col s12">

                                    <div class="row">
                                        <div class="input-field col s12">
                                            <div class="input-field col s2">
                                                <label for="test_type">Event</label>
                                            </div>
                                            <div class="input-field col s5">
                                                <span id="e_name">
                                                    <?php if (!empty($events)) {
                                                        $selected = "";
                                                        for ($c = 0; $c < count($events); $c++) {
                                                            if (!empty($event_data)) {
                                                                if ($event_data['master_id'] == $events[$c]['master_id']) {
                                                                    $selected = 'selected="selected"';

                                                                    echo ucfirst($events[$c]['name']);
                                                                }
                                                            }
                                                        }
                                                    } ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="input-field col s2">
                                            <label for="test_type">Start Date</label>
                                        </div>
                                        <div class="input-field col s5">
                                                <span id="s_date">
                                                   <?php if (!empty($event_data)) {
                                                       if ($event_data['start_date'] != "1970-01-01" && $event_data['start_date'] != "0000-00-00") {
                                                           echo date("d/m/Y", strtotime($event_data['start_date']));
                                                       }
                                                   } ?>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s2">
                                            <label for="test_type">End Date</label>
                                        </div>
                                        <div class="input-field col s5">
                                                <span id="e_date">
                                                   <?php if (!empty($event_data)) {
                                                       if ($event_data['end_date'] != "1970-01-01" && $event_data['end_date'] != "0000-00-00") {
                                                           echo date("d/m/Y", strtotime($event_data['end_date']));
                                                       }
                                                   } ?>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s2">
                                            <label for="test_type">Duration</label>
                                        </div>
                                        <div class="input-field col s5">
                                                <span id="total_duration">
                                                   <?php if (!empty($event_data)) {
                                                       echo $event_data['duration'];
                                                   } ?>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="input-field col s2">
                                            <label for="test_type">Topic</label>
                                        </div>
                                        <div class="input-field col s5">
                                                <span id="title_name">
                                                   <?php if (!empty($event_data)) {
                                                       echo $event_data['title'];
                                                   } ?>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s2">
                                            <label for="test_type">Place</label>
                                        </div>
                                        <div class="input-field col s5">
                                                <span id="place_name">
                                                   <?php if (!empty($event_data)) {
                                                       echo $event_data['place'];
                                                   } ?>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <a href="javascript:void()" data-toggle="modal" data-target="#popupCpd"
                                       class="waves-effect waves-light btn">
                                        EDIT
                                    </a>
                                    <div id="popupCpd" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">CPD Details</h4>
                                                </div>
                                                <div class="modal-body">
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
                                                                    <select name="master_id"
                                                                            class="form-control validate"
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

                                                                <div class="input-field col s4 other_event"
                                                                     style="display: none;">
                                                                    <input id="other_event_name" name="other_event_name"
                                                                           type="text"
                                                                           class="validate">
                                                                    <label for="event_data">Event Name</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="input-field col s4">
                                                                <input id="start_held_on" name="start_held_on"
                                                                       type="text"
                                                                       onchange="CalculateDiff();"
                                                                       onblur="CalculateDiff();"
                                                                       class="validate"
                                                                       value="<?php if (!empty($event_data)) {
                                                                           if ($event_data['start_date'] != "1970-01-01" && $event_data['start_date'] != "0000-00-00") {
                                                                               echo date("d/m/Y", strtotime($event_data['start_date']));
                                                                           }
                                                                       } ?>">
                                                                <label for="proficiency_date">Start Date</label>
                                                            </div>
                                                            <div class="input-field col s4">
                                                                <input id="end_held_on" name="end_held_on"
                                                                       onchange="CalculateDiff();"
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
                                                                <input id="duration" name="duration" type="text"
                                                                       class="validate"
                                                                       value="<?php if (!empty($event_data)) {
                                                                           echo $event_data['duration'];
                                                                       } ?>">
                                                                <label for="duration">Duration</label>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="input-field col s6">
                                                                <input id="title" name="title" type="text"
                                                                       class="validate"
                                                                       value="<?php if (!empty($event_data)) {
                                                                           echo $event_data['title'];
                                                                       } ?>">
                                                                <label for="title">Topic</label>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <input id="place" name="place" type="text"
                                                                       class="validate"
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
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           value="SAVE">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" id="btnCpdClose"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div id="technicalskill" class="col s12">
                                    <div class="row tech-var-div">

                                        <div class="input-field col s2">
                                            <label for="technical_skill">Technical Skill</label>
                                        </div>
                                        <div class="input-field col s8">
                                            <p id="tech-list">
                                                <?php
                                                if ($reg_data['technical_skill'] != "") {
                                                    $techSkill = explode(",", $reg_data['technical_skill']);
                                                    foreach ($techSkill as $val) {
                                                        if ($val != "") {
                                                            echo $val . "<br />";
                                                        }
                                                    }

                                                }
                                                ?></p>

                                        </div>

                                    </div>

                                    <div class="clearfix"></div>
                                    <a href="javascript:void()" data-toggle="modal" data-target="#popupTexh"
                                       class="waves-effect waves-light btn">
                                        EDIT
                                    </a>
                                    <div id="popupTexh" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Technical Skill</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmTechnical"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
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
                                                                            <input id="technical_skill"
                                                                                   name="technical_skill[]"
                                                                                   type="text"
                                                                                   class=""
                                                                                   value="<?php echo $val; ?>"
                                                                                   placeholder="Technical Skill">
                                                                            <?php
                                                                        }
                                                                    }

                                                                } else {
                                                                    ?>
                                                                    <input id="technical_skill" name="technical_skill[]"
                                                                           type="text"
                                                                           class=""
                                                                           value="" placeholder="Technical Skill">
                                                                    <input id="technical_skill" name="technical_skill[]"
                                                                           type="text"
                                                                           class=""
                                                                           value="" placeholder="Technical Skill">
                                                                    <input id="technical_skill" name="technical_skill[]"
                                                                           type="text"
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
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           name="btn_tech_next" value="SAVE">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" id="btnTechClose"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div id="personal_skill" class="col s12">
                                    <div class="input-field col s2">
                                        <label for="personal_skill">Personal Skill</label>
                                    </div>
                                    <div class="input-field col s10">
                                        <p id="personalList">
                                            <?php
                                            if ($reg_data['personal_skill'] != "") {
                                                $personal_skill = explode(",", $reg_data['personal_skill']);
                                                foreach ($personal_skill as $val) {
                                                    if ($val != "") {
                                                        echo $val . "<br />";
                                                    }
                                                }
                                            }
                                            ?>
                                        </p>
                                    </div>

                                    <div class="clearfix"></div>
                                    <a href="javascript:void()" data-toggle="modal" data-target="#popupPersonal"
                                       class="waves-effect waves-light btn">
                                        EDIT
                                    </a>
                                    <div id="popupPersonal" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Personal Skill</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmClientPersonal"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
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
                                                                            <input id="personal_skill"
                                                                                   name="personal_skill[]"
                                                                                   type="text"
                                                                                   class=""
                                                                                   value="<?php echo $val; ?>"
                                                                                   placeholder="Personal Skill">
                                                                            <?php
                                                                        }
                                                                    }

                                                                } else {
                                                                    ?>
                                                                    <input id="personal_skill" name="personal_skill[]"
                                                                           type="text"
                                                                           class=""
                                                                           value="" placeholder="Personal Skill">
                                                                    <input id="personal_skill" name="personal_skill[]"
                                                                           type="text"
                                                                           class=""
                                                                           value="" placeholder="Personal Skill">
                                                                    <input id="personal_skill" name="personal_skill[]"
                                                                           type="text"
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
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           name="btn_tech_next" value="SAVE">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" id="btnPersonalClose"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="archevements" class="col s12">
                                    <div class="input-field col s2">
                                        <label for="personal_skill">Achiements</label>
                                    </div>
                                    <div class="input-field col s10">
                                        <p id="arch-list">
                                            <?php
                                            if ($reg_data['achievement'] != "") {
                                                $achievement = explode(",", $reg_data['achievement']);
                                                foreach ($achievement as $val) {
                                                    if ($val != "") {
                                                        echo $val . " <br />";
                                                    }
                                                }
                                            }
                                            ?>
                                        </p>

                                    </div>

                                    <div class="clearfix"></div>
                                    <a href="javascript:void()" data-toggle="modal" data-target="#popupArchieve"
                                       class="waves-effect waves-light btn">
                                        EDIT
                                    </a>
                                    <div id="popupArchieve" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Achievement Skill</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmAchiement"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
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
                                                                    <input id="achievement" name="achievement[]"
                                                                           type="text"
                                                                           class=""
                                                                           value="" placeholder="Achiement Skill">
                                                                    <input id="achievement" name="achievement[]"
                                                                           type="text"
                                                                           class=""
                                                                           value="" placeholder="Achiement Skill">
                                                                    <input id="achievement" name="achievement[]"
                                                                           type="text"
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
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           name="btn_ach_next" value="SAVE">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" id="btnAchiClose"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div id="familly" class="col s12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover"
                                               id="relativeTableClient">
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
                                            <?php if (count($relative_data_client)) {

                                                for ($i = 0; $i < count($relative_data_client); $i++) {

                                                    $cond = "master_id =:master_id";
                                                    $params = array(":master_id" => $relative_data_client[$i]['master_id']);
                                                    $raltionName = $obj->fetchRow('masters_list', $cond, $params);

                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td width="200"><?php echo ucfirst($relative_data_client[$i]['applicant_name']); ?></td>
                                                        <td width="250"><?php echo $raltionName['name']; ?></td>
                                                        <td width="250"><?php echo $relative_data_client[$i]['address']; ?></td>
                                                        <td width="250"><?php echo date("d/m/Y", strtotime($relative_data_client[$i]['date_of_birth'])); ?></td>
                                                        <td width="180">
                                                            <a href="javascript:void(0);"
                                                               data-id="<?php echo $relative_data_client[$i]['family_id']; ?>"
                                                               class="update"
                                                               onclick="editRelativeClient('<?php echo $relative_data_client[$i]['family_id']; ?>');"><i
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
                                    <!-- Family popup -->
                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal"
                                            id="btnFamilyOpen" data-target="#popupFamily" style="display:none;">Open
                                        Modal
                                    </button>

                                    <!-- Modal -->
                                    <div id="popupFamily" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Family Details</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmRelaiveClient"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                                          method="post">
                                                        <input id="client_relation_id" name="relation_id" type="hidden"
                                                               value="0">

                                                        <div id="relative_in_ausi">
                                                            <div class="row">
                                                                <div class="input-field col s6">

                                                                    <input id="family_id" name="family_id" type="hidden"
                                                                           value="0">

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
                                                                        <select name="relationship"
                                                                                class="form-control validate"
                                                                                id="relationship_client">
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
                                                            <div class="row" id="marriage_date_div"
                                                                 style="display: none;">
                                                                <div class="input-field col s6">
                                                                    <input id="marriage_date" name="marriage_date"
                                                                           type="text"
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
                                                                    <input id="reta_address1_client"
                                                                           name="familyAddress[]" type="text"
                                                                           class="validate"
                                                                           value="" placeholder="Address Line No 1">
                                                                    <input id="reta_address2_client"
                                                                           name="familyAddress[]" type="text"
                                                                           class="validate"
                                                                           value="" placeholder="Address Line No 2">
                                                                    <input id="reta_address3_client"
                                                                           name="familyAddress[]" type="text"
                                                                           class="validate"
                                                                           value="" placeholder="Address Line No 3">
                                                                </div>

                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="row">
                                                                <div class="input-field col s6">
                                                                    <input id="date_of_birth_client"
                                                                           name="date_of_birth" type="text"
                                                                           class="validate"
                                                                           value="">
                                                                    <label for="date_of_birth_client">Date of
                                                                        Birth</label>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="row">
                                                                <div class="input-field col s12">
                                                                    <div class="input-field col s4">
                                                                        <label for="migrate_with_client">Migration with
                                                                            client</label>
                                                                    </div>
                                                                    <div class="input-field col s4">
                                                                        <div class="form-group">
                                                                            <input class="with-gap migrate_with_client"
                                                                                   name="migrate_with_client"
                                                                                   type="radio"
                                                                                   id="migrate_with_client_yes"
                                                                                   value="1"/>
                                                                            <label for="migrate_with_client_yes">Yes</label>

                                                                            <input class="with-gap migrate_with_client"
                                                                                   name="migrate_with_client"
                                                                                   type="radio"
                                                                                   id="migrate_with_client_no"
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
                                                                        <label for="family_passport_number">Passport
                                                                            Number</label>
                                                                    </div>

                                                                </div>
                                                                <div class="clearfix"></div>
                                                                <div class="row">
                                                                    <div class="input-field col s6">
                                                                        <input id="family_passport_issue_date"
                                                                               name="family_passport_issue_date[]"
                                                                               type="text" class="validate"
                                                                               value="">
                                                                        <label for="family_passport_issue_date">Passport
                                                                            Issue
                                                                            Date</label>
                                                                    </div>
                                                                    <div class="input-field col s6">
                                                                        <input id="family_passport_expire_date"
                                                                               name="family_passport_expire_date[]"
                                                                               type="text"
                                                                               class="validate"
                                                                               value="">
                                                                        <label for="family_passport_expire_date">Passport
                                                                            Expiry
                                                                            Date</label>
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                                <div class="clearfix"></div>

                                                                <div class="more_details"></div>
                                                                <div class="clearfix"></div>
                                                                <div class="addButton">
                                                                    <a href="javascript:void(0);"
                                                                       class="m-t-20 btn btn-primary add-passport">More</a>
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
                                                                        <input id="family_name" name="family_name"
                                                                               type="text"
                                                                               class="validate">
                                                                        <label for="family_name">Family Name</label>
                                                                    </div>
                                                                    <div class="input-field col s4">
                                                                        <input id="given_name" name="given_name"
                                                                               type="text"
                                                                               class="validate">
                                                                        <label for="family_name">Given Name</label>
                                                                    </div>
                                                                    <div class="input-field col s4">
                                                                        <div class="input-field col s4">
                                                                            <label for="reason_for_change">Reason For
                                                                                Change</label>
                                                                        </div>
                                                                        <div class="input-field col s7">
                                                                            <select name="reason_for_change"
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
                                                                                <option value="0">Other</option>
                                                                            </select>
                                                                            <input type="text" name="other_reason"
                                                                                   id="other_reason"
                                                                                   placeholder="Other Reason"
                                                                                   style="margin:15px 0px;display:none;"
                                                                                   class="form-control validate"
                                                                                   value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                                <div class="addButton">
                                                                </div>
                                                                <!--Load popup modal for add more other details-->
                                                                <div id="popupOtherDetails" class="modal fade"
                                                                     role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <!-- Modal content-->
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close"
                                                                                        data-dismiss="modal">&times;
                                                                                </button>
                                                                                <h4 class="modal-title">Other
                                                                                    Details</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="more_other_details"></div>
                                                                                <div class="clearfix"></div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a href="javascript:void(0);"
                                                                                   class="m-t-20 btn btn-primary add-other-details">More</a>
                                                                                <button type="button"
                                                                                        class="btn btn-default"
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
                                                                    <input type="submit"
                                                                           class="waves-effect waves-light btn"
                                                                           value="SAVE">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" id="btnFamilyClose"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div id="meeting" class="col s12">
                                    <span id="meeting-list">
                                    <?php if (count($meetings)) {

                                        for ($i = 0; $i < count($meetings); $i++) {
                                            $client_question = json_decode($meetings[$i]['client_question']);
                                            foreach ($client_question as $key => $val) {
                                                if ($key != "") {

                                                    ?>
                                                    <div class="row">

                                                        <div class="input-field col s2">
                                                            <label for="personal_skill">Client Question</label>
                                                        </div>
                                                        <div class="input-field col s10 pr-v-div">
                                                            <?php echo $key; ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="input-field col s2">
                                                            <label for="personal_skill">UBP Answer</label>
                                                        </div>
                                                        <div class="input-field col s10 pr-v-div">
                                                            <?php echo $val; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                    }

                                    ?>
                                        </span>
                                    <a style="display: none;" href="javascript:void(0)" id="btnMeetingOpen"
                                       data-toggle="modal" data-target="#popupMeeting"
                                       class="waves-effect waves-light btn">
                                        EDIT
                                    </a>
                                    <a href="javascript:void(0)" onclick="editMeeting();"
                                       class="waves-effect waves-light btn">
                                        EDIT
                                    </a>

                                    <div id="popupMeeting" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Meeting Details</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="frmMeeting"
                                                          class="wizard clearfix fv-form fv-form-bootstrap"
                                                          method="post">
                                                        <span id="ubp_meeting_">
                                                        <div class="row">
                                                            <div class="input-field col s2">
                                                                <label for="personal_skill">Client Question</label>
                                                            </div>
                                                            <div class="input-field col s10 pr-v-div">
                                                                <input id="client_question" name="client_question[]"
                                                                       type="text"
                                                                       class=""
                                                                       value="" placeholder="Client Question">
                                                            </div>
                                                        </div>
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
                                                        </span>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="col-lg-3"></div>
                                                            <div class="col-lg-9 text-right">
                                                                <div class="form-group">
                                                                    <!--<a class="waves-effect waves-light btn"
                                                                       id="btn_meeting_next_quetion">
                                                                        NEXT
                                                                    </a>-->
                                                                    <a id="btn_meeting_save_form"
                                                                       class="waves-effect waves-light btn">SAVE</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="btn_meeting_close" class="btn btn-default"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

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
                            <div class=" col s6">
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
<!--Registration form-->
<button type="button" class="btn btn-info btn-lg" id="btn_reg_clk" data-toggle="modal" data-target="#reg_passport"
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

        $('#relativeTableClient').DataTable({
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

    $(".reg_btn_pop").click(function () {
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

    $('#frmRelaive').on('change', '.relative_have_au', function (e) {

        var relative_have_au = $(this).val();
        $("#relative_in_ausi").hide();

        if (relative_have_au == 1) {
            $("#relative_in_ausi").show();
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

    $('#frmFollowup').on('click', '#btn_no_follow', function (e) {
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

        $('#date_of_birth_client').datetimepicker({
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

        $('#proficiency_date').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        $('#date_of_birth').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        $('#marriage_date').datetimepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            minView: 2
        });

        $('#date_of_follow').datetimepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            minView: 2
        });

        /*Personal detail added in database using ajax call*/
        $("#frmPersonal").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                first_name: "required",
            },
            messages: {
                first_name: "Please enter your first name",
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

                            var login_id = $("#login_id").val();

                            $.ajax({
                                type: "POST",
                                url: base_url + "get_personal_data?login_id=" + login_id,
                                dataType: "json",
                                success: function (response) {

                                    if (response.status == true) {

                                        $("#first_name").text(response.data.first_name);
                                        $("#last_name").text(response.data.last_name);
                                        $("#gender").text(response.data.gender);
                                        $("#date_of_birth_lbl").text(response.data.date_of_birth);
                                        $("#place_of_birth").text(response.data.place_of_birth);
                                        $("#address1").text(response.data.full_address);
                                        $("#country_name").text(response.data.country_name);
                                        $("#state_name").text(response.data.state_name);
                                        $("#city_name").text(response.data.city_name);
                                        $("#postalcode").text(response.data.postalcode);
                                        $("#email_address").text(response.data.email_address);
                                        $("#mobile_number").text(response.data.mobile_number);
                                        $("#phone_number").text(response.data.phone_number);
                                        $("#marital_status").text(response.data.marital_status);
                                        $("#btn_personal_close").click();

                                    } else if (response.status == false) {
                                        alert("Something went wrong...!");
                                        return false;
                                    }
                                }
                            });
                            $('html, body').animate({scrollTop: 0}, 1000);

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
            },
            messages: {
                name_of_degree: "Please enter your degree name",
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

                                    var link = '<a href="javascript:void(0);" data-id="' + response.data[i].education_id + '" class="update" onclick="editEdution(' + response.data[i].education_id + ');" ><i style="padding: 0px;font-size: 20px;" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';

                                    t.row.add([
                                        response.data[i].name_of_degree,
                                        response.data[i].name_of_center,
                                        response.data[i].passed_on,
                                        response.data[i].percentage,
                                        response.data[i].passed_class,
                                        link
                                    ]).draw(false);
                                    $("#btnEducationClose").click();
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

        $('#frmImmigration').on('change', '.visa_type_applied_', function (e) {

            var visa = $(this).val();
            $(".visa_div_").hide();
            $(".did_travel_").hide();
            $(".travel_date_").hide();

            $("#was_visa_type_no_").prop('checked', true);
            $("#did_travel_no_").prop('checked', true);

            if (visa == 1) {
                $(".visa_div_").show();
            }
        });

        $('#frmImmigration').on('change', '.was_visa_type_', function (e) {

            var visa_grant = $(this).val();
            $(".did_travel_").hide();
            $(".travel_date_").hide();

            if (visa_grant == 1) {
                $(".did_travel_").show();
            }
        });

        $('#frmImmigration').on('change', '.did_tralrl_rb_', function (e) {

            var did_travel = $(this).val();
            $(".travel_date_").hide();

            if (did_travel == 1) {
                $(".travel_date_").show();
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

                            $("#previous_assign_").text(response.data.previous_assign);
                            $("#remark_").text(response.data.remark);

                            if (response.data.visa_type_applied == 1) {
                                $("#visaGrant").text("Yes");
                                $("#visa_country").text(response.data.applied_country);

                                if (response.data.visa_granted == 1) {
                                    $("#visa_was").text("Yes");
                                    $("#visa_div").show();
                                    $("#did_travel").show();

                                    if (response.data.is_travel == 1) {
                                        $("#travel_").text("Yes");
                                        $("#travel_date").show();
                                        $("#f_date").text(response.data.from_date);
                                        $("#t_date").text(response.data.to_date);
                                    } else {
                                        $("#travel_date").hide();
                                        $("#travel_").text("No");
                                    }

                                } else {
                                    $("#did_travel").hide();
                                    $("#visa_was").text("No");
                                }

                            } else {
                                $("#visaGrant").text("No");
                                $("#visa_div").hide();
                                $("#did_travel").hide();
                            }


                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }

                        $("#btnImmClose").click();
                    }
                });

            }
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

                                    var link = '<a href="javascript:void(0);" data-id="' + response.data[i].relation_id + '" class="update" onclick="editRelative(' + response.data[i].relation_id + ');" ><i\n style="padding: 0px;font-size: 20px;"\n class="fa fa-pencil-square-o"\n aria-hidden="true"></i></a>';

                                    t.row.add([
                                        response.data[i].full_name_,
                                        response.data[i].since,
                                        response.data[i].relationship,
                                        response.data[i].relative_stete,
                                        response.data[i].relative_city,
                                        response.data[i].immigration_status,
                                        link
                                    ]).draw(false);

                                    $("#btn_relative_close").click();
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
            },
            messages: {
                immi_country_id: "Please enter your intersted country",
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

                            $("#in_country").text(response.data.interasted_country_id);
                            $("#int_visa").text(response.data.visa_type);
                            $("#btn_int_close").click();

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        $('#frmEnglish').on('change', '.applyed_for_', function (e) {

            var applyed_for = $(this).val();
            $(".applyed_for_div_").hide();

            if (applyed_for == 1) {
                $(".applyed_for_div_").show();
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

                            $('#exam_yes').text(response.data.applyed_for);
                            $('#test_type').text(response.data.test_type);
                            $('#listening_').text(response.data.listening);
                            $('#reading_').text(response.data.reading);
                            $('#writing_').text(response.data.writing);
                            $('#speaking_').text(response.data.speaking);
                            $('#proficiency_type_').text(response.data.proficiency_type);
                            $('#proficiency_date_').text(response.data.proficiency_date);
                            $("#btnEnglishClose").click();

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

                            $("#ref_name").text(response.data.ref_name);
                            $("#sub_name").text(response.data.sub_name);
                            $("#btn_ref_close").click();

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

                            window.location.href = "<?php echo HTTP_SERVER;?>inquirymanager";

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        $('#frmEducation').on('click', '#btn_edu_pre', function (e) {
            $("#tab_personal").click();
        });

        $('#frmEducation').on('click', '#btn_edu_next', function (e) {
            $("#tab_experiance").click();
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
                                        '\n' + 'aria-hidden="true"></i></a>';

                                    t.row.add([
                                        response.data[i].passport_number,
                                        response.data[i].passport_issue_date,
                                        response.data[i].passport_expire_date,
                                        link
                                    ]).draw(false);
                                }
                                $("#passport_id").val('0');
                                $("#btnPassportClose").click();
                            } else {
                                t.row.add([
                                    response.passport_number,
                                    response.passport_issue_date,
                                    response.passport_expire_date,
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
                            if (response.data.length > 0) {
                                var strList = "";
                                for (var i = 0; i < response.data.length; i++) {
                                    strList += response.data[i] + " <br /> ";
                                }
                            }

                            $("#tech-list").html(strList);

                            $("#btnTechClose").click();

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        /*Personal detail added in database using ajax call*/
        $("#frmClientPersonal").validate({
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
                    data: $("#frmClientPersonal").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            if (response.data.length > 0) {
                                var strList = "";
                                for (var i = 0; i < response.data.length; i++) {
                                    strList += response.data[i] + " <br /> ";
                                }
                            }

                            $("#personalList").html(strList);

                            $("#btnPersonalClose").click();

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

                            if (response.data.length > 0) {
                                var strList = "";
                                for (var i = 0; i < response.data.length; i++) {
                                    strList += response.data[i] + " <br /> ";
                                }
                            }

                            $("#arch-list").html(strList);

                            $("#btnAchiClose").click();

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

        $("#frmRelaiveClient").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                applicant_name: "required",
            },
            messages: {
                applicant_name: "Please enter applicant name",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {
                var inquiry_id = $("#login_id").val();
                var relation_id = $("#client_relation_id").val();
                $.ajax({
                    type: "POST",
                    url: base_url + "submit_family_data?inquiry_id=" + inquiry_id,
                    data: $("#frmRelaiveClient").serialize(),
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

                            $('#frmRelaiveClient .validate').val('');
                            $(".rev-passport").remove();

                            $("#migrate_with_client_yes").prop("checked", false);
                            $("#migrate_with_client_no").prop("checked", false);
                            $("#other_reason").hide();
                            $(".given_name").hide();
                            $(".family_name").hide();
                            $(".migrate_data").hide();
                            $("#other_names_yes").prop("checked", false);
                            $("#other_names_no").prop("checked", false);

                            var t = $('#relativeTableClient').DataTable();


                            if (relation_id != "" && relation_id > 0) {

                                $('#relativeTableClient').dataTable().fnClearTable();

                                var clk = "return confirm('Are you sure want to delete?');";

                                for (var i = 0; i < response.data.length; i++) {

                                    var link = '<a href="javascript:void(0);" data-id="' + response.data[i].family_id + '" class="update" onclick="editRelativeClient(' + response.data[i].family_id + ');" ><i\n style="padding: 0px;font-size: 20px;"\n class="fa fa-pencil-square-o"\n aria-hidden="true"></i></a>';

                                    t.row.add([
                                        response.data[i].applicant_name,
                                        response.data[i].relation,
                                        response.data[i].address,
                                        response.data[i].date_of_birth,
                                        link
                                    ]).draw(false);
                                }

                                $("#btnFamilyClose").click();

                            } else {
                                t.row.add([
                                    response.applicant_name,
                                    response.relation,
                                    response.address,
                                    response.date_of_birth,
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

        $('#frmRelaiveClient').on('change', '#relationship_client', function (e) {

            var relationship = $(this).val();

            $("#marriage_date_div").hide();

            if (relationship == 119) {
                $("#marriage_date_div").show();
            }
        });

        $('#frmRelaiveClient').on('change', '.migrate_with_client', function (e) {

            var migrate_with_client = $(this).val();
            $(".migrate_data").hide();

            if (migrate_with_client == 1) {
                $(".migrate_data").show();
            }
        });

        $('#frmRelaiveClient').on('change', '.other_names', function (e) {

            var other_names = $(this).val();
            $(".family_name").hide();
            $(".given_name").hide();

            if (other_names == "family") {
                $(".family_name").show();
            } else if (other_names == "given") {
                $(".given_name").show();
            }
        });

        var strAppend = '<div class="nrc"><input class="workTest validate" id="work_task" name="work_task[]" type="text"\n' +
            '                                                       class="validate"\n' +
            '                                                       value="" placeholder="Work Task"><i class=\"fa fa-trash-o remove-language\"></i></div>';
        $(document).on('click', '.add-language', function () {

            var totalLan = $('.var-div').find('.v-div').length;
            $('.remove-language').removeClass('hidden');
            $('.v-div').append(strAppend);
        });

        $(document).on('click', '.remove-language', function () {
            $(this).parent('.nrc').remove();
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

        $('#frmMeeting').on('click', '#btn_meeting_save_form', function (e) {
            var inquiry_id = $("#login_id").val();

            $.ajax({
                type: "POST",
                url: base_url + "update_meeting_data?inquiry_id=" + inquiry_id,
                data: $("#frmMeeting").serialize(),
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status == true) {
                        var strText = "";
                        $("#meeting-list").empty();
                        if (response.data.length > 0) {
                            for (var i = 0; i < response.data.length; i++) {
                                if (response.data[i].que != "") {
                                    strText += '<div class="row"><div class="input-field col s2"><label for="personal_skill">Client Question</label></div><div class="input-field col s10 pr-v-div">' + response.data[i].que + '</div></div><div class="row"><div class="input-field col s2"><label for="personal_skill">UBP Answer</label></div><div class="input-field col s10 pr-v-div">' + response.data[i].ans + '</div></div>';
                                }
                            }
                        }

                        $("#meeting-list").append(strText);
                        $("#btn_meeting_close").click();
                        $('html, body').animate({scrollTop: 0}, 1000);
                    } else if (response.status == false) {
                        alert("Something went wrong...!");
                        return false;
                    }
                }
            });
        });

        $('#frmMeeting').on('click', '#btn_meeting_next_quetion', function (e) {

            var strMeeting = '<div class="div-meeting"><div class="row"><div class="input-field col s2"><label for="personal_skill">Client Question</label></div><div class="input-field col s10 pr-v-div"><input id="client_question" name="client_question[]" type="text" class="" value="" placeholder="Client Question"></div></div><div class="clearfix"></div><div class="row"><div class="input-field col s2"><label for="personal_skill">UBP Answer</label></div><div class="input-field col s10 pr-v-div"><input id="ubp_answer" name="ubp_answer[]" type="text" class="ubp_answer" value="" placeholder="UBP Answer"></div></div><i class=\"fa fa-trash-o remove-meeting\"></i></div>';
            $('.remove-language').removeClass('hidden');
            $('.ubp_meeting').append(strMeeting);
        });

        $(document).on('click', '.remove-meeting', function () {
            $(this).parent('.div-meeting').remove();
        });

        $(document).on('click', '.remove-passport-div', function () {
            $(this).parent('.rev-passport').remove();
        });

        $("#frmExperiance").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                name_of_cmp: "required",
            },
            messages: {
                name_of_cmp: "Please enter your employee name",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
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

                            $("#other_expr_state").hide();
                            $("#other_expr_city").hide();

                            $('#frmExperiance .validate').val('');
                            $("#current_emp_yes").prop('checked', false);
                            $("#current_emp_no").prop('checked', false);
                            $(".nrc").remove();
                            $(".duration-skill").remove();

                            var t = $('#experienceTable').DataTable();

                            if (exp_id != "" && exp_id > 0) {

                                $('#experienceTable').dataTable().fnClearTable();

                                var clk = "return confirm('Are you sure want to delete?')";

                                for (var i = 0; i < response.data.length; i++) {

                                    var link = '<a href="javascript:void(0);" data-id="' + response.data[i].exp_id + '" class="update" onclick="editExperience(' + response.data[i].exp_id + ');" ><i\n style="padding: 0px;font-size: 20px;"\n class="fa fa-pencil-square-o"\n aria-hidden="true"></i></a>';

                                    t.row.add([
                                        response.data[i].name_of_cmp,
                                        response.data[i].designation,
                                        response.data[i].business_name,
                                        response.data[i].city_id,
                                        link
                                    ]).draw(false);
                                }
                                $("#exp_id").val('0');
                                $("#btnEmpClose").click();
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
                            $("#c_overview").text(response.data.career_overview);
                            $("#btnCareerClose").click();
                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

            }
        });

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

                            $("#event_id").text(response.id);
                            $("#e_name").text(response.data.e_name);
                            $("#s_date").text(response.data.start_date);
                            $("#e_date").text(response.data.end_date);
                            $("#total_duration").text(response.data.duration);
                            $("#title_name").text(response.data.title);
                            $("#place_name").text(response.data.place);
                            $("#btnCpdClose").click();


                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });

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
    });

    function editRelativeClient(id) {

        $("#client_relation_id").val(id);

        $.ajax({
            type: "POST",
            url: base_url + "get_family_data?relation_id=" + id,
            dataType: "json",
            success: function (response) {

                if (response.status == true) {

                    $("#applicant_name").val(response.applicant_name);
                    $("#relationship_client").val(response.relationship);
                    $("#relative_last_name").val(response.relative_last_name);
                    $("#reta_address1_client").val(response.reta_address1);
                    $("#reta_address2_client").val(response.reta_address2);
                    $("#reta_address3_client").val(response.reta_address3);
                    $("#date_of_birth_client").val(response.date_of_birth);
                    $(".migrate_data").hide();
                    $(".family_name").hide();
                    $(".given_name").hide();
                    $(".rev-passport").remove();
                    $("#marriage_date_div").hide();
                    if (response.relationship == 119) {
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

                        if (response.family_name != "") {
                            $(".family_name").show();
                            $("#other_names_yes").prop("checked", true);
                            $("#other_names_no").prop("checked", false);
                            $("#family_name").val(response.family_name);
                        }
                        if (response.other_names != "") {
                            $("#other_names_yes").prop("checked", false);
                            $("#other_names_no").prop("checked", true);
                            $(".given_name").show();
                            $("#given_name").val(response.given_name);


                        }

                        if (response.reason_for_change != "" && response.reason_for_change > 0) {
                            $("#reason_for_change").val(response.reason_for_change);
                        }

                    } else if (response.migrate_with_client == 0) {
                        $("#migrate_with_client_yes").prop("checked", false);
                        $("#migrate_with_client_no").prop("checked", true);
                    }


                    $("#immigration_status").val(response.immigration_status);
                    $("#relationship").val(response.relationship);

                    $("#btnFamilyOpen").click();

                } else if (response.status == false) {
                    alert("Something went wrong...!");
                    return false;
                }
            }
        });
    }

    function editMeeting() {

        var inquiry_id = $("#login_id").val();
        $.ajax({
            type: "POST",
            url: base_url + "get_meeting_data?inquiry_id=" + inquiry_id,
            dataType: "json",
            success: function (response) {

                if (response.status == true) {

                    var strText = "";
                    $("#ubp_meeting_").empty();
                    if (response.data.length > 0) {
                        for (var i = 0; i < response.data.length; i++) {
                            if (response.data[i].que != "") {
                                strText += '<div class="row">\n' +
                                    '                                                            <div class="input-field col s2">\n' +
                                    '                                                                <label for="personal_skill">Client Question</label>\n' +
                                    '                                                            </div>\n' +
                                    '                                                            <div class="input-field col s10 pr-v-div">\n' +
                                    '                                                                <input id="client_question" name="client_question[]"\n' +
                                    '                                                                       type="text"\n' +
                                    '                                                                       class=""\n' +
                                    '                                                                       value="' + response.data[i].que + '" placeholder="Client Question">\n' +
                                    '                                                            </div>\n' +
                                    '                                                        </div>\n' +
                                    '                                                        <div class="row">\n' +
                                    '                                                            <div class="input-field col s2">\n' +
                                    '                                                                <label for="personal_skill">UBP Answer</label>\n' +
                                    '                                                            </div>\n' +
                                    '                                                            <div class="input-field col s10 pr-v-div">\n' +
                                    '                                                                <input id="ubp_answer" name="ubp_answer[]" type="text"\n' +
                                    '                                                                       class="ubp_answer"\n' +
                                    '                                                                       value="' + response.data[i].ans + '" placeholder="UBP Answer">\n' +
                                    '                                                            </div>\n' +
                                    '                                                        </div>';
                            }
                        }
                    }

                    $("#ubp_meeting_").append(strText);
                    $("#btnMeetingOpen").click();

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

                $("#other_expr_state").hide();
                $("#other_expr_city").hide();

                if (response.status == true) {

                    $("#expr_country_hidden").val(response.country_id);

                    load_country(response.country_id);
                    load_expr_state(response.state_id);
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
                    $("#btnEmpOpen").click();
                } else if (response.status == false) {
                    alert("Something went wrong...!");
                    return false;
                }
            }
        });
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

                    $("#popupPassportOpen").click();

                } else if (response.status == false) {
                    alert("Something went wrong...!");
                    return false;
                }
            }
        });
    }

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
                    $("#btnpopupEducation").click();

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

                $("#relative_have_au_yes").prop('checked', true);
                $("#relative_have_au_no").prop('checked', false);
                $("#relative_in_ausi").show();
                $("#other_relative_city").hide();

                if (response.status == true) {

                    $("#relative_state_id").val(response.immigration_state);
                    $("#relative_city_id").val(response.immigration_city);

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
                    $("#btn_relative_popup").click();

                } else if (response.status == false) {
                    alert("Something went wrong...!");
                    return false;
                }
            }
        });
    }

    function load_state() {

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
    $(".applyed_for_div_").show();
    <?php

    }
    }

    if (!empty($immigration_arr)) {
    if ($immigration_arr['visa_type_applied'] == 1) {
    ?>
    $("#visa_type_yes").prop('checked', true);
    $(".visa_div").show();

    $("#visa_type_yes_").prop('checked', true);
    $(".visa_div_").show();

    <?php
    if ($immigration_arr['visa_granted'] == 1) {
    ?>
    $("#was_visa_type_yes").prop('checked', true);
    $(".did_travel").show();

    $("#was_visa_type_yes_").prop('checked', true);
    $(".did_travel_").show();

    <?php
    if ($immigration_arr['is_travel'] == 1) {
    ?>
    $("#did_travel_yes").prop('checked', true);
    $(".travel_date").show();

    $("#did_travel_yes_").prop('checked', true);
    $(".travel_date_").show();

    <?php

    } else {
    ?>
    $("#did_travel_no").prop('checked', true);
    $("#did_travel_no_").prop('checked', true);
    <?php

    }
    } else {
    ?>
    $("#was_visa_type_no").prop('checked', true);
    $("#was_visa_type_no_").prop('checked', true);
    <?php

    }
    } else {
    ?>
    $("#visa_type_no").prop('checked', true);
    $("#visa_type_no_").prop('checked', true);
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