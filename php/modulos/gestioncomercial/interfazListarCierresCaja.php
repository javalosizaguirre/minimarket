<?php
include_once RUTA_CLASES . 'caja.class.php';
class interfazListarCierresCaja
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clasecaja = new caja();
        $datacaja = $clasecaja->consultar("2", "");
        $clsabstract->legenda('fas fa-search', 'Ver detalle de cierre');
        $clsabstract->legenda('fas fa-lock-open', 'Reaperturar Caja');


        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Productos";
        $html = ' 
    
    <div class="card">
        <div class="card-header">' . $titulo . '</div>
            <div class="card-body">        
                <form class="form-inline" onsubmit="return false;">                    
                    <input type="text" class="form-control" id="txtBuscar" placeholder="Buscar por descripcion" style="width:70%">                           
                    <button type="button" class="btn btn-secondary" id="btnBuscar"><i class="fas fa-search"></i>Buscar</button>                                          
                </form>             
            </div>
            
            <div class="card-body" id="outQuery">
                ' . $this->datagrid('') . '
            </div>
            <p><center>' . $leyenda . '</center></p>
        
        
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

    function datagrid($criterio, $total_regs = 0, $pagina = 1, $nreg_x_pag = 100)
    {
        $Grid = new eGrid();
        $Grid->numeracion();

        $Grid->columna(array(
            "titulo" => "Caja",
            "campo" => "descripcion",
            "width" => "50"
        ));


        $Grid->columna(array(
            "titulo" => "Fecha de Apertura",
            "campo" => "fechaapertura",
            "width" => "100"
        ));
        $Grid->columna(array(
            "titulo" => "Fecha de Cierre",
            "campo" => "fechacierre",
            "width" => "100"
        ));


        $Grid->columna(array(
            "titulo" => "Monto de Apertura",
            "campo" => "montoapertura",
            "width" => "50",
            "align" => "right"
        ));
        $Grid->columna(array(
            "titulo" => "Efectivo",
            "campo" => "efectivo",
            "width" => "50",
            "align" => "right"
        ));
        $Grid->columna(array(
            "titulo" => "Tarjeta",
            "campo" => "tarjeta",
            "width" => "50",
            "align" => "right"
        ));
        $Grid->columna(array(
            "titulo" => "Total",
            "campo" => "total",
            "width" => "50",
            "align" => "right"
        ));

        $Grid->columna(array(
            "titulo" => "Estado",
            "campo" => "cerrado",
            "width" => "20",
            "fnCallback" => function ($row) {
                if ($row["cerrado"] == '1') {
                    $cadena = '<span class = "badge badge-success">Cerrado</span>';
                } elseif ($row["cerrado"] == '0') {
                    $cadena = '<span class = "badge badge-danger">Pendiente</span>';
                }
                return $cadena;
            }
        ));

        $Grid->accion(array(
            "icono" => "fas fa-search",
            "titulo" => "Ver detalle",
            "xajax" => array(
                "fn" => "xajax__verdetalleCierreCaja",
                "parametros" => array(
                    "campos" => array("caja", "fechaapertura")
                )
            )
        ));

        if ($_SESSION["sys_perfil"] == '1' || $_SESSION["sys_perfil"] == '2') {

            $Grid->accion(array(
                "icono" => "fas fa-lock-open",
                "titulo" => "Reaperturar Caja",
                "xajax" => array(
                    "fn" => "xajax__reaperturarCaja",
                    "parametros" => array(
                        "campos" => array("id")
                    )
                )
            ));
        }



        $Grid->data(array(
            "criterio" => $criterio,
            "total" => $Grid->totalRegistros,
            "pagina" => $pagina,
            "nRegPagina" => $nreg_x_pag,
            "class" => "caja",
            "method" => "buscar"
        ));
        $Grid->paginador(array(
            "xajax" => "xajax__cierrecajaDatagrid",
            "criterio" => array($criterio),
            "total" => $Grid->totalRegistros,
            "nRegPagina" => $nreg_x_pag,
            "pagina" => $pagina,
            "nItems" => "5",
            "lugar" => "in"
        ));
        $html = $Grid->render();
        return $html;
    }

    function verdetalleCierreCaja($form)
    {
        $clasecaja = new caja();
        $claseventa = new venta();

        $datadetalle = $clasecaja->verDetallado('2', $form);
        $datasaldo = $clasecaja->verDetallado('4', $form);
        $html = ' <div id="imprimir"><form class="form-inline" onsubmit="return false;" id="formCierre">
                    <table style="width:50%" align="center">
                    <thead>
                        <tr>
                            <td style="text-align:center; font-size:20px;font-weight:bold" colspan="4">.::SALDO INICIAL::.</td>
                        </tr>

';
        $d = 1;
        foreach ($datasaldo as $val) {
            $html .= '<tr>
                            <th colspan="2" style="text-align:left">TOTAL</th>                            
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
                        
                                    <tr>
                            <td colspan="4">===============================================</th>
                        </tr>
            <tr>
                            <td colspan="4">===============================================</th>
                        </tr>
                        <tr>
                            <td style="text-align:center; font-size:20px;font-weight:bold" colspan="4">.::DETALLADO BILLETES Y MONEDAS::.</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:left">
                            Billetes de S/ 200
                            </td>
                            <td style="text-align:right">
                                ' . (number_format(($datasaldo["0"]["billete200"]), 0, '.', '')) . '
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:left">
                            Billetes de S/ 100
                            </td>
                            <td style="text-align:right">
                                ' . (number_format(($datasaldo["0"]["billete100"]), 0, '.', '')) . '
                            </td>
                        </tr>               
                        <tr>
                            <td colspan="3" style="text-align:left">
                            Billetes de S/ 50
                            </td>
                            <td style="text-align:right">
                                ' . (number_format(($datasaldo["0"]["billete50"]), 0, '.', '')) . '
                            </td>
                        </tr>               
                        <tr>
                            <td colspan="3" style="text-align:left">
                            Billetes de S/ 20
                            </td>
                            <td style="text-align:right">
                                ' . (number_format(($datasaldo["0"]["billete20"]), 0, '.', '')) . '
                            </td>
                        </tr>               
                        <tr>
                            <td colspan="3" style="text-align:left">
                            Billetes de S/ 10
                            </td>
                            <td style="text-align:right">
                                ' . (number_format(($datasaldo["0"]["billete10"]), 0, '.', '')) . '
                            </td>
                        </tr>               
                        <tr>
                            <td colspan="3" style="text-align:left">
                            Monedas de S/ 5
                            </td>
                            <td style="text-align:right">
                                ' . (number_format(($datasaldo["0"]["moneda5"]), 0, '.', '')) . '
                            </td>
                        </tr>                                                            
                        <tr>
                            <td colspan="3" style="text-align:left">
                            Monedas de S/ 2
                            </td>
                            <td style="text-align:right">
                                ' . (number_format(($datasaldo["0"]["moneda2"]), 0, '.', '')) . '
                            </td>
                        </tr>              
                        <tr>
                            <td colspan="3" style="text-align:left">
                            Monedas de S/ 1
                            </td>
                            <td style="text-align:right">
                                ' . (number_format(($datasaldo["0"]["moneda1"]), 0, '.', '')) . '
                            </td>
                        </tr>                                                                                                                                                          
                        <tr>
                            <td colspan="3" style="text-align:left">
                            Monedas de S/ 0.50
                            </td>
                            <td style="text-align:right">
                                ' . (number_format(($datasaldo["0"]["moneda05"]), 0, '.', '')) . '
                            </td>
                        </tr>               
                        <tr>
                            <td colspan="3" style="text-align:left">
                            Monedas de S/ 0.20
                            </td>
                            <td style="text-align:right">
                                ' . (number_format(($datasaldo["0"]["moneda02"]), 0, '.', '')) . '
                            </td>
                        </tr>                 
                        <tr>
                            <td colspan="3" style="text-align:left">
                            Monedas de S/ 0.10
                            </td>
                            <td style="text-align:right">
                                ' . (number_format(($datasaldo["0"]["moneda01"]), 0, '.', '')) . '
                            </td>
                        </tr>   
                        <tr>
                            <td colspan="2" style="text-align:left">
                            TOTAL
                            </td>
                            <td style="text-align:right"colspan="2">
                                ' . (number_format(($datasaldo["0"]["total"]), 2, '.', '')) . '
                            </td>
                        </tr>                                                                                                                                                                                                                                                   

        </tbody>
                </table>
                <input type="hidden" id="txtEfectivo" name="txtEfectivo" class="form-control" value="' . (number_format(($totalefectivo), 2, '.', '')) . '">
                <input type="hidden" id="txtTarjeta" name="txtTarjeta" class="form-control"  value="' . (number_format(($totaltarjeta), 2, '.', '')) . '">
                <input type="hidden" id="txtTotal" name="txtTotal" class="form-control"  value="' . (number_format(($total), 2, '.', '')) . '">
                <input type="hidden" id="txtIdCaja" name="txtIdCaja" class="form-control"  value="' . $form["lstCaja"] . '">
                <input type="hidden" id="txtIdApertura" name="txtIdApertura" class="form-control"  value="' . $datasaldo[0]["id"] . '">
                
                        
                </form></div>';

        $botones = '<button type="button" class="btn btn-primary" id="btnCerrarCaja" onclick="imprSelec(\'imprimir\')"><i class="fa fa-print" ></i>Imprimir</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-remove"></i>Cerrar</button>';


        return array($html, $botones);
    }
}


