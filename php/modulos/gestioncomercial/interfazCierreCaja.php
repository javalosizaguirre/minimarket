<?php
include_once RUTA_CLASES . 'caja.class.php';
class interfazCierreCaja
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clasecaja = new caja();
        $datacaja = $clasecaja->consultar('2', '');

        $titulo = "Cierre de Caja";
        $html = ' 
    
    <div class="card" style="width:50%;text-align:center; margin-left:23%">
        <div class="card-header">' . $titulo . '</div>
            <div class="card-body">        
                <form class="form-inline" onsubmit="return false;" id="form">
                    <table stely="width:100%" align="center">
                        <tr>
                            <td style="width:15%;text-align:left">Usuario</td>
                            <td><input style="width:60%;text-align:left" class="form-control" type="text" id="txtUsuario" name="txtUsuario" value="' . $_SESSION["sys_usuario"] . '" readonly></td>
                        </tr>
                        <tr>
                            <td>Fecha</td>
                            <td><input style="width:60%" type="text" class="form-control datepicker" id="txtFecha" name="txtFecha" readonly value="' . date("d-m-Y") . '"></td>
                        </tr>
                        <tr>
                            <td>Caja</td>
                            <td>
                                <select id="lstCaja" name="lstCaja" class="form-control" style="width:60%">
                                    <option value="">Seleccionar...</option>';
        foreach ($datacaja as $value) {
            $html .= '<option value="' . $value["id"] . '">' . $value["descripcion"] . '</option>';
        }
        $html .= '</select>
                            </td>
                        </tr>                        
                        <tr>
                            <td  style="text-align:center" colspan="2"><button type="button" class="btn btn-secondary" id="btnDetallado">Detallado</button>
                            <button type="button" class="btn btn-secondary" id="btnGeneral">Cerrar Caja</button>                            
                        </tr>
                    </table>
                    
                </form>             
            </div>
                                
           <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contenido">
                    
                </div>
                <div class="modal-footer" id="footer">
                </div>
                </div>
            </div>
            </div>


        </div>

        </div>
    </div>
    
    ';

        return $html;
    }

    function verDetallado($form)
    {
        $clasecaja = new caja();
        $claseventa = new venta();

        $datadetalle = $clasecaja->verDetallado('1', $form);
        $html = '<table id="tab_" class="data-tbl-simple table table-bordered" style="border-left:#ccc 1px solid;border-right:0px;width:100%;">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Serie</th>
                            <th>Comprobante</th>
                            <th>Subtotal</th>
                            <th>IGV</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>';
        $c = 1;
        $total = 0.00;
        foreach ($datadetalle as $value) {
            $html .= '<tr style="background:#bdbdbd">
                            <td>' . $c++ . '</td>                            
                            <td style="text-align:left;font-size:16px; font-weight:bold">' . $value["serie"] . '</td>
                            <td style="text-align:left;font-size:16px; font-weight:bold">' .  str_pad($value["nrocomprobante"], 8, "0", STR_PAD_LEFT)  . '</td>
                            <td style="text-align:right;font-size:16px; font-weight:bold">' . $value["subtotal"] . '</td>
                            <td style="text-align:right;font-size:16px; font-weight:bold">' . $value["igv"] . '</td>
                            <td style="text-align:right;font-size:16px; font-weight:bold">' . $value["total"] . '</td>
                        </tr>';
            $datedetalleventa = $claseventa->consultar(1, $value["id"]);
            $html .= '<tr style="background:#e1e1e1">
                            <td></td>
                            <td colspan="2" style="text-align:center">Producto</td>
                            <td style="text-align:center">Cant.</td>
                            <td style="text-align:center">Precio</td>
                            <td style="text-align:center">Subtotal</td>
                            
                        </tr>';
            foreach ($datedetalleventa as  $item) {
                $html .= '<tr >
                            <td></td>
                            <td colspan="2">' . $item["descripcion"] . '</td>
                            <td>' . $item["cantidad"] . '</td>
                            <td>' . $item["precio"] . '</td>
                            <td style="text-align:right">' . (number_format(($item["cantidad"] * $item["precio"]), 2, '.', '')) . '</td>
                            
                        </tr>';
            }

            $total = $total + $value["total"];
        }
        $html .= '
            <tr>
                <td colspan="5" style="text-align:center">TOTAL</td>
                <td colspan="5" style="text-align:right;font-size:16px; font-weight:bold">' . $total . '</td>
            </tr>
        </tbody>
                </table>';

        $botones = '<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-remove"></i>Cerrar</button>';


        return array($html, $botones);
    }



    function verGenerla($form)
    {
        $clasecaja = new caja();
        $claseventa = new venta();

        $datadetalle = $clasecaja->verDetallado('2', $form);
        $datasaldo = $clasecaja->verDetallado('4', $form);
        $html = ' <form class="form-inline" onsubmit="return false;" id="formCierre">
                    <table style="width:50%" align="center">
                    <thead>
                        <tr>
                            <td style="text-align:center; font-size:20px;font-weight:bold" colspan="4">.::SALDO INICIAL::.</td>
                        </tr>

                        <tr>
                            <th>ITEM</th>
                            <th>SALDO</th>                            
                            <th colspan="2">TOTAL</th>                            
                        </tr>';
        $d = 1;
        foreach ($datasaldo as $val) {
            $html .= '<tr>
                            <th colspan="2">TOTAL</th>                            
                            <td style="text-align:left;">S/ </td>
                            <th style="text-align:right;font-size:16px; font-weight:bold">' . $val["montoapertura"] . '</th>                            
                        </tr>';
        }
        $html .= '<tr>
                            <td colspan="4">===============================================</th>
                        </tr>
                        <tr>
                            <td colspan="4">===============================================</th>
                        </tr>
                        <tr>
                            <td style="text-align:center; font-size:20px;font-weight:bold" colspan="4">.::RESUMEN DE VENTAS::.</td>
                        </tr>

                        <tr>
                            <th>ITEM</th>
                            <th>FORMA DE PAGO</th>
                            <th colspan="2">TOTAL</th>                            
                        </tr>
                        <tr>
                            <td colspan="4">===============================================</th>
                        </tr>
                    </thead>
                    <tbody>';
        $c = 1;
        $total = 0.00;
        $totaltarjeta = 0.00;
        $totalefectivo = 0.00;
        foreach ($datadetalle as $value) {
            $html .= '<tr >
                            <td>' . $c++ . '</td>                            
                            <td style="text-align:left;">' . $value["descripcion"] . '</td>
                            <td style="text-align:left;">S/ </td>
                            <td style="text-align:right;font-size:16px; font-weight:bold">' . $value["total"] . '</td>
                        </tr>
                        ';

            if ($value["formapago"] == '3') {
                $datatarjeta = $clasecaja->verDetallado('3', $form);
                foreach ($datatarjeta as $item) {
                    $html .= '<tr>
                                <td></td>                                
                                <td style="text-align:left;">' . $item["descripcion"] . '</td>
                                <td style="text-align:left;">S/ </td>
                                <td style="text-align:right;">' . $item["total"] . '</td>
                            </tr>';
                    $totaltarjeta = $totaltarjeta + $item["total"];
                }
            } elseif ($value["formapago"] == '1') {
                $totalefectivo = $value["total"];
            }
            $html .= '<tr>
                            <td colspan="4">===============================================</th>
                        </tr>';
            $total = $total + $value["total"];
        }
        $html .= '
            <tr>
                <td colspan="2" style="text-align:left">TOTAL VENTAS</td>
                <td style="text-align:left;">S/ </td>
                <td  style="text-align:right;font-size:16px; font-weight:bold">' . (number_format(($total), 2, '.', '')) . '</td>
            </tr>
            
            <tr>
                            <td colspan="4">===============================================</th>
                        </tr>
            <tr>
                            <td colspan="4">===============================================</th>
                        </tr>
                        <tr>
                            <td style="text-align:center; font-size:20px;font-weight:bold" colspan="4">.::RESUMEN FINAL::.</td>
                        </tr>
                        <tr>
                            
                            <td colspan="2" style="text-align:left;">SALDO INICIAL</td>
                            <td style="text-align:left;">S/ </td>
                            <td style="text-align:right;font-size:16px; font-weight:bold">' . (number_format(($datasaldo["0"]["montoapertura"]), 2, '.', '')) . '</td>
                        </tr>
                        <tr>
                            
                            <td colspan="2"  style="text-align:left;">TOTAL VENTAS</td>
                            <td style="text-align:left;">S/ </td>
                            <td style="text-align:right;font-size:16px; font-weight:bold">' . (number_format(($total), 2, '.', '')) . '</td>
                        </tr>     
                        <tr>
                            
                            <td colspan="2"  style="text-align:left;">TOTAL EN CAJA (Monto Inicial + Total de Ventas)</td>
                            <td style="text-align:left;">S/ </td>
                            <td style="text-align:right;font-size:16px; font-weight:bold">' . (number_format(($datasaldo["0"]["montoapertura"] + $total), 2, '.', '')) . '</td>
                        </tr>                     

        </tbody>
                </table>
                <input type="hidden" id="txtEfectivo" name="txtEfectivo" class="form-control" value="' . (number_format(($totalefectivo), 2, '.', '')) . '">
                <input type="hidden" id="txtTarjeta" name="txtTarjeta" class="form-control"  value="' . (number_format(($totaltarjeta), 2, '.', '')) . '">
                <input type="hidden" id="txtTotal" name="txtTotal" class="form-control"  value="' . (number_format(($total), 2, '.', '')) . '">
                <input type="hidden" id="txtIdCaja" name="txtIdCaja" class="form-control"  value="' . $form["lstCaja"] . '">
                <input type="hidden" id="txtIdApertura" name="txtIdApertura" class="form-control"  value="' . $datasaldo[0]["id"] . '">
                
                        
                </form>';

        $botones = '<button type="button" class="btn btn-primary" id="btnCerrarCaja"><i class="icon-remove"></i>Cerrar Caja</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-remove"></i>Cerrar</button>';


        return array($html, $botones);
    }
}


