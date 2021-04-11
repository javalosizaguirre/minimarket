<?php session_start();
$archivodemo = $_POST["hdarchivodemo"];
$archivoproduccion = $_POST["hdarchivoproduccion"];
unlink($archivodemo);
unlink($archivoproduccion);
echo '<script>  window.top.document.getElementById("lbl_archivo").style.display=\'\';'
    . '   window.top.document.getElementById("btneliminar").style.display=\'none\';'
    . '   window.top.document.getElementById("hdarchivodemo").value=\'\';'
    . '   window.top.document.getElementById("hdarchivoproduccion").value=\'\';'
    . '   window.top.document.getElementById("hdnombrearchivo").value=\'\';'
    . '   window.top.document.getElementById("sp_ruta").innerHTML=\'\'; </script>';
