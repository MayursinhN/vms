<?php include_once '../include/header.php'; ?>
<?php

$row = array();
$loginid = $objsession->get("log_admin_loginid");
$master_id = 0;

if (isset($_GET['master_id'])) {
    $cond = '';
    $master_id = $_GET['master_id'];
    $cond = "ref_id=:master_id";
    $params = array(":master_id" => $master_id);
    $row = $obj->fetchRow('referance_list', $cond, $params);
}

?>

<div class="header">
    <h1 class="page-header"> Manage Reference </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li><a href="<?php echo HTTP_SERVER; ?>references">List of Reference</a></li>
        <li class="active">Reference</li>
    </ol>
</div>
<div id="page-inner">
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="padding20">
                        <form name="frm_marital_status" method="post" id="frm_marital_status"
                              class="wizard clearfix fv-form fv-form-bootstrap">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Name :</label>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="ref_name" id="ref_name"
                                           value="<?php if (!empty($row)) {
                                               echo $row['ref_name'];
                                           } ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Address :</label>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <textarea name="address" class="materialize-textarea"
                                              id="other"><?php if (!empty($row)) {
                                            echo $row['address'];
                                        } ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Email :</label>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="ref_email" id="ref_email"
                                           value="<?php if (!empty($row)) {
                                               echo $row['ref_email'];
                                           } ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Mobile Number 1 :</label>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="ref_contact_number"
                                           id="ref_contact_number"
                                           value="<?php if (!empty($row)) {
                                               echo $row['ref_contact_number'];
                                           } ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Mobile Number 2 :</label>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="ref_number2" id="ref_number2"
                                           value="<?php if (!empty($row)) {
                                               echo $row['ref_number2'];
                                           } ?>">
                                </div>
                            </div>
                            <?php if (empty($row)) { ?>
                                <div class="clearfix"></div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Select Refery</label>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <input class="with-gap ref_select"
                                               name="ref_select"
                                               type="radio" id="ref_select_yes"
                                               value="0"/>
                                        <label for="ref_select_yes">Reference</label>

                                        <input class="with-gap ref_select"
                                               name="ref_select"
                                               type="radio" id="ref_select_no"
                                               value="1"/>
                                        <label for="ref_select_no">Sub Agent</label>
                                        <br/>
                                        <span id="ref_select_msg"></span>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <input type="hidden" name="ref_select" value="<?php echo $row['types']; ?>">
                            <?php } ?>
                            <div class="clearfix"></div>
                            <div style="display: none;" class="subagent" id="subagent_id">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Commission Rate:</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="commission" id="commission"
                                               value="<?php if (!empty($row)) {
                                                   echo $row['commission'];
                                               } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-lg-3"></div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <?php if (!empty($row)) { ?>
                                        <input type="submit" name="btn_update" class="waves-effect waves-light btn"
                                               value="SAVE">
                                    <?php } else { ?>
                                        <input type="submit" name="btn_add" class="waves-effect waves-light btn"
                                               value="SAVE">
                                    <?php } ?>
                                    <a href="<?php echo HTTP_SERVER; ?>references"
                                       class="waves-effect waves-light btn">CANCEL</a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <?php

    if (isset($_POST['btn_add'])) {

        extract($_POST);

        $currentDate = date('Y-m-d');

        $field = array('ref_name', 'ref_email', "address", "ref_contact_number", "ref_number2", "commission", "types", "is_active");
        $value = array($ref_name, $ref_email, $address, $ref_contact_number, $ref_number2, $commission, $ref_select, 1);

        $staus_array = array_combine($field, $value);
        $obj->insert($staus_array, 'referance_list');

        $objsession->set('ads_message', 'Reference added successfully.');
        redirect(HTTP_SERVER . "references");

    }

    if (isset($_POST['btn_update'])) {

        extract($_POST);
        $currentDate = date('Y-m-d');

        $field = array('ref_name', 'ref_email', "address", "ref_contact_number", "ref_number2", "commission", "types", "is_active");
        $value = array($ref_name, $ref_email, $address, $ref_contact_number, $ref_number2, $commission, $ref_select, 1);
        $staus_array = array_combine($field, $value);

        $obj->update($staus_array, 'referance_list', array('ref_id' => $master_id));
        $objsession->set('ads_message', 'Reference updated successfully.');
        
        redirect(HTTP_SERVER . "references");
    }

    ?>
    <?php include_once '../include/footer.php'; ?>

    <script>
        $(document).ready(function () {

            $('#frm_marital_status').on('change', '.ref_select', function (e) {

                var visa = $(this).val();
                $("#subagent_id").hide();

                if (visa == 1) {
                    $("#subagent_id").show();
                }
            });

            $("#frm_marital_status").validate({
                debug: false,
                errorClass: "error",
                errorElement: "span",
                rules: {
                    ref_name: "required",
                    ref_contact_number: "required",
                    ref_select: "required"
                },
                messages: {
                    ref_name: "Please enter your reference title",
                    ref_contact_number: "Please enter your mobile number",
                    ref_select: "Please select your reference"
                },
                highlight: function (element, errorClass) {
                    $('input').removeClass('error');
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "ref_select") {
                        error.insertAfter("#ref_select_msg");
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

            <?php if(!empty($row)) { if(($row['types'])) { ?>
            $("#subagent_id").show();
            <?php } } ?>
        });
    </script>