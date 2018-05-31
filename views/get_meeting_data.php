<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "inquiry_id=:inquiry_id";
    $params = array(":inquiry_id" => $inquiry_id);
    $meetings = $obj->fetchRowAll('meetings', $cond, $params);
    $aaData = array();

    if (count($meetings)) {
        $cnt = 0;
        for ($i = 0; $i < count($meetings); $i++) {
            $client_question = json_decode($meetings[$i]['client_question']);
            if (!empty($client_question)) {
                foreach ($client_question as $key => $val) {
                    if ($key != "") {
                        $aaData[$cnt]['que'] = $key;
                        $aaData[$cnt]['ans'] = $val;
                        $cnt++;
                    }

                }
            }

        }
    }
    echo json_encode(array('status' => true, 'data' => $aaData));
}

?>