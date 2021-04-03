<?php
session_start();
error_reporting(0);
date_default_timezone_set('America/Lima');
include_once '../../clases/gestioncomercial/comprobante.class.php';
include_once '../../../tools/phpqrcode/qrlib.php';


$clasecomprobante = new comprobante();
$datacomprobante = $clasecomprobante->consultar('1', $_GET["id"]);
$datadetalle = $clasecomprobante->consultar('2', $datacomprobante[0]["id"]);

$tipocomprobante = '';
if (strlen($datacomprobante[0]["cliente"]) == 8) {
    $tipocomprobante = '1';
} elseif (strlen($datacomprobante[0]["cliente"]) == 11) {
    $tipocomprobante = '6';
}

/* GENERAR CODIGO QR */
$codesdir = '../../../img/qr/';
$codefile = $datacomprobante[0]["serie"] . '-' . str_pad($datacomprobante[0]["nrocomprobante"], 8, "0", STR_PAD_LEFT) . '.png';
$infoqr = '20605714413|' . $datacomprobante[0]["tipocomprobante"] . '|' . $datacomprobante[0]["serie"] . '|' . str_pad($datacomprobante[0]["nrocomprobante"], 8, "0", STR_PAD_LEFT) . '|' . $datacomprobante[0]["igv"] . '|' . $datacomprobante[0]["total"] . '|' . $datacomprobante[0]["fechaventa"] . '|' . $tipocomprobante . '|' . $datacomprobante[0]["cliente"] . '|';
QRcode::png($infoqr, $codesdir . $codefile, 'H - Mejor', '2');

if ($datacomprobante[0]["tipocomprobante"] == '01') {
    $tipocomprobante = "Factura de Venta Electrónica";
} elseif ($datacomprobante[0]["tipocomprobante"] == '03') {
    $tipocomprobante = "Boleta de Venta Electrónica";
} elseif ($datacomprobante[0]["tipocomprobante"] == '00') {
    $tipocomprobante = "Nota de Venta";
}


/*Apartado para facturacion electronica en caliente*/
$c = 0;
$d = 1;

$databoleta = $clasecomprobante->consultarVenta('2', $_GET["id"]);
$datadetalle = $clasecomprobante->consultarVenta('3', $_GET["id"]);
$data = array();
$arraydetalle = array();


