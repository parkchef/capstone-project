<?php
include_once("header.php");
$query = mysqli_query($conn, "SELECT *, v.created_date AS vcd
FROM vehicle v
INNER JOIN vehicle_mileage vm
ON v.vehicle_id=vm.vehicle_id
AND vm.vm_status>0
WHERE v.member_id=" . $member_details['member_id'] . " AND v.vehicle_status>0;");
?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">Vehicle Management</h3>
            <div class="nk-block-des text-soft">
                <p>You can manage your registered vehicles.</p>
            </div>
        </div><!-- .nk-block-head-content -->
        <div class="nk-content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <table class="datatable-init table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Model</th>
                                        <th>Name</th>
                                        <th>Mileage</th>
                                        <th>Road Tax Expire</th>
                                        <th>Registered Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $row['plate_number']; ?></td>
                                            <td><?php echo $row['model']; ?></td>
                                            <td><?php echo $row['pre_name']; ?></td>
                                            <td><?php echo number_format($row['mileage']) . " KM"; ?></td>
                                            <td><?php echo date("Y-m-d", strtotime($row['expired_date'])); ?></td>
                                            <td><?php echo date("Y-m-d", strtotime($row['vcd'])); ?></td>
                                            <td>
                                                <form action="edit-vehicle.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="vehicle_id" value="<?php echo $row['vehicle_id']; ?>" />
                                                    <button class="btn btn-success" type="submit" name="edit_vehicle"><i class="fa-solid fa-pen-to-square"></i></button>
                                                </form>
                                                <button class="btn btn-danger" onclick="deleteVehicle(<?php echo $row['vehicle_id']; ?>);"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="row mt-3">
                                <div class="col-12 d-flex justify-content-center">
                                    <a href="add-vehicle.php" class="btn btn-primary">+ Add</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function deleteVehicle(vehicleId) {
        $("#confirm_header").html("CONFIRMATION");
        $("#confirm_body").html("Are you sure you want to delete this vehicle?");
        $("#confirm_btn").attr("onClick", "deleteVehicleOper(" + vehicleId + ")");
        $("#confirm_modal").modal("show");
    }

    function deleteVehicleOper(vehicleId) {
        $.ajax({
            url: "assets/php/delete-vehicle.php",
            type: "POST",
            dataType: "JSON",
            data: {
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