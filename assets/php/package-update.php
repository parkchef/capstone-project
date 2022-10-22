<?php
include_once("../../config.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['admin_session_id'])) {
    $session_id = $_SESSION['admin_session_id'];
    $session_check = DB::queryFirstField("SELECT COUNT(*) FROM `admin` WHERE `session_id`='$session_id';");
    if ($session_check > 0) {
        if (isset($_POST['package_id']) && isset($_POST['price']) && isset($_POST['amount'])) {
            $package_id = $_POST['package_id'];
            $price = $_POST['price'];
            $amount = $_POST['amount'];
            DB::query("UPDATE package_details SET `status`=-1 WHERE package_id=$package_id;");
            $data['status'] = 1;
            $data['return'] = "This package has been successfully updated!";
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