if ($databoleta[0]["tipocomprobante"] == '03') {
    $ruta = "http://localhost/minimarket/tools/UBL21/ws/boleta.php";
    $codigotipodocumento = '03';
    $arrayempresa = array(
        "ruc" => "20605714413",
        "tipo_doc" => '6',
        "nom_comercial" => 'A.A.A. MINIMARKET E.I.R.L.',
        "razon_social" => 'A.A.A. MINIMARKET E.I.R.L.',
        "codigo_ubigeo" => '021809',
        "direccion" => 'AV. PACIFICO MZA. A-1 LOTE. 2 (FRENTE DEL MERCADO BUENOS AIRES) ANCASH - SANTA - NUEVO CHIMBOTE',
        "direccion_departamento" => 'ANCASH',
        "direccion_provincia" => 'SANTA',
        "direccion_distrito" => 'NUEVO CHIMBOTE',
        "direccion_codigopais" => '9589',
        "usuariosol" => 'MODDATOS',
        "clavesol" => 'MODDATOS'
    );

    while ($c < count($datadetalle)) {
        $arraydetalle[$c] = array(
            "txtITEM" => $d++,
            "txtUNIDAD_MEDIDA_DET" => "NIU",
            "txtCANTIDAD_DET" => $datadetalle[$c]["cantidad"],
            "txtPRECIO_DET" => $datadetalle[$c]["precio"],
            "txtSUB_TOTAL_DET" => $datadetalle[$c]["subtotalsinigv"],
            "txtPRECIO_TIPO_CODIGO" => "01",
            "txtIGV" => $datadetalle[$c]["igv"],
            "txtISC" => "0", //  POR DEFECTO NO MOVER
            "txtIMPORTE_DET" => $datadetalle[$c]["subtotalsinigv"],
            "txtCOD_TIPO_OPERACION" => "10", // 10 POR DEFECTO NO MOVER
            "txtCODIGO_DET" => $datadetalle[$c]["detalle"],
            "txtDESCRIPCION_DET" => $datadetalle[$c]["descripcion"],
            "txtPRECIO_SIN_IGV_DET" => $datadetalle[$c]["subtotalsinigv"]
        );
        $c++;
    }



    foreach ($databoleta as $item) {
        $data["tipo_proceso"] = "3";
        $data["pass_firma"] = "20605714413";
        $data["tipo_operacion"] = "0101";
        $data["total_gravadas"] = $item["subtotal"];
        $data["total_inafecta"] = 0;
        $data["total_exoneradas"] = 0;
        $data["total_gratuitas"] = 0;
        $data["total_exportacion"] = 0;
        $data["total_descuento"] = 0;
        $data["sub_total"] = $item["subtotal"];
        $data["porcentaje_igv"] = '18.00';
        $data["total_igv"] = $item["igv"];
        $data["total_isc"] = "0";
        $data["total_otr_imp"] = "0";
        $data["total"] = $item["total"];
        $data["total_letras"] = numtoletras($item["total"]);
        $data["nro_guia_remision"] = "";
        $data["cod_guia_remision"] = "";
        $data["nro_otr_comprobante"] = "";
        $data["serie_comprobante"] = $item["serie"];
        $data["numero_comprobante"] = $item["nrocomprobante"];
        $data["fecha_comprobante"] = substr($item["fechaventa"], 0, 10);
        $data["fecha_vto_comprobante"] = substr($item["fechaventa"], 0, 10);
        $data["cod_tipo_documento"] = $codigotipodocumento;
        $data["cod_moneda"] = 'PEN';

        $data["cliente_numerodocumento"] = $item["nrodocumento"];
        $data["cliente_nombre"] = $item["nombres"];
        $data["cliente_tipodocumento"] = $codigotipodocumento;
        $data["cliente_direccion"] = $item["direccion"];
        $data["cliente_pais"] = "PE";
        $data["cliente_ciudad"] = "CHIMBOTE";
        $data["cliente_codigoubigeo"] = "";
        $data["cliente_departamento"] = "";
        $data["cliente_provincia"] = "";
        $data["cliente_distrito"] = "";
        $data["emisor"] = $arrayempresa;
        $data["detalle"] = $arraydetalle;
    }

    //Invocamos el servicio
    $token = ''; //en caso quieras utilizar algún token generado desde tu sistema
    //codificamos la data
    $data_json = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ruta);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Authorization: Token token="' . $token . '"',
            'Content-Type: application/json',
        )
    );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($respuesta, true);



    if ($response["respuesta"] == 'OK') {
        $clasecomprobante->mantenimientocomprobantesunatIndividual('1', $_GET["id"], @$data["serie_comprobante"], @$data["numero_comprobante"], @$response['respuesta'], @$response['hash_cpe'], @$response['hash_cdr'], @$response['cod_sunat'], @$response['msj_sunat'], '1');
        $codigohash = @$response['hash_cpe'];
    } else {
        $clasecomprobante->mantenimientocomprobantesunatIndividual('2', $_GET["id"], @$data["serie_comprobante"], @$data["numero_comprobante"], @$response['respuesta'], @$response['hash_cpe'], @$response['hash_cdr'], @$response['cod_sunat'], str_replace("'", "", @$response['msj_sunat']), '0');
    }
} elseif ($databoleta[0]["tipocomprobante"] == '01') {
    $ruta = "http://localhost/minimarket/tools/UBL21/ws/factura.php";
    $codigotipodocumento = '06';

    $arrayempresa = array(
        "ruc" => "20605714413",
        "tipo_doc" => '6',
        "nom_comercial" => 'A.A.A. MINIMARKET E.I.R.L.',
        "razon_social" => 'A.A.A. MINIMARKET E.I.R.L.',
        "codigo_ubigeo" => '021809',
        "direccion" => 'AV. PACIFICO MZA. A-1 LOTE. 2 (FRENTE DEL MERCADO BUENOS AIRES) ANCASH - SANTA - NUEVO CHIMBOTE',
        "direccion_departamento" => 'ANCASH',
        "direccion_provincia" => 'SANTA',
        "direccion_distrito" => 'NUEVO CHIMBOTE',
        "direccion_codigopais" => '9589',
        "usuariosol" => 'MODDATOS',
        "clavesol" => 'MODDATOS'
    );

    while ($c < count($datadetalle)) {
        $arraydetalle[$c] = array(
            "txtITEM" => $d++,
            "txtUNIDAD_MEDIDA_DET" => "NIU",
            "txtCANTIDAD_DET" => $datadetalle[$c]["cantidad"],
            "txtPRECIO_DET" => $datadetalle[$c]["precio"],
            "txtSUB_TOTAL_DET" => $datadetalle[$c]["subtotalsinigv"],
            "txtPRECIO_TIPO_CODIGO" => "01",
            "txtIGV" => $datadetalle[$c]["igv"],
            "txtISC" => "0", //  POR DEFECTO NO MOVER
            "txtIMPORTE_DET" => $datadetalle[$c]["subtotalsinigv"],
            "txtCOD_TIPO_OPERACION" => "10", // 10 POR DEFECTO NO MOVER
            "txtCODIGO_DET" => $datadetalle[$c]["detalle"],
            "txtDESCRIPCION_DET" => $datadetalle[$c]["descripcion"],
            "txtPRECIO_SIN_IGV_DET" => $datadetalle[$c]["subtotalsinigv"]
        );
        $c++;
    }



    foreach ($databoleta as $item) {
        $data["tipo_proceso"] = "3";
        $data["pass_firma"] = "20605714413";
        $data["tipo_operacion"] = "0101";
        $data["total_gravadas"] = $item["subtotal"];
        $data["total_inafecta"] = 0;
        $data["total_exoneradas"] = 0;
        $data["total_gratuitas"] = 0;
        $data["total_exportacion"] = 0;
        $data["total_descuento"] = 0;
        $data["sub_total"] = $item["subtotal"];
        $data["porcentaje_igv"] = '18.00';
        $data["total_igv"] = $item["igv"];
        $data["total_isc"] = "0";
        $data["total_otr_imp"] = "0";
        $data["total"] = $item["total"];
        $data["total_letras"] = numtoletras($item["total"]);
        $data["nro_guia_remision"] = "";
        $data["cod_guia_remision"] = "";
        $data["nro_otr_comprobante"] = "";
        $data["serie_comprobante"] = $item["serie"];
        $data["numero_comprobante"] = $item["nrocomprobante"];
        $data["fecha_comprobante"] = substr($item["fechaventa"], 0, 10);
        $data["fecha_vto_comprobante"] = substr($item["fechaventa"], 0, 10);
        $data["cod_tipo_documento"] = "01";
        $data["cod_moneda"] = 'PEN';

        $data["cliente_numerodocumento"] = $item["nrodocumento"];
        $data["cliente_nombre"] = $item["nombres"];
        $data["cliente_tipodocumento"] = "6";
        $data["cliente_direccion"] = $item["direccion"];
        $data["cliente_pais"] = "PE";
        $data["cliente_ciudad"] = "CHIMBOTE";
        $data["cliente_codigoubigeo"] = "";
        $data["cliente_departamento"] = "";
        $data["cliente_provincia"] = "";
        $data["cliente_distrito"] = "";
        $data["emisor"] = $arrayempresa;
        $data["detalle"] = $arraydetalle;
    }

    //Invocamos el servicio
    $token = ''; //en caso quieras utilizar algún token generado desde tu sistema
    //codificamos la data
    $data_json = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ruta);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Authorization: Token token="' . $token . '"',
            'Content-Type: application/json',
        )
    );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($respuesta, true);


    if ($response["respuesta"] == 'OK') {
        $clasecomprobante->mantenimientocomprobantesunatIndividual('1', $_GET["id"], $data["serie_comprobante"], $data["numero_comprobante"], @$response['respuesta'], @$response['hash_cpe'], @$response['hash_cdr'], @$response['cod_sunat'], @$response['msj_sunat'], '1');
        $codigohash = @$response['hash_cpe'];
    } else {
        $clasecomprobante->mantenimientocomprobantesunatIndividual('2', $_GET["id"], $data["serie_comprobante"], $data["numero_comprobante"], @$response['respuesta'], @$response['hash_cpe'], @$response['hash_cdr'], @$response['cod_sunat'], str_replace("'", "", @$response['msj_sunat']), '0');
    }
}



