<?php
require_once("Configuration/Database.php");
require_once("Configuration/Functions.php");
require_once("GenerateJsonApi.php");
$SettingDefaultId = 1;
$Settings = $connection->prepare("SELECT * FROM tblsettings WHERE tblSettingId= :tblSettingId");
$Settings->bindParam(":tblSettingId", $SettingDefaultId, PDO::PARAM_INT);
$Settings->execute();
$Setting = $Settings->fetch(PDO::FETCH_ASSOC);
CheckClosedSession();

$GetEmail = base64_decode($_SESSION["MANAGMENT_USER"]);
$GetPassword = base64_decode($_SESSION["MANAGMENT_PASSWORD"]);
$GetManagerQuery = $connection->prepare("SELECT * FROM tblmanagers 
WHERE
tblManagerEmail= :tblManagerEmail
AND tblManagerPassword= :tblManagerPassword
AND tblManagerStatus IN('ACTIVE')
AND tblManagerPub IN('ADMINISTRATOR', 'MODERATOR')"); 
$GetManagerQuery->bindParam(":tblManagerEmail", $GetEmail, PDO::PARAM_STR);
$GetManagerQuery->bindParam(":tblManagerPassword", $GetPassword, PDO::PARAM_STR);
$GetManagerQuery->execute();
$GetManager = $GetManagerQuery->fetch(PDO::FETCH_ASSOC);

$_SESSION["CurrentSystemLogo"] = $Setting["tblSettingLogoUrl"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title><?php echo $Setting["tblSettingCompanyTitle"] . " Backoffice"; ?></title>

    <link rel="shortcut icon" href="assets/img/favicon.png">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/feather.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/plugins/toastr/toatr.css">
    <link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">
    
</head>
<style>
.logo {
    margin-top: -10px;
    width: 175px;
    height: 75px;
}
</style>

<body class="nk-body bg-lighter npc-default has-sidebar no-touch nk-nio-theme">

    <div class="main-wrapper">

        <div class="header header-one">

            <div class="header-left header-left-one">
                <img class="logo" src="../<?php echo $Setting["tblSettingLogoUrl"]; ?>">
            </div>
            <a href="javascript:void(0);" id="toggle_btn">
                <i class="fas fa-bars"></i>
            </a>
            <a class="mobile_btn" id="mobile_btn">
                <i class="fas fa-bars"></i>
            </a>
            <ul class="nav nav-tabs user-menu">
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <img src="assets/img/profiles/logged-user.jpg" alt="">
                            <span class="status online"></span>
                        </span>
                        <span><?php echo $GetManager["tblManagerFirstname"] . " " . $GetManager["tblManagerLastname"]; ?></span>
                    </a>
                    <div class="dropdown-menu">
                     
                        <a class="dropdown-item" href="javascript:;" id="Logout"><i data-feather="log-out"
                                class="me-1"></i>
                            Çıkış Yap</a>
                    </div>
                </li>

            </ul>

        </div>

        <?php require_once("DashboardSidebar.php") ?>