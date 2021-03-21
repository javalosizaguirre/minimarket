<?php
include_once RUTA_CLASES . 'usuarios.class.php';
class interfazUsuarios
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clsabstract->legenda('fa fa-user-edit', 'Editar');
        $clsabstract->legenda('fa fa-times-circle', 'Eliminar');

        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Usuarios";
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
            "titulo" => "DNI",
            "campo" => "dni",
            "width" => "80"
        ));

        $Grid->columna(array(
            "titulo" => "Apellidos y Nombres",
            "campo" => "nombres",
            "width" => "300"
        ));

        $Grid->columna(array(
            "titulo" => "Email",
            "campo" => "email",
            "width" => "150"
        ));

        $Grid->columna(array(
            "titulo" => "Celular",
            "campo" => "nrotelefono",
            "width" => "100"
        ));
        $Grid->columna(array(
            "titulo" => "Perfil",
            "campo" => "nombreperfil",
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
                "fn" => "xajax__usuariosMantenimiento",
                "msn" => "¿Esta seguro de eliminar el registro?",
                "parametros" => array(
                    "flag" => "3",
                    "campos" => array("dni")
                )
            )
        ));

        $Grid->accion(array(
            "icono" => "fa fa-user-edit",
            "titulo" => "Editar Usuario",
            "xajax" => array(
                "fn" => "xajax__interfazUsuariosEditar",
                "parametros" => array(
                    "flag" => "2",
                    "campos" => array("dni")
                )
            )
        ));
        $Grid->data(array(
            "criterio" => $criterio,
            "total" => $Grid->totalRegistros,
            "pagina" => $pagina,
            "nRegPagina" => $nreg_x_pag,
            "class" => "usuarios",
            "method" => "buscar"
        ));
        $Grid->paginador(array(
            "xajax" => "xajax__usuariosDatagrid",
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
        $claseperfil = new perfil();
        $dataperfil = $claseperfil->consultar('2', '');
        $html = '
            <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post">                
                
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><span style="color:red">(*)</span> DNI:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:30%" class="form-control"   id="txtDni" name="txtDni"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Nombres:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtNombres" name="txtNombres"/>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Apellidos:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtApellidos" name="txtApellidos"/>
                        </div>
                    </div>        
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Email:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtEmail" name="txtEmail"/>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Teléfono:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtNroTelefono" name="txtNroTelefono"/>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Dirección:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtDireccion" name="txtDireccion"/>
                        </div>
                    </div>                                         
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Perfil:</label>
                        <div class="col-sm-9">
                            <select id="lstPerfil" name="lstPerfil" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($dataperfil as $value) {
            $html .= '<option value="' . $value["perfil"] . '">' . $value["descripcion"] . '</option>';
        }
        $html .= '</select>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Contraseña:</label>
                        <div class="col-sm-9">
                            <input type="password" style ="width:100%" class="form-control"   id="txtContrasenia" name="txtContrasenia" placeholder="Contraseña por defecto su DNI"/>
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

    public function interfazEditar($dni)
    {
        $claseperfil = new perfil();
        $claseusuario = new usuarios();
        $dataperfil = $claseperfil->consultar('2', '');
        $datausuarios = $claseusuario->consultar('1', $dni);
        $html = '
            <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post">                
                
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><span style="color:red">(*)</span> DNI:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:30%" class="form-control"   id="txtDni" name="txtDni" value="' . $dni . '" readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Nombres:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtNombres" name="txtNombres" value="' . $datausuarios[0]["nombres"] . '"/>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Apellidos:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtApellidos" name="txtApellidos" value="' . $datausuarios[0]["apellidos"] . '"/>
                        </div>
                    </div>        
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Email:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtEmail" name="txtEmail" value="' . $datausuarios[0]["email"] . '"/>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Teléfono:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtNroTelefono" name="txtNroTelefono" value="' . $datausuarios[0]["nrotelefono"] . '"/>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Dirección:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtDireccion" name="txtDireccion" value="' . $datausuarios[0]["direccion"] . '"/>
                        </div>
                    </div>                                         
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" ><span style="color:red">(*)</span> Perfil:</label>
                        <div class="col-sm-9">
                            <select id="lstPerfil" name="lstPerfil" class="form-control">
                                <option value="">SELECCIONAR...</option>';
        foreach ($dataperfil as $value) {
            if ($datausuarios[0]["perfil"] == $value["perfil"]) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $html .= '<option value="' . $value["perfil"] . '" ' . $selected . '>' . $value["descripcion"] . '</option>';
        }
        $html .= '</select>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" > Contraseña:</label>
                        <div class="col-sm-9">
                            <input type="password" style ="width:100%" class="form-control"   id="txtContrasenia" name="txtContrasenia" placeholder="Contraseña por defecto su DNI"/>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" >Activo:</label>
                        <div class="col-sm-9">
                            <input id="chk_activo"  name="chk_activo" type="checkbox" value="1" style="vertical-align:middle" ' . ($datausuarios[0]["activo"] == '1' ? 'checked' : '') . '>
                        </div>
                    </div>                                                                                                                                                                                                                          
            </form>';

        $botones = '<span style="color:red">(*) Campos Obligatorios.</span>
                        <button type="button" class="btn btn-primary" id="btnEditar"><i class="icon-ok icon-white"></i><span id="spanSave01">Guardar</span></button>                   
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-remove"></i>Cerrar</button>                        
            </fieldset>
            </form>';
        return array($html, $botones);
    }
}

function _interfazUsuarios()
{
    $rpta = new xajaxResponse();
    $cls = new interfazUsuarios();
    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);
    $rpta->script("
    $('#btnNuevo').unbind('click').click(function() {
        xajax__interfazUsuariosNuevo();
    });");
    $rpta->script("
    $('#btnBuscar').unbind('click').click(function() {
    xajax__usuariosDatagrid(document.getElementById('txtBuscar').value);
    });");
    $rpta->script("
    $('#txtBuscar').unbind('keypress').keypress(function() {
        validarEnter(event)
    });");
    return $rpta;
}

function _interfazUsuariosNuevo()
{
    $rpta = new xajaxResponse('UTF-8');
    $cls = new interfazUsuarios();
    $html = $cls->interfazNuevo();
    $rpta->script("$('#modal .modal-header h5').text('Registrar Usuario');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");
    $rpta->script("
        $('#btnGuardar').unbind('click').click(function() {
            xajax__usuariosMantenimiento('1',xajax.getFormValues('form'));
        });");
    return $rpta;
}

function _interfazUsuariosEditar($flag, $dni)
{
    $rpta = new xajaxResponse('UTF-8');
    $cls = new interfazUsuarios();
    $html = $cls->interfazEditar($dni);
    $rpta->script("$('#modal .modal-header h5').text('Registrar Usuario');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");
    $rpta->script("
        $('#btnEditar').unbind('click').click(function() {
            xajax__usuariosMantenimiento('" . $flag . "',xajax.getFormValues('form'));
        });");
    return $rpta;
}

function _usuariosDatagrid($criterio, $total_regs = 0, $pagina = 1, $nregs = 50)
{
    $rpta = new xajaxResponse();
    $cls = new interfazUsuarios();
    $html = $cls->datagrid($criterio, $total_regs, $pagina, $nregs);
    $rpta->assign("outQuery", "innerHTML", $html);
    return $rpta;
}

function _usuariosMantenimiento($flag, $form = '')
{
    $rpta = new xajaxResponse();
    $clase = new usuarios();
    $interfaz = new interfazUsuarios();
    if ($flag == '3') {
        $form = array("txtDni" => $form);
    }

    $msj1 = '';
    $msj = 'LOS SIGUIENTES CAMPOS SON REQUERIDOS (*)';
    $msj .= '\\n-----------------------------------------------------------------------\\n';


    if ($form["txtDni"] == '') {
        $msj1 .= '- Dni\\n';
    }
    if ($form["txtNombres"] == '') {
        $msj1 .= '- Nombres\\n';
    }
    if ($form["txtApellidos"] == '') {
        $msj1 .= '- Apellidos\\n';
    }
    if ($form["lstPerfil"] == '') {
        $msj1 .= '- Perfil\\n';
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

$xajax->register(XAJAX_FUNCTION, '_interfazUsuarios');
$xajax->register(XAJAX_FUNCTION, '_interfazUsuariosNuevo');
$xajax->register(XAJAX_FUNCTION, '_usuariosMantenimiento');
$xajax->register(XAJAX_FUNCTION, '_usuariosDatagrid');
$xajax->register(XAJAX_FUNCTION, '_interfazUsuariosEditar');