function numtoletras($xcifra)
{
    $xarray = array(
        0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
    //
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)) {  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            } else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            } else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena .= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena .= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena .= "UN BILLON ";
                    else
                        $xcadena .= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena .= "UN MILLON ";
                    else
                        $xcadena .= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO CON $xdecimales/100 SOLES";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN CON $xdecimales/100 SOLES ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena .= " CON $xdecimales/100 SOLES "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <script type="text/javascript">
        function printdoc() {
            if (!window.print) {
                alert("Su navegador no soporta Imprimir. Actualize su navegador.\n")
                return;
            }
            window.print();
        }
    </script>

    <link rel="stylesheet" href="../../../css/print.css" type="text/css" />

</head>

<body>
    <table>
        <tr>
            <td align="center" style="font-size:16px; font-weight:bold">.:: AAA MINIMARKET E.I.R.L. ::.</td>
        </tr>
        <tr>
            <td align="center" style="font-size:16px; font-weight:bold">R.U.C. 20605714413</td>
        </tr>
        <tr>
            <td align="center" style="font-size:16px; font-weight:bold">AV. PACÍFICO A-1 NUEVO CHIMBOTE - ANCASH</td>
        </tr>
        <tr>
            <td align="center" style="font-size:12px">FECHA/HORA: <?php echo $datacomprobante[0]["fechaventa"]; ?></td>
        </tr>
        <tr>
            <td align="center" style="font-size:12px"><?php echo $tipocomprobante . ' : ' . $datacomprobante[0]["serie"] . '-' . str_pad($datacomprobante[0]["nrocomprobante"], 8, "0", STR_PAD_LEFT); ?> </td>
        </tr>
        <tr>
            <td>
                ===========================================
            </td>
        </tr <tr>
        <td align="left" style="font-size:12px">Nro. Doc. <?php echo $datacomprobante[0]["cliente"]; ?> </td>
        </tr>
        <tr>
            <td align="left" style="font-size:12px">Cliente <?php echo $datacomprobante[0]["nombres"]; ?> </td>
        </tr>
        <tr>
            <td>
                ===========================================
            </td>
        </tr <tr>
        <td>
            <table>
                <tr>
                    <td style="font-size:12px">CANT.</td>
                    <td style="font-size:12px">DESCRIPCION</td>
                    <td style="font-size:12px">PU</td>
                    <td style="font-size:12px">DCTO.</td>
                    <td style="font-size:12px">IMPORTE</td>
                </tr>
                <?php
                $cantidadarticulos = 0;
                foreach ($datadetalle as $value) {
                    echo '<tr>
                            <td  style="font-size:12px">' . $value["cantidad"] . '</td>
                            <td  style="font-size:12px">' . $value["descripcion"] . '</td>
                            <td  style="font-size:12px" align="right">' . $value["precio"] . '</td>
                            <td  style="font-size:12px" align="right">0.00</td>
                            <td  style="font-size:12px" align="right">' . (number_format(($value["cantidad"] * $value["precio"]), 2, '.', '')) . '</td></tr>';
                    $cantidadarticulos++;
                }
                ?>
                <tr align="right">
                    <td colspan="4">
                        DCTO
                    </td>
                    <td style="font-size:12px">
                        0.00
                    </td>
                </tr>
                <?php
                if ($datacomprobante[0]["tipocomprobante"] == '01') {
                    echo '<tr align="right">
                            <td colspan="4">
                                SUBTOTAL
                            </td>
                            <td style="font-size:12px">
                                ' . $datacomprobante[0]["subtotal"] . '
                            </td>
                        </tr>
                    <tr align="right">
                            <td colspan="4">
                                IGV
                            </td>
                            <td style="font-size:12px">
                                ' . $datacomprobante[0]["igv"] . '
                            </td>
                        </tr>';
                }
                ?>
                <tr align="right">
                    <td colspan="4" style="font-size:16px; font-weight:bold">
                        TOTAL
                    </td>
                    <td style="font-size:16px; font-weight:bold">
                        <?php echo $datacomprobante[0]["total"] ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="5" align="center">
                        Autorizado mediante Resolución de Intendencia
                        N° 032- 005 Representación impresa de la
                        Boleta de Venta Electronica.
                    </td>
                </tr>
                <tr>
                    <td colspan="5" align="center"><?php echo (@$codigohash != '' ? 'HASH: ' . @$codigohash : '') ?></td>
                </tr>
                <tr>
                    <td colspan="5" align="center">
                        <img src="../../../img/qr/<?php echo $datacomprobante[0]['serie'] . '-' . str_pad($datacomprobante[0]['nrocomprobante'], 8, '0', STR_PAD_LEFT) . '.png' ?>" alt="">

                    </td>
                </tr>
                <tr>
                    <td colspan="5" align="center">
                        CANCELADO
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        Número de artículos: <?php echo $cantidadarticulos ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        Caj.: <?php echo $_SESSION["sys_usuario_nombre"] . ' ' . $_SESSION["sys_usuario_apellido"] ?>
                    </td>
                </tr>

            </table>
        </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td style="font-size:16px; font-weight:bold">Pago con</td>
                        <td style="font-size:16px; font-weight:bold">S/</td>
                        <td align="right" style="font-size:16px; font-weight:bold"><?php echo ($datacomprobante[0]["formapago"] == '3' ? number_format($datacomprobante[0]["total"], 2, '.', '') : number_format($datacomprobante[0]["pagocon"], 2, '.', ''))  ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:16px; font-weight:bold">Vuelto</td>
                        <td style="font-size:16px; font-weight:bold">S/</td>
                        <td align="right" style="font-size:16px; font-weight:bold"><?php echo ($datacomprobante[0]["formapago"] == '3' ? '0.00' : number_format($datacomprobante[0]["vuelto"], 2, '.', '')) ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center">
                GRACIAS POR SU COMPRA!!!
            </td>
        </tr>
        <tr>
            <td>
                ===========================================
            </td>
        </tr>
        <tr>
            <td align="center">
                :: AAA MINIMARKET E.I.R.L::. <br>
                R.U.C:20605714413
            </td>
        </tr>
    </table>



    <script type="text/javascript">
        printdoc();
    </script>
</body>

</html>