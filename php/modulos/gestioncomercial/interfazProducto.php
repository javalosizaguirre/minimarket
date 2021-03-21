<?php
include_once RUTA_CLASES . 'producto.class.php';
class interfazProducto
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clsabstract->legenda('fa fa-user-edit', 'Editar');
        $clsabstract->legenda('fa fa-times-circle', 'Eliminar');

        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Perfiles de Usuario";
        $html = ' 
    
    <div class="card">
        <div class="card-header">' . $titulo . '</div>
            <div class="card-body">        
                <form class="form-inline" onsubmit="return false;">
                    <input type="text" class="form-control" id="txtBuscar" placeholder="Buscar por descripcion" style="width:70%">                           
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
            "titulo" => "Código",
            "campo" => "producto",
            "width" => "50"
        ));


        $Grid->columna(array(
            "titulo" => "Descripcion",
            "campo" => "descripcion",
            "width" => "250"
        ));
        $Grid->columna(array(
            "titulo" => "Categoría",
            "campo" => "nombrecategoria",
            "width" => "250"
        ));

        $Grid->columna(array(
            "titulo" => "Stock Actual",
            "campo" => "stockactual",
            "width" => "50",
            "align" => "right"
        ));

        $Grid->columna(array(
            "titulo" => "Precio",
            "campo" => "precioventa",
            "width" => "50",
            "align" => "right"
        ));

        $Grid->columna(array(
            "titulo" => "Estado",
            "campo" => "activo",
            "width" => "20",
            "fnCallback" => function ($row) {
                if ($row["activo"] == '1') {
                    $cadena = '<span class = "badge badge-success">Activo</span>';
                } elseif ($row["activo"] == '0') {
                    $cadena = '<span class = "badge badge-danger">Inactivo</span>';
                }
                return $cadena;
            }
        ));


        $Grid->accion(array(
            "icono" => "fa fa-times-circle",
            "titulo" => "Eliminar Registro",
            "xajax" => array(
                "fn" => "xajax__productoMantenimiento",
                "msn" => "¿Esta seguro de eliminar el registro?",
                "parametros" => array(
                    "flag" => "3",
                    "campos" => array("producto")
                )
            )
        ));

        $Grid->accion(array(
            "icono" => "fa fa-user-edit",
            "titulo" => "Editar Producto",
            "xajax" => array(
                "fn" => "xajax__interfazProductoEditar",
                "parametros" => array(
                    "flag" => "2",
                    "campos" => array("producto")
                )
            )
        ));
        $Grid->data(array(
            "criterio" => $criterio,
            "total" => $Grid->totalRegistros,
            "pagina" => $pagina,
            "nRegPagina" => $nreg_x_pag,
            "class" => "producto",
            "method" => "buscar"
        ));
        $Grid->paginador(array(
            "xajax" => "xajax__productoDatagrid",
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
        $clasecategoria = new categoriaproducto();
        $clasemodelo = new modeloproducto();
        $clasetalla = new tallaproducto();
        $clasemarca = new marcaproducto();
        $claseunidadmedida = new unidadmedidaproducto();

        $datacategoria = $clasecategoria->consultar('2', '');
        $datamarca = $clasemarca->consultar('2', '');
        $datamodelo = $clasemodelo->consultar('2', '');
        $datatalla = $clasetalla->consultar('2', '');
        $dataunidadmedida = $claseunidadmedida->consultar('2', '');
        $html = '
            <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post">                
                
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Código:</label>
                        <div class="col-sm-10">
                            <input type="text" style ="width:30%" class="form-control"   id="txtCodigo" name="txtCodigo" maxlength="15"  />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" ><span style="color:red">(*)</span> Descripción:</label>
                        <div class="col-sm-10">
                            <input type="text" style ="width:100%" class="form-control"   id="txtDescripcion" name="txtDescripcion"/>
                        </div>
                    </div>      
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Categoría:</label>
                        <div class="col-sm-4">
                            <select id="lstCategoria" name="lstCategoria" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($datacategoria as $value) {
            $html .= '<option value="' . $value["categoria"] . '">' . $value["descripcion"] . '</option>';
        }
        $html .=
            '</select>
                        </div>
                        <label class="col-sm-2 col-form-label" > Marca:</label>
                        <div class="col-sm-4">
                            <select id="lstMarca" name="lstMarca" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($datamarca as $value) {
            $html .= '<option value="' . $value["marca"] . '">' . $value["descripcion"] . '</option>';
        }
        $html .=
            '</select>
                        </div>
                    </div>    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Modelo:</label>
                        <div class="col-sm-4">
                            <select id="lstModelo" name="lstModelo" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($datamodelo as $value) {
            $html .= '<option value="' . $value["modelo"] . '">' . $value["descripcion"] . '</option>';
        }
        $html .=
            '</select>
                        </div>
                        <label class="col-sm-2 col-form-label" > Talla:</label>
                        <div class="col-sm-4">
                            <select id="lstTalla" name="lstTalla" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($datatalla as $value) {
            $html .= '<option value="' . $value["talla"] . '">' . $value["descripcion"] . '</option>';
        }
        $html .=
            '</select>
                        </div>
                    </div>   
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Unidad Medida:</label>
                        <div class="col-sm-4">
                            <select id="lstUnidadMedida" name="lstUnidadMedida" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($dataunidadmedida as $value) {
            $html .= '<option value="' . $value["unidadmedida"] . '">' . $value["descripcion"] . '</option>';
        }
        $html .=
            '</select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Costo:</label>
                        <div class="col-sm-4">
                            <input type="text" style ="width:100%;text-align:right" class="form-control"   id="txtPrecioCompra" name="txtPrecioCompra"  />
                        </div>
                        <label class="col-sm-2 col-form-label" > Precio:</label>
                        <div class="col-sm-4">
                            <input type="text" style ="width:100%;text-align:right" class="form-control"   id="txtPrecioVenta" name="txtPrecioVenta"   />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Stock:</label>
                        <div class="col-sm-4">
                            <input type="text" style ="width:100%;text-align:right" class="form-control"   id="txtStockActual" name="txtStockActual"  />
                        </div>
                        <label class="col-sm-2 col-form-label" > Stock Min.:</label>
                        <div class="col-sm-4">
                            <input type="text" style ="width:100%;text-align:right" class="form-control"   id="txtStockMinimo" name="txtStockMinimo"   />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Fecha de venc.:</label>
                        <div class="col-sm-4">
                            <input type="text" style ="width:100%;text-align:right" class="form-control"   id="txtFechaVencimiento" name="txtFechaVencimiento"  />
                        </div>                        
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Activo:</label>
                        <div class="col-sm-10">
                            <input id="chk_activo"  name="chk_activo" type="checkbox" value="1" style="vertical-align:middle" checked>
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

    public function interfazEditar($producto)
    {
        $claseproducto = new producto();
        $clasecategoria = new categoriaproducto();
        $clasemodelo = new modeloproducto();
        $clasetalla = new tallaproducto();
        $clasemarca = new marcaproducto();
        $claseunidadmedida = new unidadmedidaproducto();

        $dataproducto = $claseproducto->consultar('1', $producto);
        $datacategoria = $clasecategoria->consultar('2', '');
        $datamarca = $clasemarca->consultar('2', '');
        $datamodelo = $clasemodelo->consultar('2', '');
        $datatalla = $clasetalla->consultar('2', '');
        $dataunidadmedida = $claseunidadmedida->consultar('2', '');
        $html = '
            <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post">                
                
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Código:</label>
                        <div class="col-sm-10">
                            <input type="text" style ="width:30%" class="form-control"   id="txtCodigo" name="txtCodigo" maxlength="15" value="' . $producto . '" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" ><span style="color:red">(*)</span> Descripción:</label>
                        <div class="col-sm-10">
                            <input type="text" style ="width:100%" class="form-control"   id="txtDescripcion" name="txtDescripcion" value = "' . $dataproducto[0]["descripcion"] . '"/>
                        </div>
                    </div>      
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Categoría:</label>
                        <div class="col-sm-4">
                            <select id="lstCategoria" name="lstCategoria" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($datacategoria as $value) {
            if ($dataproducto[0]["categoria"] == $value["categoria"]) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $html .= '<option value="' . $value["categoria"] . '" ' . $selected . '>' . $value["descripcion"] . '</option>';
        }
        $html .=
            '</select>
                        </div>
                        <label class="col-sm-2 col-form-label" > Marca:</label>
                        <div class="col-sm-4">
                            <select id="lstMarca" name="lstMarca" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($datamarca as $value) {
            if ($dataproducto[0]["marca"] == $value["marca"]) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $html .= '<option value="' . $value["marca"] . '" ' . $selected . '>' . $value["descripcion"] . '</option>';
        }
        $html .=
            '</select>
                        </div>
                    </div>    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Modelo:</label>
                        <div class="col-sm-4">
                            <select id="lstModelo" name="lstModelo" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($datamodelo as $value) {
            if ($dataproducto[0]["modelo"] == $value["modelo"]) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $html .= '<option value="' . $value["modelo"] . '" ' . $selected . '>' . $value["descripcion"] . '</option>';
        }
        $html .=
            '</select>
                        </div>
                        <label class="col-sm-2 col-form-label" > Talla:</label>
                        <div class="col-sm-4">
                            <select id="lstTalla" name="lstTalla" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($datatalla as $value) {
            if ($dataproducto[0]["talla"] == $value["talla"]) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $html .= '<option value="' . $value["talla"] . '" ' . $selected . '>' . $value["descripcion"] . '</option>';
        }
        $html .=
            '</select>
                        </div>
                    </div>   
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Unidad Medida:</label>
                        <div class="col-sm-4">
                            <select id="lstUnidadMedida" name="lstUnidadMedida" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($dataunidadmedida as $value) {
            if ($dataproducto[0]["unidadmedida"] == $value["unidadmedida"]) {
                $selected = 'selected';
            } else {
                $selected = '';
            }

            $html .= '<option value="' . $value["unidadmedida"] . '" ' . $selected . '>' . $value["descripcion"] . '</option>';
        }
        $html .=
            '</select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Costo:</label>
                        <div class="col-sm-4">
                            <input type="text" style ="width:100%;text-align:right" class="form-control"   id="txtPrecioCompra" name="txtPrecioCompra"  value="' . $dataproducto[0]["preciocompra"] . '"/>
                        </div>
                        <label class="col-sm-2 col-form-label" > Precio:</label>
                        <div class="col-sm-4">
                            <input type="text" style ="width:100%;text-align:right" class="form-control"   id="txtPrecioVenta" name="txtPrecioVenta"  value="' . $dataproducto[0]["precioventa"] . '" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Stock:</label>
                        <div class="col-sm-4">
                            <input type="text" style ="width:100%;text-align:right" class="form-control"   id="txtStockActual" name="txtStockActual" value="' . $dataproducto[0]["stockactual"] . '" />
                        </div>
                        <label class="col-sm-2 col-form-label" > Stock Min.:</label>
                        <div class="col-sm-4">
                            <input type="text" style ="width:100%;text-align:right" class="form-control"   id="txtStockMinimo" name="txtStockMinimo" value="' . $dataproducto[0]["stockminimo"] . '"  />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Fecha de venc.:</label>
                        <div class="col-sm-4">
                            <input type="text" style ="width:100%;text-align:right" class="form-control"   id="txtFechaVencimiento" name="txtFechaVencimiento"  value="' . $dataproducto[0]["fechavencimiento"] . '"/>
                        </div>                        
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Activo:</label>
                        <div class="col-sm-10">
                            <input id="chk_activo"  name="chk_activo" type="checkbox" value="1" style="vertical-align:middle" ' . ($dataproducto[0]["activo"] == '1' ? 'checked' : '') . '>
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

function _interfazProducto()
{
    $rpta = new xajaxResponse();
    $cls = new interfazProducto();
    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);
    $rpta->script("
    $('#btnNuevo').unbind('click').click(function() {
        xajax__interfazProductoNuevo();
    });");
    $rpta->script("
    $('#btnBuscar').unbind('click').click(function() {
    xajax__productoDatagrid(document.getElementById('txtBuscar').value);
    });");
    $rpta->script("
    $('#txtBuscar').unbind('keypress').keypress(function() {
        validarEnter(event)
    });");
    return $rpta;
}

function _interfazProductoNuevo()
{
    $rpta = new xajaxResponse('UTF-8');
    $cls = new interfazProducto();
    $html = $cls->interfazNuevo();
    $rpta->script("$('#modal .modal-header h5').text('Registrar Producto');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");
    $rpta->script("
        $('#btnGuardar').unbind('click').click(function() {
            xajax__productoMantenimiento('1',xajax.getFormValues('form'));
        });");
    return $rpta;
}

function _interfazProductoEditar($flag, $producto)
{
    $rpta = new xajaxResponse('UTF-8');
    $cls = new interfazProducto();
    $html = $cls->interfazEditar($producto);
    $rpta->script("$('#modal .modal-header h5').text('Editar Producto');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");
    $rpta->script("
        $('#btnEdiar').unbind('click').click(function() {
            xajax__productoMantenimiento('" . $flag . "',xajax.getFormValues('form'));
        });");
    return $rpta;
}

function _productoDatagrid($criterio, $total_regs = 0, $pagina = 1, $nregs = 50)
{
    $rpta = new xajaxResponse();
    $cls = new interfazProducto();
    $html = $cls->datagrid($criterio, $total_regs, $pagina, $nregs);
    $rpta->assign("outQuery", "innerHTML", $html);
    return $rpta;
}

function _productoMantenimiento($flag, $form = '')
{
    $rpta = new xajaxResponse();
    $clase = new producto();
    $interfaz = new interfazProducto();
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

$xajax->register(XAJAX_FUNCTION, '_interfazProducto');
$xajax->register(XAJAX_FUNCTION, '_interfazProductoNuevo');
$xajax->register(XAJAX_FUNCTION, '_productoDatagrid');
$xajax->register(XAJAX_FUNCTION, '_productoMantenimiento');
$xajax->register(XAJAX_FUNCTION, '_interfazProductoEditar');
