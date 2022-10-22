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
        if (isset($_POST['plate_number']) && isset($_POST['vehicle_name']) && isset($_POST['vehicle_mileage']) && isset($_POST['vehicle_model']) && isset($_POST['exp_date'])) {
            $vehicle_name = $_POST['vehicle_name'];
            $vehicle_mileage = $_POST['vehicle_mileage'];
            $vehicle_model = $_POST['vehicle_model'];
            $exp_date = $_POST['exp_date'];
            $plate_number = $_POST['plate_number'];
            if ($vehicle_name != "" && $vehicle_mileage != "" && $vehicle_model != "" && $exp_date != "" && $plate_number != "") {
                // Plate number duplicated check.
                $query = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM vehicle WHERE plate_number='$plate_number' AND vehicle_status>0;");
                $pn_check = mysqli_fetch_assoc($query)['cnt'];
                if ($pn_check == 0) {
                    mysqli_query($conn, "INSERT INTO vehicle(member_id, model, pre_name, expired_date, plate_number) VALUES(" . $member_details['member_id'] . ", '$vehicle_model', '$vehicle_name', '$exp_date', '$plate_number');");
                    $vehicle_id = $conn->insert_id;
                    mysqli_query($conn, "INSERT INTO vehicle_mileage(vehicle_id, mileage) VALUES($vehicle_id, $vehicle_mileage);");
                    $data['status'] = 1;
                    $data['return'] = "Your vehicle has been successfully registered!";
                } else {
                    $data['status'] = -1;
                    $data['return'] = "This license plate number has been registered.";
                }
            } else {
                $data['status'] = -1;
                $data['return'] = "Please key-in every required fields.";
            }
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
