<?php
include_once RUTA_MYSQL . 'connection.class.php';
class tipocomprobante extends connectdb
{
    function buscar($criterio, $buscar, $flagContar = 0, $paginaActual = 1, $regsPorPag = 20)
    {
        $data = array();
        $query = "CALL sp_tipocomprobanteBuscar('$criterio', '$buscar', '$flagContar', '$paginaActual', '$regsPorPag')";
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
        $tipocomprobante = isset($form["txtCodigo"]) ? $form["txtCodigo"] : '';
        $descripcion = isset($form["txtDescripcion"]) ? $form["txtDescripcion"] : '';
        $activo = isset($form["chk_activo"]) ? $form["chk_activo"] : '0';
        $query = "CALL sp_tipocomprobanteMantenedor('$flag', '$tipocomprobante', '$descripcion', '$activo', '$usuario')";
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
        $query = "CALL sp_tipocomprobanteConsultar('$flag', '$criterio')";
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
