<?php include_once '../include/header.php'; ?>
<?php
$cond = "is_active =:active AND is_register =:is_register ORDER BY inquiry_id DESC";
$params = array(":active" => 1, ':is_register' => 0);
$previousInquiry = $obj->fetchRowAll('inquiry_list', $cond, $params);

$cond = "category_name =:category_name AND is_active =:is_active AND doc_id =:doc_id ORDER BY indexs DESC";
$params = array(":category_name" => 'PaymentStage', ":is_active" => 1, ":doc_id" => 1);
$PaymentStage = $obj->fetchRowAll('masters_list', $cond, $params);

?>

<style>
    .filled-in {
        position: inherit !important;
        opacity: 1 !important;
    }

    .waves-input-wrapper01 {
        margin-top: -80px;
    }
</style>
<div class="header">
    <h1 class="page-header pull-left"> Inquiry Manager</h1>
    <div class="add-button">
        <a href="<?php echo HTTP_SERVER; ?>inquiry" class="btn-floating"><i class="material-icons">add</i></a>
    </div>
    <div class="clearfix"></div>
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li class="active">Inquiry Manager List</li>
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

                        <form id="masterFrm" method="post">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Inquiry No.</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <th>Date of Birth</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (count($previousInquiry)) {

                                    for ($i = 0; $i < count($previousInquiry); $i++) {

                                        $cond = "inquiry_id =:inquiry_id AND is_active =:is_active";
                                        $params = array(":inquiry_id" => $previousInquiry[$i]['inquiry_id'], ':is_active' => 0);
                                        $nofollow = $obj->fetchRow('follow_up', $cond, $params);
                                        $trCl = "";
                                        if (!empty($nofollow)) {
                                            $trCl = "style='color: #a94442;background-color: #f2dede;border-color: #ebccd1;'";
                                        }

                                        ?>
                                        <div class="modal fade" id="_delete<?php echo $i; ?>" tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel">

                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <p class="text-center"><strong>Are you 100% sure about
                                                                this?</strong></p>
                                                        <br/>
                                                        <div class="inputer">
                                                            <div class="input-wrapper text-center"><a
                                                                        href="<?php echo HTTP_SERVER; ?>inquirymanager/<?php echo $previousInquiry[$i]['inquiry_id']; ?>"
                                                                        class="btn btn-success reload">Yes</a>
                                                                <button type="button" class="btn btn-success reload"
                                                                        data-dismiss="modal" aria-label="Close">No
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <tr class="odd gradeX" <?php echo $trCl; ?>>
                                            <td width="250"><?php echo "#" . $previousInquiry[$i]['inquiry_id']; ?></td>
                                            <td width="200"><?php echo $previousInquiry[$i]['first_name'] . " " . $previousInquiry[$i]['middle_name'] . " " . $previousInquiry[$i]['last_name']; ?></td>
                                            <td width="250"><?php echo $previousInquiry[$i]['address1']; ?></td>
                                            <td width="250"><?php echo $previousInquiry[$i]['email_address']; ?></td>
                                            <td width="250"><?php echo $previousInquiry[$i]['mobile_number']; ?></td>
                                            <td width="250"><?php echo date("d-m-Y", strtotime($previousInquiry[$i]['date_of_birth'])); ?></td>
                                            <td width="180" class="text-center">
                                                <a href="<?php echo HTTP_SERVER; ?>inquiry/<?php echo $previousInquiry[$i]['inquiry_id']; ?>/tabs"><i
                                                            style="padding: 0px;font-size: 20px;"
                                                            class="fa fa-pencil-square-o"

                                                            aria-hidden="true"></i></a>
                                                <a href="#_delete<?php echo $i; ?>" data-toggle="modal"><i
                                                            style="padding: 0px;font-size: 20px;" class="fa fa-times"
                                                            aria-hidden="true"></i></a>

                                                <a href="<?php echo HTTP_SERVER; ?>viewinquiry/<?php echo $previousInquiry[$i]['inquiry_id']; ?>/tabs"><i
                                                            style="padding: 0px;font-size: 20px;" class="fa fa-eye"
                                                            aria-hidden="true"></i></a>
                                                <a href="javascript:void(0)" class="reg_btn_pop"
                                                   data-id="<?php echo $previousInquiry[$i]['inquiry_id']; ?>"><i
                                                            style="font-size: 20px;" class="fa fa-sign-in"
                                                            aria-hidden="true"></i></a>
                                            </td>
                                        </tr>

                                    <?php }
                                } ?>

                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>

    <button type="button" class="btn btn-info btn-lg" id="btn_reg_clk" data-toggle="modal" data-target="#reg_passport"
            style="display: none;">Open Modal
    </button>
    <!-- Modal -->
    <div id="reg_passport" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form id="reg_form" method="post">
                <input id="inquiry_id" name="inquiry_id" type="hidden" value="0">
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

    <?php

    if (isset($_GET['login_id'])) {
        $data = array('is_active' => 0);
        if ($obj->update($data, 'inquiry_list', array('inquiry_id' => $_GET['login_id'])) == true) {
            $objsession->set('ads_message', 'Inquery successfully deleted.');
            redirect(HTTP_SERVER . "inquirymanager");
        }
    }
    ?>
    <?php include_once '../include/footer.php'; ?>

    <script src="<?php echo HTTP_SERVER; ?>assets/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <link href="<?php echo HTTP_SERVER; ?>assets/css/bootstrap-datetimepicker.css" rel="Stylesheet"
          type="text/css"/>

    <script src="<?php echo HTTP_SERVER; ?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo HTTP_SERVER; ?>assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>

        $(document).ready(function () {
            var base_url = "<?php echo HTTP_SERVER; ?>";
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

            $('#dataTables-example').DataTable({
                "ordering": false,
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"}
                ],
            }).on('page.dt', function () {
                $('html, body').animate({
                    scrollTop: $(".page-header").offset().top
                }, 'slow');
            });

            $(".reg_btn_pop").click(function () {
                var id = $(this).data('id');
                if (id > 0) {
                    $("#inquiry_id").val(id);
                    $("#btn_reg_clk").click();
                }
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

                    var inquiry_id = $("#inquiry_id").val();

                    $.ajax({
                        type: "POST",
                        url: base_url + "submit_passport_data?inquiry_id=" + inquiry_id,
                        data: $("#reg_form").serialize(),
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            if (response.status == true) {

                                $("#btn_reg_btn_close").click();

                                var inquiry_id = $("#inquiry_id").val();

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

                    var inquiry_id = $("#inquiry_id").val();

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
        });
    </script>