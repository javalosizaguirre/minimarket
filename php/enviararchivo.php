<?php


session_start();
//actualizar_instrumento_evaluacion();
//function actualizar_instrumento_evaluacion(){

$ruc = $_POST["RUC_EMPRESA"];
$arrayicon["pfx"]  = 'img/key.png';

$pathdemo              = '../tools/UBL21/archivos_xml_sunat/certificados/beta/' . $ruc . '/';
$pathproduccion        = '../tools/UBL21/archivos_xml_sunat/certificados/produccion/' . $ruc . '/';

$carpetacpedemo = '../tools/UBL21/archivos_xml_sunat/cpe_xml/beta/' . $ruc . '/';
$carpetacpeproduccion = '../tools/UBL21/archivos_xml_sunat/cpe_xml/produccion/' . $ruc . '/';

if (!file_exists($pathdemo)) {
    if (!mkdir($pathdemo, 0777, true)) {
        die('Fallo al crear las carpetas Demo Certificado Digital...');
    }
}

if (!file_exists($pathproduccion)) {
    if (!mkdir($pathproduccion, 0777, true)) {
        die('Fallo al crear las carpetas Produccion Certificado Digital...');
    }
}

if (!file_exists($carpetacpedemo)) {
    if (!mkdir($carpetacpedemo, 0777, true)) {
        die('Fallo al crear las carpetas Demo CPE...');
    }
}

if (!file_exists($carpetacpeproduccion)) {
    if (!mkdir($carpetacpeproduccion, 0777, true)) {
        die('Fallo al crear las carpetas produccion CPE...');
    }
}

$filename = $_FILES["fileevidencia"]["name"];
$pos               = strpos($filename, ".");
$ext               = substr($filename, $pos + 1);
$archivo_con_punto = preg_split("/\./", $filename);
$ultimo_punto      = count($archivo_con_punto) - 1;
$ext               = $archivo_con_punto[$ultimo_punto];
$ext               = strtolower($ext);
$nombre = $filename;

$tipo = $_FILES["fileevidencia"]["type"];
$rutatmp = $_FILES["fileevidencia"]["tmp_name"];
$tamanio = $_FILES["fileevidencia"]["size"];

$archivoname = $ruc . '.' . $ext;

$nomruta           = $pathdemo . '/' . $nombre;
$ruta              = $pathdemo . $archivoname;

$nomrutaproduccion           = $pathproduccion . '/' . $nombre;
$rutaproduccion              = $pathproduccion . $archivoname;

if (!$arrayicon[$ext] || $nombre == "") {
    echo '<script>alert("El archivo no cumple con las reglas establecidas \nSi el Documento esta Selecciionado\n\r Si el formato del archivo es válido(Dcumento de Word, Archivo PDF, Archivo comprimido zip o rar) ")</script>';
    echo '<script>window.top.document.getElementById("DivTrans").style.display="none";</script>';
    die();
}
if (is_uploaded_file($_FILES['fileevidencia']['tmp_name'])) {
    copy($_FILES['fileevidencia']['tmp_name'], $pathdemo . $archivoname);
    copy($_FILES['fileevidencia']['tmp_name'], $pathproduccion . $archivoname);
    if (file_exists($ruta)) {
        $subio = true;
        if ($subio) {
            echo '<script>window.top.document.getElementById("sp_ruta").innerHTML="<a href=\'javascript:void(0)\' style=\'color:#990000\' onclick=window.open(\'' . substr($ruta, 6) . '\',\'' . $nombre . '\',\'width=500,height=400\')  ><img width=\'20px\' src=\'' . $arrayicon[$ext] . '\'> ' . $nombre . ' </a>";'
                . '   window.top.document.getElementById("lbl_archivo").style.display=\'none\';'
                . '   window.top.document.getElementById("btneliminar").style.display=\'\';'
                . '   window.top.document.getElementById("hdarchivodemo").value=\'' . $ruta . '\';'
                . '   window.top.document.getElementById("hdarchivoproduccion").value=\'' . $rutaproduccion . '\';'
                . '   window.top.document.getElementById("hdnombrearchivo").value=\'' . $nombre . '\';'
                . '   window.top.document.getElementById("BtnMantenimientoNuevo") ? window.top.document.getElementById("BtnMantenimientoNuevo").disabled = false: \'\';  </script>';
        } else {
            echo '<script>alert("El archivo no cumple con las reglas establecidas")</script>';
        }
    } else {
        echo '<script>alert("No se pudo subir el archivo, comunicarse con Division de sistemas: Operacion de TI")</script>';
    }
}
