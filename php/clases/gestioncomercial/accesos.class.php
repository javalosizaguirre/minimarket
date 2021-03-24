<?php

class accesos extends connectdb
{
    function consultar($flag, $criterio = '', $perfil = '')
    {
        $data = array();
        $query = "CALL sp_accesosConsulta('$flag', '$criterio', '$perfil')";
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

    function mantenedor($cadena, $total, $perfil)
    {
        $data = array();
        $usuario = $_SESSION["sys_usuario"];
        $query = "CALL sp_accesosMantenimiento('$cadena', '$total', '$perfil','$usuario')";
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
