<?php
class interfazVentas
{
    function principal()
    {
        $_SESSION["carrito"] = array();
        $clsabstract = new interfazAbstract();
        $clasetipocomprobante = new tipocomprobante();
        $datatipocomprobante = $clasetipocomprobante->consultar('2', '');
        $clsabstract->legenda('fa fa-user-edit', 'Editar');
        $clsabstract->legenda('fa fa-times-circle', 'Eliminar');

        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Buscar Productos";
        $html = ' 
    
    <div class="card">
        <div class="card-header">' . $titulo . '</div>
            <div class="card-body">        
                <form class="form-inline" onsubmit="return false;">
                    <input type="text" class="form-control" id="txtBuscar" placeholder="Buscar por Nombres o Nro. Documento" style="width:70%">                           
                    <button type="button" class="btn btn-secondary" id="btnBuscar"><i class="fas fa-search"></i>Buscar</button>
                                           
                </form>             
            </div>
            
            <div class="card-body" id="outQuery" style="margin-top:-50px"> 

            </div>

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
    </div>
    <p>
    <div class="card">
        <div class="card-header">Venta</div>
            <div class="card-body">
                 <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post"> 
                 <div class="form-group row">
                    <div class="input-group">
                        <label class="col-sm-2 col-form-label" > Cliente:</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="txtBuscarCliente" placeholder="Buscar por Nro. Documento" style="width:70%">                      
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="btnBuscarCliente">Buscar</button>
                        </span>
                        </div>
                    </div>
                </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Nombre:</label>
                        <div class="col-sm-10">
                            <input type="text" style ="width:80%" class="form-control"   id="txtNombre" name="txtNombre"/>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Dirección:</label>
                        <div class="col-sm-10">
                            <input type="text" style ="width:80%" class="form-control"   id="txtDireccion" name="txtDireccion"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" > Comprobante:</label>
                        <div class="col-sm-10">
                            <select id="lstTipoDocumento" name="lstTipoDocumento" class ="form-control" style="width:30%">
                                <option value="">SELECCIONAR...</option>';
        foreach ($datatipocomprobante as $value) {
            $html .= '<option value="' . $value["tipocomprobante"] . '">' . $value["descripcion"] . '</option>';
        }
        $html .= '</select>
                        </div>
                    </div>                                          
                </form>
            </div>

            <div class="card-body" id="outQueryDetalle" style="margin-top:-50px">';
        $html .=
            '<table id="tab_" class="data-tbl-simple table table-bordered" style="border-left:#ccc 1px solid;border-right:0px;width:100%;">
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
                    </tbody>';
        $html .= '</div>

        </div>
    </div>
    ';

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
                    <td id="tdSubtotal" style="text-align:right">0.00</td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align:center;font-size:18px; font-weight:bold">TOTAL</td>
                    <td id="tdSubtotal" style="text-align:right">0.00</td>
                </tr>';
        $html .= '</tbody>';
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

$xajax->register(XAJAX_FUNCTION, '_interfazVentas');
$xajax->register(XAJAX_FUNCTION, '_BuscarDatosxDni');
$xajax->register(XAJAX_FUNCTION, '_llenarBandejaVenta');
