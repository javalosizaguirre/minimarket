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
}