function _interfazListarCierresCaja()
{
    $rpta = new xajaxResponse();
    $cls = new interfazListarCierresCaja();
    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);
    $rpta->script("
    $('#btnBuscar').unbind('click').click(function() {
    xajax__cierrecajaDatagrid(document.getElementById('txtBuscar').value);
    });");
    $rpta->script("
    $('#txtBuscar').unbind('keypress').keypress(function() {
        validarEnter(event)
    });");
    $rpta->script("
        function imprSelec(nombre) {
        var ficha = document.getElementById(nombre);
        var ventimp = window.open(' ', 'popimpr');
        ventimp.document.write( ficha.innerHTML );
        ventimp.document.close();
        ventimp.print( );
        ventimp.close();
        }
    ");
    return $rpta;
}

function _cierrecajaDatagrid($criterio, $total_regs = 0, $pagina = 1, $nregs = 100)
{
    $rpta = new xajaxResponse();
    $cls = new interfazListarCierresCaja();
    $html = $cls->datagrid($criterio, $total_regs, $pagina, $nregs);
    $rpta->assign("outQuery", "innerHTML", $html);
    return $rpta;
}

function _verdetalleCierreCaja($caja, $fecha)
{
    $rpta = new xajaxResponse();
    $interfaz = new interfazListarCierresCaja();
    $form = array("txtFecha" => dmy($fecha), "lstCaja" => $caja);
    $html = $interfaz->verdetalleCierreCaja($form);
    $rpta->script("$('#modal .modal-header h5').text('Cierre de Caja');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");
    return $rpta;
}


function _reaperturarCaja($id)
{
    $rpta = new xajaxResponse();
    $clase = new caja();
    $interfaz = new interfazListarCierresCaja();


    $form = array("txtIdApertura" => $id);
    $result = $clase->mantenedor('3', $form);
    if ($result[0]['mensaje'] == 'MSG_008') {
        $rpta->alert(MSG_008);
        $rpta->assign("outQuery", "innerHTML", $interfaz->datagrid(''));
    } else {
        $rpta->alert("Error al reaperturar Caja, por favor comuníques con el Administrador del Sistema");
    }

    return $rpta;
}


$xajax->register(XAJAX_FUNCTION, '_interfazListarCierresCaja');
$xajax->register(XAJAX_FUNCTION, '_cierrecajaDatagrid');
$xajax->register(XAJAX_FUNCTION, '_verdetalleCierreCaja');
$xajax->register(XAJAX_FUNCTION, '_reaperturarCaja');
