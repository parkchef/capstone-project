<?php
include_once("../../connect.php");
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['phone_number']) && isset($_POST['oper_type'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone_number = $_POST['phone_number'];
    $oper_type = $_POST['oper_type'];
    $data['status'] = 1;
    if (strlen($phone_number) > 12) {
        $data['status'] = -1;
        $data['return'] = "The phone number should be less than 12 digits.";
    }
    if (strlen($phone_number) < 8) {
        $data['status'] = -1;
        $data['return'] = "The phone number should be at least 8 digits.";
    }
    if (strlen($password) < 8) {
        $data['status'] = -1;
        $data['return'] = "The password should be at least 8 characters.";
    }
    if (strlen($password) > 32) {
        $data['status'] = -1;
        $data['return'] = "The password should be less than 32s characters.";
    }
    if ($password != $confirm_password) {
        $data['status'] = -1;
        $data['return'] = "The confirm password should be same with the password.";
    }
    if (strlen($email) < 1) {
        $data['status'] = -1;
        $data['return'] = "Please enter a valid email.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $data['status'] = -1;
        $data['return'] = "Please enter a valid email.";
    }
    $query = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM members WHERE member_email='$email';");
    $email_unique_check = mysqli_fetch_assoc($query)['cnt'];
    if ($email_unique_check > 0) {
        $data['status'] = -1;
        $data['return'] = "This email has been already registered.";
    }
    if (!(strlen($name) > 4 && strlen($name) < 32)) {
        $data['status'] = -1;
        $data['return'] = "The name field should be at least 4 or less than 32 characters.";
    }
    if ($data['status'] > 0 && $oper_type > 0) {
        $session_id_check = 1;
        while ($session_id_check > 0) {
            $session_id = bin2hex(random_bytes(5));
            $query = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM members WHERE member_session_id='$session_id';");
            $session_id_check = mysqli_fetch_assoc($query)['cnt'];
        }
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO members(member_name, member_email, member_session_id, member_password, phone_number) VALUES('$name', '$email', '$session_id', '$hash_password', '$phone_number');");
        $data['return'] = "Your account has been successfully registered!";
    }
} else {
    $data['status'] = -1;
    $data['return'] = "Failed to load data. Please try again later.";
}
echo json_encode($data);
