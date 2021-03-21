<?php
include_once RUTA_CLASES . 'cliente.class.php';
class interfazCliente
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clsabstract->legenda('fa fa-user-edit', 'Editar');
        $clsabstract->legenda('fa fa-times-circle', 'Eliminar');

        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Cliente";
        $html = ' 
    
    <div class="card">
        <div class="card-header">' . $titulo . '</div>
            <div class="card-body">        
                <form class="form-inline" onsubmit="return false;">
                    <input type="text" class="form-control" id="txtBuscar" placeholder="Buscar por Nombres o Nro. Documento" style="width:70%">                           
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
            "titulo" => "Tipo de Documento",
            "campo" => "nombretipodocumento",
            "width" => "100"
        ));

        $Grid->columna(array(
            "titulo" => "Nro. Documento",
            "campo" => "nrodocumento",
            "width" => "100"
        ));

        $Grid->columna(array(
            "titulo" => "Apellidos y Nombres",
            "campo" => "nombres",
            "width" => "300"
        ));

        $Grid->columna(array(
            "titulo" => "Dirección",
            "campo" => "direccion",
            "width" => "200"
        ));

        $Grid->columna(array(
            "titulo" => "Email",
            "campo" => "email",
            "width" => "100"
        ));

        $Grid->columna(array(
            "titulo" => "Nro. Teléfono",
            "campo" => "telefono",
            "width" => "100"
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
                "fn" => "xajax__clienteMantenimiento",
                "msn" => "¿Esta seguro de eliminar el registro?",
                "parametros" => array(
                    "flag" => "3",
                    "campos" => array("nrodocumento")
                )
            )
        ));

        $Grid->accion(array(
            "icono" => "fa fa-user-edit",
            "titulo" => "Editar Usuario",
            "xajax" => array(
                "fn" => "xajax__interfazClienteEditar",
                "parametros" => array(
                    "flag" => "2",
                    "campos" => array("nrodocumento")
                )
            )
        ));
        $Grid->data(array(
            "criterio" => $criterio,
            "total" => $Grid->totalRegistros,
            "pagina" => $pagina,
            "nRegPagina" => $nreg_x_pag,
            "class" => "cliente",
            "method" => "buscar"
        ));
        $Grid->paginador(array(
            "xajax" => "xajax__clienteDatagrid",
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
        $clasetipodocumento = new tipodocumento();
        $datatipodocumento = $clasetipodocumento->consultar('2', '');
        $html = '
            <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post">                
                
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Nro. Documento:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:50%" class="form-control"   id="txtNroDocumento" name="txtNroDocumento" maxlength="12" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Tipo Documento:</label>
                        <div class="col-sm-9">
                            <select id="lstTipoDocumento" name="lstTipoDocumento" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($datatipodocumento as $value) {
            $html .= '<option value="' . $value["tipodocumento"] . '">' . $value["descripcion"] . '</option>';
        }
        $html .= '</select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Nombre:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtNombre" name="txtNombre"/>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Dirección:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtDireccion" name="txtDireccion"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Teléfono:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtTelefono" name="txtTelefono"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Email:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtEmail" name="txtEmail"/>
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

    public function interfazEditar($cliente)
    {
        $clase = new cliente();
        $clasetipodocumento = new tipodocumento();

        $datacliente = $clase->consultar('1', $cliente);
        $datatipodocumento = $clasetipodocumento->consultar('2', '');
        $html = '
            <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post">                
                
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Nro. Documento:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:50%" class="form-control"   id="txtNroDocumento" name="txtNroDocumento" maxlength="12" value="' . $cliente . '" readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Tipo Documento:</label>
                        <div class="col-sm-9">
                            <select id="lstTipoDocumento" name="lstTipoDocumento" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($datatipodocumento as $value) {
            if ($datacliente[0]["tipodocumento"] == $value["tipodocumento"]) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $html .= '<option value="' . $value["tipodocumento"] . '" ' . $selected . '>' . $value["descripcion"] . '</option>';
        }
        $html .= '</select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Nombre:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtNombre" name="txtNombre" value="' . $datacliente[0]["nombres"] . '"/>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Dirección:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtDireccion" name="txtDireccion" value="' . $datacliente[0]["direccion"] . '"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Teléfono:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtTelefono" name="txtTelefono" value="' . $datacliente[0]["telefono"] . '"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Email:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtEmail" name="txtEmail" value="' . $datacliente[0]["email"] . '"/>
                        </div>
                    </div>                                                                                             
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" >Activo:</label>
                        <div class="col-sm-9">
                            <input id="chk_activo"  name="chk_activo" type="checkbox" value="1" style="vertical-align:middle" ' . ($datacliente[0]["activo"] == '1' ? 'checked' : '') . '>
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

function _interfazCliente()
{
    $rpta = new xajaxResponse();
    $cls = new interfazCliente();
    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);
    $rpta->script("
    $('#btnNuevo').unbind('click').click(function() {
        xajax__interfazClienteNuevo();
    });");
    $rpta->script("
    $('#btnBuscar').unbind('click').click(function() {
    xajax__clienteDatagrid(document.getElementById('txtBuscar').value);
    });");
    $rpta->script("
    $('#txtBuscar').unbind('keypress').keypress(function() {
        validarEnter(event)
    });");
    return $rpta;
}

function _interfazClienteNuevo()
{
    $rpta = new xajaxResponse('UTF-8');
    $cls = new interfazCliente();
    $html = $cls->interfazNuevo();
    $rpta->script("$('#modal .modal-header h5').text('Registrar Perfil');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");
    $rpta->script("
        $('#btnGuardar').unbind('click').click(function() {
            xajax__clienteMantenimiento('1',xajax.getFormValues('form'));
        });");
    return $rpta;
}

function _interfazClienteEditar($flag, $perfil)
{
    $rpta = new xajaxResponse('UTF-8');
    $cls = new interfazCliente();
    $html = $cls->interfazEditar($perfil);
    $rpta->script("$('#modal .modal-header h5').text('Registrar Perfil');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");
    $rpta->script("
        $('#btnEdiar').unbind('click').click(function() {
            xajax__clienteMantenimiento('" . $flag . "',xajax.getFormValues('form'));
        });");
    return $rpta;
}

function _clienteDatagrid($criterio, $total_regs = 0, $pagina = 1, $nregs = 50)
{
    $rpta = new xajaxResponse();
    $cls = new interfazCliente();
    $html = $cls->datagrid($criterio, $total_regs, $pagina, $nregs);
    $rpta->assign("outQuery", "innerHTML", $html);
    return $rpta;
}

function _clienteMantenimiento($flag, $form = '')
{
    $rpta = new xajaxResponse();
    $clase = new cliente();
    $interfaz = new interfazCliente();
    if ($flag == '3') {
        $form = array("txtNroDocumento" => $form);
    }

    $msj1 = '';
    $msj = 'LOS SIGUIENTES CAMPOS SON REQUERIDOS (*)';
    $msj .= '\\n-----------------------------------------------------------------------\\n';


    if ($form["txtNroDocumento"] == '') {
        $msj1 .= '- Nro. de Documento\\n';
    }

    if ($form["lstTipoDocumento"] == '') {
        $msj1 .= '- Nro. de Documento\\n';
    }

    if ($form["txtNombre"] == '') {
        $msj1 .= '- Nombre\\n';
    }

    if ($form["lstTipoDocumento"] == '01' &&  strlen($form["txtNroDocumento"]) != 8) {
        $msj1 .= '- El Nro. de DNI debe contener 8 caracteres\\n';
    }

    if ($form["lstTipoDocumento"] == '06' && strlen($form["txtNroDocumento"]) != 11) {
        $msj1 .= '- El Nro. de RUC debe contener 11 caracteres\\n';
    }

    if ($form["lstTipoDocumento"] == '04' && strlen($form["txtNroDocumento"]) != 12) {
        $msj1 .= '- El Nro. de Carnet de Extranjeria debe contener 12 caracteres\\n';
    }

    if ($form["lstTipoDocumento"] == '07' && strlen($form["txtNroDocumento"]) != 12) {
        $msj1 .= '- El Nro. de Pasaporte debe contener 12 caracteres\\n';
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

$xajax->register(XAJAX_FUNCTION, '_interfazCliente');
$xajax->register(XAJAX_FUNCTION, '_interfazClienteNuevo');
$xajax->register(XAJAX_FUNCTION, '_clienteDatagrid');
$xajax->register(XAJAX_FUNCTION, '_clienteMantenimiento');
$xajax->register(XAJAX_FUNCTION, '_interfazClienteEditar');
