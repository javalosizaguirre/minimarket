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
            $caja = isset($form["txtIdCaja"]) ? $form["txtIdCaja"] : '';
        }
        $fecha = isset($form["txtFechaApertura"]) ? $form["txtFechaApertura"] : '0000-00-00';
        $usuario = $_SESSION["sys_usuario"];
        $monto = isset($form["txtMontoApertura"]) ? $form["txtMontoApertura"] : '0.00';
        $fechacierre = isset($form["txtFechaApertura"]) ? $form["txtFechaApertura"] : '0000-00-00';
        $efectivo = isset($form["txtEfectivo"]) ? $form["txtEfectivo"] : '0.00';
        $tarjetas = isset($form["txtTarjeta"]) ? $form["txtTarjeta"] : '0.00';
        $total = isset($form["txtTotal"]) ? $form["txtTotal"] : '0.00';
        $billete200  = isset($form["txt200"]) ? $form["txt200"] : '0.00';
        $billete100 = isset($form["txt100"]) ? $form["txt100"] : '0.00';
        $billete50 = isset($form["txt50"]) ? $form["txt50"] : '0.00';
        $billete20 = isset($form["txt20"]) ? $form["txt20"] : '0.00';
        $billete10 = isset($form["txt10"]) ? $form["txt10"] : '0.00';
        $moneda5 = isset($form["txt5"]) ? $form["txt5"] : '0.00';
        $moneda2 = isset($form["txt2"]) ? $form["txt2"] : '0.00';
        $moneda1 = isset($form["txt1"]) ? $form["txt1"] : '0.00';
        $moneda05 = isset($form["txt05"]) ? $form["txt05"] : '0.00';
        $moneda02 = isset($form["txt02"]) ? $form["txt02"] : '0.00';
        $moneda01 = isset($form["txt01"]) ? $form["txt01"] : '0.00';

        $query = "CALL sp_cajaMantenedor('$flag','$id','$caja', '$fecha', '$usuario', '$monto','$fechacierre','$efectivo','$tarjetas','$total','$billete200','$billete100','$billete50','$billete20','$billete10','$moneda5','$moneda2','$moneda1','$moneda05','$moneda02','$moneda01')";

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
