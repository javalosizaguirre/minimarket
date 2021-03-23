<?php
include_once RUTA_CLASES . 'ventas.class.php';
include_once RUTA_CLASES . 'ventasdetalle.class.php';
class interfazVentas
{
    function principal()
    {
        $_SESSION["carrito"] = array();
        $clsabstract = new interfazAbstract();
        $clasetipocomprobante = new tipocomprobante();
        $claseformapago = new formapago();
        $clasetarjetas = new tarjetas();
        $datatipocomprobante = $clasetipocomprobante->consultar('2', '');
        $dataformapago = $claseformapago->consultar('2', '');
        $datatarjetas = $clasetarjetas->consultar('2', '');

        $clsabstract->legenda('fa fa-user-edit', 'Editar');
        $clsabstract->legenda('fa fa-times-circle', 'Eliminar');

        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Buscar Productos";
        $html = ' 
    
    <div class="card">
        <div class="card-header">' . $titulo .
            '</div>
            <div class="card-body">        
                <form class="form-inline" onsubmit="return false;">
                    <input type="text" class="form-control" id="txtBuscar" placeholder="Buscar por Nombres o Nro. Documento" style="width:70%">                           
                    <button type="button" class="btn btn-secondary" id="btnBuscar"><i class="fas fa-search"></i>Buscar</button>
                                           
                </form>             
            </div>
            
            <div class="card-body" id="outQuery" style="margin-top:-50px"> 

            </div>           
        </div>

        </div>
    </div>
    <p>
    <form id="frmVenta" name="frmVenta" onsubmit="return false;"  class="form-horizontal">
    <div class="card">
        <div class="card-header">Venta</div>
            <div class="card-body">
                 <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post"> 
                 <div class="form-group row">
                        <label class="col-sm-1 col-form-label" >Doc.</label>
                        <div class="col-sm-2">
                            <select id="lstTipoDocumento" name="lstTipoDocumento" class ="form-control" style="width:100%">
                                <option value="">Seleccionar...</option>';
        foreach ($datatipocomprobante as $value) {
            $html .= '<option value="' . $value["tipocomprobante"] . '" ' . ($value["tipocomprobante"] == '01') . '>' . $value["descripcion"] . '</option>';
        }
        $html .=
            '</select>
                        </div>                    
                        <label class="col-sm-1 col-form-label" > Fecha:</label>
                        <div class="col-sm-3">                                
                            <input type="text" class="form-control datepicker" id="txtFecha" name="txtFecha" readonly value="' . date("d-m-Y") . '"> 
                        </div>                        
                    </div> 
                    <div class="form-group row">
                    <label class="col-sm-1 col-form-label" >F. Pago</label>
                        <div class="col-sm-2">
                            <select id="lstFormaPago" name="lstFormaPago" class ="form-control" style="width:100%">
                                <option value="">Seleccionar...</option>';
        foreach ($dataformapago as $value) {
            $html .= '<option value="' . $value["formapago"] . '" ' . ($value["formapago"] == '1' ? 'selected' : '') . '>' . $value["descripcion"] . '</option>';
        }
        $html .=
            '</select>
                        </div>
                        
                        <label class="col-sm-1 col-form-label tarjetas" style="display:none">Tarjeta</label>
                        <div class="col-sm-2 tarjetas" style="display:none">
                            <select id="lstTarjeta" name="lstTarjeta" class ="form-control" style="width:100%">
                                <option value="">Seleccionar...</option>';
        foreach ($datatarjetas as $value) {
            $html .= '<option value="' . $value["tarjeta"] . '" >' . $value["descripcion"] . '</option>';
        }
        $html .= '</select>
                        </div>
                    
                    </div>
                    
                 <div class="form-group row">
                    <div class="input-group">
                        <label class="col-sm-1 col-form-label" > Cliente:</label>
                        <div class="col-sm-11">
                        <input type="text" class="form-control" id="txtBuscarCliente" name="txtBuscarCliente" placeholder="Buscar por Nro. Documento" style="width:70%" readonly>                      
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="btnBuscarCliente" >Buscar</button>
                        </span>
                        </div>
                    </div>
                </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label" > Nombre:</label>
                        <div class="col-sm-11">
                            <input type="text" style ="width:80%" class="form-control"   id="txtNombre" name="txtNombre" readonly/>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label" > Dir.:</label>
                        <div class="col-sm-11">
                            <input type="text" style ="width:80%" class="form-control"   id="txtDireccion" name="txtDireccion" readonly/>
                        </div>
                    </div>
                                                             
                </form>
            </div>

            <div class="card-body" id="outQueryDetalle" style="margin-top:-50px">        
                <table id="tab_" class="data-tbl-simple table table-bordered" style="border-left:#ccc 1px solid;border-right:0px;width:100%;">
                    <thead>
                        <tr>
                            <th style="width:20px;vertical-align:middle;text-align:center">Item</th>
                            <th style="width:700px;vertical-align:middle;text-align:center">Producto</th>
                            <th style="width:20px;vertical-align:middle;text-align:center">Cant.</th>
                            <th style="width:20px;vertical-align:middle;text-align:center">Precio</th>
                            <th style="width:20px;vertical-align:middle;text-align:center">Subtotal</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                
            </div> 
            <div style="text-align:center">
           <button class="btn btn-primary" type="button" id="btnProcesarVenta" style="width:100px">Procesar</button>
           </div> 
        </div>                
    </div>   
    <iframe style="display:none" id="frame" width="400" height="400" frameborder="0"></iframe>

    </form>';

        return $html;
    }

