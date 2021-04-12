<?php
include_once RUTA_CLASES . 'ventas.class.php';
include_once RUTA_CLASES . 'ventasdetalle.class.php';
include_once RUTA_CLASES . 'caja.class.php';
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
    
         
                <form class="form-inline" onsubmit="return false;">
                    <input type="text" class="form-control" id="txtBuscar" placeholder="Buscar por Código o Descripción" style="width:70%">                           
                    <button type="button" class="btn btn-secondary" id="btnBuscar"><i class="fas fa-search"></i>Buscar</button>
                                           
                </form>             
            </div>
            <br>
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
            $html .= '<option value="' . $value["tipocomprobante"] . '" >' . $value["descripcion"] . '</option>';
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
        <iframe style="display:none" id="frame" width="300" height="300" frameborder="0"></iframe>    
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        
    </div>       
    </div>   
    

    </form>

            ';

        return $html;
    }

    function listarBandeja()
    {
        $c = 1;
        $d = 0;
        $total = count($_SESSION["carrito"]["producto"]);

        if ($total == 0) {

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
                    <tbody></table>';
        } else {
            $html =
                '<table id="tab_" class="data-tbl-simple table table-bordered" style="border-left:#ccc 1px solid;border-right:0px;width:100%;">
                    <thead>
                        <tr>
                            <th style="width:20px;vertical-align:middle;text-align:center">Rem.</th>
                            <th style="width:20px;vertical-align:middle;text-align:center">Item</th>
                            <th style="width:80px;vertical-align:middle;text-align:center">Código</th>
                            <th style="width:400px;vertical-align:middle;text-align:center">Producto</th>
                            <th style="width:10px;vertical-align:middle;text-align:center">Cant.</th>
                            <th style="width:10px;vertical-align:middle;text-align:center">Precio</th>
                            <th style="width:10px;vertical-align:middle;text-align:center">Subtotal</th>                            
                        </tr>
                    </thead>
                    <tbody>';
            while ($d < $total) {
                if ($_SESSION["carrito"]["producto"][$d] != '') {
                    $html .= '<tr>
                                        <td style="text-align:center"><a href="javascript:void(0)" onclick="xajax__vaciarBandejaVenta(\'' . $_SESSION["carrito"]["producto"][$d] . '\')"><i class="fa fa-times-circle" style="font-size:18px"></i></td>
                                        <td >' . $c++ . '</td>
                                        <td id="tdProducto_' . ($c - 1) . '">' . $_SESSION["carrito"]["producto"][$d] . '</td>
                                        <td id="tdDescripcion_' . ($c - 1) . '">' . $_SESSION["carrito"]["descripcion"][$d] . '</td>
                                        <td id="tdCantidad_' . ($c - 1) . '" style="text-align:right" onkeyup="calcularSubtotalItem(\'' . ($c - 1) . '\')" contenteditable="true" onkeypress="return gKeyAceptaSoloDigitosPunto(event)">' . $_SESSION["carrito"]["cantidad"][$d] . '</td>
                                        <td id="tdPrecio_' . ($c - 1) . '" style="text-align:right">' . (number_format($_SESSION["carrito"]["precioventa"][$d], 2, '.', '')) . '</td>
                                        <td id="tdSub_' . ($c - 1) . '" style="text-align:right" class="subtotales">' . (number_format(($_SESSION["carrito"]["cantidad"][$d] * $_SESSION["carrito"]["precioventa"][$d]), 2, '.', '')) . '</td>
                                    </tr>';
                }
                $d++;
            }
            $html .= '<tr>
                    <td colspan="6" style="text-align:center;font-size:18px; font-weight:bold">SUB TOTAL</td>
                    <td id="tdSubtotal" style="text-align:right">0.00</td>                    
                </tr>
                <tr>
                    <td colspan="6" style="text-align:center;font-size:18px; font-weight:bold">IGV</td>
                    <td id="tdigv" style="text-align:right">0.00</td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align:center;font-size:18px; font-weight:bold">TOTAL</td>
                    <td id="tdtotal" style="text-align:right">0.00</td>
                </tr>
                <tr>
                    <td colspan="7">
                        <table style="width: 40%" border="0">
                            <tr>
                                <td style="width: 20%" >Pago con:</td>
                                <td><input style="text-align:right" type="text" class="form-control" id="txtPagoCon" name="txtPagoCon" placeholder="S/ 0.00"  onkeyup="calcularVuelto()" onkeypress="return gKeyAceptaSoloDigitosPunto(event)"></td>
                                <td></td>
                                <td>Vuelto:</td>
                                <td><input style="text-align:right" type="text" class="form-control" id="txtVuelto" name="txtVuelto" placeholder="S/ 0.00" readonly></td>
                            </tr>
                        </table>
                    </td>
                </tr>                
                <input type="hidden" id="txtSubtotal" name="txtSubtotal" value="0.00">
                <input type="hidden" id="txtIgv" name="txtIgv"  value="0.00">                
                <input type="hidden" id="txtTotal" name="txtTotal" value="0.00">


                <input type="hidden" id="txtSubtotalBoleta" name="txtSubtotalBoleta"  value="0.00">
                <input type="hidden" id="txtIgvBoleta" name="txtIgvBoleta"  value="0.00">
                <input type="hidden" id="txtTotalBoleta" name="txtTotalBoleta"  value="0.00">';
            $html .= '</tbody></table>';
            return $html;
        }
    }

    function interfazAperturarCaja()
    {
        $html = '
            <form name="form" id="form" class="form-horizontal" onsubmit="return false" method="post">                
                
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" >Cajera:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtCodigo" name="txtCodigo" value="' . $_SESSION["sys_usuario"] . '"  readonly />
                        </div>
                    </div>       
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" >Fecha Apertura:</label>
                        <div class="col-sm-9">
                            <input type="text" style ="width:100%" class="form-control"   id="txtFechaApertura" name="txtFechaApertura" value="' . (date("Y-m-d h:m:s")) . '"  readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" >Montor Apertura:</label>
                        <div class="col-sm-9">
                            <input onkeypress="return gKeyAceptaSoloDigitosPunto(event)" type="text" style ="width:100%;text-align:right" class="form-control"   id="txtMontoApertura" name="txtMontoApertura"  placeholder="S/ 0.00"   />
                        </div>
                    </div>                                                                                                                                                                                                                                   
            </form>';

        $botones = '
                        <button type="button" class="btn btn-primary" id="btnAperturarCaja"><i class="icon-ok icon-white"></i><span id="spanSave01">Guardar</span></button>                   
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-remove"></i>Cerrar</button>                        
            </fieldset>
            </form>';
        return array($html, $botones);
    }

    function datagrid($criterio, $total_regs = 0, $pagina = 1, $nreg_x_pag = 100)
    {
        $Grid = new eGrid();
        $Grid->numeracion();

        $Grid->columna(array(
            "titulo" => "Serie",
            "campo" => "serie",
            "width" => "50"
        ));


        $Grid->columna(array(
            "titulo" => "Numeracióm",
            "campo" => "nrocomprobante",
            "width" => "100"
        ));
        $Grid->columna(array(
            "titulo" => "Cliente",
            "campo" => "nombres",
            "width" => "250"
        ));

        $Grid->columna(array(
            "titulo" => "Fecha de Venta",
            "campo" => "fechaventa",
            "width" => "50"
        ));

        $Grid->columna(array(
            "titulo" => "Subtotal",
            "campo" => "subtotal",
            "width" => "50",
            "align" => "right"
        ));

        $Grid->columna(array(
            "titulo" => "Igv",
            "campo" => "igv",
            "width" => "50",
            "align" => "right"
        ));

        $Grid->columna(array(
            "titulo" => "Total",
            "campo" => "total",
            "width" => "50",
            "align" => "right"
        ));

        $Grid->columna(array(
            "titulo" => "Estado",
            "campo" => "estadosunat",
            "width" => "20",
            "fnCallback" => function ($row) {
                if ($row["estadosunat"] == '1') {
                    $cadena = '<span class = "badge badge-success">Enviado</span>';
                } elseif ($row["estadosunat"] == '0') {
                    $cadena = '<span class = "badge badge-danger">Pendiente</span>';
                }
                return $cadena;
            }
        ));

        if ($_SESSION["sys_perfil"] == '1' || $_SESSION["sys_perfil"] == '2') {
            $Grid->accion(array(
                "icono" => "fa fa-times-circle",
                "titulo" => "Anular Registro",
                "xajax" => array(
                    "fn" => "xajax__anularComprobante",
                    "msn" => "¿Esta seguro desea anular el Comprobante?",
                    "parametros" => array(
                        "flag" => "2",
                        "campos" => array("id")
                    )
                )
            ));
        }

        $Grid->accion(array(
            "icono" => "fas fa-search",
            "titulo" => "Ver detalle",
            "xajax" => array(
                "fn" => "xajax__verdetalle",
                "parametros" => array(
                    "campos" => array("id")
                )
            )
        ));

        $Grid->accion(array(
            "icono" => "fa fa-print",
            "titulo" => "Reimprimir",
            "xajax" => array(
                "fn" => "xajax__reeimprimirComprobante",
                "parametros" => array(
                    "campos" => array("id")
                )
            )
        ));



        $Grid->data(array(
            "criterio" => $criterio,
            "total" => $Grid->totalRegistros,
            "pagina" => $pagina,
            "nRegPagina" => $nreg_x_pag,
            "class" => "venta",
            "method" => "buscar"
        ));
        $Grid->paginador(array(
            "xajax" => "xajax__ventaDatagrid",
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


    function listarVentas()
    {
        $clsabstract = new interfazAbstract();
        $clsabstract->legenda('fas fa-search', 'Ver detalle');
        $clsabstract->legenda('fa fa-times-circle', 'Anular');

        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Ventas";
        $html = ' 
    
    <div class="card">
        <div class="card-header">' . $titulo . '</div>
            <div class="card-body">        
            <iframe style="display:none" id="frame" width="100" height="100" frameborder="0"></iframe> 
                <form class="form-inline" onsubmit="return false;">
                    <input type="text" class="form-control" id="txtBuscar" placeholder="Buscar por descripcion" style="width:70%">                           
                    <button type="button" class="btn btn-secondary" id="btnBuscar"><i class="fas fa-search"></i>Buscar</button>                                           
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
          
    </div>
    
    ';

        return $html;
    }

    function detalleVenta($venta)
    {
        $claseventa = new venta();
        $datadetalle = $claseventa->consultar('1', $venta);
        $html = '<table id="tab_" class="data-tbl-simple table table-bordered" style="border-left:#ccc 1px solid;border-right:0px;width:100%;">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>';
        $c = 1;
        foreach ($datadetalle as $value) {
            $html .= '<tr>
                            <td>' . $c++ . '</td>
                            <td>' . $value["descripcion"] . '</td>
                            <td style="text-align:right">' . $value["cantidad"] . '</td>
                            <td style="text-align:right">' . $value["precio"] . '</td>
                            <td style="text-align:right">' . $value["totalitem"] . '</td>
                        </tr>';
        }
        $html .= '</bpody>
                </table>';

        $botones = '<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-remove"></i>Cerrar</button>';


        return array($html, $botones);
    }
}

function _interfazVentas()
{
    $rpta = new xajaxResponse();
    $cls = new interfazVentas();
    $clasecaja = new caja();

    $datacaja = $clasecaja->consultar('1', $_SESSION["sys_caja_asignada"]);

    if ($datacaja[0]["total"] == '0') {
        $rpta->assign("container", "innerHTML", '<div class="modal-dialog" role="document">
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
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
            </div>');
        $html = $cls->interfazAperturarCaja();
        $rpta->script("$('#modal .modal-header h5').text('Aperturar Caja');");
        $rpta->assign("contenido", "innerHTML", $html[0]);
        $rpta->assign("footer", "innerHTML", $html[1]);
        $rpta->script("$('#modal').modal('show')");
        $rpta->script("
        $('#btnAperturarCaja').unbind('click').click(function() {
            xajax__aperturarCaja('1',xajax.getFormValues('form'));
        });");
    } else {
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
                if(this.value=='01'){
                    $('#txtBuscarCliente').attr('maxlength','11');                                        
                }else if(this.value=='03' || this.value=='00'){
                    $('#txtBuscarCliente').attr('maxlength','8');                                        
                }
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
    }




    return $rpta;
}

function _BuscarDatosxDni($dni)
{
    $rpta = new xajaxResponse();
    $clasecliente = new cliente();
    $datacliente = $clasecliente->consultar('1', $dni);

    if (count($datacliente) == 0) {
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
    } else {
        $rpta->assign("txtNombre", "value", $datacliente[0]["nombres"]);
        $rpta->assign("txtDireccion", "value", $datacliente[0]["direccion"]);
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
    $rpta->assign("txtBuscar", "value", '');
    $rpta->script("sumaSubtotales()");
    $rpta->script("$('#txtBuscar').focus()");
    $rpta->assign("outQuery", "innerHTML", '');
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

    if ($form["lstTipoDocumento"] == '01') {
        if ($form["txtTotal"] == '0.00' || $form["txtTotal"] == '' || (!isset($form["txtTotal"]))) {
            $msj1 .= '- Debe agregar al menos un Producto.\\n';
        }
    } else {
        if ($form["txtTotalBoleta"] == '0.00' || $form["txtTotalBoleta"] == '' || (!isset($form["txtTotalBoleta"]))) {
            $msj1 .= '- Debe agregar al menos un Producto.\\n';
        }
    }


    if ($form["lstFormaPago"] != '3') {
        if ($form["txtPagoCon"] == '') {
            $msj1 .= '- Pago con.\\n';
        } else {
            if ($form["lstTipoDocumento"] == '01') {
                if ($form["txtPagoCon"] < $form["txtTotal"]) {
                    $msj1 .= '- El importe pagado no puede ser menor al total de venta.\\n';
                }
            } else {
                if ($form["txtPagoCon"] < $form["txtTotalBoleta"]) {
                    $msj1 .= '- El importe pagado no puede ser menor al total de venta.\\n';
                }
            }
        }
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
                        var url = 'php/modulos/gestioncomercial/comprobante.php?id=" . $result[0]["id"] . "&pagocon=" . $form["txtPagoCon"] . "&vuelto=" . $form["txtVuelto"] . "';
                        frame.attr('src',url);
                    }
                ");
                $rpta->script("loadPage()");
                $_SESSION["carrito"] = array();
                $rpta->assign("outQuery", "innerHTML", '');
                $rpta->assign("txtBuscar", "value", "");
                $rpta->assign("txtBuscarCliente", "value", "");
                $rpta->assign("txtNombre", "value", "");
                $rpta->assign("txtDireccion", "value", "");
                $rpta->assign("lstTipoDocumento", "value", "");
                $rpta->script("
                 $('#txtDireccion').attr('readonly','readonly');
                $('#txtNombre').attr('readonly','readonly');
                $('#txtBuscarCliente').attr('readonly','readonly');
                ");
                $rpta->assign("outQueryDetalle", "innerHTML", $interfazventa->listarBandeja());
            }
        } else {
            $rpta->alert('Ocurrio un error al guardar los datos, por favor comuníquese con el Administrador de Sistemas');
        }
    }

    return $rpta;
}

function _vaciarBandejaVenta($producto)
{
    $rpta = new xajaxResponse();
    $interfaz = new interfazVentas();

    $total = count($_SESSION["carrito"]["producto"]);
    $existe = false;
    $c = 0;

    while ($c < $total) {
        if ($_SESSION["carrito"]["producto"][$c] == $producto) {
            if ($_SESSION["carrito"]["cantidad"][$c] > 1) {
                $_SESSION["carrito"]["cantidad"][$c] = $_SESSION["carrito"]["cantidad"][$c] - 1;
            } elseif ($_SESSION["carrito"]["cantidad"][$c] = 1) {
                $_SESSION["carrito"]["cantidad"][$c] = '';
                $_SESSION["carrito"]["producto"][$c] = '';
                $_SESSION["carrito"]["precioventa"][$c] = '';
                $_SESSION["carrito"]["descripcion"][$c] = '';
            }
        }
        $c++;
    }


    $html = $interfaz->listarBandeja();
    $rpta->assign("outQueryDetalle", "innerHTML", $html);
    $rpta->script("sumaSubtotales()");
    return $rpta;
}

function _actualizarCantidad($producto, $cantidad, $subtotalitem)
{
    $rpta = new xajaxResponse();

    $total = count($_SESSION["carrito"]["producto"]);

    $c = 0;

    while ($c < $total) {
        if ($_SESSION["carrito"]["producto"][$c] == $producto) {
            $_SESSION["carrito"]["cantidad"][$c] = $cantidad;
        }
        $c++;
    }

    return $rpta;
}

function _aperturarCaja($flag, $form)
{
    $rpta = new xajaxResponse();
    $clase = new caja();
    $interfaz = new interfazVentas();

    $msj1 = '';
    $msj = 'LOS SIGUIENTES CAMPOS SON REQUERIDOS (*)';
    $msj .= '\\n-----------------------------------------------------------------------\\n';


    if ($form["txtMontoApertura"] == '') {
        $msj1 .= '- Monto de Apertura\\n';
    }

    if ($msj1 != '') {
        $rpta->script('alert("' . $msj . $msj1 . '")');
    } else {

        $result = $clase->mantenedor($flag, $form);
        if ($result[0]['mensaje'] == 'MSG_001') {
            $rpta->alert(MSG_001);
            $rpta->script("jQuery('#modal').modal('hide');");
            $rpta->script("xajax__interfazVentas()");
        } elseif ($result[0]['mensaje'] == 'MSG_007') {
            $rpta->alert(MSG_007);
        } else {
            $rpta->alert("Error al aperturar Caja, por favor comuníques con el Administrador del Sistema");
        }
    }
    return $rpta;
}

function _ventaDatagrid($criterio, $total_regs = 0, $pagina = 1, $nregs = 100)
{
    $rpta = new xajaxResponse();
    $cls = new interfazVentas();
    $html = $cls->datagrid($criterio, $total_regs, $pagina, $nregs);
    $rpta->assign("outQuery", "innerHTML", $html);
    return $rpta;
}

function _interfazListarVentas()
{
    $rpta = new xajaxResponse();
    $cls = new interfazVentas();
    $html = $cls->listarVentas();
    $rpta->assign("container", "innerHTML", $html);

    $rpta->script("
    $('#btnBuscar').unbind('click').click(function() {
    xajax__ventaDatagrid(document.getElementById('txtBuscar').value);
    });");
    $rpta->script("
    $('#txtBuscar').unbind('keypress').keypress(function() {
        validarEnter(event)
    });");
    return $rpta;
}

function _verdetalle($venta)
{
    $rpta = new xajaxResponse();
    $cls = new interfazVentas();
    $html = $cls->detalleVenta($venta);
    $rpta->script("$('#modal .modal-header h5').text('Registrar Producto');");
    $rpta->assign("contenido", "innerHTML", $html[0]);
    $rpta->assign("footer", "innerHTML", $html[1]);
    $rpta->script("$('#modal').modal('show')");

    return $rpta;
}

function _anularComprobante($flag, $idventa)
{
    $rpta = new xajaxResponse();
    $claseventa = new venta();
    $interfazventa = new interfazVentas();
    $form = array("hhddIdVenta" => $idventa);
    $result = $claseventa->mantenedor('2', $form);

    if ($result[0]["mensaje"] == 'MSG_006') {
        $rpta->alert(MSG_006);
        $html = $interfazventa->datagrid('');
        $rpta->assign("outQuery", "innerHTML", $html);
    }
    return $rpta;
}

function _reeimprimirComprobante($idventa)
{
    $rpta = new xajaxResponse();
    $claseventa = new venta();
    $interfazventa = new interfazVentas();
    $rpta->script("
                   
                        var frame = $('#frame');
                        var url = 'php/modulos/gestioncomercial/comprobante.php?id=" . $idventa . "';
                        frame.attr('src',url);
                    
                ");


    return $rpta;
}


$xajax->register(XAJAX_FUNCTION, '_interfazVentas');
$xajax->register(XAJAX_FUNCTION, '_BuscarDatosxDni');
$xajax->register(XAJAX_FUNCTION, '_llenarBandejaVenta');
$xajax->register(XAJAX_FUNCTION, '_procesarVenta');
$xajax->register(XAJAX_FUNCTION, '_vaciarBandejaVenta');
$xajax->register(XAJAX_FUNCTION, '_actualizarCantidad');
$xajax->register(XAJAX_FUNCTION, '_aperturarCaja');
$xajax->register(XAJAX_FUNCTION, '_ventaDatagrid');
$xajax->register(XAJAX_FUNCTION, '_interfazListarVentas');
$xajax->register(XAJAX_FUNCTION, '_verdetalle');
$xajax->register(XAJAX_FUNCTION, '_anularComprobante');
$xajax->register(XAJAX_FUNCTION, '_reeimprimirComprobante');
