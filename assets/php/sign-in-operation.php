<?php
include_once("../../connect.php");
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = mysqli_query($conn, "SELECT member_password, member_session_id FROM members WHERE member_email='$email' LIMIT 1;");
    $member_details = mysqli_fetch_assoc($query);
    if ($member_details != "") {
        if (password_verify($password, $member_details['member_password'])) {
            $data['status'] = 1;
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['session_id'] = $member_details['member_session_id'];
        } else {
            $data['status'] = -1;
            $data['return'] = "Invalid account";
        }
    } else {
        $data['status'] = -1;
        $data['return'] = "Invalid account";
    }
} else {
    $data['status'] = -1;
    $data['return'] = "Invalid account";
}
echo json_encode($data);