    function listarBandeja()
    {
        $html =
            '<table id="tab_" class="data-tbl-simple table table-bordered" style="border-left:#ccc 1px solid;border-right:0px;width:100%;">
                    <thead>
                        <tr>
                            <th style="width:20px;vertical-align:middle;text-align:center">Item</th>
                            <th style="width:80px;vertical-align:middle;text-align:center">Código</th>
                            <th style="width:400px;vertical-align:middle;text-align:center">Producto</th>
                            <th style="width:10px;vertical-align:middle;text-align:center">Cant.</th>
                            <th style="width:10px;vertical-align:middle;text-align:center">Precio</th>
                            <th style="width:10px;vertical-align:middle;text-align:center">Subtotal</th>
                            
                        </tr>
                    </thead>
                    <tbody>';
        $c = 1;
        $d = 0;

        $total = count($_SESSION["carrito"]["producto"]);
        while ($d < $total) {
            $html .= '<tr>
                                        <td >' . $c++ . '</td>
                                        <td >' . $_SESSION["carrito"]["producto"][$d] . '</td>
                                        <td >' . $_SESSION["carrito"]["descripcion"][$d] . '</td>
                                        <td style="text-align:right">' . $_SESSION["carrito"]["cantidad"][$d] . '</td>
                                        <td style="text-align:right">' . (number_format($_SESSION["carrito"]["precioventa"][$d], 2, '.', '')) . '</td>
                                        <td style="text-align:right" class="subtotales">' . (number_format(($_SESSION["carrito"]["cantidad"][$d] * $_SESSION["carrito"]["precioventa"][$d]), 2, '.', '')) . '</td>
                                    </tr>';
            $d++;
        }
        $html .= '<tr>
                    <td colspan="5" style="text-align:center;font-size:18px; font-weight:bold">SUB TOTAL</td>
                    <td id="tdSubtotal" style="text-align:right">0.00</td>                    
                </tr>
                <tr>
                    <td colspan="5" style="text-align:center;font-size:18px; font-weight:bold">IGV</td>
                    <td id="tdigv" style="text-align:right">0.00</td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align:center;font-size:18px; font-weight:bold">TOTAL</td>
                    <td id="tdtotal" style="text-align:right">0.00</td>
                </tr>
                <input type="hidden" id="txtSubtotal" name="txtSubtotal" value="0.00">
                <input type="hidden" id="txtIgv" name="txtIgv"  value="0.00">
                <input type="hidden" id="txtTotal" name="txtTotal" value="0.00">';
        $html .= '</tbody>
                                
                ';
        return $html;
    }
}

