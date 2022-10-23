<?php
include_once("header.php");
$vehicle_details = mysqli_query($conn, "SELECT * FROM vehicle v INNER JOIN vehicle_mileage vm ON vm.vehicle_id=v.vehicle_id AND vm.vm_status>0 WHERE v.vehicle_status>0 AND member_id=" . $member_details['member_id'] . ";");
$duration_arr = [];
$mileage_arr = [];
if (isset($_POST['vehicle_select'])) {
    $vehicle_id = $_POST['vehicle_select'];
    $query = mysqli_query($conn, "SELECT plate_number FROM vehicle WHERE vehicle_id=$vehicle_id;");
    $plate_number = mysqli_fetch_assoc($query)['plate_number'];
} else {
    if (mysqli_num_rows($vehicle_details) > 0) {
        $row = mysqli_fetch_assoc($vehicle_details);
        $vehicle_id = $row['vehicle_id'];
        $plate_number = $row['plate_number'];
    } else {
        echo "
        <script>
            window.location.replace('add-vehicle.php');
        </script>
        ";
    }
}
$query = mysqli_query($conn, "SELECT created_date, mileage FROM vehicle_mileage WHERE vehicle_id=$vehicle_id ORDER BY created_date DESC;");
// Get duraion.
for ($i = 0; $i < 5; $i++) {
    $duration_arr[] = date("M", strtotime("-$i months"));
    $start = date("Y-m-01 00:00:00", strtotime("-$i months"));
    $end = date("Y-m-t 23:59:59", strtotime("-$i months"));
    $query = mysqli_query($conn, "SELECT mileage FROM vehicle_mileage WHERE vehicle_id=$vehicle_id AND created_date BETWEEN '$start' AND '$end' ORDER BY created_date DESC LIMIT 1;");
    if (mysqli_num_rows($query) > 0) {
        $tmp_mileage = mysqli_fetch_assoc($query)['mileage'];
    } else {
        $tmp_mileage = 0;
    }
    $mileage_arr[] = $tmp_mileage;
}
$duration_arr = array_reverse($duration_arr);
$mileage_arr = array_reverse($mileage_arr);
// This month mileage.
$last_month_first = date("Y-m-01 H:i:s");
$last_month_end = date("Y-m-t H:i:s");
$query = mysqli_query($conn, "SELECT mileage FROM vehicle_mileage WHERE vehicle_id=$vehicle_id AND created_date BETWEEN '$last_month_first' AND '$last_month_end' ORDER BY created_date DESC LIMIT 1");
if (mysqli_num_rows($query) > 0) {
    $current_mileage = mysqli_fetch_assoc($query)['mileage'];
} else {
    $current_mileage = 0;
}
// The last month mileage.
$last_month_first = date("Y-m-01 H:i:s", strtotime("-1 months"));
$last_month_end = date("Y-m-t H:i:s", strtotime("-1 months"));
$query = mysqli_query($conn, "SELECT mileage FROM vehicle_mileage WHERE vehicle_id=$vehicle_id AND created_date BETWEEN '$last_month_first' AND '$last_month_end' ORDER BY created_date DESC LIMIT 1");
if (mysqli_num_rows($query) > 0) {
    $last_mileage = mysqli_fetch_assoc($query)['mileage'];
} else {
    $last_mileage = 0;
}
?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Dashboard</h3>
                        <div class="nk-block-des text-soft">
                            <p>Welcome to G1 Smart Fleet Management.</p>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-lg-8">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Mileage Overview</h6>
                                        <p>You can check monthly mileage chart.</p>
                                    </div>
                                </div><!-- .card-title-group -->
                                <div class="nk-order-ovwg">
                                    <div class="row g-4 align-end">
                                        <div class="col-xxl-8">
                                            <form action="dashboard.php" method="POST" class="d-flex">
                                                <select class="form-control" name="vehicle_select" id="vehicle_select">
                                                    <?php
                                                    $query = mysqli_query($conn, "SELECT * FROM vehicle v INNER JOIN vehicle_mileage vm ON vm.vehicle_id=v.vehicle_id AND vm.vm_status>0 WHERE v.vehicle_status>0 AND member_id=" . $member_details['member_id'] . ";");
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                        if ($vehicle_id == $row['vehicle_id']) {
                                                            $selected = "selected";
                                                        } else {
                                                            $selected = "";
                                                        }
                                                    ?>
                                                        <option value="<?php echo $row['vehicle_id']; ?>" <?php echo $selected; ?>><?php echo $row['plate_number']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <button class="btn btn-primary ml-3" type="submit" name="submit_btn">Select</button>
                                            </form>
                                            <canvas id="mileage_chart"></canvas>
                                        </div><!-- .col -->
                                        <div class="col-xxl-4">
                                            <div class="row g-4">
                                                <div class="col-sm-6 col-xxl-12">
                                                    <div class="nk-order-ovwg-data buy">
                                                        <div class="amount"><?php echo number_format($current_mileage) . " KM"; ?> <small class="currenct currency-usd">Recent Mileage</small></div>
                                                        <div class="info">Last month <strong><?php echo number_format($last_mileage) . " KM"; ?> <span class="currenct currency-usd">Mileage</span></strong></div>
                                                        <?php
                                                        if ($current_mileage == 0) {
                                                        ?>
                                                            <form action="edit-vehicle.php" method="POST">
                                                                <input type="hidden" name="vehicle_id" value="<?php echo $vehicle_id; ?>" />
                                                                <button class="btn btn-primary" type="submit">
                                                                    Go to update
                                                                </button>
                                                            </form>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .col -->
                                    </div>
                                </div><!-- .nk-order-ovwg -->
                            </div><!-- .card-inner -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-lg-4">
                        <div class="card card-bordered h-100">
                            <div class="card-inner-group">
                                <div class="card-inner card-inner-md">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">To-Do-List</h6>
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM vehicle WHERE expired_date<=DATE_ADD(NOW(), INTERVAL 90 DAY) AND member_id=" . $member_details['member_id'] . " AND vehicle_status>0;");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $tmp_plate_number = $row['plate_number'];
                                    $left_days = date("d", strtotime($row['expired_date']) - strtotime("Y-m-d H:i:s"));
                                ?>
                                    <div class="card-inner">
                                        <div class="nk-wg-action">
                                            <div class="nk-wg-action-content">
                                                <i class="icon fa-solid fa-car-burst mr-3"></i>
                                                <div class="title">Insurance & Road Tax</div>
                                                <p>
                                                    <?php echo $tmp_plate_number; ?> still got <strong><?php echo $left_days; ?> days</strong> expired.<br>
                                                    After renew, please update this vehicle info.
                                                </p>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                    <?php
                                }
                                $query = mysqli_query($conn, "SELECT vehicle_id, plate_number FROM vehicle WHERE member_id=" . $member_details['member_id'] . " AND vehicle_status>0;");
                                $last_month_first = date("Y-m-01 H:i:s");
                                $last_month_end = date("Y-m-t H:i:s");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $tmp_vi = $row['vehicle_id'];
                                    // Get this vehicle's this month mileage.
                                    $query2 = mysqli_query($conn, "SELECT mileage FROM vehicle_mileage WHERE vehicle_id=$tmp_vi AND created_date BETWEEN '$last_month_first' AND '$last_month_end';");
                                    if (mysqli_num_rows($query2) == 0) {
                                        $tmp_plate_number = $row['plate_number'];
                                    ?>
                                        <div class="card-inner">
                                            <div class="nk-wg-action">
                                                <div class="nk-wg-action-content">
                                                    <i class="icon fa-solid fa-signal"></i>
                                                    <div class="title">Update Mileage</div>
                                                    <p><strong><?php echo $tmp_plate_number; ?></strong> needs to be updated mileage.</p>
                                                    <form action="edit-vehicle.php" method="POST">
                                                        <input type="hidden" name="vehicle_id" value="<?php echo $vehicle_id; ?>" />
                                                        <button class="btn btn-primary" type="submit">
                                                            Go to update
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div><!-- .card-inner -->
                                <?php
                                    }
                                }
                                ?>
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-xxl-8">
                        <div class="card card-bordered card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title"><span class="mr-2">Vehicle Status</span></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner p-0 border-top">
                                <div class="nk-tb-list nk-tb-orders">
                                    <table class="datatable-init table" id="update_position">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Status</th>
                                                <th>Set</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT * FROM vehicle WHERE member_id=" . $member_details['member_id'] . " AND vehicle_status>0;");
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $v_status = $row['vehicle_status'];
                                                if ($v_status == 1) {
                                                    $class = "success";
                                                    $status_str = "Stand by";
                                                }
                                                if ($v_status == 2) {
                                                    $class = "danger";
                                                    $status_str = "Rented";
                                                }
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['plate_number']; ?></td>
                                                    <td>
                                                        <span style="width: 80px;" class="justify-content-center badge badge-sm badge-dim badge-outline-<?php echo $class; ?>">
                                                            <?php echo $status_str; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="card-tools mt-n1 mr-n1">
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="javascript:vehicleStatus(<?php echo $row['vehicle_id']; ?>, 1);"><span>Stand by</span></a></li>
                                                                        <li><a href="javascript:vehicleStatus(<?php echo $row['vehicle_id']; ?>, 2);"><span>Rented</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>
<!-- content @e -->
<!-- footer @s -->
<?php include_once("footer.php"); ?>
<script>
    var durationArr = <?php echo json_encode($duration_arr); ?>;
    var mileageArr = <?php echo json_encode($mileage_arr); ?>;
    const chart = new Chart("mileage_chart", {
        data: {
            datasets: [{
                type: 'bar',
                label: 'Mileage',
                data: mileageArr,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)'
            }],
            labels: durationArr
        }
    });

    function vehicleStatus(vehicleId, vStatus) {
        $.ajax({
            url: "assets/php/vehicle-status.php",
            type: "POST",
            dataType: "JSON",
            data: {
                vehicle_id: vehicleId,
                vehicle_status: vStatus
            },
            success: function(response) {
                let dataStatus = parseInt(response.status);
                if (dataStatus == 1) {
                    location.reload("#update_position");
                }
                if (dataStatus == -1) {
                    $("#inform_danger_body").html(response.return);
                    $("#inform_danger_btn").attr("onClick", "location.reload()");
                    $("#inform_danger").modal("show");
                }
            },
            error: function(response) {
                console.log(response);
            }
        });
    }

    function licenseScanner(memberId) {
        FleetManagement.licenseScanner(memberId);
    }
</script>