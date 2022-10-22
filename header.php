<?php
include_once("connect.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];
    $query = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM members WHERE member_session_id='$session_id';");
    $session_id_check = mysqli_fetch_assoc($query)['cnt'];
    if ($session_id_check != 1) {
        echo "
        <script>
            window.location.replace('login.php');
        </script>
        ";
    }
    $query = mysqli_query($conn, "SELECT * FROM members WHERE member_session_id='$session_id';");
    $member_details = mysqli_fetch_assoc($query);
} else {
    echo "
    <script>
        window.location.replace('login.php');
    </script>
    ";
}
?>
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
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="dashboard.php" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="images/logo-dark.png" srcset="images/logo-dark.png 2x" alt="logo">
                            <img class="logo-dark logo-img" src="images/logo-dark.png" srcset="images/logo-dark.png 2x" alt="logo-dark">
                        </a>
                    </div>
                    <div class="nk-menu-trigger mr-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element">
                    <div class="nk-sidebar-body" data-simplebar>
                        <div class="nk-sidebar-content">
                            <div class="nk-sidebar-menu">
                                <ul class="nk-menu">
                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">Capstone Project</h6>
                                    </li><!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="dashboard.php" class="nk-menu-link">
                                            <span class="nk-menu-icon"><i class="fa-solid fa-chalkboard-user"></i></span>
                                            <span class="nk-menu-text">Dashboard</span>
                                        </a>
                                    </li><!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="vehicle-management.php" class="nk-menu-link">
                                            <span class="nk-menu-icon"><i class="fa-solid fa-car"></i></span>
                                            <span class="nk-menu-text">Vehicle Management</span>
                                        </a>
                                    </li><!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="account-setting.php" class="nk-menu-link">
                                            <span class="nk-menu-icon"><i class="fa-solid fa-gear"></i></span>
                                            <span class="nk-menu-text">Account Setting</span>
                                        </a>
                                    </li><!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="sign-out.php" class="nk-menu-link">
                                            <span class="nk-menu-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                                            <span class="nk-menu-text">Sign Out</span>
                                        </a>
                                    </li><!-- .nk-menu-item -->
                                </ul>
                            </div>
                        </div><!-- .nk-sidebar-content -->
                    </div><!-- .nk-sidebar-body -->
                </div><!-- .nk-sidebar-element -->
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ml-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="dashboard.php" class="logo-link">
                                    <img class="logo-light logo-img" src="images/logo-dark.png" srcset="images/logo-dark.png 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="images/logo-dark.png" srcset="images/logo-dark.png 2x" alt="logo-dark">
                                </a>
                            </div>
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- main header @e -->
                <!-- content @s -->