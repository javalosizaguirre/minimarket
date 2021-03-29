<?php
include_once RUTA_CLASES . 'ingresoproductos.class.php';
class interfazIngresoProducto
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clsabstract->legenda('fa fa-user-edit', 'Editar');
        $clsabstract->legenda('fa fa-times-circle', 'Eliminar');

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
            "titulo" => "Fecha",
            "campo" => "fechamovimiento",
            "width" => "100"
        ));

        $Grid->columna(array(
            "titulo" => "Tipo de Comprobante",
            "campo" => "nombretipocomprobante",
            "width" => "100"
        ));

        $Grid->columna(array(
            "titulo" => "Serie",
            "campo" => "seriecomprobante",
            "width" => "100"
        ));

        $Grid->columna(array(
            "titulo" => "Nro. Comprobante",
            "campo" => "numerocomprobante",
            "width" => "100"
        ));

        $Grid->columna(array(
            "titulo" => "Estado",
            "campo" => "anulado",
            "width" => "20",
            "fnCallback" => function ($row) {
                if ($row["anulado"] == '1') {
                    $cadena = '<span class = "badge badge-success">Anulado</span>';
                } elseif ($row["anulado"] == '0') {
                    $cadena = '<span class = "badge badge-danger"></span>';
                }
                return $cadena;
            }
        ));


        $Grid->accion(array(
            "icono" => "fa fa-times-circle",
            "titulo" => "Eliminar Registro",
            "xajax" => array(
                "fn" => "xajax__ingresoproductosMantenimiento",
                "msn" => "¿Esta seguro de Anular el registro?",
                "parametros" => array(
                    "flag" => "3",
                    "campos" => array("id")
                )
            )
        ));

        $Grid->accion(array(
            "icono" => "fa fa-user-edit",
            "titulo" => "Editar Usuario",
            "xajax" => array(
                "fn" => "xajax__interfazIngresoProductosEditar",
                "parametros" => array(
                    "flag" => "2",
                    "campos" => array("id")
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
        $clasetipocomprobante = new tipocomprobante();
        $datatipocomprobante = $clasetipocomprobante->consultar('2', '');
        $html = '
            <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post">                
                
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" ><span style="color:red">(*)</span> Fecha:</label>
                        <div class="col-sm-3">
                            <input type="text" style ="width:100%" class="form-control"   id="txtFechaIngreso" name="txtFechaIngreso" readonly/>
                        </div>
                        <label class="col-sm-3 col-form-label"><span style="color:red">(*)</span> Tipo Comprobante</label>
                        <div class="col-sm-4">
                            <select id="lstTipoComprobante" name="lstTipoComprobante" class="form-control">
                                <option value="">Seleccionar...</option>';
        foreach ($datatipocomprobante as $value) {
            $html .= '<option value="' . $value["tipocomprobante"] . '">' . $value["descripcion"] . '</option>';
        }
        $html .= '</select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > <span style="color:red">(*)</span> Serie:</label>
                        <div class="col-sm-3">
                            <input type="text" style ="width:100%" class="form-control"   id="txtSerie" name="txtSerie"/>
                        </div>
                        <label class="col-sm-3 col-form-label"><span style="color:red">(*)</span> Nro. Comprobante</label>
                        <div class="col-sm-4">
                            <input type="text" style="width:100%" class="form-control" id="txtNroComprobante" name="txtNroComprobante" />
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"> Buscar Producto</label>
                        <div class="col-sm-10">
                            <input onkeyup = "validarEnterBusquedaProducto(event)" type="text" style="width:100%" class="form-control" id="txtBuscarProducto" name="txtBuscarProducto" placeholder="Escribir el Código o Descripción del producto y presione [Enter]"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><span style="color:red">(*)</span> Producto</label>
                        <div class="col-sm-10" id="dvlstProducto">
                           <select id="lstProducto" name="lstProducto" class="form-control" style="width:100%">
                                <option value="">Seleccionar...</option>
                           </select> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><span style="color:red">(*)</span> Cantidad</label>
                        <div class="col-sm-3">                           
                                <input type="text" style="width:100%; text-align:right" class="form-control" id="txtCantidad" name="txtCantidad" onkeypress="return gKeyAceptaSoloDigitos(event)"/>                           
                        </div>
                        <label class="col-sm-2 col-form-label"> Costo</label>
                        <div class="col-sm-3">                           
                                <input type="text" style="width:100%; text-align:right" class="form-control" id="txtCosto" name="txtCosto" onkeypress="return gKeyAceptaSoloDigitosPunto(event)"/>                           
                        </div>
                    </div>
                    <div style="width:100%; text-align:center">
                        <button type="button" class="btn btn-primary" id="btnAgregar"><i class="fas fa-plus"></i><span id="spanSave01">Agregar</span></button>
                    </div>
                    <div id="dvNotaIngreso">
                    </div>                                        
                                                                                                                                                                                                                                        
            </form>';

        $botones = '<span style="color:red">(*) Campos Obligatorios.</span>
                        <button type="button" class="btn btn-primary" id="btnGuardar"><i class="icon-ok icon-white"></i><span id="spanSave01">Guardar</span></button>                   
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-remove"></i>Cerrar</button>                        
            </fieldset>
            </form>';
        return array($html, $botones);
    }

    public function interfazEditar($perfil)
    {
        $clase = new perfil();
        $data = $clase->consultar('1', $perfil);

        $html = '
            <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post">                
                
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" >Código:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:30%" class="form-control"   id="txtCodigo" name="txtCodigo" value="' . $perfil . '" maxlength="3" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Descripción:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtDescripcion" name="txtDescripcion" value="' . $data[0]["descripcion"] . '"/>
                        </div>
                    </div>                                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" >Activo:</label>
                        <div class="col-sm-9">
                            <input id="chk_activo"  name="chk_activo" type="checkbox" value="1" style="vertical-align:middle" ' . ($data[0]["activo"] == '1' ? 'checked' : '') . '>
                        </div>
                    </div>                                                                                                                                                                                                                          
            </form>';

        $botones = '<span style="color:red">(*) Campos Obligatorios.</span>
                        <button type="button" class="btn btn-primary" id="btnEdiar"><i class="icon-ok icon-white"></i><span id="spanSave01">Guardar</span></button>                   
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-remove"></i>Cerrar</button>                        
            </fieldset>
            </form>';
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
        $('#btnAgregar').unbind('click').click(function() {
            xajax__agregarProductosTemporal(xajax.getFormValues('form'));
        });");


    return $rpta;
}

function _interfazIngresoProductosEditar($flag, $id)
{
    $rpta = new xajaxResponse('UTF-8');
    $cls = new interfazIngresoProducto();
    $html = $cls->interfazEditar($id);
    $rpta->script("$('#modal .modal-header h5').text('Editar Ingreso de Productos');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");
    $rpta->script("
        $('#btnEdiar').unbind('click').click(function() {
            xajax__ingresoproductosMantenimiento('" . $flag . "',xajax.getFormValues('form'));
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


    if ($form["txtDescripcion"] == '') {
        $msj1 .= '- Descripcion\\n';
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
    $dataproducto = $claseproducto->consultar('4', $criterio);
    $combo = '<select id="lstProducto" name="lstProducto" class="form-control" style="width:100%">
                <option value="">Seleccionar</option>';
    foreach ($dataproducto as $value) {
        $combo .= '<option value="' . $value["producto"] . '">' . $value["descripcion"] . '</option>';
    }
    $combo .= '</select>';
    $rpta->assign("dvlstProducto", "innerHTML", $combo);
    return $rpta;
}

function _agregarProductosTemporal($producto, $cantidad, $costo)
{
    $rpta = new xajaxResponse();

    return $rpta;
}

$xajax->register(XAJAX_FUNCTION, '_interfazIngresoProductos');
$xajax->register(XAJAX_FUNCTION, '_interfazIngresoProductosNuevo');
$xajax->register(XAJAX_FUNCTION, '_ingresoproductosDatagrid');
$xajax->register(XAJAX_FUNCTION, '_ingresoproductosMantenimiento');
$xajax->register(XAJAX_FUNCTION, '_interfazIngresoProductosEditar');
$xajax->register(XAJAX_FUNCTION, '_resultadoProductos');