function _interfazVentas()
{
    $rpta = new xajaxResponse();
    $cls = new interfazVentas();
    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);
    $rpta->script("
    $('#btnNuevo').unbind('click').click(function() {
        xajax__interfazPerfilNuevo();
    });");
    $rpta->script("
    $('#btnBuscar').unbind('click').click(function() {
    xajax__listarProductos(document.getElementById('txtBuscar').value);
    });");

    $rpta->script("
    $('#txtBuscar').unbind('keypress').keypress(function() {
        validarEnter(event)
    });");


    $rpta->script("
    $('#btnBuscarCliente').unbind('click').click(function() {
    xajax__BuscarDatosxDni(document.getElementById('txtBuscarCliente').value);
    });");

    $rpta->script("
    $('#txtBuscarCliente').unbind('keypress').keypress(function() {
        validarEnterCliente(event)
    });");

    $rpta->script("
        $('#lstTipoDocumento').unbind('change').change(function() {
            if(this.value===''){            
                $('#txtDireccion').attr('readonly','readonly');
                $('#txtNombre').attr('readonly','readonly');
                $('#txtBuscarCliente').attr('readonly','readonly');
                sumaSubtotales();
            }else{
                $('#txtDireccion').removeAttr('readonly');   
                $('#txtNombre').removeAttr('readonly');
                $('#txtBuscarCliente').removeAttr('readonly');
                sumaSubtotales();
            }
            
    });");

    $rpta->script("
        $('#btnProcesarVenta').unbind('click').click(function() {
            xajax__procesarVenta(xajax.getFormValues('frmVenta'));
        });");

    $rpta->script("
        $('#lstFormaPago').unbind('change').change(function() {            
            if(this.value=='3'){
                $('.tarjetas').css('display', 'block');
            }else{
                $('.tarjetas').css('display', 'none');
            }
    });");

    $rpta->script("$('.datepicker').datepicker({
        clearBtn: true,
        language: 'es'
    });");


    return $rpta;
}

function _BuscarDatosxDni($dni)
{
    $rpta = new xajaxResponse();
    $data = array();
    if (strlen($dni) == 8) {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $response = file_get_contents("https://api.reniec.cloud/dni/" . $dni, false, stream_context_create($arrContextOptions));
        $data = (json_decode($response, true));
        $nombre = $data["apellido_paterno"] . ' ' . $data["apellido_materno"] . ' ' . $data["nombres"];
        $rpta->assign("txtNombre", "value", $nombre);
    } elseif (strlen($dni) == 11) {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $response = file_get_contents("https://api.apis.net.pe/v1/ruc?numero=" . $dni, false, stream_context_create($arrContextOptions));
        $data = (json_decode($response, true));
        $nombre = $data["nombre"];
        $direccion = $data["direccion"];
        $rpta->assign("txtNombre", "value", $nombre);
        $rpta->assign("txtDireccion", "value", $direccion);
    }
    return $rpta;
}

function _llenarBandejaVenta($producto, $precioventa, $descripcion)
{
    $rpta = new xajaxResponse();
    $interfaz = new interfazVentas();

    $total = count($_SESSION["carrito"]["producto"]);
    $existe = false;
    $c = 0;
    if ($total == 0) {
        $_SESSION["carrito"]["producto"][] = $producto;
        $_SESSION["carrito"]["cantidad"][] = 1;
        $_SESSION["carrito"]["precioventa"][] = round($precioventa, 2);
        $_SESSION["carrito"]["descripcion"][] = $descripcion;
    } else {
        while ($c < $total) {
            if ($_SESSION["carrito"]["producto"][$c] == $producto) {
                $_SESSION["carrito"]["cantidad"][$c] = $_SESSION["carrito"]["cantidad"][$c] + 1;
                $existe = true;
            }
            $c++;
        }
        if (!$existe) {
            $_SESSION["carrito"]["producto"][] = $producto;
            $_SESSION["carrito"]["cantidad"][] = 1;
            $_SESSION["carrito"]["precioventa"][] = round($precioventa, 2);
            $_SESSION["carrito"]["descripcion"][] = $descripcion;
        }
    }
    $html = $interfaz->listarBandeja();
    $rpta->assign("outQueryDetalle", "innerHTML", $html);
    $rpta->script("sumaSubtotales()");
    return $rpta;
}

function _procesarVenta($form)
{
    $rpta = new xajaxResponse();
    $claseventa = new venta();
    $clasedetalleventa = new ventadetalle();
    $interfazventa = new interfazVentas();

    $msj1 = '';
    $msj = 'LOS SIGUIENTES CAMPOS SON REQUERIDOS (*)';
    $msj .= '\\n-----------------------------------------------------------------------\\n';


    if ($form["lstTipoDocumento"] == '') {
        $msj1 .= '- Doc.\\n';
    }

    if ($form["txtFecha"] == '') {
        $msj1 .= '- Fecha.\\n';
    }

    if ($form["lstFormaPago"] == '') {
        $msj1 .= '- Doc.\\n';
    }

    if ($form["txtBuscarCliente"] == '') {
        $msj1 .= '- Cliente.\\n';
    }

    if ($form["txtNombre"] == '') {
        $msj1 .= '- Nombre.\\n';
    }


    if ($form["txtTotal"] == '' || (!isset($form["txtTotal"]))) {
        $msj1 .= '- Debe agregar al menos un Producto.\\n';
    }

    if ($msj1 != '') {
        $rpta->script('alert("' . $msj . $msj1 . '")');
    } else {
        $result = $claseventa->mantenedor('1', $form);
        if ($result[0]["mensaje"] == 'MSG_001') {
            $c = 0;
            $cont = count($_SESSION["carrito"]["producto"]);

            while ($c < $cont) {
                if ($_SESSION["carrito"]["producto"][$c] != '') {
                    $resultdetalle = $clasedetalleventa->mantenedor('1', '', $result[0]["id"], $result[0]["serie"], $result[0]["nrocomprobante"], $_SESSION["carrito"]["producto"][$c], $_SESSION["carrito"]["cantidad"][$c], $_SESSION["carrito"]["precioventa"][$c]);
                }
                $c++;
            }

            if ($resultdetalle[0]["mensaje"] == 'MSG_001') {
                $rpta->script("
                    function loadPage(){
                        var frame = $('#frame');
                        var url = 'php/modulos/gestioncomercial/comprobante.php?id=" . $result[0]["id"] . "';
                        frame.attr('src',url);
                    }
                ");
                $rpta->script("loadPage()");
                $rpta->script("xajax__interfazVentas()");
            }
        } else {
            $rpta->alert('Ocurrio un error al guardar los datos, por favor comuníquese con el Administrador de Sistemas');
        }
    }

    return $rpta;
}

$xajax->register(XAJAX_FUNCTION, '_interfazVentas');
$xajax->register(XAJAX_FUNCTION, '_BuscarDatosxDni');
$xajax->register(XAJAX_FUNCTION, '_llenarBandejaVenta');
$xajax->register(XAJAX_FUNCTION, '_procesarVenta');
