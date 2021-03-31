<?php
include_once RUTA_CLASES . 'ingresoproductos.class.php';
class interfazIngresoProducto
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clsabstract->legenda('fas fa-search', 'Ver Ingresos');


        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Ingreso stock de Productos";
        $html = ' 
    
    <div class="card">
        <div class="card-header">' . $titulo . '</div>
            <div class="card-body">        
                <form class="form-inline" onsubmit="return false;">
                    <input type="text" class="form-control" id="txtBuscar" placeholder="Buscar por Código de Producto/Descripcion o Nro de Comprobante" style="width:70%">                           
                    <button type="button" class="btn btn-secondary" id="btnBuscar"><i class="fas fa-search"></i>Buscar</button>
                    <button type="button" class="btn btn-secondary" id="btnNuevo">Nuevo</button>                        
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
    </div>';

        return $html;
    }

    function datagrid($criterio, $total_regs = 0, $pagina = 1, $nreg_x_pag = 50)
    {
        $Grid = new eGrid();
        $Grid->numeracion();
        $Grid->columna(array(
            "titulo" => "Movimiento",
            "campo" => "tipomovimiento",
            "width" => "50"
        ));


        $Grid->columna(array(
            "titulo" => "Producto",
            "campo" => "producto",
            "width" => "100"
        ));

        $Grid->columna(array(
            "titulo" => "Descripción",
            "campo" => "nombreproducto",
            "width" => "300"
        ));

        $Grid->columna(array(
            "titulo" => "Stock",
            "campo" => "cant_ingreso",
            "width" => "100",
            "align" => "right"
        ));

        $Grid->accion(array(
            "icono" => "fas fa-search",
            "titulo" => "Ver Ingresos",
            "xajax" => array(
                "fn" => "xajax__verkardexFisico",
                "parametros" => array(
                    "campos" => array("producto")
                )
            )
        ));

        $Grid->data(array(
            "criterio" => $criterio,
            "total" => $Grid->totalRegistros,
            "pagina" => $pagina,
            "nRegPagina" => $nreg_x_pag,
            "class" => "ingresoproductos",
            "method" => "buscar"
        ));
        $Grid->paginador(array(
            "xajax" => "xajax__ingresoproductosDatagrid",
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

    public function interfazNuevo()
    {

        $html = '
            <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post">                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" > Buscar:</label>
                    <div class="col-sm-10">
                        <div class="input-group" style="width:100%">
                        <input type="text" class="form-control" id="txtBuscarProducto" name="txtBuscarProducto" onkeypress="return validarEnterBusquedaProducto(event)">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="btnBuscarProductos">Buscar</button>
                        </span>
                        </div>
                    </div>
                </div>
                                       
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><span style="color:red">(*)</span> Producto</label>
                    <div class="col-sm-10" id="dvlstProducto">
                        <select id="lstProducto" name="lstProducto" class="form-control" style="width:100%">
                            <option value="">Sin coincidencias</option>
                        </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><span style="color:red">(*)</span> Cantidad</label>
                    <div class="col-sm-2">                           
                            <input type="text" style="width:100%; text-align:right" class="form-control" id="txtCantidad" name="txtCantidad" onkeypress="return gKeyAceptaSoloDigitos(event)"/>                           
                    </div>
                    <label class="col-sm-2 col-form-label"><span style="color:red">(*)</span> Costo</label>
                    <div class="col-sm-2">                           
                            <input type="text" style="width:100%; text-align:right" class="form-control" id="txtCosto" name="txtCosto" onkeypress="return gKeyAceptaSoloDigitosPunto(event)"/>                           
                    </div>
                    <label class="col-sm-2 col-form-label"><span style="color:red">(*)</span> Precio</label>
                    <div class="col-sm-2">                           
                            <input type="text" style="width:100%; text-align:right" class="form-control" id="txtPrecio" name="txtPrecio" onkeypress="return gKeyAceptaSoloDigitosPunto(event)"/>                           
                    </div>                    
                </div>                                                       
                                                                                                                                                                                                                                        
            </form>';

        $botones = '<span style="color:red">(*) Campos Obligatorios.</span>
                        <button type="button" class="btn btn-primary" id="btnGuardar"><i class="icon-ok icon-white"></i><span id="spanSave01">Guardar</span></button>                   
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-remove"></i>Cerrar</button>                        
            </fieldset>
            </form>';
        return array($html, $botones);
    }

    function interfazKardexFisico($producto)
    {
        $clase = new ingresoproductos();
        $data = $clase->consultar($producto);

        $html = '<table class="data-tbl-simple table table-bordered" style="border-left:#ccc 1px solid;border-right:0px;width:100%;">
                    <thead>
                        <tr>
                            <th style="text-align:center">Fecha</th>
                            <th style="text-align:center">Entradas</th>
                            <th style="text-align:center">Salidas</th>
                            <th style="text-align:center">Saldos</th>                        
                        </tr>
                    </thead>';
        $ingresos = 0;
        $salidas = 0;
        foreach ($data as $value) {
            $ingresos = $ingresos + $value["cant_ingreso"];
            $salidas = $salidas + $value["cant_salida"];
            $html .= '<tr>
                                    <td>' . substr($value["fechamovimiento"], 0, 10) . '</td>

                                    <td style="text-align:right">' . ($value["tipomovimiento"] == 'I' ? number_format($value["cant_ingreso"], 0, '.', '') : '') . '</td>
                                    <td style="text-align:right">' . ($value["tipomovimiento"] == 'S' ? number_format($value["cant_salida"], 0, '.', '') : '') . '</td>
                                    <td style="text-align:right">' . ($ingresos - $salidas) . '</td>                        
                                </tr>';
        }
        $html .= '<tr>
                    <td style="text-align:center; font-weight:bold;font-size:18px">TOTAL</td>
                    <td style="text-align:right; font-weight:bold;font-size:18px">' . $ingresos . '</td>
                    <td style="text-align:right; font-weight:bold;font-size:18px">' . $salidas . '</td>
                    <td style="text-align:right; font-weight:bold;font-size:18px">' . ($ingresos - $salidas) . '</td>
                </tr>   
        </table>';
        $botones = '<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-remove"></i>Cerrar</button>';
        return array($html, $botones);
    }
}

function _interfazIngresoProductos()
{
    $rpta = new xajaxResponse();
    $cls = new interfazIngresoProducto();
    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);
    $rpta->script("
    $('#btnNuevo').unbind('click').click(function() {
        xajax__interfazIngresoProductosNuevo();
    });");
    $rpta->script("
    $('#btnBuscar').unbind('click').click(function() {
    xajax__ingresoproductosDatagrid(document.getElementById('txtBuscar').value);
    });");
    $rpta->script("
    $('#txtBuscar').unbind('keypress').keypress(function() {
        validarEnter(event)
    });");
    return $rpta;
}

function _interfazIngresoProductosNuevo()
{
    $rpta = new xajaxResponse('UTF-8');
    $cls = new interfazIngresoProducto();
    $html = $cls->interfazNuevo();
    $rpta->script("$('#modal .modal-header h5').text('Ingreso de Productos');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");
    $rpta->script("
        $('#btnBuscarProductos').unbind('click').click(function() {
            xajax__resultadoProductos($('#txtBuscarProducto').val());
        });");

    $rpta->script("
        $('#btnGuardar').unbind('click').click(function() {
            xajax__ingresoproductosMantenimiento('1',xajax.getFormValues('form'));
        });");

    return $rpta;
}


function _ingresoproductosDatagrid($criterio, $total_regs = 0, $pagina = 1, $nregs = 50)
{
    $rpta = new xajaxResponse();
    $cls = new interfazIngresoProducto();
    $html = $cls->datagrid($criterio, $total_regs, $pagina, $nregs);
    $rpta->assign("outQuery", "innerHTML", $html);
    return $rpta;
}

function _ingresoproductosMantenimiento($flag, $form = '')
{
    $rpta = new xajaxResponse();
    $clase = new ingresoproductos();
    $interfaz = new interfazIngresoProducto();
    if ($flag == '3') {
        $form = array("txtCodigo" => $form);
    }

    $msj1 = '';
    $msj = 'LOS SIGUIENTES CAMPOS SON REQUERIDOS (*)';
    $msj .= '\\n-----------------------------------------------------------------------\\n';


    if ($form["lstProducto"] == '') {
        $msj1 .= '- Producto\\n';
    }

    if ($form["txtCantidad"] == '') {
        $msj1 .= '- Cantidad\\n';
    }

    if ($form["txtCosto"] == '') {
        $msj1 .= '- Costo\\n';
    }

    if ($form["txtPrecio"] == '') {
        $msj1 .= '- Precio\\n';
    }

    if ($msj1 != '' && $flag != '3') {
        $rpta->script('alert("' . $msj . $msj1 . '")');
    } else {

        $result = $clase->mantenedor($flag, $form);
        if ($result[0]['mensaje'] == 'MSG_001') {
            $rpta->alert(MSG_001);
            $rpta->script("jQuery('#modal').modal('hide');");
            $rpta->assign("outQuery", "innerHTML", $interfaz->datagrid(''));
        } elseif ($result[0]['mensaje'] == 'MSG_002') {
            $rpta->alert(MSG_002);
            $rpta->script("jQuery('#modal').modal('hide');");
            $rpta->assign("outQuery", "innerHTML", $interfaz->datagrid(''));
        } elseif ($result[0]['mensaje'] == 'MSG_003') {
            $rpta->alert(MSG_003);
            $rpta->assign("outQuery", "innerHTML", $interfaz->datagrid(''));
        } elseif ($result[0]['mensaje'] == 'MSG_004') {
            $rpta->alert(MSG_004);
        } elseif ($result[0]['mensaje'] == 'MSG_005') {
            $rpta->alert(MSG_005);
        }
    }
    return $rpta;
}

function _resultadoProductos($criterio)
{
    $rpta = new xajaxResponse();
    $claseproducto = new producto();
    if (strlen($criterio) < 4) {
        $rpta->alert("Debe ingresar al menos 4 caracteres");
    } else {
        $dataproducto = $claseproducto->consultar('4', $criterio);
        $combo = '<select id="lstProducto" name="lstProducto" class="form-control" style="width:100%">
                    <option value="">Seleccionar...</option>';
        foreach ($dataproducto as $value) {
            $combo .= '<option value="' . $value["producto"] . '">' . $value["descripcion"] . '</option>';
        }
        $combo .= '</select>';
        $rpta->assign("dvlstProducto", "innerHTML", $combo);
        $rpta->script("
        $('#lstProducto').unbind('change').change(function() {
            xajax__consultarDatosProducto(this.value);
        });");
    }
    return $rpta;
}

function _consultarDatosProducto($criterio)
{
    $rpta = new xajaxResponse();
    $claseproducto = new producto();
    $dataproducto = $claseproducto->consultar('5', $criterio);
    $rpta->assign("txtCosto", "value", $dataproducto[0]["preciocompra"]);
    $rpta->assign("txtPrecio", "value", $dataproducto[0]["precioventa"]);
    return $rpta;
}

function _verkardexFisico($producto)
{
    $rpta = new xajaxResponse('UTF-8');
    $cls = new interfazIngresoProducto();
    $html = $cls->interfazKardexFisico($producto);
    $rpta->script("$('#modal .modal-header h5').text('Kardex Físico');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");
    return $rpta;
}



$xajax->register(XAJAX_FUNCTION, '_interfazIngresoProductos');
$xajax->register(XAJAX_FUNCTION, '_interfazIngresoProductosNuevo');
$xajax->register(XAJAX_FUNCTION, '_ingresoproductosDatagrid');
$xajax->register(XAJAX_FUNCTION, '_ingresoproductosMantenimiento');
$xajax->register(XAJAX_FUNCTION, '_resultadoProductos');
$xajax->register(XAJAX_FUNCTION, '_consultarDatosProducto');
$xajax->register(XAJAX_FUNCTION, '_verkardexFisico');
