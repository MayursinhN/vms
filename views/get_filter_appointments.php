<?php
include_once '../common/config.php';

extract($_GET);

$loginid = $objsession->get("log_admin_loginid");

if ($_GET) {

    if ($appo_id == 1) {
        $cond = "is_active =:active AND is_open =:is_open AND appo_date_time >=:appo_date_time";
        $params = array(":active" => 1, ":is_open" => 1, ":appo_date_time" => date("Y-m-d H:i"));
    } else if ($appo_id == 0 && $appo_id != "All") {
        $cond = "is_active =:active AND is_open =:is_open";
        $params = array(":active" => 1, ":is_open" => 0);
    } else if ($appo_id == 2) {
        $cond = "is_active =:active AND is_open =:is_open";
        $params = array(":active" => 1, ":is_open" => 2);
    } else if ($appo_id == 3) {
        $cond = "is_active =:active AND is_open =:is_open AND appo_date_time <=:appo_date_time";
        $params = array(":active" => 1, ":is_open" => 1, ":appo_date_time" => date("Y-m-d H:i"));
    } else if ($appo_id === "All") {
        $cond = "is_active =:active";
        $params = array(":active" => 1);
    }

    $cond .= "  ORDER BY appo_date_time DESC";

    /* if ($objsession->get('log_admin_type') != 'admin') {
         $cond .= " AND appo_with =:created_by ORDER BY app_id DESC";
         $params[':created_by'] = $loginid;
     }*/

    $appoinments = array();
    $appoinments = $obj->fetchRowAll('appoinments', $cond, $params);

    if (count($appoinments)) {
        $ex_appointment = 0;
        $today = date("Y-m-d H:i");

        for ($i = 0; $i < count($appoinments); $i++) {

            $cond = "login_id =:master_id";
            $params = array(":master_id" => $appoinments[$i]['appo_with']);

            $app_with = $obj->fetchRow('users', $cond, $params);

            $appDate = $appoinments[$i]['appo_date_time'];
            $appoinments[$i]['app_with'] = $app_with['full_name'];
            $appoinments[$i]['appo_date'] = date("d/m/Y", strtotime($appoinments[$i]['appo_date_time']));
            $appoinments[$i]['appo_time'] = date("H:i", strtotime($appoinments[$i]['appo_date_time']));

            if (strtotime($today) > strtotime($appDate) && $appoinments[$i]['is_open'] == 1) {
                $ex_appointment = 1;
            }

            $click = "click";

            if ($ex_appointment == 1) {
                $appo_status = "Expired";
                $cls = "progress-bar-danger change_app_status";
            } else {
                if ($appoinments[$i]['is_open'] == 1) {
                    $appo_status = "Open";
                    $cls = "progress-bar-warning change_app_status";
                    $click = "---";
                } else if ($appoinments[$i]['is_open'] == 0) {
                    $appo_status = "Cancel";
                    $cls = "progress-bar-danger change_app_status";
                } else if ($appoinments[$i]['is_open'] == 2) {
                    $appo_status = "Attended";
                    $cls = "progress-bar-success change_app_status";
                }
            }

            $link = '<a href="javascript:void(0)" style="color: #FFF;padding: 4px;"
                                                   class="' . $cls . '"
                                                   data-id="' . $appoinments[$i]['app_id'] . '">' . $appo_status . '</a>';


            $cls = "";
            if ($ex_appointment == 1) {
                $appo_status = "Expired";
                $cls = "re_appointment";
            } else {
                if ($appoinments[$i]['is_open'] == 0) {
                    $appo_status = "Cancel";
                    $cls = "re_appointment";
                } else if ($appoinments[$i]['is_open'] == 2) {
                    $appo_status = "Attended";
                    $cls = "re_appointment";
                }
            }

            $link01 = '<a style="text-decoration: none;" href="javascript:void(0)" class="' . $cls . '"
                                                   data-id="' . $appoinments[$i]['app_id'] . '" data-title="' . $appoinments[$i]['appo_with'] . '">..</a>';

            $appoinments[$i]['status'] = $link;
            $appoinments[$i]['reApp'] = $link01;
            $ex_appointment = 0;

        }
    }

    echo json_encode(array('status' => true, 'data' => $appoinments));

}

?>