<?php session_start();
if (!isset($_SESSION['email']) || (!isset($_SESSION['senha']))) {
    session_destroy();
    header("Location: index.php");
}
?>

<meta charset="utf-8" />
<link rel="icon" type="image/png" href="assets/img/favicon.ico">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<title>Dashboard</title>

<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
<meta name="viewport" content="width=device-width" />


<!-- Bootstrap core CSS     -->
<link href="../Components/Bootstrap/css/bootstrap.min.css" rel="stylesheet" />

<!-- Animation library for notifications   -->
<link href="../Components/Libs/animate.min.css" rel="stylesheet"/>

<!--  Light Bootstrap Table core CSS    -->
<link href="../Components/Bootstrap/css/light-bootstrap-dashboard.css" rel="stylesheet"/>

<!--  CSS for Demo Purpose, don't include it in your project     -->
<link href="../Components/Css/dashboard.css" rel="stylesheet" />

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Toggle -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<!--     Fonts and icons     -->
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
