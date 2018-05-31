<?php include_once '../include/header.php'; ?>
<?php

$client_id = 0;
$visa_id = 0;
$row = array();

if (isset($_GET['visa_id'])) {
    $visa_id = $_GET['visa_id'];
}

if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];
    $cond = "is_active =:active AND inquiry_id =:inquiry_id";
    $params = array(":active" => 1, "inquiry_id" => $client_id);
    $row = $obj->fetchRow('registration', $cond, $params);
}

$cond = "is_active =:active AND category_name =:category AND FIND_IN_SET(:find_string,other)";
$params = array(":active" => 1, ":category" => 'workcomplete', ":find_string" => $visa_id);
$works = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "is_active =:active";
$params = array(":active" => 1);
$status = $obj->fetchRowAll('client_file_staus', $cond, $params);

?>

<style>
    .waves-input-wrapper01 {
        margin-top: -80px;
    }

    .v_type li {
        line-height: 30px;
    }

    .work-p {
        font-size: 19px;
        margin-bottom: 10px !important;
    }

    .filled-in {
        position: inherit !important;
        margin-right: 10px !important;
        opacity: 1 !important;
    }
</style>
<div class="header">
    <h1 class="page-header pull-left"> File Status </h1>
    <div class="add-button"><a href="<?php echo HTTP_SERVER; ?>manageworkcomplete" class="btn-floating"><i
                    class="material-icons">add</i></a></div>
    <div class="clearfix"></div>
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li class="active">File Status</li>
    </ol>
</div>

<div id="page-inner">
    <div class="row">
        <div class="col-md-12">

            <?php if ($objsession->get('ads_message') != "") {
                ?>
                <div class="alert alert-success">
                    <?php echo $objsession->get('ads_message'); ?>
                </div>
                <?php $objsession->remove('ads_message');
            } ?>
            <?php if ($objsession->get('ads_message') != "") {
                ?>
                <div class="error-message"> <?php echo $objsession->get('ads_message'); ?> </div>
                <?php $objsession->remove('ads_message');
            } ?>

            <!-- Advanced Tables -->
            <div class="card">
                <div class="card-content">
                    <div class="table-responsive">

                        <form name="frmWorkComplete" id="frmWorkComplete" method="post">
                            <p class="work-p">
                                Status
                            </p>
                            <?php
                            if (!empty($works)) {
                                ?>
                                <ul class="v_type">
                                    <?php
                                    $selected = "";
                                    for ($i = 0; $i < count($works); $i++) {

                                        $cond = "is_active =:active AND FIND_IN_SET(:find_string,master_id) AND inquiry_id =:inquiry_id";
                                        $params = array(":active" => 1, ":find_string" => $works[$i]['master_id'], "inquiry_id" => $client_id);
                                        $workDone = $obj->fetchRow('workcomplete', $cond, $params);
                                        if (!empty($workDone)) {
                                            $selected = "checked";
                                        }
                                        ?>
                                        <li>
                                            <input <?php echo $selected; ?> class="filled-in" type="checkbox"
                                                                            id="master_id" name="master_id[]"
                                                                            value="<?php echo $works[$i]['master_id']; ?>">
                                            <?php echo $works[$i]['name']; ?>
                                        </li>
                                        <?php
                                        $selected = "";
                                    }
                                    ?>
                                </ul>
                                <?php
                            } else {
                                ?>
                                <p>Data not found</p>
                                <?php
                            }
                            ?>
                            <span id="work-msg"></span>
                            <div class="clearfix"></div>
                            <div class="col-md-6 col-sm-6" style="padding: 0px;">
                                <div class="col-lg-2" style="padding: 0px;">
                                    <div class="form-group">
                                        <label>Status :</label>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <select name="status" class="form-control" id="status">
                                            <option value="">---Select---</option>
                                            <?php if (!empty($status)) {
                                                $selected = "";
                                                for ($i=0;$i<count($status);$i++) {
                                                    if (!empty($row)) {
                                                        if ($row['status_id'] == $status[$i]['status_id']) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                    }
                                                    ?>
                                                    <option <?php echo $selected; ?>
                                                            value="<?php echo $status[$i]['status_id']; ?>">
                                                        <?php echo ucwords($status[$i]['status']); ?></option>
                                                    <?php $selected = '';
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <p><input type="submit" name="btn_update" value="Update"></p>
                        </form>
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>

    <?php

    if (isset($_GET['master_id'])) {
        $data = array('is_active' => 0);
        if ($obj->update($data, 'masters_list', array('master_id' => $_GET['master_id'])) == true) {
            $objsession->set('ads_message', 'Work Complete successfully deleted.');
            redirect(HTTP_SERVER . "workcomplete");
        }
    }

    if (isset($_POST['btn_update'])) {

        extract($_POST);
        $currentDate = date('Y-m-d');

        $masterId = "";
        if (!empty($master_id)) {
            $masterId = implode(",", $master_id);
        }

        $field = array('inquiry_id', "master_id", "created_date", "is_active");
        $value = array($client_id, $masterId, $currentDate, 1);
        $staus_array = array_combine($field, $value);

        $cond = "is_active =:active AND inquiry_id =:inquiry_id";
        $params = array(":active" => 1, "inquiry_id" => $client_id);
        $workDone = $obj->fetchRow('workcomplete', $cond, $params);
        if (!empty($workDone)) {

            $obj->update($staus_array, 'workcomplete', array('work_id' => $workDone['work_id']));

        } else {
            $obj->insert($staus_array, 'workcomplete');
        }

        $field = array('status_id');
        $value = array($status);
        $staus_array = array_combine($field, $value);
        $obj->update($staus_array, 'registration', array('inquiry_id' => $client_id));

        $objsession->set('ads_message', 'Status updated successfully.');

        redirect(HTTP_SERVER . "filestatus/" . $visa_id . '/' . $client_id);

    }

    ?>
    <?php include_once '../include/footer.php'; ?>
    <script>

        $(document).ready(function () {

            $("#frmWorkComplete").validate({
                debug: false,
                errorClass: "error",
                errorElement: "span",
                rules: {
                    "master_id[]": "required",
                },
                messages: {
                    "master_id[]": "Please select atleast one",
                },
                highlight: function (element, errorClass) {
                    $('input').removeClass('error');
                },
                errorPlacement: function (error, element) {

                    if (element.attr("name") == "master_id[]") {
                        error.insertAfter("#work-msg");
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>