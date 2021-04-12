<?php
include_once RUTA_CLASES . 'parametrosgenerales.class.php';
class interfazParametrosGenerales
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $claseparametrosgenerales = new parametrosgenerales();
        $arrayicon["pfx"]  = 'img/key.png';
        $datadepartamento = $claseparametrosgenerales->consultar('1', '');

        $titulo = "Parámetros Generales";
        $html = ' 
    
    <div class="card">
        <div class="card-header">' . $titulo . '</div>
            <div class="card-body">        
               <form id="form" name="form" onsubmit="return false" method="POST" target="ifrupload"
                  method="post"  enctype="multipart/form-data">
                   <table id="tab_" class="data-tbl-simple table table-bordered" style="border-left:#ccc 1px solid;border-right:0px;width:100%;">
                        <thead>
                            <tr>
                                <td style="width:30%">Razon Social de la Empresa</td>
                                <td style="width:70%"><input type="text" id="RAZON_SOCIAL" name="RAZON_SOCIAL" class="form-control" style="width:100%"></td>
                            </tr>
                            <tr>
                                <td style="width:30%">Nombre Comercial de la Empresa</td>
                                <td style="width:70%"><input type="text" id="RAZON_SOCIAL_COMERCIAL" name="RAZON_SOCIAL_COMERCIAL" class="form-control" style="width:100%"></td>
                            </tr>
                            
                            <tr>
                                <td>RUC de la empresa</td>
                                <td><input type="text" id="RUC_EMPRESA" name="RUC_EMPRESA" class="form-control" style="width:25%"></td>
                            </tr>
                            <tr>
                                <td>Dirección de la Empresa</td>
                                <td><input type="text" id="DIRECCION_EMPRESA" name="DIRECCION_EMPRESA" class="form-control" style="width:100%"></td>
                            </tr>
                            <tr>
                                <td>Departamento</td>
                                <td>
                                   <select id="DEPARTAMENTO_EMPRESA" name="DEPARTAMENTO_EMPRESA" class="form-control"  style="width:40%">
                                        <option value="">SELECCIONAR...</option>';
        foreach ($datadepartamento as $value) {
            $html .= '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';
        }
        $html .=
            '</select>
                                </td>
                            </tr>
                            <tr>
                                <td>Provincia</td>
                                <td id="tdProvincia">
                                    <select id="PROVINCIA_EMPRESA" name="PROVINCIA_EMPRESA" class="form-control"  style="width:40%">
                                        <option value="">SIN COINCIDENCIAS...</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Distrito</td>
                                <td id="tdDistrito">
                                    <select id="DISTRITO_EMPRESA" name="DISTRITO_EMPRESA" class="form-control"  style="width:40%">
                                        <option value="">SIN COINCIDENCIAS...</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Usuario SOL</td>
                                <td><input type="text" id="USUARIO_SOL" name="USUARIO_SOL" class="form-control" style="width:25%"></td>
                            </tr>
                            <tr>
                                <td>Clave Sol</td>
                                <td><input type="text" id="CLAVE_SOL" name="CLAVE_SOL" class="form-control" style="width:25%"></td>
                            </tr>
                            <tr>
                                <td>Firma Digital</td>
                                <td>                                    
                                    <div class="controls">
                                        <label class="pull-left" id="lbl_archivo" >
                                            <input  type="file" class="span3"   id="fileevidencia" name="fileevidencia" onchange="this.form.action=\'php/enviararchivo.php\';
                                                                    this.form.submit()" >
                                            <input type="hidden" id="hdarchivodemo" name="RUTA_FIRMA_DIGITAL_DEMO">
                                            <input type="hidden" id="hdarchivoproduccion" name="RUTA_FIRMA_DIGITAL_PRODUCCION">                                            
                                            <input type="hidden" id="hdnombrearchivo" name="hdnombrearchivo">                                                                                                                                                                                
                                        </label>
                                        <label class="pull-left" id="sp_ruta"></label>
                                            <button style="display:none" id="btneliminar" name="btneliminar"
                                                    onclick="this.form.action=\'php/eliminararchivo.php\';
                                                             this.form.submit();">
                                            <img width="16px" src="img/eliminar.png">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Numeración Inicial de Boleta</td>
                                <td><input type="text" id="NUMERACION_BOLETA_INICIAL" name="NUMERACION_BOLETA_INICIAL" class="form-control" style="width:25%" onkeypress="return gKeyAceptaSoloDigitos(event)"></td>
                            </tr>
                            <tr>
                                <td>Numeración Actual de Boleta</td>
                                <td><input type="text" id="NUMERACION_BOLETA_ACTUAL" name="NUMERACION_BOLETA_ACTUAL" class="form-control" style="width:25%" onkeypress="return gKeyAceptaSoloDigitos(event)"></td>
                            </tr>
                            <tr>
                                <td>Serie Boleta</td>
                                <td><input type="text" id="SERIE_BOLETA" name="SERIE_BOLETA" class="form-control" style="width:25%"></td>
                            </tr>
                            <tr>
                                <td>Numeración Inicial de Factura</td>
                                <td><input type="text" id="NUMERACION_FACTURA_INICIAL" name="NUMERACION_FACTURA_INICIAL" class="form-control" style="width:25%" onkeypress="return gKeyAceptaSoloDigitos(event)"></td>
                            </tr>
                            <tr>
                                <td>Numeración Actual de Factura</td>
                                <td><input type="text" id="NUMERACION_FACTURA_ACTUAL" name="NUMERACION_FACTURA_ACTUAL" class="form-control" style="width:25%" onkeypress="return gKeyAceptaSoloDigitos(event)"></td>
                            </tr>
                            <tr>
                                <td>Serie Factura</td>
                                <td><input type="text" id="SERIE_FACTURA" name="SERIE_FACTURA" class="form-control" style="width:25%"></td>
                            </tr>
                            <tr>
                                <td>Numeración Inicial Nota de Débito</td>
                                <td><input type="text" id="NUMERACIÓN_NOTA_DEBITO_INICIAL" name="NUMERACIÓN_NOTA_DEBITO_INICIAL" class="form-control" style="width:25%" onkeypress="return gKeyAceptaSoloDigitos(event)"></td>
                            </tr>
                            <tr>
                                <td>Numeración Actual Nota de Débito</td>
                                <td><input type="text" id="NUMERACIÓN_NOTA_DEBITO_ACTUAL" name="NUMERACIÓN_NOTA_DEBITO_ACTUAL" class="form-control" style="width:25%" onkeypress="return gKeyAceptaSoloDigitos(event)"></td>
                            </tr>
                            <tr>
                                <td>Serie Nota de Débito</td>
                                <td><input type="text" id="SERIE_NOTA_DEBITO" name="SERIE_NOTA_DEBITO" class="form-control" style="width:25%"></td>
                            </tr>
                            <tr>
                                <td>Numeración Inicial Nota de Crédito</td>
                                <td><input type="text" id="NUMERACIÓN_NOTA_CREDITO_INICIAL" name="NUMERACIÓN_NOTA_CREDITO_INICIAL" class="form-control" style="width:25%" onkeypress="return gKeyAceptaSoloDigitos(event)"></td>
                            </tr>
                            <tr>
                                <td>Numeración Actual Nota de Crédito</td>
                                <td><input type="text" id="NUMERACIÓN_NOTA_CREDITO_ACTUAL" name="NUMERACIÓN_NOTA_CREDITO_ACTUAL" class="form-control" style="width:25%" onkeypress="return gKeyAceptaSoloDigitos(event)"></td>
                            </tr>
                            <tr>
                                <td>Serie Nota de Crédito</td>
                                <td><input type="text" id="SERIE_NOTA_CREDITO" name="SERIE_NOTA_CREDITO" class="form-control" style="width:25%"></td>
                            </tr>
                            <tr>
                                <td>numeración Ininicial Nota de Venta</td>
                                <td><input type="text" id="NUMERACION_NOTA_VENTA_INICIAL" name="NUMERACION_NOTA_VENTA_INICIAL" class="form-control" style="width:25%" onkeypress="return gKeyAceptaSoloDigitos(event)"></td>
                            </tr>
                            <tr>
                                <td>numeración Actual Nota de venta</td>
                                <td><input type="text" id="NUMERACION_NOTA_VENTA_ACTUAL" name="NUMERACION_NOTA_VENTA_ACTUAL" class="form-control" style="width:25%" onkeypress="return gKeyAceptaSoloDigitos(event)"></td>
                            </tr>
                            <tr>
                                <td>Serie Nota de Venta</td>
                                <td><input type="text" id="SERIE_NOTA_VENTA" name="SERIE_NOTA_VENTA" class="form-control" style="width:25%"></td>
                            </tr>
                            <tr>
                                <td>IGV</td>
                                <td><input type="text" id="IGV_PROCENTAJE" name="IGV_PROCENTAJE" class="form-control" style="width:25%" onkeypress="return gKeyAceptaSoloDigitos(event)"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="button" class="btn btn-primary" id="btnGuardar"><i class="icon-ok icon-white"></i><span id="spanSave01">Guardar</span></button>
                                </td>
                            </tr>
                        </thead>
                        
                   </table> 
                       
                </form>
                <iframe style="width:600px;display:none" id="ifrupload" name="ifrupload" >
                        </iframe>             
            </div>                    
        </div>        
    </div>';

        return $html;
    }
}

