<?php
session_start();
include_once "tools/xajax/xajax_core/xajax.inc.php";
include_once "php/config.php";
include_once "php/mensajes.php";
include_once RUTA_CLASES . "menu.class.php";
include_once RUTA_PHP . "interfaz.abstract.php";
include_once RUTA_PHP . "funciones.php";
include_once RUTA_DATAGRID . "dataGrid.class.php";


$xajax = new xajax();
$xajax->configure('javascript URI', 'tools/xajax/');
$xajax->configure("errorHandler", true);
$xajax->register(XAJAX_PROCESSING_EVENT, XAJAX_PROCESSING_EVENT_INVALID, "onInvalidRequest");

include RUTA_PHP_MODULO . "interfazPerfil.php";
include RUTA_PHP_MODULO . "interfazUsuarios.php";


$clsMenu = new menu();
$dataModulos = $clsMenu->consultarMenu('1', $_SESSION["sys_perfil"]);

$xajax->processRequest();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Minimarket</title>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/solid.js"></script>
    <script type="text/javascript" src="js/fontawesome.js"></script>
    <script type="text/javascript" src="js/sidebar.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>

    <link rel="stylesheet" href="css/bootstrap-4.6.0-dist/bootstrap.min.css">
    <link rel="stylesheet" href="css/stylesidebar.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/datagrid.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <?php
    $xajax->printJavascript('/');
    ?>


</head>

<body>

    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-brand">
                    <a href="#">Minimarket aaa</a>
                    <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <div class="sidebar-header">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="img/user.jpg" alt="User picture">
                    </div>
                    <div class="user-info">
                        <span class="user-name"><?php echo $_SESSION["sys_usuario_nombre"] ?>
                            <strong><?php echo $_SESSION["sys_usuario_apellido"] ?></strong>
                        </span>
                        <span class="user-role"><?php echo $_SESSION["sys_perfil_nombre"] ?></span>
                        <span class="user-status">
                            <i class="fa fa-circle"></i>
                            <span>Conectado</span>
                        </span>
                    </div>
                </div>
                <!-- sidebar-header  -->
                <div class="sidebar-menu">
                    <ul>

                        <?php
                        foreach ($dataModulos as $value) {
                            echo '<li class="sidebar-dropdown">
                            <a href="#">
                                <i class="' . $value["Imagen"] . '"></i>
                                <span>' . $value["Nombre"] . '</span>
                            </a>';
                            $dataOpciones = $clsMenu->consultarMenu('2', $_SESSION["sys_perfil"], $value["Menu"]);
                            echo '<div class="sidebar-submenu">';
                            foreach ($dataOpciones as $item) {
                                echo '
                                        <ul>
                                            <li>
                                                <a href="javascript:void(0)" onclick="' . $item["Url"] . '">' . $item["Nombre"] . '</a>
                                            </li>
                                        </ul>
                                        ';
                            }
                            echo '  </div>
                        </li>';
                        }
                        ?>
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-content  -->
            <div class="sidebar-footer">
                <!--
      <a href="#">
        <i class="fa fa-bell"></i>
        <span class="badge badge-pill badge-warning notification">3</span>
      </a>
      <a href="#">
        <i class="fa fa-envelope"></i>
        <span class="badge badge-pill badge-success notification">7</span>
      </a>
      <a href="#">
        <i class="fa fa-cog"></i>
        <span class="badge-sonar"></span>
      </a>
    -->
                <a href="php/cerrar_sesion.php">
                    <i class="fa fa-power-off"></i>
                </a>
            </div>
        </nav>
        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container-fluid" id="container">



            </div>
        </main>
    </div>

    <script src="js/popper.min.js"></script>
    <script src="js/4.1.0/bootstrap.min.js"></script>


</body>

</html>