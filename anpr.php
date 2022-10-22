<?php
include_once("connect.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];
    $query = mysqli_query($conn, "SELECT member_id FROM members WHERE member_session_id='$session_id';");
    $member_id = mysqli_fetch_assoc($query)['member_id'];
    if (isset($_FILES['image_file'])) {
        $car_image = $_FILES['image_file'];
        $target_dir = "images/car-plate/";
        $extension = pathinfo($car_image['name'], PATHINFO_EXTENSION);
        $image_name = $session_id . "-" . date("YmdHis") . ".$extension";
        $image_path = $target_dir . $image_name;
        move_uploaded_file($car_image["tmp_name"], $image_path);
        $return = exec("python app.py $image_name");
        if ($return == "") {
            $data['status'] = -2;
            $data['return'] = "Failed to scan your license plate number. Please manualy enter into the field.";
        } else {
            $data['status'] = 1;
            $data['return'] = $return;
        }
    } else {
        $data['status'] = -2;
        $data['return'] = "Please upload your car plate image.";
    }
} else {
    $data['status'] = -1;
    $data['return'] = "Your session has been expired. Please sign in again.";
}
echo json_encode($data);
