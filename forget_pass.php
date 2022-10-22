<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>Fleet Management</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=2.4.0">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=2.4.0">
</head>

<body class="nk-body bg-white has-sidebar ">
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-lg">
            <div class="nk-content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="nk-sidebar-content">
                            <div class="nk-sidebar-menu">
                                <ul class="nk-menu">
                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">Capstone Project</h6>
                                        <div class="nk-block-head">
                                            <div class="nk-block-head">
                                                <div class="nk-block-head-content">
                                                    <h5 class="nk-block-title">Forget password</h5>
                                                    <div class="nk-block-des">
                                                        <p>If you forgot your password, well, then we’ll email you instructions to reset your password.</p>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head -->
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label" for="default-01">Email</label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <input type="text" class="form-control form-control-lg" id="email">
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn-lg btn-primary btn-block" onclick="forgotPassword();">Send</button>
                                                    </div>
                                                </div>
                                                <span class="err-msg" id="email_err"></span>
                                            </div>
                                            <div class="form-note-s2 pt-5">
                                                <a href="login.php"><strong>Return to login</strong></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="confirm_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirm_header"></h5>
                    <a class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body" id="confirm_body">
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button id="confirm_btn" class="btn btn-success">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="confirm_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirm_header"></h5>
                    <a class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body" id="confirm_body">
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button id="confirm_btn" class="btn btn-success">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="inform_success">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                        <h4 class="nk-modal-title" id="inform_success_header"></h4>
                        <div class="nk-modal-text">
                            <div id="inform_success_body" class="caption-text"></div>
                        </div>
                        <div class="nk-modal-action">
                            <button id="inform_success_btn" class="btn btn-lg btn-mw btn-primary">Confirm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="inform_danger">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                        <h4 class="nk-modal-title">Unable To Process</h4>
                        <div class="nk-modal-text">
                            <p id="inform_danger_body" class="lead"></p>
                        </div>
                        <div class="nk-modal-action mt-5">
                            <button id="inform_danger_btn" class="btn btn-lg btn-mw btn-light">Confirm</a>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div>
        </div>
    </div>
    <script src="./assets/js/bundle.js?ver=2.4.0"></script>
    <script src="./assets/js/scripts.js?ver=2.4.0"></script>
    <script>
        function forgotPassword() {
            $("#email_err").html("");
            let email = $("#email").val();
            $.ajax({
                url: "assets/php/forgot-password.php",
                type: "POST",
                dataType: "JSON",
                data: {
                    email: email
                },
                success: function(response) {
                    $("#email_err").html(response.return);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }
    </script>
</body>

</html>