<?php
session_start();
include_once "config.php";
include_once "clases/gestioncomercial/admin.class.php";



$clsAdmin = new admin();

$usuario = $_POST["hhddUsuario"];
$clave = md5($_POST["hhddPassword"]);

$datosUsuario = $clsAdmin->logeo($usuario, $clave);


if ($datosUsuario[0]["perfil"] != '') {
    $_SESSION["sys_usuario"] = $usuario;
    $_SESSION["sys_perfil"] = $datosUsuario[0]["perfil"];
    $_SESSION["sys_img"] = $datosUsuario[0]["rutaimg"];
    $_SESSION["sys_perfil_nombre"] = $datosUsuario[0]["descripcion"];
    $_SESSION["sys_usuario_nombre"] = $datosUsuario[0]["nombres"];
    $_SESSION["sys_usuario_apellido"] = $datosUsuario[0]["apellidos"];
    $_SESSION["sys_caja_asignada"] = $datosUsuario[0]["cajaasignada"];
    $_SESSION["carrito"] = array();
    $_SESSION["notaingreso"] = array();
    $_SESSION["sys_mensaje_sunat"] = '';
    header('Location: ../interfazMenuPrincipal.php');
} else {
    header('Location: ../');
}
