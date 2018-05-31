<?php include_once '../include/header.php'; ?>
<?php

$row = array();
$loginid = $objsession->get("log_admin_loginid");
$master_id = 0;

if (isset($_GET['master_id'])) {
    $cond = '';
    $master_id = $_GET['master_id'];
    $cond = "master_id=:master_id";
    $params = array(":master_id" => $master_id);
    $row = $obj->fetchRow('masters_list', $cond, $params);
}

?>

<div class="header">
    <h1 class="page-header"> Manage Currency Type </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li><a href="<?php echo HTTP_SERVER; ?>currency">List of Currency Type</a></li>
        <li class="active">Currency Type</li>
    </ol>
</div>
<div id="page-inner">
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col-lg-9">
                    <div class="padding20">
                        <form name="frm_marital_status" method="post" id="frm_marital_status"
                              class="wizard clearfix fv-form fv-form-bootstrap">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Title :</label>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="<?php if (!empty($row)) {
                                               echo $row['name'];
                                           } ?>">
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
                                    <a href="<?php echo HTTP_SERVER; ?>business"
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

        $field = array('name', 'category_name', "other", "created_date", "is_active");
        $value = array($name, 'Currency', "", $currentDate, 1);

        $staus_array = array_combine($field, $value);
        $obj->insert($staus_array, 'masters_list');
        $objsession->set('ads_message', 'Currency type added successfully.');

        redirect(HTTP_SERVER . "currency");
    }

    if (isset($_POST['btn_update'])) {

        extract($_POST);
        $currentDate = date('Y-m-d');

        $field = array('name', "other", "modify_date");
        $value = array($name, "", $currentDate);
        $staus_array = array_combine($field, $value);

        $obj->update($staus_array, 'masters_list', array('master_id' => $master_id));
        $objsession->set('ads_message', 'Currency type updated successfully.');

        redirect(HTTP_SERVER . "currency");

    }

    ?>
    <?php include_once '../include/footer.php'; ?>

    <script>
        $(document).ready(function () {

            $("#frm_marital_status").validate({
                debug: false,
                errorClass: "error",
                errorElement: "span",
                rules: {
                    name: "required",
                },
                messages: {
                    name: "Please enter your currency title",
                },
                highlight: function (element, errorClass) {
                    $('input').removeClass('error');
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>