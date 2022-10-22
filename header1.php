<?php
include_once("connect.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];
    $query = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM members WHERE member_session_id='$session_id';");
    $session_id_check = mysqli_fetch_assoc($query)['cnt'];
    if ($session_id_check == 1) {
        echo "
        <script>
            window.location.replace('dashboard.php');
        </script>
        ";
    }
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