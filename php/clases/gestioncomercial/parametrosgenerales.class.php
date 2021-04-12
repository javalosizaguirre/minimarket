<?php
include_once RUTA_MYSQL . 'connection.class.php';
class parametrosgenerales extends connectdb
{

    function mantenedor($key, $value)
    {
        $data = array();
        $query = "CALL sp_parametrosgeneralesMantenedor('$key', '$value')";
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

        $query = "CALL sp_parametrosgeneralesConsultar('$flag', '$criterio')";


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
