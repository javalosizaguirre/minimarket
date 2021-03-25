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
        $fechacomprobante = isset($form["txtFecha"]) ? ymd($form["txtFecha"]) : '0000-00-00';
        $cliente = isset($form["txtBuscarCliente"]) ? $form["txtBuscarCliente"] : '';
        $nombrecliente = isset($form["txtNombre"]) ? $form["txtNombre"] : '';
        $direccion = isset($form["txtDireccion"]) ? $form["txtDireccion"] : '';
        $subtotal = isset($form["txtSubtotal"]) ? $form["txtSubtotal"] : '0.00';
        $igv = isset($form["txtIgv"]) ? $form["txtIgv"] : '0.00';
        $total = isset($form["txtTotal"]) ? $form["txtTotal"] : '0.00';
        $formapago  = isset($form["lstFormaPago"]) ? $form["lstFormaPago"] : '';
        $tarjeta = isset($form["lstTarjeta"]) ? $form["lstTarjeta"] : '';
        $caja = $_SESSION["sys_caja_asignada"];

        $query = "CALL sp_ventaMantenedor('$flag', '$tipocomprobante', '$fechacomprobante', '$cliente','$direccion','$nombrecliente','$formapago','$tarjeta','$subtotal','$igv','$total', '$usuario','$caja')";
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
}