function _interfazCierreCaja()
{
    $rpta = new xajaxResponse();
    $cls = new interfazCierreCaja();

    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);

    $rpta->script("
        $('#btnDetallado').unbind('click').click(function() {
            xajax__verCierreDetallado(xajax.getFormValues('form'));
        });");

    $rpta->script("
        $('#btnGeneral').unbind('click').click(function() {
            xajax__verCierreGeneral(xajax.getFormValues('form'));
        });");

    $rpta->script("$('.datepicker').datepicker({
        clearBtn: true,
        language: 'es'
    });");
    return $rpta;
}

function _verCierreDetallado($form)
{
    $rpta = new xajaxResponse();
    $cls = new interfazCierreCaja();
    $msj1 = '';
    $msj = 'LOS SIGUIENTES CAMPOS SON REQUERIDOS (*)';
    $msj .= '\\n-----------------------------------------------------------------------\\n';


    if ($form["lstCaja"] == '') {
        $msj1 .= '- Debe seleccionar una Caja\\n';
    }


    if ($msj1 != '') {
        $rpta->script('alert("' . $msj . $msj1 . '")');
    } else {
        $html = $cls->verDetallado($form);
        $rpta->script("$('#modal .modal-header h5').text('Detallado');");
        $rpta->assign("contenido", "innerHTML", $html[0]);
        $rpta->assign("footer", "innerHTML", $html[1]);
        $rpta->script("$('#modal').modal('show')");
    }

    return $rpta;
}

