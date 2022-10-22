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
        if (isset($_POST['vehicle_id']) && isset($_POST['pre_name']) && isset($_POST['mileage']) && isset($_POST['model']) && isset($_POST['exp_date'])) {
            $vehicle_id = $_POST['vehicle_id'];
            $pre_name = $_POST['pre_name'];
            $mileage = $_POST['mileage'];
            $model = $_POST['model'];
            $exp_date = $_POST['exp_date'];
            // Check this session member is the vehicle owner.
            $query = mysqli_query($conn, "SELECT member_id FROM vehicle WHERE vehicle_id=$vehicle_id;");
            $v_member_id = mysqli_fetch_assoc($query)['member_id'];
            if ($v_member_id == $member_details['member_id']) {
                // Input format check.
                if ($pre_name != "" && $mileage != "" && $model != "" && $exp_date != "") {
                    // Mileage cannot be lower than the last mileage.
                    $query = mysqli_query($conn, "SELECT mileage FROM vehicle_mileage WHERE vehicle_id=$vehicle_id AND vm_status=1;");
                    $last_mileage = mysqli_fetch_assoc($query)['mileage'];
                    mysqli_query($conn, "UPDATE vehicle SET model='$model', pre_name='$pre_name', expired_date='$exp_date' WHERE vehicle_id=$vehicle_id;");
                    if ($mileage != $last_mileage) {
                        mysqli_query($conn, "UPDATE vehicle_mileage SET vm_status=-1 WHERE vehicle_id=$vehicle_id;");
                        mysqli_query($conn, "INSERT INTO vehicle_mileage(vehicle_id, mileage) VALUES($vehicle_id, $mileage);");
                    }
                    $data['status'] = 1;
                    $data['return'] = "Your vehicle has been successfully updated!";
                } else {
                    $data['status'] = -1;
                    $data['return'] = "Please enter valid values.";
                }
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
