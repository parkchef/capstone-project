<?php
include_once("../../connect.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];
    $query = mysqli_query($conn, "SELECT * FROM members WHERE member_session_id='$session_id';");
    $member_details = mysqli_fetch_assoc($query);
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone_number'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $member_id = $member_details['member_id'];
        $data['status'] = 1;
        if (strlen($phone_number) > 12) {
            $data['status'] = -1;
            $data['return'] = "The phone number should be less than 12 digits.";
        }
        if (strlen($phone_number) < 8) {
            $data['status'] = -1;
            $data['return'] = "The phone number should be at least 8 digits.";
        }
        if (strlen($email) < 1) {
            $data['status'] = -1;
            $data['return'] = "Please enter a valid email.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data['status'] = -1;
            $data['return'] = "Please enter a valid email.";
        }
        $query = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM members WHERE member_email='$email' AND member_id!=$member_id;");
        $email_unique_check = mysqli_fetch_assoc($query)['cnt'];
        if ($email_unique_check > 0) {
            $data['status'] = -1;
            $data['return'] = "This email has been already registered.";
        }
        if (!(strlen($name) > 4 && strlen($name) < 32)) {
            $data['status'] = -1;
            $data['return'] = "The name field should be at least 4 or less than 32 characters.";
        }
        if ($data['status'] > 0) {
            mysqli_query($conn, "UPDATE members SET member_email='$email', member_name='$name', phone_number='$phone_number' WHERE member_id=$member_id;");
            $data['return'] = "Your account has been successfully registered!";
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
