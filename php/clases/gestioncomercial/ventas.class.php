<?php
include_once RUTA_MYSQL . 'connection.class.php';
class venta extends connectdb
{
    function buscar($criterio, $buscar, $flagContar = 0, $paginaActual = 1, $regsPorPag = 20)
    {
        $data = array();
        $query = "CALL sp_ventaBuscar('$criterio', '$buscar', '$flagContar', '$paginaActual', '$regsPorPag')";
        // echo "buscar--->   ".$query;
        $result = parent::query($query);

        if (!isset($result['error'])) {
            foreach ($result as $row) {
                if ($flagContar == 1) {
                    $data['total'] = $row['total'];
                } else {
                    $data[] = $row;
                }
            }
        } else {
            $this->setMsgErr($result['error']);
        }
        return $data;
    }

    function mantenedor($flag, $form)
    {
        $data = array();
        $usuario = $_SESSION["sys_usuario"];

        $tipocomprobante = isset($form["lstTipoDocumento"]) ? $form["lstTipoDocumento"] : '';
        $hora = substr(date('h:i:s A'), 0, 8);
        $fechacomprobante = isset($form["txtFecha"]) ? (ymd($form["txtFecha"]) . ' ' . $hora) : '0000-00-00 00:00:00';
        $cliente = isset($form["txtBuscarCliente"]) ? $form["txtBuscarCliente"] : '';
        $nombrecliente = isset($form["txtNombre"]) ? $form["txtNombre"] : '';
        $direccion = isset($form["txtDireccion"]) ? $form["txtDireccion"] : '';
        if ($form["lstTipoDocumento"] == '01') {
            $subtotal = isset($form["txtSubtotal"]) ? $form["txtSubtotal"] : '0.00';
            $igv = isset($form["txtIgv"]) ? $form["txtIgv"] : '0.00';
            $total = isset($form["txtTotal"]) ? $form["txtTotal"] : '0.00';
        } else {
            $subtotal = isset($form["txtSubtotalBoleta"]) ? $form["txtSubtotalBoleta"] : '0.00';
            $igv = isset($form["txtIgvBoleta"]) ? $form["txtIgvBoleta"] : '0.00';
            $total = isset($form["txtTotalBoleta"]) ? $form["txtTotalBoleta"] : '0.00';
        }


        $formapago  = isset($form["lstFormaPago"]) ? $form["lstFormaPago"] : '';
        $tarjeta = isset($form["lstTarjeta"]) ? $form["lstTarjeta"] : '';
        $caja = $_SESSION["sys_caja_asignada"];
        $pagocon = isset($form["txtPagoCon"]) ? $form["txtPagoCon"] : '';
        $vuelto = isset($form["txtVuelto"]) ? $form["txtVuelto"] : '';
        isset($form["lstTarjeta"]) ? $form["lstTarjeta"] : '';
        $id = isset($form["hhddIdVenta"]) ? $form["hhddIdVenta"] : '';

        $query = "CALL sp_ventaMantenedor('$flag', '$tipocomprobante', '$fechacomprobante', '$cliente','$direccion','$nombrecliente','$formapago','$tarjeta','$subtotal','$igv','$total', '$usuario','$caja', '$id', '$pagocon', '$vuelto')";

        $result = parent::query($query);
        if (!isset($result['error'])) {
            foreach ($result as $row) {
                $data[] = $row;
            }
        } else {
            $this->setMsgErr($result['error']);
        }
        return $data;
    }

    function consultar($flag, $criterio)
    {
        $data = array();
        $query = "CALL sp_ventaConsultar('$flag', '$criterio')";
        $result = parent::query($query);
        if (!isset($result['error'])) {
            foreach ($result as $row) {
                $data[] = $row;
            }
        } else {
            $this->setMsgErr($result['error']);
        }
        return $data;
    }


    function enviosunatbuscar($criterio, $buscar, $flagContar = 0, $paginaActual = 1, $regsPorPag = 20)
    {
        $data = array();
        $tipocomprobante = $criterio["lstTipoComprobante"];
        $fecha = ymd($criterio["txtFecha"]);
        $nrocomprobante = $criterio["txtBuscar"];
        $query = "CALL sp_ventaEnvioSunatBuscar('$criterio', '$buscar', '$flagContar', '$paginaActual', '$regsPorPag','$tipocomprobante','$fecha','$nrocomprobante')";
        // echo "buscar--->   ".$query;
        $result = parent::query($query);

        if (!isset($result['error'])) {
            foreach ($result as $row) {
                if ($flagContar == 1) {
                    $data['total'] = $row['total'];
                } else {
                    $data[] = $row;
                }
            }
        } else {
            $this->setMsgErr($result['error']);
        }
        return $data;
    }

    function mantenimientocomprobantesunat($flag, $venta, $serie, $numero, $respuesta, $hash_cpe, $hash_cdr, $codigo_sunat, $mensaje_sunat, $estado)
    {
        $data = array();
        $usuario = $_SESSION["sys_usuario"];


        $query = "CALL sp_comprobantesunat('" . $flag . "','" . $venta . "','" . $serie . "','" . $numero . "','" . $respuesta . "','" . $hash_cpe . "','" . $hash_cdr . "','" . $codigo_sunat . "','" . $mensaje_sunat . "','" . $estado . "', '" . $usuario . "')";
        $result = parent::query($query);
        if (!isset($result['error'])) {
            foreach ($result as $row) {
                $data[] = $row;
            }
        } else {
            $this->setMsgErr($result['error']);
        }
        return $data;
    }
}