function _verCierreGeneral($form)
{
    $rpta = new xajaxResponse();
    $cls = new interfazCierreCaja();
    $msj1 = '';
    $msj = 'LOS SIGUIENTES CAMPOS SON REQUERIDOS (*)';
    $msj .= '\\n-----------------------------------------------------------------------\\n';


    if ($form["lstCaja"] == '') {
        $msj1 .= '- Debe seleccionar una Caja\\n';
    }


    if ($msj1 != '') {
        $rpta->script('alert("' . $msj . $msj1 . '")');
    } else {
        $clasecaja = new caja();
        $datacaja = $clasecaja->consultar('1', $form["lstCaja"]);

        if ($datacaja[0]["total"] === '0') {
            $rpta->alert("No existen datos para la fecha y Caja seleccionados");
        } else {
            $html = $cls->verGenerla($form);
            $rpta->script("$('#modal .modal-header h5').text('CIERRE DE CAJA');");
            $rpta->assign("contenido", "innerHTML", $html[0]);
            $rpta->assign("footer", "innerHTML", $html[1]);
            $rpta->script("$('#modal').modal('show')");
        }
    }

    $rpta->script("
        $('#btnCerrarCaja').unbind('click').click(function() {
            xajax__cerrarCaja(xajax.getFormValues('formCierre'));
        });");


    return $rpta;
}

function _cerrarCaja($form)
{
    $rpta = new xajaxResponse();
    $clase = new caja();
    $interfaz = new interfazVentas();

    $msj1 = '';
    $msj = 'LOS SIGUIENTES CAMPOS SON REQUERIDOS (*)';
    $msj .= '\\n-----------------------------------------------------------------------\\n';



    $result = $clase->mantenedor('2', $form);
    if ($result[0]['mensaje'] == 'MSG_002') {
        $rpta->alert(MSG_001);
        $rpta->script("jQuery('#modal').modal('hide');");
    } else {
        $rpta->alert("Error al Cerrar Caja, por favor comuníques con el Administrador del Sistema");
    }

    return $rpta;
}

$xajax->register(XAJAX_FUNCTION, '_interfazCierreCaja');
$xajax->register(XAJAX_FUNCTION, '_verCierreDetallado');
$xajax->register(XAJAX_FUNCTION, '_verCierreGeneral');
$xajax->register(XAJAX_FUNCTION, '_cerrarCaja');
