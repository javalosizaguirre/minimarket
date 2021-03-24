<?php

include_once RUTA_CLASES . 'accesos.class.php';
class interfazAccesos
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clsT = new perfil();
        $leyenda = $clsabstract->renderLegenda('30%');

        $html = ' 
        
        <div class="card">
            <div class="card-header">Accesos por Tipo de Usuario </div>
                <div class="card-body">        
                    <form class="form-inline" action="/action_page.php">
                             <select id="lstTipoUsuario" name="lstTipoUsuario" class="form-control span3" style="width:50%"
                             onchange="xajax__consultarAccesos(this.value)">
                                <option value="">Seleccionar</option>';
        $clsT = new perfil();
        $resultT = $clsT->consultar('2', '');
        foreach ($resultT as $row) {

            $html .= '<option value="' . $row['perfil'] . '">' . $row['descripcion'] . '</option>';
        }
        $html .= '</select>   
                        <button type="button" class="btn btn-secondary" id="btnGuardarAccesos"><i class="fas fa-search"></i>Guardar</button>                                                                                              
                    </form>             
                </div>
                
                <div class="card-body" id="outQuery">
                        ' . $this->listadoOpciones() . '
                </div>
                <p><center>' . $leyenda . '</center></p>
            
            
               
            </div>
        </div>';






        return $html;
    }

    function listadoOpciones()
    {
        $cls =  new accesos();
        $dataModulos = $cls->consultar('1');


        $html = '<form id="frm_tableroAccesos" name="frm_tableroAccesos" onsubmit="return false"><table class="data-tbl-simple table table-bordered">';
        foreach ($dataModulos as $itemModulo) {
            $html .= '<tr >';
            $html .= '<thead>';
            $html .= '<th>';
            $html .= $itemModulo["nombre"];
            $html .= '</th>
                                    </tr>
                                    </thead>';

            $dataOpciones = $cls->consultar('2', $itemModulo["menu"]);
            $c = 1;
            foreach ($dataOpciones as $itemOpciones) {
                $html .= '<tr><td>';
                $html .= '<input class="chk_accesos" type="checkbox" id=' . $itemOpciones["cod"] . ' name=' . $itemOpciones["cod"] . '>&nbsp;&nbsp;';
                $html .= $itemOpciones["nombre"];
                $html .= '</td></tr>';
            }
        }
        $html .= '</tr>
                </table></form>';

        return $html;
    }
}


function _interfazGestionarAccesos()
{
    $rpta = new xajaxResponse();
    $cls = new interfazAccesos();
    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);
    $rpta->script("
        $('#btnGuardarAccesos').unbind('click');
        $('#btnGuardarAccesos').click(function() {            
                xajax__mantenimientoAccesos(xajax.getFormValues('frm_tableroAccesos'), document.getElementById('lstTipoUsuario').value)            
        });");

    return $rpta;
}


function _consultarAccesos($perfil)
{
    $rpta = new xajaxResponse();
    $cls = new accesos();
    $dataAccesosxPerfil = $cls->consultar('3', '', $perfil);

    $rpta->script('$(".chk_accesos").prop("checked", false);  ');
    foreach ($dataAccesosxPerfil as $itemOpcion) {
        $rpta->script("document.getElementById('" . $itemOpcion["cod"] . "').checked=true");
    }
    return $rpta;
}


function _mantenimientoAccesos($form, $perfil)
{
    $rpta = new xajaxResponse();
    $cls_ = new accesos();

    $c = 0;
    $cadena = '';

    foreach ($form as $key => $value) {
        $cadena .= $key . '¬';
        $c++;
    }

    $cadena = trim($cadena, '¬');

    $cls_->mantenedor($cadena, $c, $perfil);


    $rpta->alert("Los datos se guardaron correctamente");
    $rpta->script("xajax__interfazGestionarAccesos()");


    return $rpta;
}


$xajax->register(XAJAX_FUNCTION, '_interfazGestionarAccesos');
$xajax->register(XAJAX_FUNCTION, '_consultarAccesos');
$xajax->register(XAJAX_FUNCTION, '_mantenimientoAccesos');
