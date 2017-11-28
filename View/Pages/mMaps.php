<!doctype html>
<html lang="en">
<head>
    <title>Usuarios</title>
    <?php include_once "head.php"; ?>
    <?php require_once "../../models/TipoUsuario.php"; ?>
    <style>
        #legend {
            font-family: Arial, sans-serif;
            background: #fff;
            padding: 10px;
            margin: 10px;
            border: 3px solid #000;
        }
        #legend h3 {
            margin-top: 0;
        }
        #legend img {
            vertical-align: middle;
        }
    </style>
</head>
<div>
    <?php include_once "menu.php"; ?>

    <div class="container-fluid">
        <div class="row">
            <br>
            <div class="col-md-12">
                <div id="map" style="height: 600px; width: 100%"></div>
                <div id="legend"><h3>Legenda</h3></div>
            </div>
        </div>
    </div>
</div>

</body>
<!-- Map Icons -->
<script type="text/javascript" src="../Components/MapIcons/js/map-icons.js"></script>
<script src="../Components/Js/initMapAdm.js"></script>

<?php include_once "footer.php"; ?>

<script src="../Components/JQuery/jquery-minicolors.js"></script>
<link href="../Components/Css/jquery.minicolors.css" rel="stylesheet" />
</html>