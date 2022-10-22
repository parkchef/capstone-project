<?php
include_once("../../config.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['admin_session_id'])) {
    $session_id = $_SESSION['admin_session_id'];
    $session_check = DB::queryFirstField("SELECT COUNT(*) FROM `admin` WHERE `session_id`='$session_id';");
    if ($session_check > 0) {
        if (isset($_POST['config_id']) && isset($_POST['value'])) {
            $config_id = $_POST['config_id'];
            $value = $_POST['value'];
            DB::query("UPDATE invech_config SET `value`=$value WHERE config_id=$config_id;");
            $data['status'] = 1;
            $data['return'] = "Your configure setting has been successfully updated!";
        } else {
            $data['status'] = -1;
            $data['return'] = "Failed to load posted data. Please try again later.";
        }
    } else {
        $data['status'] = -1;
        $data['return'] = "Unauthorized access! Please sign in again.";
    }
} else {
    $data['status'] = -1;
    $data['return'] = "Your session has been expired. Please sign in again.";
}
echo json_encode($data);
