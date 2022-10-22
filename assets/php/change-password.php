<?php
include_once("../../connect.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];
    $query = mysqli_query($conn, "SELECT * FROM members WHERE member_session_id='$session_id';");
    $member_details = mysqli_fetch_assoc($query);
    if (isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['process'])) {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $process = $_POST['process'];
        $member_id = $member_details['member_id'];
        $data['status'] = 1;
        if ($password != $confirm_password) {
            $data['status'] = -1;
            $data['return'] = "The confirm password should be same with the password.";
        }
        if (strlen($password) < 8) {
            $data['status'] = -1;
            $data['return'] = "The password should be at least 8 characters.";
        }
        if (strlen($password) > 32) {
            $data['status'] = -1;
            $data['return'] = "The password should be less than 32s characters.";
        }
        if ($data['status'] > 0 && $process > 0) {
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE members SET member_password='$hash_password' WHERE member_id=$member_id;");
            $data['return'] = "Your password has been successfully updated! Please sign in again.";
        }
    } else {
        $data['status'] = -1;
        $data['return'] = "Failed to load data. Please try again later.";
    }
} else {
    $data['status'] = -1;
    $data['return'] = "Your session has been expired. Please sign in again.";
}
echo json_encode($data);
