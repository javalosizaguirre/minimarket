<?php
include_once RUTA_CLASES . 'tipodocumento.class.php';
class interfazTipoDocumento
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clsabstract->legenda('fa fa-user-edit', 'Editar');
        $clsabstract->legenda('fa fa-times-circle', 'Eliminar');

        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Tipo de Documento";
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
            <div class="modal-dialog" role="document">
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
            "campo" => "tipodocumento",
            "width" => "50"
        ));

        $Grid->columna(array(
            "titulo" => "Descripcion",
            "campo" => "descripcion",
            "width" => "400"
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
                "fn" => "xajax__tipodocumentoMantenimiento",
                "msn" => "¿Esta seguro de eliminar el registro?",
                "parametros" => array(
                    "flag" => "3",
                    "campos" => array("tipodocumento")
                )
            )
        ));

        $Grid->accion(array(
            "icono" => "fa fa-user-edit",
            "titulo" => "Editar Tipo de Documento",
            "xajax" => array(
                "fn" => "xajax__interfazTipoDocumentoEditar",
                "parametros" => array(
                    "flag" => "2",
                    "campos" => array("tipodocumento")
                )
            )
        ));
        $Grid->data(array(
            "criterio" => $criterio,
            "total" => $Grid->totalRegistros,
            "pagina" => $pagina,
            "nRegPagina" => $nreg_x_pag,
            "class" => "tipodocumento",
            "method" => "buscar"
        ));
        $Grid->paginador(array(
            "xajax" => "xajax__tipodocumentoDatagrid",
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
                        <label class="col-sm-3 col-form-label" >Código:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:30%" class="form-control"   id="txtCodigo" name="txtCodigo" maxlength="2" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Descripción:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtDescripcion" name="txtDescripcion"/>
                        </div>
                    </div>                                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" >Activo:</label>
                        <div class="col-sm-9">
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

    public function interfazEditar($tipodocumento)
    {
        $clase = new tipodocumento();
        $data = $clase->consultar('1', $tipodocumento);

        $html = '
            <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post">                
                
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" >Código:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:30%" class="form-control"   id="txtCodigo" name="txtCodigo" value="' . $tipodocumento . '" maxlength="3" readonly />
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

function _interfazTipoDocumento()
{
    $rpta = new xajaxResponse();
    $cls = new interfazTipoDocumento();
    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);
    $rpta->script("
    $('#btnNuevo').unbind('click').click(function() {
        xajax__interfazTipoDocumentoNuevo();
    });");
    $rpta->script("
    $('#btnBuscar').unbind('click').click(function() {
    xajax__tipodocumentoDatagrid(document.getElementById('txtBuscar').value);
    });");
    $rpta->script("
    $('#txtBuscar').unbind('keypress').keypress(function() {
        validarEnter(event)
    });");
    return $rpta;
}

function _interfazTipoDocumentoNuevo()
{
    $rpta = new xajaxResponse('UTF-8');
    $cls = new interfazTipoDocumento();
    $html = $cls->interfazNuevo();
    $rpta->script("$('#modal .modal-header h5').text('Registrar Tipo de Documento');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");
    $rpta->script("
        $('#btnGuardar').unbind('click').click(function() {
            xajax__tipodocumentoMantenimiento('1',xajax.getFormValues('form'));
        });");
    return $rpta;
}

function _interfazTipoDocumentoEditar($flag, $tipodocumento)
{
    $rpta = new xajaxResponse('UTF-8');
    $cls = new interfazTipoDocumento();
    $html = $cls->interfazEditar($tipodocumento);
    $rpta->script("$('#modal .modal-header h5').text('Editar Tipo de Documento');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");
    $rpta->script("
        $('#btnEdiar').unbind('click').click(function() {
            xajax__tipodocumentoMantenimiento('" . $flag . "',xajax.getFormValues('form'));
        });");
    return $rpta;
}

function _tipodocumentoDatagrid($criterio, $total_regs = 0, $pagina = 1, $nregs = 50)
{
    $rpta = new xajaxResponse();
    $cls = new interfazTipoDocumento();
    $html = $cls->datagrid($criterio, $total_regs, $pagina, $nregs);
    $rpta->assign("outQuery", "innerHTML", $html);
    return $rpta;
}

function _tipodocumentoMantenimiento($flag, $form = '')
{
    $rpta = new xajaxResponse();
    $clase = new tipodocumento();
    $interfaz = new interfazTipoDocumento();
    if ($flag == '3') {
        $form = array("txtCodigo" => $form);
    }

    $msj1 = '';
    $msj = 'LOS SIGUIENTES CAMPOS SON REQUERIDOS (*)';
    $msj .= '\\n-----------------------------------------------------------------------\\n';

    if ($form["txtCodigo"] == '') {
        $msj1 .= '- Código\\n';
    }

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

$xajax->register(XAJAX_FUNCTION, '_interfazTipoDocumento');
$xajax->register(XAJAX_FUNCTION, '_interfazTipoDocumentoNuevo');
$xajax->register(XAJAX_FUNCTION, '_tipodocumentoDatagrid');
$xajax->register(XAJAX_FUNCTION, '_tipodocumentoMantenimiento');
$xajax->register(XAJAX_FUNCTION, '_interfazTipoDocumentoEditar');
