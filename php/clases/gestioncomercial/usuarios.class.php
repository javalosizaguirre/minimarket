<?php
include_once RUTA_MYSQL . 'connection.class.php';
class usuarios extends connectdb
{
    function buscar($criterio, $buscar, $flagContar = 0, $paginaActual = 1, $regsPorPag = 20)
    {
        $data = array();
        $query = "CALL sp_usuariosBuscar('$criterio', '$buscar', '$flagContar', '$paginaActual', '$regsPorPag')";
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
        $dni = isset($form["txtDni"]) ? $form["txtDni"] : '';
        $nombres = isset($form["txtNombres"]) ? $form["txtNombres"] : '';
        $apellidos = isset($form["txtApellidos"]) ? $form["txtApellidos"] : '';
        $email = isset($form["txtEmail"]) ? $form["txtEmail"] : '';
        $telefono = isset($form["txtNroTelefono"]) ? $form["txtNroTelefono"] : '';
        $direccion = isset($form["txtDireccion"]) ? $form["txtDireccion"] : '';
        $perfil = isset($form["lstPerfil"]) ? $form["lstPerfil"] : '';
        $activo = isset($form["chk_activo"]) ? $form["chk_activo"] : '0';
        $fechanacimiento = '0000-00-00';
        $nombreimg = '';
        $rutaimg = '';
        if ($flag == '1') {
            $contrasenia = $form["txtContrasenia"] == '' ? md5($form["txtDni"]) : md5($form["txtContrasenia"]);
        } elseif ($flag == '2') {
            $contrasenia = $form["txtContrasenia"] != '' ? md5($form["txtContrasenia"]) : '';
        }

        $query = "CALL sp_usuariosMantenedor('$flag','$dni','$perfil', '$nombres','$apellidos','$fechanacimiento','$email','$telefono','$direccion','$nombreimg','$rutaimg','$contrasenia','$activo', '$usuario')";
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
        $query = "CALL sp_usuariosConsultar('$flag', '$criterio')";
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