function _interfazParametrosGenerales()
{
    $rpta = new xajaxResponse();
    $cls = new interfazParametrosGenerales();
    $clase = new parametrosgenerales();
    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);

    $result = $clase->consultar('4', '');
    foreach ($result as $value) {
        $rpta->assign($value["descripcion"], "value", $value["valor"]);
        if ($value["descripcion"] == "PROVINCIA_EMPRESA") {
            $rpta->script("xajax__cargarProvincia('" . substr($value["valor"], 0, 2) . "', '" . $value["valor"] . "')");
        }

        if ($value["descripcion"] == "DISTRITO_EMPRESA") {
            $rpta->script("xajax__cargarDistrito('" . substr($value["valor"], 0, 4) . "', '" . $value["valor"] . "')");
        }

        if ($value["descripcion"] == "RUTA_FIRMA_DIGITAL_DEMO") {
            $rpta->assign("hdarchivodemo", "value", $value["valor"]);
        }

        if ($value["descripcion"] == "RUTA_FIRMA_DIGITAL_PRODUCCION") {
            $rpta->assign("hdarchivoproduccion", "value", $value["valor"]);
        }
    }
    $rpta->script("
    $('#btnGuardar').unbind('click').click(function() {
        xajax__parametrosgeneralesMantenimiento('1',xajax.getFormValues('form'))
    });");

    $rpta->script("
    $('#DEPARTAMENTO_EMPRESA').unbind('change').change(function() {
        xajax__cargarProvincia(this.value)
    });");


    return $rpta;
}


function _parametrosgeneralesMantenimiento($flag, $form)
{
    $rpta = new xajaxResponse();
    $clase = new parametrosgenerales();
    $interfaz = new interfazParametrosGenerales();


    foreach ($form as $key => $value) {
        $result = $clase->mantenedor($key, $value);
    }

    if ($result[0]['mensaje'] == 'MSG_001') {
        $rpta->alert(MSG_001);
        $rpta->script("location.reload()");
    }


    return $rpta;
}

function _cargarProvincia($criterio, $defecto = '')
{
    $rpta = new xajaxResponse();
    $claseparametrosgenerales = new parametrosgenerales();
    $dataprovincia = $claseparametrosgenerales->consultar('2', $criterio);
    $html = '<select id="PROVINCIA_EMPRESA" name="PROVINCIA_EMPRESA" class="form-control" style="width:40%">
                <option value="">SELECCIONAR...</option>';
    foreach ($dataprovincia as $value) {
        if ($value["id"] == $defecto) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        $html .= '<option value="' . $value["id"] . '" ' . $selected . '>' . $value["nombre"] . '</option>';
    }
    $html .= '</select>';
    $rpta->assign("tdProvincia", "innerHTML", $html);

    $rpta->script("
    $('#PROVINCIA_EMPRESA').unbind('change').change(function() {
        xajax__cargarDistrito(this.value)
    });");
    return $rpta;
}

function _cargarDistrito($criterio, $defecto = '')
{
    $rpta = new xajaxResponse();
    $claseparametrosgenerales = new parametrosgenerales();

    $datadistrito = $claseparametrosgenerales->consultar('3', $criterio);
    $html = '<select id="DISTRITO_EMPRESA" name="DISTRITO_EMPRESA" class="form-control" style="width:40%">
                <option value="">SELECCIONAR...</option>';
    foreach ($datadistrito as $value) {
        if ($defecto == $value["id"]) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        $html .= '<option value="' . $value["id"] . '" ' . $selected . '>' . $value["nombre"] . '</option>';
    }
    $html .= '</select>';
    $rpta->assign("tdDistrito", "innerHTML", $html);
    return $rpta;
}

$xajax->register(XAJAX_FUNCTION, '_interfazParametrosGenerales');
$xajax->register(XAJAX_FUNCTION, '_parametrosgeneralesMantenimiento');
$xajax->register(XAJAX_FUNCTION, '_cargarProvincia');
$xajax->register(XAJAX_FUNCTION, '_cargarDistrito');
