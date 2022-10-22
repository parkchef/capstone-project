<?php
include_once("header1.php");
?>
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
                                        <div class="nk-block-head-content">
                                            <h5 class="nk-block-title">Fleet management Registration</h5>
                                            <div class="nk-block-des">
                                                <p>Create New Account</p>
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="form-group">
                                        <label class="form-label" for="name">Name</label>
                                        <input type="text" class="form-control form-control-lg" id="name" placeholder="Enter your name" oninput="nameFormat(this)">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control form-control-lg" id="email" placeholder="Enter your email address">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="password">Password</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control form-control-lg" id="password" placeholder="Enter your password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="password">Confirm Password</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control form-control-lg" id="confirm_password" placeholder="Confirm your password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="email">Phone number</label>
                                        <input type="text" class="form-control form-control-lg" id="phone_number" placeholder="Enter your Phone number" oninput="numberFormatter('#phone_number', 12);">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block" onclick="registration(0);">Register</button>
                                    </div>
                                    <div class="form-note-s2 pt-4"> Already have an account ? <a href="login.php"><strong>Login here</strong></a>
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
</body>

</html>