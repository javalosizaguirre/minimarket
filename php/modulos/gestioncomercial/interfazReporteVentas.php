<?php
include_once RUTA_CLASES . 'ventas.class.php';
include_once RUTA_CLASES . 'ventasdetalle.class.php';
include_once RUTA_CLASES . 'caja.class.php';
class interfazReporteventas
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clasetipocomprobante = new tipocomprobante();
        $clsabstract->legenda('fas fa-search', 'Ver detalle');
        $clsabstract->legenda('fas fa-arrow-circle-right', 'Enviar Comprobante');
        $datostipocomprobante = $clasetipocomprobante->consultar('3', '');
        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Ventas";
        $html = ' 
    
    <div class="card">
        <div class="card-header">' . $titulo . '</div>
            <div class="card-body">        
            
                <form class="form-inline" onsubmit="return false;" id="frmConsulta">
                    <table style="width:100%" >
                        <tr>
                            <td style="width:20%">Tipo de Reporte</td>
                            <td  style="width:30%">
                                <select id="lstTipoReporte" name="lstTipoReporte" class="form-control" style="width:100%">
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Ventas por dia general</option>
                                    <option value="2">ventas por dia detallado</option>                                                                        
                                    <option value="3">Ventas por Caja</option>
                                </select>
                            </td>
                            <td style="width:60%"></td>
                        </tr>
                        <tr>
                            <td>Desde</td>
                            <td><input type="text" class="form-control datepicker" id="txtFechaDesde" name="txtFechaDesde" readonly style="width:100%"></td>                            
                            <td></td>
                        </tr>
                        <tr>
                            <td>Desde</td>
                            <td><input type="text" class="form-control datepicker" id="txtFechaHasta" name="txtFechaHasta" readonly style="width:100%"></td>                            
                            <td></td>
                        </tr>
                                                
                        <tr>
                            <td colspan="3" style="text-align:center">
                                <button type="button" class="btn btn-secondary" id="btnBuscar"><i class="fas fa-search"></i>Buscar</button>                                
                                <button type="button" class="btn btn-secondary" id="btnExcel"><i class="fas fa-file-excel"></i>Excel</button>
                            </td>
                        </tr>    
                    </table>
                                               
                    
            </form>                
            </div>            
            <div class="card-body" id="outQuery">
                
            </div>
            </form>    
        </div>
        </div>
          
    </div>';

        return $html;
    }

    function reporte($form)
    {
        $claseventa = new venta();

        if ($form["lstTipoReporte"] == '1') {
            $data = $claseventa->consultarReportes($form);
            $html = '<table id="tblReporte" align="center" class="data-tbl-simple table table-bordered" style="border-left:#ccc 1px solid;border-right:0px;width:40%;">
                        <thead>
                            <tr>
                                <th  style="text-align:center">FECHA</th>
                                <th  style="text-align:center">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>';
            $total = 0;
            foreach ($data as $value) {
                $html .= '<tr>
                                <th>' . $value["fecha"] . '</th>
                                <th style="text-align:right">' . $value["total"] . '</th>
                            </tr>';
                $total = $total + $value["total"];
            }
            $html .= '<tr>
                                <th>TOTAL</th>
                                <th style="text-align:right">' . $total . '</th>
                            </tr>';
            $html .= '</table>';
        } elseif ($form["lstTipoReporte"] == '2') {
            $data = $claseventa->consultarReportes($form);
            $html = '<table  id="tblReporte" align="center"  class="data-tbl-simple table table-bordered" style="border-left:#ccc 1px solid;border-right:0px;width:70%;">
                        <thead>
                            <tr>
                                <th  style="text-align:center">NRO.</th>
                                <th  style="text-align:center">FECHA DE VENTA</th>
                                <th  style="text-align:center">SERIE</th>
                                <th  style="text-align:center">NRO. COMPROBANTE</th>
                                <th  style="text-align:center">CLIENTE</th>
                                <th  style="text-align:center">FORMA DE PAGO</th>
                                <th  style="text-align:center">TARJETA</th>
                                <th  style="text-align:center">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>';
            $total = 0;
            $c = 1;
            foreach ($data as $value) {

                $html .= '<tr>
                                <th>' . $c . '</th>
                                <th>' . $value["fechaventa"] . '</th>
                                <th>' . $value["serie"] . '</th>
                                <th>' . $value["nrocomprobante"] . '</th>
                                <th>' . $value["nombres"] . '</th>
                                <th>' . $value["nombreformapago"] . '</th>                                                                                
                                <th>' . $value["nombretarjeta"] . '</th>
                                <th style="text-align:right">' . $value["total"] . '</th>
                            </tr>';
                $total = $total + $value["total"];
            }
            $html .= '<tr>
                                <th colspan="7">TOTAL</th>
                                <th style="text-align:right">' . $total . '</th>
                            </tr>';
            $html .= '</table>';
        } elseif ($form["lstTipoReporte"] == '3') {
            $c = 1;
            $data = $claseventa->consultarReportes($form);
            $html = '<table  id="tblReporte" align="center"  class="data-tbl-simple table table-bordered" style="border-left:#ccc 1px solid;border-right:0px;width:50%;">
                        <thead>
                            <tr>
                                <th  style="text-align:center">NRO.</th>
                                <th  style="text-align:center">CAJA</th>
                                <th  style="text-align:center">FECHA</th>
                                <th  style="text-align:center">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>';
            $total = 0;
            foreach ($data as $value) {
                $html .= '<tr>
                                <th>' . $c++ . '</th>
                                <th>' . $value["descripcion"] . '</th>
                                <th>' . $value["fecha"] . '</th>
                                <th style="text-align:right">' . $value["total"] . '</th>
                            </tr>';
                $total = $total + $value["total"];
            }
            $html .= '<tr>
                                <th colspan="3">TOTAL</th>
                                <th style="text-align:right">' . $total . '</th>
                            </tr>';
            $html .= '</table>';
        }
        return $html;
    }
}

function _interfazReporteVentas()
{
    $rpta = new xajaxResponse();
    $cls = new interfazReporteventas();

    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);

    $rpta->script("
    $('#btnBuscar').unbind('click').click(function() {
        if($('#lstTipoReporte').val() ==''){
            alert('Debe Seleccionar un tipo de reporte');
        }else{
            xajax__reporteVentas(xajax.getFormValues('frmConsulta'));
        }
    });");

    $rpta->script("
    $('#btnExcel').unbind('click').click(function() {
        tableToExcel('tblReporte')
    });");

    $rpta->script("$('.datepicker').datepicker({
        clearBtn: true,
        language: 'es'
    });");
    return $rpta;
}


function _reporteVentas($form)
{
    $rpta = new xajaxResponse();
    $cls = new interfazReporteventas();
    $html = $cls->reporte($form);
    $rpta->assign("outQuery", "innerHTML", $html);
    return $rpta;
}
$xajax->register(XAJAX_FUNCTION, '_interfazReporteVentas');
$xajax->register(XAJAX_FUNCTION, '_reporteVentas');
