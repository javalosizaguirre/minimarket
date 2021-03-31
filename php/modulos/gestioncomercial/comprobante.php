<?php
session_start();
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
/*
    [id] => 40 
    [tipocomprobante] => 01 
    [serie] => F001 
    [nrocomprobante] => 139 
    [fechaventa] => 2021-03-23 
    [cliente] => 42412264 
    [formapago] => 1 
    [tarjeta] => 
    [subtotal] => 3.39 
    [igv] => 0.61 
    [total] => 4.00     
*/
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
                        <td align="right" style="font-size:16px; font-weight:bold"><?php echo (number_format($datacomprobante[0]["pagocon"], 2, '.', ''))  ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:16px; font-weight:bold">Vuelto</td>
                        <td style="font-size:16px; font-weight:bold">S/</td>
                        <td align="right" style="font-size:16px; font-weight:bold"><?php echo (number_format($datacomprobante[0]["vuelto"], 2, '.', '')) ?></td>
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