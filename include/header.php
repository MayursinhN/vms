<?php ob_start(); ?>
<?php include_once '../common/config.php';
if ($objsession->get('log_admin_type') == "") {
    redirect(HTTP_SERVER . '');
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo PROJECT_NAME; ?></title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo PATH; ?>assets/materialize/css/materialize.min.css"
          media="screen,projection"/>
    <!-- Bootstrap Styles-->
    <link href="<?php echo PATH; ?>assets/css/bootstrap.css" rel="stylesheet"/>
    <!-- FontAwesome Styles-->
    <link href="<?php echo PATH; ?>assets/css/font-awesome.css" rel="stylesheet"/>
    <!-- Morris Chart Styles-->
    <link href="<?php echo PATH; ?>assets/js/morris/morris-0.4.3.min.css" rel="stylesheet"/>
    <!-- Custom Styles-->
    <link href="<?php echo PATH; ?>assets/css/custom-styles.css" rel="stylesheet"/>
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
    <link rel="stylesheet" href="<?php echo PATH; ?>assets/js/Lightweight-Chart/cssCharts.css">
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default top-navbar" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle waves-effect waves-dark" data-toggle="collapse"
                    data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand waves-effect waves-dark" href="<?php echo HTTP_SERVER; ?>"><i
                        class="large material-icons">insert_chart</i>
                <strong><?php echo PROJECT_ADMIN_TITLE; ?></strong></a>

            <div id="sideNav" href=""><i class="material-icons dp48">toc</i></div>
        </div>
        <ul class="nav navbar-top-links navbar-right">

            <li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown1"><i
                            class="fa fa-user fa-fw" style="padding: 0px !important;"></i> <b>Web Admin</b> <i
                            class="material-icons right">arrow_drop_down</i></a>
            </li>
        </ul>
    </nav>
    <!-- Dropdown Structure -->
    <ul id="dropdown1" class="dropdown-content">
        <li><a href="<?php echo HTTP_SERVER; ?>profile"><i class="fa fa-user fa-fw"></i> My Profile</a></li>
        <!-- <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li> -->
        <li><a href="<?php echo HTTP_SERVER; ?>logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
    </ul>
    <!--/. NAV TOP  -->
    <?php include_once 'sidebar.php'; ?>
    <div id="page-wrapper">