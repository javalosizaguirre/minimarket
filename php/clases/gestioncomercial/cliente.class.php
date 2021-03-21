<?php
include_once RUTA_MYSQL . 'connection.class.php';
class cliente extends connectdb
{
    function buscar($criterio, $buscar, $flagContar = 0, $paginaActual = 1, $regsPorPag = 20)
    {
        $data = array();
        $query = "CALL sp_clienteBuscar('$criterio', '$buscar', '$flagContar', '$paginaActual', '$regsPorPag')";
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
        $nrodocumento = isset($form["txtNroDocumento"]) ? $form["txtNroDocumento"] : '';
        $tipodocumento = isset($form["lstTipoDocumento"]) ? $form["lstTipoDocumento"] : '';
        $nombre = isset($form["txtNombre"]) ? $form["txtNombre"] : '';
        $direccion = isset($form["txtDireccion"]) ? $form["txtDireccion"] : '';
        $telefono = isset($form["txtTelefono"]) ? $form["txtTelefono"] : '';
        $email = isset($form["txtEmail"]) ? $form["txtEmail"] : '';
        $activo = isset($form["chk_activo"]) ? $form["chk_activo"] : '0';
        $query = "CALL sp_clienteMantenedor('$flag', '$nrodocumento', '$tipodocumento','$nombre','$direccion','$telefono','$email', '$activo', '$usuario')";
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
        $query = "CALL sp_clienteConsultar('$flag', '$criterio')";
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
