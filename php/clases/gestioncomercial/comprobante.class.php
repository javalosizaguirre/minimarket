<?php
include_once '.../../../connection.class.php';
class comprobante extends connectdb
{

    function consultar($flag, $criterio)
    {
        $data = array();
        $query = "CALL sp_comprobanteConsultar('$flag', '$criterio')";
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

    function consultarVenta($flag, $criterio)
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

    function mantenimientocomprobantesunatIndividual($flag, $venta, $serie, $numero, $respuesta, $hash_cpe, $hash_cdr, $codigo_sunat, $mensaje_sunat, $estado)
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
