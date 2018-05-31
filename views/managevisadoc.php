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

$cond = "is_active =:active AND category_name =:category ORDER BY name";
$params = array(":active" => 1, ":category" => 'Visa Type');
$visa_type = $obj->fetchRowAll('masters_list', $cond, $params);

$cond = "is_active =:active AND category_name =:category";
$params = array(":active" => 1, ":category" => 'Doctype');

$visaDoc = $obj->fetchRowAll('masters_list', $cond, $params);

?>
<style>
    .filled-in {
        position: inherit !important;
        margin-right:10px !important;
        opacity: 1 !important;
    }

</style>
<div class="header">
    <h1 class="page-header"> Visa Document </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li><a href="<?php echo HTTP_SERVER; ?>visadocument">List of Visa Document</a></li>
        <li class="active">Visa Document</li>
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

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Doc Types :</label>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <select name="doc_id" class="form-control" id="doc_id">
                                        <option value="">---Select---</option>
                                        <?php if (!empty($visaDoc)) {
                                            $selected = "";
                                            for ($c = 0; $c < count($visaDoc); $c++) {
                                                if (!empty($row)) {
                                                    if ($row['doc_id'] == $visaDoc[$c]['master_id']) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                }
                                                ?>
                                                <option <?php echo $selected; ?>
                                                        value="<?php echo $visaDoc[$c]['master_id']; ?>">
                                                    <?php echo ucfirst($visaDoc[$c]['name']); ?></option>
                                                <?php $selected = '';
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Visa Type :</label>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <ul>
                                    <?php
                                    if (!empty($visa_type)) {
                                        $chk = "";
                                        for($i=0;$i<count($visa_type);$i++) {
                                            if (!empty($row)) {
                                                $v_type = explode(",",$row['other']);
                                                if (in_array($visa_type[$i]['master_id'],$v_type)) {
                                                    $chk = 'checked';
                                                }
                                            }
                                    ?>
                                            <li><input <?php echo $chk;?> class="filled-in" type="checkbox" name="visa_type[]" value="<?php echo $visa_type[$i]['master_id'];?>"><?php echo $visa_type[$i]['name'];?></li>
                                    <?php
                                            $chk = "";
                                        }
                                    }
                                    ?>
                                    </ul>
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
                                    <a href="<?php echo HTTP_SERVER; ?>visadocument"
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
        $visa_type_id = "";
        if (!empty($visa_type)) {
            $visa_type_id = implode(",",$visa_type);
        }

        $field = array('name', 'doc_id','category_name', "other", "created_date", "is_active");
        $value = array($name, $doc_id,'visadocument', $visa_type_id, $currentDate, 1);

        $staus_array = array_combine($field, $value);
        $obj->insert($staus_array, 'masters_list');
        $objsession->set('ads_message', 'Visa Document added successfully.');

        redirect(HTTP_SERVER . "visadocument");
    }

    if (isset($_POST['btn_update'])) {

        extract($_POST);
        $currentDate = date('Y-m-d');

        $visa_type_id = "";
        if (!empty($visa_type)) {
            $visa_type_id = implode(",",$visa_type);
        }

        $field = array('name','doc_id', "other", "modify_date");
        $value = array($name, $doc_id,$visa_type_id, $currentDate);
        $staus_array = array_combine($field, $value);

        $obj->update($staus_array, 'masters_list', array('master_id' => $master_id));
        $objsession->set('ads_message', 'Visa Document updated successfully.');

        redirect(HTTP_SERVER . "visadocument");

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
                    name: "Please enter your visa codument",
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