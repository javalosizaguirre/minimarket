<?php
include_once RUTA_MYSQL . 'connection.class.php';
class ingresoproductos extends connectdb
{
    function buscar($criterio, $buscar, $flagContar = 0, $paginaActual = 1, $regsPorPag = 20)
    {
        $data = array();
        $query = "CALL sp_ingresoproductosBuscar('$criterio', '$buscar', '$flagContar', '$paginaActual', '$regsPorPag')";

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
        $producto = $form["lstProducto"];
        $cantidad = $form["txtCantidad"];
        $costo = $form["txtCosto"];
        $precio = $form["txtPrecio"];
        $query = "CALL sp_ingresoproductosMantenedor('$flag', '$producto', '$cantidad', '$costo','$precio','$usuario')";
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

    function consultar($producto)
    {
        $data = array();
        $usuario = $_SESSION["sys_usuario"];
        $query = "CALL sp_kardexfisico('$producto')";
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
