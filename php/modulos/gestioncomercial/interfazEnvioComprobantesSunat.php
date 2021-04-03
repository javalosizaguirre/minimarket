<?php
include_once RUTA_CLASES . 'ventas.class.php';
include_once RUTA_CLASES . 'ventasdetalle.class.php';
include_once RUTA_CLASES . 'caja.class.php';
class interfazEnvioSunat
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clasetipocomprobante = new tipocomprobante();
        $clsabstract->legenda('fas fa-search', 'Ver detalle');
        $clsabstract->legenda('fas fa-arrow-circle-right', 'Enviar Comprobante');
        $datostipocomprobante = $clasetipocomprobante->consultar('3', '');
        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Ventas";
        $html = ' 
    
    <div class="card">
        <div class="card-header">' . $titulo . '</div>
            <div class="card-body">        
            
                <form class="form-inline" onsubmit="return false;" id="frmConsulta">
                    <table style="width:100%">
                        <tr>
                            <td style="width:20%">Comprobante</td>
                            <td  style="width:30%">
                                <select id="lstTipoComprobante" name="lstTipoComprobante" class="form-control" style="width:100%">
                                    <option value="">Seleccionar...</option>';
        foreach ($datostipocomprobante as $value) {
            $html .= '<option value="' . $value["tipocomprobante"] . '">' . $value["descripcion"] . '</option>';
        }
        $html .= '</select>
                            </td>
                            <td style="width:60%"></td>
                        </tr>
                        <tr>
                            <td>Fecha</td>
                            <td><input type="text" class="form-control datepicker" id="txtFecha" name="txtFecha" readonly style="width:100%"></td>                            
                            <td></td>
                        </tr>
                        <tr>
                           <td>Nro. Comprobante</td> 
                           <td><input type="text" class="form-control" id="txtBuscar" name="txtBuscar" placeholder="Nro. Comprobante" style="width:100%"></td>
                           <td></td>
                        </tr>
                        <tr>
                           <td>Estado</td> 
                           <td>
                                <select id="lstEstado" name="lstEstado" class="form-control">
                                    <option value="">Todos...</option>
                                    <option value="1">Enviados</option>
                                    <option value="0" selected>Pendientes</option>
                                </select>
                           </td>
                           <td></td>
                        </tr>                        
                        <tr>
                            <td colspan="3">
                                <button type="button" class="btn btn-secondary" id="btnBuscar"><i class="fas fa-search"></i>Buscar</button>
                                <button type="button" class="btn btn-secondary" id="btnSeleccionarTodo">Todos</button>
                                <button style="display:none" type="button" class="btn btn-secondary" id="btnDeseleccionarTodo">Borrar</button>
                                <button style="display:none" type="button" class="btn btn-secondary" id="btnEnviarSunat"><i class="fas fa-arrow-circle-right"></i>Enviar a Sunat</button>
                            </td>
                        </tr>    
                    </table>
                                               
                    
            </form>                
            </div>
            <form id="frmChk" name="frmChk" onsubmit="return false">
            <div class="card-body" id="outQuery">
                ' . $this->datagrid('') . '
            </div>
            </form>
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


        $Grid->accion(array(
            "titulo" => "Sel.",
            "width" => "20",
            "fnCallback" => function ($row) {
                if ($row["estadosunat"] == '0') {
                    $cadena = '<input type="checkbox" disabled id="checkbox_' . $row["rownum"] . '" name="checkbox_' . $row["rownum"] . '" value="' . $row["id"] . '">';
                }

                return $cadena;
            }
        ));


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
            "titulo" => "Enviar Comprobante",
            "width" => "20",
            "fnCallback" => function ($row) {
                if ($row["estadosunat"] == '0') {
                    $cadena = '<a href="javascript:void(0)" onclick="xajax__enviarComprobanteSunat(' . $row["id"] . ')">
                    <i class="fas fa-arrow-circle-right"></i>
                    </a>';
                } else {
                    $cadena = '';
                }

                return $cadena;
            }
        ));





        $Grid->data(array(
            "criterio" => $criterio,
            "total" => $Grid->totalRegistros,
            "pagina" => $pagina,
            "nRegPagina" => $nreg_x_pag,
            "class" => "venta",
            "method" => "enviosunatbuscar"
        ));
        $Grid->paginador(array(
            "xajax" => "xajax__ventaDatagrid",
            "criterio" => "xajax.getFormValues('frmConsulta')",
            "total" => $Grid->totalRegistros,
            "nRegPagina" => $nreg_x_pag,
            "pagina" => $pagina,
            "nItems" => "5",
            "lugar" => "in"
        ));
        $html = $Grid->render();
        return $html;
    }

    function numtoletras($xcifra)
    {
        $xarray = array(
            0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
        //
        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }

        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }

                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)) {  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                } else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {
                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                } else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = $this->subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO

            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena .= " DE";

            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena .= " DE";

            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena .= "UN BILLON ";
                        else
                            $xcadena .= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena .= "UN MILLON ";
                        else
                            $xcadena .= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO CON $xdecimales/100 SOLES";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UN CON $xdecimales/100 SOLES ";
                        }
                        if ($xcifra >= 2) {
                            $xcadena .= " CON $xdecimales/100 SOLES "; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }

    function subfijo($xx)
    { // esta función regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }
}

