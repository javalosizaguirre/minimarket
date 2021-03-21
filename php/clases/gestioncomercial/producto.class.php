<?php
include_once RUTA_MYSQL . 'connection.class.php';
class producto extends connectdb
{
    function buscar($criterio, $buscar, $flagContar = 0, $paginaActual = 1, $regsPorPag = 20)
    {
        $data = array();
        $query = "CALL sp_productoBuscar('$criterio', '$buscar', '$flagContar', '$paginaActual', '$regsPorPag')";
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
        $producto = isset($form["txtCodigo"]) ? $form["txtCodigo"] : '';
        $descripcion = isset($form["txtDescripcion"]) ? $form["txtDescripcion"] : '';
        $categoria = isset($form["lstCategoria"]) ? $form["lstCategoria"] : '';
        $marca = isset($form["lstMarca"]) ? $form["lstMarca"] : '';
        $modelo = isset($form["lstModelo"]) ? $form["lstModelo"] : '';
        $talla = isset($form["lstTalla"]) ? $form["lstTalla"] : '';
        $unidadmedida = isset($form["lstUnidadMedida"]) ? $form["lstUnidadMedida"] : '';
        $preciocompra = isset($form["txtPrecioCompra"]) ? $form["txtPrecioCompra"] : 0.00;
        $precioventa = isset($form["txtPrecioVenta"]) ? $form["txtPrecioVenta"] : 0.00;
        $stockactual = isset($form["txtStockActual"]) ? $form["txtStockActual"] : 0;
        $stockminimo = isset($form["txtStockMinimo"]) ? $form["txtStockMinimo"] : 0;
        $fechavencimiento = isset($form["txtFechaVencimiento"]) ? $form["txtFechaVencimiento"] : '0000-00-00';
        $activo = isset($form["chk_activo"]) ? $form["chk_activo"] : '0';
        $query = "CALL sp_productoMantenedor('$flag', '$producto','$descripcion','$categoria','$marca','$modelo','$talla','$unidadmedida','$stockactual','$stockminimo','$preciocompra','$precioventa','$fechavencimiento', '$activo', '$usuario')";
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
        $query = "CALL sp_productoConsultar('$flag', '$criterio')";
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
