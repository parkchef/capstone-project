<?php
include_once("header.php");
if (isset($_POST['vehicle_id'])) {
    $vehicle_id = $_POST['vehicle_id'];
    // Check this session member is the owner.
    $query = mysqli_query($conn, "SELECT member_id FROM vehicle WHERE vehicle_id=$vehicle_id;");
    $v_member_id = mysqli_fetch_assoc($query)['member_id'];
    if ($member_details['member_id'] == $v_member_id) {
        $query = mysqli_query($conn, "SELECT *, v.created_date AS vcd
        FROM vehicle v
        INNER JOIN vehicle_mileage vm
        ON v.vehicle_id=vm.vehicle_id
        AND vm.vm_status>0
        WHERE v.member_id=" . $member_details['member_id'] . " AND v.vehicle_status>0 AND v.vehicle_id=$vehicle_id;");
        $vehicle_details = mysqli_fetch_assoc($query);
    } else {
        echo "
        <script>
            window.location.replace('vehicle-management.php');
        </script>
        ";
    }
} else {
    echo "
    <script>
        window.location.replace('vehicle-management.php');
    </script>
    ";
}
?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">Update Vehicle</h3>
            <div class="nk-block-des text-soft">
                <p>You can update your vehicle info here.</p>
            </div>
        </div><!-- .nk-block-head-content -->
        <div class="nk-content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="form-group">
                                <label class="form-label">Plate Number</label>
                                <input class="form-control" type="text" id="vehicle_number" value="<?php echo $vehicle_details['plate_number']; ?>" disabled />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Preferred Name</label>
                                <input class="form-control" type="text" id="vehicle_name" value="<?php echo $vehicle_details['pre_name']; ?>" oninput="nameFormat(this);" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Vehicle Model</label>
                                <input class="form-control" type="text" id="vehicle_model" value="<?php echo $vehicle_details['model']; ?>" oninput="nameFormat(this);" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Total Mileage</label>
                                <input class="form-control" type="text" id="vehicle_mileage" value="<?php echo $vehicle_details['mileage']; ?>" oninput="numberFormatter(this, 10);" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Road Tax & Insurance Expiary Date</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left">
                                        <em class="icon ni ni-calendar"></em>
                                    </div>
                                    <input type="text" class="form-control date-picker" id="exp_date" value="<?php echo date("Y-m-d", strtotime($vehicle_details['expired_date'])); ?>" data-date-format="yyyy-mm-dd" readonly />
                                </div>
                            </div>
                            <div class="row justify-content-center mt-3">
                                <a class="btn btn-danger mr-3" href="vehicle-management.php">Cancel</a>
                                <button class="btn btn-success" onclick="updateVehicle(<?php echo $vehicle_id; ?>);">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function updateVehicle(vehicleId) {
        let preName = $("#vehicle_name").val();
        let model = $("#vehicle_model").val();
        let mileage = $("#vehicle_mileage").val();
        let expDate = $("#exp_date").val();
        $.ajax({
            url: "assets/php/edit-vehicle.php",
            type: "POST",
            dataType: "JSON",
            data: {
                pre_name: preName,
                model: model,
                mileage: mileage,
                exp_date: expDate,
                vehicle_id: vehicleId
            },
            success: function(response) {
                $(".modal").modal("hide");
                let dataStatus = parseInt(response.status);
                if (dataStatus == 1) {
                    $("#inform_success_body").html(response.return);
                    $("#inform_success_btn").attr("onClick", "location.reload()");
                    $("#inform_success").modal("show");
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
</script>
<?php
include_once("footer.php");
?>