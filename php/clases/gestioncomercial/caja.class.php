<?php
include_once RUTA_MYSQL . 'connection.class.php';
class caja extends connectdb
{

    function buscar($criterio, $buscar, $flagContar = 0, $paginaActual = 1, $regsPorPag = 20)
    {
        $data = array();
        $query = "CALL sp_cierrecajaBuscar('$criterio', '$buscar', '$flagContar', '$paginaActual', '$regsPorPag')";
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

    function consultar($flag, $criterio)
    {
        $data = array();
        $query = "CALL sp_cajaConsultar('$flag', '$criterio')";
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

    function mantenedor($flag, $form)
    {
        $data = array();
        $id = isset($form["txtIdApertura"]) ? $form["txtIdApertura"] : '';
        if ($flag == '1') {
            $caja = isset($_SESSION["sys_caja_asignada"]) ? $_SESSION["sys_caja_asignada"] : '';
        } else {
            $caja = isset($_SESSION["txtIdCaja"]) ? $_SESSION["txtIdCaja"] : '';
        }
        $fecha = isset($form["txtFechaApertura"]) ? $form["txtFechaApertura"] : '0000-00-00';
        $usuario = $_SESSION["sys_usuario"];
        $monto = isset($form["txtMontoApertura"]) ? $form["txtMontoApertura"] : '0.00';
        $fechacierre = isset($form["txtFechaApertura"]) ? $form["txtFechaApertura"] : '0000-00-00';
        $efectivo = isset($form["txtEfectivo"]) ? $form["txtEfectivo"] : '0.00';
        $tarjetas = isset($form["txtTarjeta"]) ? $form["txtTarjeta"] : '0.00';
        $total = isset($form["txtTotal"]) ? $form["txtTotal"] : '0.00';
        $query = "CALL sp_cajaMantenedor('$flag','$id','$caja', '$fecha', '$usuario', '$monto','$fechacierre','$efectivo','$tarjetas','$total')";
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

    function verDetallado($flag, $form)
    {
        $data = array();
        $usuario = $_SESSION["sys_usuario"];
        $fecha = ymd($form["txtFecha"]);
        $caja = $form["lstCaja"];

        $query = "CALL sp_cajaConsultarDetallado('$flag','$caja', '$fecha', $usuario)";
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
