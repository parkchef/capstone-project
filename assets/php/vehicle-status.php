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
        if (isset($_POST['vehicle_id']) && isset($_POST['vehicle_status'])) {
            $vehicle_id = $_POST['vehicle_id'];
            $vehicle_status = $_POST['vehicle_status'];
            // Check this session member is the vehicle owner.
            $query = mysqli_query($conn, "SELECT member_id FROM vehicle WHERE vehicle_id=$vehicle_id;");
            $v_member_id = mysqli_fetch_assoc($query)['member_id'];
            if ($v_member_id == $member_details['member_id']) {
                mysqli_query($conn, "UPDATE vehicle SET vehicle_status=$vehicle_status WHERE vehicle_id=$vehicle_id;");
                $data['status'] = 1;
            } else {
                $data['status'] = -1;
                $data['return'] = "Unauthorized access! Please try again later.";
            }
        } else {
            $data['status'] = -1;
            $data['return'] = "Failed to load your vehicle info. Please try again later.";
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