function _interfazEnvioSunat()
{
    $rpta = new xajaxResponse();
    $cls = new interfazEnvioSunat();

    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);

    $rpta->script("
    $('#btnBuscar').unbind('click').click(function() {
    xajax__enviosunatDatagrid(xajax.getFormValues('frmConsulta'));
    });");

    $rpta->script("
    $('#btnSeleccionarTodo').unbind('click').click(function() {  
        $('input:checkbox').prop('disabled', false); 
        $('input:checkbox').prop('checked', true);      
        $('#btnEnviarSunat').show();
        $('#btnDeseleccionarTodo').show();        
    });");

    $rpta->script("
    $('#btnDeseleccionarTodo').unbind('click').click(function() {  
        $('input:checkbox').prop('checked', false);      
        $('input:checkbox').prop('disabled', true); 
        $('#btnEnviarSunat').hide();
        $('#btnDeseleccionarTodo').hide();        
    });");


    $rpta->script("
    $('#btnEnviarSunat').unbind('click').click(function() {        
    xajax__enviosunatMasa(xajax.getFormValues('frmChk'));
    });");


    $rpta->script("$('.datepicker').datepicker({
        clearBtn: true,
        language: 'es'
    });");
    return $rpta;
}

function _enviosunatDatagrid($criterio, $total_regs = 0, $pagina = 1, $nregs = 100)
{
    $rpta = new xajaxResponse();
    $cls = new interfazEnvioSunat();
    $html = $cls->datagrid($criterio, $total_regs, $pagina, $nregs);
    $rpta->assign("outQuery", "innerHTML", $html);
    return $rpta;
}

function _enviarComprobanteSunat($idventa)
{
    $rpta = new xajaxResponse();
    $clsventa = new venta();
    $interfaz = new interfazEnvioSunat();
    $c = 0;
    $d = 1;

    $databoleta = $clsventa->consultar('2', $idventa);
    $datadetalle = $clsventa->consultar('3', $idventa);
    $data = array();
    $arraydetalle = array();


    if ($databoleta[0]["tipocomprobante"] == '03') {
        $ruta = "http://localhost/minimarket/tools/UBL21/ws/boleta.php";
        $codigotipodocumento = '03';

        $arrayempresa = array(
            "ruc" => "20605714413",
            "tipo_doc" => '6',
            "nom_comercial" => 'A.A.A. MINIMARKET E.I.R.L.',
            "razon_social" => 'A.A.A. MINIMARKET E.I.R.L.',
            "codigo_ubigeo" => '021809',
            "direccion" => 'AV. PACIFICO MZA. A-1 LOTE. 2 (FRENTE DEL MERCADO BUENOS AIRES) ANCASH - SANTA - NUEVO CHIMBOTE',
            "direccion_departamento" => 'ANCASH',
            "direccion_provincia" => 'SANTA',
            "direccion_distrito" => 'NUEVO CHIMBOTE',
            "direccion_codigopais" => '9589',
            "usuariosol" => 'MODDATOS',
            "clavesol" => 'MODDATOS'
        );

        while ($c < count($datadetalle)) {
            $arraydetalle[$c] = array(
                "txtITEM" => $d++,
                "txtUNIDAD_MEDIDA_DET" => "NIU",
                "txtCANTIDAD_DET" => $datadetalle[$c]["cantidad"],
                "txtPRECIO_DET" => $datadetalle[$c]["precio"],
                "txtSUB_TOTAL_DET" => $datadetalle[$c]["subtotalsinigv"],
                "txtPRECIO_TIPO_CODIGO" => "01",
                "txtIGV" => $datadetalle[$c]["igv"],
                "txtISC" => "0", //  POR DEFECTO NO MOVER
                "txtIMPORTE_DET" => $datadetalle[$c]["subtotalsinigv"],
                "txtCOD_TIPO_OPERACION" => "10", // 10 POR DEFECTO NO MOVER
                "txtCODIGO_DET" => $datadetalle[$c]["detalle"],
                "txtDESCRIPCION_DET" => $datadetalle[$c]["descripcion"],
                "txtPRECIO_SIN_IGV_DET" => $datadetalle[$c]["subtotalsinigv"]
            );
            $c++;
        }



        foreach ($databoleta as $item) {
            $data["tipo_proceso"] = "3";
            $data["pass_firma"] = "20605714413";
            $data["tipo_operacion"] = "0101";
            $data["total_gravadas"] = $item["subtotal"];
            $data["total_inafecta"] = 0;
            $data["total_exoneradas"] = 0;
            $data["total_gratuitas"] = 0;
            $data["total_exportacion"] = 0;
            $data["total_descuento"] = 0;
            $data["sub_total"] = $item["subtotal"];
            $data["porcentaje_igv"] = '18.00';
            $data["total_igv"] = $item["igv"];
            $data["total_isc"] = "0";
            $data["total_otr_imp"] = "0";
            $data["total"] = $item["total"];
            $data["total_letras"] = $interfaz->numtoletras($item["total"]);
            $data["nro_guia_remision"] = "";
            $data["cod_guia_remision"] = "";
            $data["nro_otr_comprobante"] = "";
            $data["serie_comprobante"] = $item["serie"];
            $data["numero_comprobante"] = $item["nrocomprobante"];
            $data["fecha_comprobante"] = substr($item["fechaventa"], 0, 10);
            $data["fecha_vto_comprobante"] = substr($item["fechaventa"], 0, 10);
            $data["cod_tipo_documento"] = $codigotipodocumento;
            $data["cod_moneda"] = 'PEN';

            $data["cliente_numerodocumento"] = $item["nrodocumento"];
            $data["cliente_nombre"] = $item["nombres"];
            $data["cliente_tipodocumento"] = $codigotipodocumento;
            $data["cliente_direccion"] = $item["direccion"];
            $data["cliente_pais"] = "PE";
            $data["cliente_ciudad"] = "CHIMBOTE";
            $data["cliente_codigoubigeo"] = "";
            $data["cliente_departamento"] = "";
            $data["cliente_provincia"] = "";
            $data["cliente_distrito"] = "";
            $data["emisor"] = $arrayempresa;
            $data["detalle"] = $arraydetalle;
        }

        //Invocamos el servicio
        $token = ''; //en caso quieras utilizar algún token generado desde tu sistema
        //codificamos la data
        $data_json = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Authorization: Token token="' . $token . '"',
                'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($respuesta, true);



        if ($response["respuesta"] == 'OK') {
            $clsventa->mantenimientocomprobantesunat('1', $idventa, $data["serie_comprobante"], $data["numero_comprobante"], $response['respuesta'], $response['hash_cpe'], $response['hash_cdr'], $response['cod_sunat'], $response['msj_sunat'], '1');
            $rpta->alert($response['msj_sunat']);
            $rpta->script("document.getElementById('btnBuscar').click()");
        } else {
            $cadena = "respuesta	: " . $response['respuesta'] . "\n";
            $cadena .= "hash_cpe	: " . $response['hash_cpe'] . "\n";
            $cadena .= "hash_cdr	: " . $response['hash_cdr'] . "\n";
            $cadena .= "msj_sunat	: " . $response['msj_sunat'];
            $clsventa->mantenimientocomprobantesunat('2', $idventa, $data["serie_comprobante"], $data["numero_comprobante"], $response['respuesta'], $response['hash_cpe'], $response['hash_cdr'], $response['cod_sunat'], str_replace("'", "", $response['msj_sunat']), '0');
            $rpta->alert($cadena);
        }



        $rpta->assign("idRespuesta", "innerHTML", $cadena);
    } elseif ($databoleta[0]["tipocomprobante"] == '01') {
        $ruta = "http://localhost/minimarket/tools/UBL21/ws/factura.php";
        $codigotipodocumento = '06';

        $arrayempresa = array(
            "ruc" => "20605714413",
            "tipo_doc" => '6',
            "nom_comercial" => 'A.A.A. MINIMARKET E.I.R.L.',
            "razon_social" => 'A.A.A. MINIMARKET E.I.R.L.',
            "codigo_ubigeo" => '021809',
            "direccion" => 'AV. PACIFICO MZA. A-1 LOTE. 2 (FRENTE DEL MERCADO BUENOS AIRES) ANCASH - SANTA - NUEVO CHIMBOTE',
            "direccion_departamento" => 'ANCASH',
            "direccion_provincia" => 'SANTA',
            "direccion_distrito" => 'NUEVO CHIMBOTE',
            "direccion_codigopais" => '9589',
            "usuariosol" => 'MODDATOS',
            "clavesol" => 'MODDATOS'
        );

        while ($c < count($datadetalle)) {
            $arraydetalle[$c] = array(
                "txtITEM" => $d++,
                "txtUNIDAD_MEDIDA_DET" => "NIU",
                "txtCANTIDAD_DET" => $datadetalle[$c]["cantidad"],
                "txtPRECIO_DET" => $datadetalle[$c]["precio"],
                "txtSUB_TOTAL_DET" => $datadetalle[$c]["subtotalsinigv"],
                "txtPRECIO_TIPO_CODIGO" => "01",
                "txtIGV" => $datadetalle[$c]["igv"],
                "txtISC" => "0", //  POR DEFECTO NO MOVER
                "txtIMPORTE_DET" => $datadetalle[$c]["subtotalsinigv"],
                "txtCOD_TIPO_OPERACION" => "10", // 10 POR DEFECTO NO MOVER
                "txtCODIGO_DET" => $datadetalle[$c]["detalle"],
                "txtDESCRIPCION_DET" => $datadetalle[$c]["descripcion"],
                "txtPRECIO_SIN_IGV_DET" => $datadetalle[$c]["subtotalsinigv"]
            );
            $c++;
        }



        foreach ($databoleta as $item) {
            $data["tipo_proceso"] = "3";
            $data["pass_firma"] = "20605714413";
            $data["tipo_operacion"] = "0101";
            $data["total_gravadas"] = $item["subtotal"];
            $data["total_inafecta"] = 0;
            $data["total_exoneradas"] = 0;
            $data["total_gratuitas"] = 0;
            $data["total_exportacion"] = 0;
            $data["total_descuento"] = 0;
            $data["sub_total"] = $item["subtotal"];
            $data["porcentaje_igv"] = '18.00';
            $data["total_igv"] = $item["igv"];
            $data["total_isc"] = "0";
            $data["total_otr_imp"] = "0";
            $data["total"] = $item["total"];
            $data["total_letras"] = $interfaz->numtoletras($item["total"]);
            $data["nro_guia_remision"] = "";
            $data["cod_guia_remision"] = "";
            $data["nro_otr_comprobante"] = "";
            $data["serie_comprobante"] = $item["serie"];
            $data["numero_comprobante"] = $item["nrocomprobante"];
            $data["fecha_comprobante"] = substr($item["fechaventa"], 0, 10);
            $data["fecha_vto_comprobante"] = substr($item["fechaventa"], 0, 10);
            $data["cod_tipo_documento"] = "01";
            $data["cod_moneda"] = 'PEN';

            $data["cliente_numerodocumento"] = $item["nrodocumento"];
            $data["cliente_nombre"] = $item["nombres"];
            $data["cliente_tipodocumento"] = "6";
            $data["cliente_direccion"] = $item["direccion"];
            $data["cliente_pais"] = "PE";
            $data["cliente_ciudad"] = "CHIMBOTE";
            $data["cliente_codigoubigeo"] = "";
            $data["cliente_departamento"] = "";
            $data["cliente_provincia"] = "";
            $data["cliente_distrito"] = "";
            $data["emisor"] = $arrayempresa;
            $data["detalle"] = $arraydetalle;
        }

        //Invocamos el servicio
        $token = ''; //en caso quieras utilizar algún token generado desde tu sistema
        //codificamos la data
        $data_json = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Authorization: Token token="' . $token . '"',
                'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($respuesta, true);


        if ($response["respuesta"] == 'OK') {
            $clsventa->mantenimientocomprobantesunat('1', $idventa, $data["serie_comprobante"], $data["numero_comprobante"], $response['respuesta'], $response['hash_cpe'], $response['hash_cdr'], $response['cod_sunat'], $response['msj_sunat'], '1');
            $rpta->alert($response['msj_sunat']);
            $rpta->script("document.getElementById('btnBuscar').click()");
        } else {
            $cadena = "respuesta	: " . $response['respuesta'] . "\n";
            $cadena .= "hash_cpe	: " . $response['hash_cpe'] . "\n";
            $cadena .= "hash_cdr	: " . $response['hash_cdr'] . "\n";
            $cadena .= "msj_sunat	: " . $response['msj_sunat'];
            $clsventa->mantenimientocomprobantesunat('2', $idventa, $data["serie_comprobante"], $data["numero_comprobante"], $response['respuesta'], $response['hash_cpe'], $response['hash_cdr'], $response['cod_sunat'], str_replace("'", "", $response['msj_sunat']), '0');
            $rpta->alert($cadena);
        }
    }
    return $rpta;
}

function _enviosunatMasa($form)
{
    $rpta = new xajaxResponse();

    $f = 1;




    $cabeceraaceptados = 'RESUMEN COMPROBANTES ACEPTADOS (*)';
    $cabeceraaceptados .= '\\n-----------------------------------------------------------------------\\n';
    $msjaceptados = '';

    $cabeceranoaceptados = '\\nRESUMEN COMPROBANTES NO ACEPTADOS (*)';
    $cabeceranoaceptados .= '\\n-----------------------------------------------------------------------\\n';
    $msjnoaceptados = '';

    while ($f <= 100) {
        if (isset($form["checkbox_" . $f])) {
            $idventa  = $form["checkbox_" . $f];
            $clsventa = new venta();
            $interfaz = new interfazEnvioSunat();
            $c = 0;
            $d = 1;


            $databoleta = $clsventa->consultar('2', $idventa);
            $datadetalle = $clsventa->consultar('3', $idventa);
            $data = array();
            $arraydetalle = array();


            if ($databoleta[0]["tipocomprobante"] == '03') {
                $ruta = "http://localhost/minimarket/tools/UBL21/ws/boleta.php";
                $codigotipodocumento = '03';

                $arrayempresa = array(
                    "ruc" => "20605714413",
                    "tipo_doc" => '6',
                    "nom_comercial" => 'A.A.A. MINIMARKET E.I.R.L.',
                    "razon_social" => 'A.A.A. MINIMARKET E.I.R.L.',
                    "codigo_ubigeo" => '021809',
                    "direccion" => 'AV. PACIFICO MZA. A-1 LOTE. 2 (FRENTE DEL MERCADO BUENOS AIRES) ANCASH - SANTA - NUEVO CHIMBOTE',
                    "direccion_departamento" => 'ANCASH',
                    "direccion_provincia" => 'SANTA',
                    "direccion_distrito" => 'NUEVO CHIMBOTE',
                    "direccion_codigopais" => '9589',
                    "usuariosol" => 'MODDATOS',
                    "clavesol" => 'MODDATOS'
                );

                while ($c < count($datadetalle)) {
                    $arraydetalle[$c] = array(
                        "txtITEM" => $d++,
                        "txtUNIDAD_MEDIDA_DET" => "NIU",
                        "txtCANTIDAD_DET" => $datadetalle[$c]["cantidad"],
                        "txtPRECIO_DET" => $datadetalle[$c]["precio"],
                        "txtSUB_TOTAL_DET" => $datadetalle[$c]["subtotalsinigv"],
                        "txtPRECIO_TIPO_CODIGO" => "01",
                        "txtIGV" => $datadetalle[$c]["igv"],
                        "txtISC" => "0", //  POR DEFECTO NO MOVER
                        "txtIMPORTE_DET" => $datadetalle[$c]["subtotalsinigv"],
                        "txtCOD_TIPO_OPERACION" => "10", // 10 POR DEFECTO NO MOVER
                        "txtCODIGO_DET" => $datadetalle[$c]["detalle"],
                        "txtDESCRIPCION_DET" => $datadetalle[$c]["descripcion"],
                        "txtPRECIO_SIN_IGV_DET" => $datadetalle[$c]["subtotalsinigv"]
                    );
                    $c++;
                }



                foreach ($databoleta as $item) {
                    $data["tipo_proceso"] = "3";
                    $data["pass_firma"] = "20605714413";
                    $data["tipo_operacion"] = "0101";
                    $data["total_gravadas"] = $item["subtotal"];
                    $data["total_inafecta"] = 0;
                    $data["total_exoneradas"] = 0;
                    $data["total_gratuitas"] = 0;
                    $data["total_exportacion"] = 0;
                    $data["total_descuento"] = 0;
                    $data["sub_total"] = $item["subtotal"];
                    $data["porcentaje_igv"] = '18.00';
                    $data["total_igv"] = $item["igv"];
                    $data["total_isc"] = "0";
                    $data["total_otr_imp"] = "0";
                    $data["total"] = $item["total"];
                    $data["total_letras"] = $interfaz->numtoletras($item["total"]);
                    $data["nro_guia_remision"] = "";
                    $data["cod_guia_remision"] = "";
                    $data["nro_otr_comprobante"] = "";
                    $data["serie_comprobante"] = $item["serie"];
                    $data["numero_comprobante"] = $item["nrocomprobante"];
                    $data["fecha_comprobante"] = substr($item["fechaventa"], 0, 10);
                    $data["fecha_vto_comprobante"] = substr($item["fechaventa"], 0, 10);
                    $data["cod_tipo_documento"] = $codigotipodocumento;
                    $data["cod_moneda"] = 'PEN';

                    $data["cliente_numerodocumento"] = $item["nrodocumento"];
                    $data["cliente_nombre"] = $item["nombres"];
                    $data["cliente_tipodocumento"] = $codigotipodocumento;
                    $data["cliente_direccion"] = $item["direccion"];
                    $data["cliente_pais"] = "PE";
                    $data["cliente_ciudad"] = "CHIMBOTE";
                    $data["cliente_codigoubigeo"] = "";
                    $data["cliente_departamento"] = "";
                    $data["cliente_provincia"] = "";
                    $data["cliente_distrito"] = "";
                    $data["emisor"] = $arrayempresa;
                    $data["detalle"] = $arraydetalle;
                }

                //Invocamos el servicio
                $token = ''; //en caso quieras utilizar algún token generado desde tu sistema
                //codificamos la data
                $data_json = json_encode($data);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $ruta);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Authorization: Token token="' . $token . '"',
                        'Content-Type: application/json',
                    )
                );
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $respuesta = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($respuesta, true);



                if ($response["respuesta"] == 'OK') {
                    $clsventa->mantenimientocomprobantesunat('1', $idventa, $data["serie_comprobante"], $data["numero_comprobante"], $response['respuesta'], $response['hash_cpe'], $response['hash_cdr'], $response['cod_sunat'], $response['msj_sunat'], '1');
                    $msjaceptados .= $response['msj_sunat'] . '\\n';
                } else {
                    $clsventa->mantenimientocomprobantesunat('2', $idventa, $data["serie_comprobante"], $data["numero_comprobante"], $response['respuesta'], $response['hash_cpe'], $response['hash_cdr'], $response['cod_sunat'], str_replace("'", "", $response['msj_sunat']), '0');
                    $msjnoaceptados .= $response['msj_sunat'] . '\\n';
                }
            } elseif ($databoleta[0]["tipocomprobante"] == '01') {
                $ruta = "http://localhost/minimarket/tools/UBL21/ws/factura.php";
                $codigotipodocumento = '06';

                $arrayempresa = array(
                    "ruc" => "20605714413",
                    "tipo_doc" => '6',
                    "nom_comercial" => 'A.A.A. MINIMARKET E.I.R.L.',
                    "razon_social" => 'A.A.A. MINIMARKET E.I.R.L.',
                    "codigo_ubigeo" => '021809',
                    "direccion" => 'AV. PACIFICO MZA. A-1 LOTE. 2 (FRENTE DEL MERCADO BUENOS AIRES) ANCASH - SANTA - NUEVO CHIMBOTE',
                    "direccion_departamento" => 'ANCASH',
                    "direccion_provincia" => 'SANTA',
                    "direccion_distrito" => 'NUEVO CHIMBOTE',
                    "direccion_codigopais" => '9589',
                    "usuariosol" => 'MODDATOS',
                    "clavesol" => 'MODDATOS'
                );

                while ($c < count($datadetalle)) {
                    $arraydetalle[$c] = array(
                        "txtITEM" => $d++,
                        "txtUNIDAD_MEDIDA_DET" => "NIU",
                        "txtCANTIDAD_DET" => $datadetalle[$c]["cantidad"],
                        "txtPRECIO_DET" => $datadetalle[$c]["precio"],
                        "txtSUB_TOTAL_DET" => $datadetalle[$c]["subtotalsinigv"],
                        "txtPRECIO_TIPO_CODIGO" => "01",
                        "txtIGV" => $datadetalle[$c]["igv"],
                        "txtISC" => "0", //  POR DEFECTO NO MOVER
                        "txtIMPORTE_DET" => $datadetalle[$c]["subtotalsinigv"],
                        "txtCOD_TIPO_OPERACION" => "10", // 10 POR DEFECTO NO MOVER
                        "txtCODIGO_DET" => $datadetalle[$c]["detalle"],
                        "txtDESCRIPCION_DET" => $datadetalle[$c]["descripcion"],
                        "txtPRECIO_SIN_IGV_DET" => $datadetalle[$c]["subtotalsinigv"]
                    );
                    $c++;
                }



                foreach ($databoleta as $item) {
                    $data["tipo_proceso"] = "3";
                    $data["pass_firma"] = "20605714413";
                    $data["tipo_operacion"] = "0101";
                    $data["total_gravadas"] = $item["subtotal"];
                    $data["total_inafecta"] = 0;
                    $data["total_exoneradas"] = 0;
                    $data["total_gratuitas"] = 0;
                    $data["total_exportacion"] = 0;
                    $data["total_descuento"] = 0;
                    $data["sub_total"] = $item["subtotal"];
                    $data["porcentaje_igv"] = '18.00';
                    $data["total_igv"] = $item["igv"];
                    $data["total_isc"] = "0";
                    $data["total_otr_imp"] = "0";
                    $data["total"] = $item["total"];
                    $data["total_letras"] = $interfaz->numtoletras($item["total"]);
                    $data["nro_guia_remision"] = "";
                    $data["cod_guia_remision"] = "";
                    $data["nro_otr_comprobante"] = "";
                    $data["serie_comprobante"] = $item["serie"];
                    $data["numero_comprobante"] = $item["nrocomprobante"];
                    $data["fecha_comprobante"] = substr($item["fechaventa"], 0, 10);
                    $data["fecha_vto_comprobante"] = substr($item["fechaventa"], 0, 10);
                    $data["cod_tipo_documento"] = "01";
                    $data["cod_moneda"] = 'PEN';

                    $data["cliente_numerodocumento"] = $item["nrodocumento"];
                    $data["cliente_nombre"] = $item["nombres"];
                    $data["cliente_tipodocumento"] = "6";
                    $data["cliente_direccion"] = $item["direccion"];
                    $data["cliente_pais"] = "PE";
                    $data["cliente_ciudad"] = "CHIMBOTE";
                    $data["cliente_codigoubigeo"] = "";
                    $data["cliente_departamento"] = "";
                    $data["cliente_provincia"] = "";
                    $data["cliente_distrito"] = "";
                    $data["emisor"] = $arrayempresa;
                    $data["detalle"] = $arraydetalle;
                }

                //Invocamos el servicio
                $token = ''; //en caso quieras utilizar algún token generado desde tu sistema
                //codificamos la data
                $data_json = json_encode($data);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $ruta);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Authorization: Token token="' . $token . '"',
                        'Content-Type: application/json',
                    )
                );
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $respuesta = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($respuesta, true);


                if ($response["respuesta"] == 'OK') {
                    $clsventa->mantenimientocomprobantesunat('1', $idventa, $data["serie_comprobante"], $data["numero_comprobante"], $response['respuesta'], $response['hash_cpe'], $response['hash_cdr'], $response['cod_sunat'], $response['msj_sunat'], '1');
                    $msjaceptados .= $response['msj_sunat'] . '\\n';
                } else {
                    $clsventa->mantenimientocomprobantesunat('2', $idventa, $data["serie_comprobante"], $data["numero_comprobante"], $response['respuesta'], $response['hash_cpe'], $response['hash_cdr'], $response['cod_sunat'], str_replace("'", "", $response['msj_sunat']), '0');
                    $msjnoaceptados .= $response['msj_sunat'] . '\\n';
                }
            }
        }
        $f++;
    }

    if ($msjaceptados == '') {
        $cabeceraaceptados = '';
    }

    if ($msjnoaceptados == '') {
        $cabeceranoaceptados = '';
    }
    $rpta->script('alert("' . $cabeceraaceptados . $msjaceptados . $cabeceranoaceptados . $msjnoaceptados . '")');



    $rpta->script('$("#btnBuscar").click()');
    return $rpta;
}

$xajax->register(XAJAX_FUNCTION, '_interfazEnvioSunat');
$xajax->register(XAJAX_FUNCTION, '_enviosunatDatagrid');
$xajax->register(XAJAX_FUNCTION, '_enviarComprobanteSunat');
$xajax->register(XAJAX_FUNCTION, '_enviosunatMasa');
