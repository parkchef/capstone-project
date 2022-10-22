<?php
include_once("../../connect.php");
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $query = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM members WHERE member_email='$email';");
    $num_query = mysqli_fetch_assoc($query)['cnt'];
    if ($num_query > 0) {
        $query = mysqli_query($conn, "SELECT member_email, member_id FROM members WHERE member_email='$email';");
        $email = mysqli_fetch_assoc($query)['member_email'];
        $hash_code = bin2hex(random_bytes(5));
        $to = $email;
        $subject = "Fleet Management - Forgot Password";
        $message = "
        <html>
            <head>
                <title>Forgot Password</title>
            </head>
            <body>
                Insert the below hash code to reset your password:<br>
                $hash_code
            </body>
        </html>
        ";
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // More headers
        $headers .= 'From: <parkchansu39@gmail.com>' . "\r\n";
        $headers .= 'Cc: parkchansu39@gmail.com' . "\r\n";
        mail($to, $subject, $message, $headers);
        $member_id = mysqli_fetch_assoc($query)['member_id'];
        mysqli_query($conn, "INSERT INTO forgot_password(member_id, hash_code) VALUES($member_id, '$hash_code');");
        $data['status'] = 1;
        $data['return'] = "Hash code email has been successfully sent!";
    } else {
        $data['status'] = -1;
        $data['return'] = "Invalid email address";
    }
} else {
    $data['status'] = -1;
    $data['return'] = "Invalid email address";
}
echo json_encode($data);
