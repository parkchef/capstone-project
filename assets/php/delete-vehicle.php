<?php
include_once("../../connect.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];
    // Session check.
    $query = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM members WHERE member_session_id='$session_id';");
    $si_status = mysqli_fetch_assoc($query)['cnt'];
    if ($si_status == 1) {
        $query = mysqli_query($conn, "SELECT * FROM members WHERE member_session_id='$session_id';");
        $member_details = mysqli_fetch_assoc($query);
        if (isset($_POST['vehicle_id'])) {
            $vehicle_id = $_POST['vehicle_id'];
            mysqli_query($conn, "UPDATE vehicle SET vehicle_status=-1 WHERE vehicle_id=$vehicle_id;");
            $data['status'] = 1;
            $data['return'] = "The vehicle has been successfully deleted!";
        } else {
            $data['status'] = -1;
            $data['return'] = "Failed to load your requested vehicle info. Please try again later.";
        }
    } else {
        $data['status'] = -1;
        $data['return'] = "Your session has been expired. Please sign in again.";
    }
} else {
    $data['status'] = -1;
    $data['return'] = "Your session has been expired. Please sign in again.";
}
echo json_encode($data);
