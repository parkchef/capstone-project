<?php
include_once("header.php");
$plate_number = "";
$plate_err = "";
if (isset($_GET['plate_number'])) {
    $plate_number = $_GET['plate_number'];
    $pieces = explode(" ", $plate_number);
    if (count($pieces) != 2) {
        $plate_number = "";
        $plate_err = "Scanned number is wrong format. Please scan again.";
    }
    if (count($pieces) == 2) {
        if (strlen($pieces[1]) == 0 || strlen($pieces[1]) > 4) {
            $plate_number = "";
            $plate_err = "Scanned number is wrong format. Please scan again.";
        }
        if (strlen($pieces[0]) == 0 || strlen($pieces[0]) > 3) {
            $plate_number = "";
            $plate_err = "Scanned number is wrong format. Please scan again.";
        }
    }
}
?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">Register Vehicle</h3>
            <div class="nk-block-des text-soft">
                <p>You can register your vehicle.</p>
                <a href="vehicle-management.php" class="btn btn-primary mb-3">Back</a>
            </div>
        </div><!-- .nk-block-head-content -->
        <div class="nk-content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="form-group">
                                <label class="form-label">Plate Number</label>
                                <input class="form-control" type="text" id="vehicle_number" value="<?php echo $plate_number; ?>" disabled />
                                <span class="err-msg" id="upload_err"><?php echo $plate_err; ?></span>
                                <div class="row justify-content-center mt-3">
                                    <button class="btn btn-primary" onclick="test();">License Plate Scan</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Preferred Name</label>
                                <input class="form-control" type="text" id="vehicle_name" oninput="nameFormat(this);" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Vehicle Model</label>
                                <input class="form-control" type="text" id="vehicle_model" oninput="nameFormat(this);" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Total Mileage</label>
                                <input class="form-control" type="text" id="vehicle_mileage" oninput="numberFormatter(this, 10);" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Road Tax & Insurance Expiary Date</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left">
                                        <em class="icon ni ni-calendar"></em>
                                    </div>
                                    <input type="text" class="form-control date-picker" id="exp_date" data-date-format="yyyy-mm-dd" readonly />
                                </div>
                            </div>
                            <div class="row justify-content-center mt-3">
                                <button class="btn btn-primary" onclick="addVehicle();">Register</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="loading_modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loading_header"></h5>
            </div>
            <div class="modal-body" id="loading_body">
            </div>
        </div>
    </div>
</div>
<?php
include_once("footer.php");
?>
<script>
    function test() {
        FleetManagement.showToast();
    }

    function addVehicle() {
        let vehicleName = $("#vehicle_name").val();
        let vehicleModel = $("#vehicle_model").val();
        let vehicleMileage = $("#vehicle_mileage").val();
        let plateNumber = $("#vehicle_number").val();
        let expDate = $("#exp_date").val();
        $.ajax({
            url: "assets/php/add-vehicle.php",
            type: "POST",
            dataType: "JSON",
            data: {
                vehicle_name: vehicleName,
                vehicle_model: vehicleModel,
                vehicle_mileage: vehicleMileage,
                exp_date: expDate,
                plate_number: plateNumber
            },
            success: function(response) {
                let dataStatus = parseInt(response.status);
                if (dataStatus == -1) {
                    $("#inform_danger_body").html(response.return);
                    $("#inform_danger_btn").attr("onClick", "location.reload()");
                    $("#inform_danger").modal("show");
                }
                if (dataStatus == 1) {
                    $("#inform_success_body").html(response.return);
                    $("#inform_success_btn").attr("onClick", "window.location.replace('vehicle-management.php')");
                    $("#inform_success").modal("show");
                }
            },
            error: function(response) {
                console.log(response);
            }
        });
    }
</script>