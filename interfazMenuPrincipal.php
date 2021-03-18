<?php
session_start();
include_once "php/clases/admin.class.php";
$clsAdmin = new admin();

$dataModulos = $clsAdmin->consultarMenu('1',$_SESSION["sys_perfil"]);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Minimarket</title>
    
    <script type="text/javascript" src="js/jquery.min.js" ></script>
    <script type="text/javascript" src="js/solid.js" ></script>
    <script type="text/javascript" src="js/fontawesome.js" ></script>
    <script type="text/javascript" src="js/sidebar.js" ></script>

    <link rel="stylesheet" href="css/bootstrap-4.6.0-dist/bootstrap.min.css">   
    <link rel="stylesheet" href="css/stylesidebar.css">        
    <link rel="stylesheet" href="css/all.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    

      
    
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
          <img class="img-responsive img-rounded" src="img/user.jpg"
            alt="User picture">
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
                                <i class="'.$value["Imagen"].'"></i>
                                <span>'.$value["Nombre"].'</span>
                            </a>';
                            $dataOpciones = $clsAdmin->consultarMenu('2',$_SESSION["sys_perfil"], $value["Menu"]);
                                echo '<div class="sidebar-submenu">';
                            foreach ($dataOpciones as $item) {
                                echo '
                                        <ul>
                                            <li>
                                                <a href="#">'.$item["Nombre"].'</a>
                                            </li>
                                        </ul>
                                        ';
                            }
                    echo '  </div>
                        </li>';
                }
            ?>
        <!--    
        <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-tachometer-alt"></i>
              <span>Dashboard</span>
              <span class="badge badge-pill badge-warning">New</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Dashboard 1
                    <span class="badge badge-pill badge-success">Pro</span>
                  </a>
                </li>
                <li>
                  <a href="#">Dashboard 2</a>
                </li>
                <li>
                  <a href="#">Dashboard 3</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-shopping-cart"></i>
              <span>E-commerce</span>
              <span class="badge badge-pill badge-danger">3</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Products

                  </a>
                </li>
                <li>
                  <a href="#">Orders</a>
                </li>
                <li>
                  <a href="#">Credit cart</a>
                </li>
              </ul>
            </div>
          </li>
          
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-chart-line"></i>
              <span>Charts</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Pie chart</a>
                </li>
                <li>
                  <a href="#">Line chart</a>
                </li>
                <li>
                  <a href="#">Bar chart</a>
                </li>
                <li>
                  <a href="#">Histogram</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-globe"></i>
              <span>Maps</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Google maps</a>
                </li>
                <li>
                  <a href="#">Open street map</a>
                </li>
              </ul>
            </div>
          </li>
            -->
                    
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
    <div class="container-fluid">
      

      
    </div>
  </main>
  <!-- page-content" -->
</div>

    <script src="js/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>    
    <script src="js/4.1.0/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    
</body>

</html>