<?php
include_once("header.php");
?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Account Setting</h3>
                </div><!-- .nk-block-head-content -->
            </div><!-- .nk-block-between -->
        </div><!-- .nk-block-head -->
        <div class="nk-content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?php echo $member_details['member_email']; ?>" id="email" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="<?php echo $member_details['member_name']; ?>" oninput="nameFormat(this)" id="name" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" value="<?php echo $member_details['phone_number']; ?>" oninput="numberFormatter(this, 12);" id="phone_number" />
                            </div>
                            <div class="row justify-content-center mt-3">
                                <button class="btn btn-primary" onclick="memberUpdate();">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-block-head nk-block-head-sm mt-3">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Change Password</h3>
                </div><!-- .nk-block-head-content -->
            </div><!-- .nk-block-between -->
        </div><!-- .nk-block-head -->
        <div class="nk-content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" />
                            </div>
                            <div class="row justify-content-center mt-3">
                                <button class="btn btn-primary" onclick="changePassword(0);">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once("footer.php");
?>
<script>
    function memberUpdate() {
        let email = $("#email").val();
        let name = $("#name").val();
        let phoneNumber = $("#phone_number").val();
        $.ajax({
            url: "assets/php/edit-member.php",
            type: "POST",
            dataType: 'JSON',
            data: {
                email: email,
                name: name,
                phone_number: phoneNumber
            },
            success: function(response) {
                let dataStatus = parseInt(response.status);
                if (dataStatus == 1) {
                    $("#inform_success_header").html("Success");
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

    function changePassword(process) {
        process = parseInt(process);
        let password = $("#password").val();
        let confirmPassword = $("#confirm_password").val();
        $.ajax({
            url: "assets/php/change-password.php",
            type: "POST",
            dataType: "JSON",
            data: {
                password: password,
                confirm_password: confirmPassword,
                process: process
            },
            success: function(response) {
                $(".modal").modal("hide");
                let dataStatus = parseInt(response.status);
                if (dataStatus == 1) {
                    if (process > 0) {
                        $("#inform_success_header").html("Success");
                        $("#inform_success_body").html(response.return);
                        $("#inform_success_btn").attr("onClick", "window.location.replace('sign-out.php')");
                        $("#inform_success").modal("show");
                    } else {
                        $("#confirm_header").html("CONFIRMATION");
                        $("#confirm_body").html("Are you sure you want to change your password?");
                        $("#confirm_btn").attr("onClick", "changePassword(1)");
                        $("#confirm_modal").modal("show");
                    }
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