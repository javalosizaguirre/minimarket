<?php

# funciones comunes xajax 
# estas funciones estan disponibles en todo el proyecto.
#

# clase principal

class interfazCommons extends interfazAbstract {

    function consultarDepartamentos($pais, $idSelectDpto, $idSelectProv, $idSelectDistrito, $dptoDefault, $capaSalidaProvs, $capaSalidaDistrs, $incluirOnchange) {
        $c_ubigeo = new mae_ubigeo();
        $dataDptos = $c_ubigeo->consultarUbigeos('8', $pais);

        $onChange = '';
        if ($incluirOnchange == '1') {
            $onChange = 'ubigConsultarProvincias(\'' . $pais . '\',this.value,\'' . $idSelectProv . '\',\'' . $idSelectDistrito . '\',\'\',\'' . $capaSalidaProvs . '\',\'' . $capaSalidaDistrs . '\')';
        }
        $html = $this->htmlCombo($dataDptos, array('iddepartamento', 'descripcion'), array('id' => $idSelectDpto, 'name' => $idSelectDpto, 'onchange' => $onChange), $dptoDefault, false, true);
        return $html;
    }

    function consultarProvincias($pais, $dpto, $idSelectProv, $idSelectDistrito, $provDefault, $capaSalidaProvs, $capaSalidaDistrs, $incluirOnchange) {
        $c_ubigeo = new mae_ubigeo();
        $dataProvincias = $c_ubigeo->consultarUbigeos('4', $dpto);

        $onChange = '';
        if ($incluirOnchange == '1') {
            $onChange = 'ubigConsultarDistritos(\'' . $pais . '\',\'' . $dpto . '\' + this.value,\'' . $idSelectDistrito . '\',\'\',\'' . $capaSalidaDistrs . '\')';
        }

        $html = $this->htmlCombo($dataProvincias, array('idprovincia', 'descripcion'), array('id' => $idSelectProv, 'name' => $idSelectProv, 'onchange' => $onChange), $provDefault, false, true);
        return $html;
    }

    function consultarDistritos($pais, $provincia, $idSelectDistrito, $distritoDefault, $capaSalidaDistrs) {
        $c_ubigeo = new mae_ubigeo();
        $dataDistritos = $c_ubigeo->consultarUbigeos('5', $provincia);
        $html = $this->htmlCombo($dataDistritos, array('iddistrito', 'descripcion'), array('id' => $idSelectDistrito, 'name' => $idSelectDistrito), $distritoDefault, false, true);
        return $html;
    }
}

# ------------------------------  end class ------------------------------ #
#
# Funciones xajax
#

function _glbConsultarDepartamentos($arrayValues) {
    $rpta = new xajaxResponse('UTF-8');

    $arrayValues = unserialize(stripslashes($arrayValues));

    $c_icommons = new interfazCommons();
    $rpta->addAssign($arrayValues[5], 'innerHTML', $c_icommons->consultarDepartamentos($arrayValues[0], $arrayValues[1], $arrayValues[2], $arrayValues[3], $arrayValues[4], $arrayValues[6], $arrayValues[7], $arrayValues[8]));
    $rpta->addScript('gEliminarOptions(\'' . $arrayValues[2] . '\')');
    $rpta->addScript('gEliminarOptions(\'' . $arrayValues[3] . '\')');
    return $rpta;
}

function _glbConsultarProvincias($arrayValues) {
    $rpta = new xajaxResponse('UTF-8');

    $arrayValues = unserialize(stripslashes($arrayValues));
    $c_icommons = new interfazCommons();
               
    $rpta->addAssign($arrayValues[5], 'innerHTML', $c_icommons->consultarProvincias($arrayValues[0], $arrayValues[1], $arrayValues[2], $arrayValues[3], $arrayValues[4], $arrayValues[5], $arrayValues[6], $arrayValues[7]));
    $rpta->addScript('gEliminarOptions(\'' . $arrayValues[3] . '\')');
    return $rpta;
}

function _glbConsultarDistritos($arrayValues) {
    $rpta = new xajaxResponse('UTF-8');

    $arrayValues = unserialize(stripslashes($arrayValues));
    $c_icommons = new interfazCommons();
    $rpta->addAssign($arrayValues[4], 'innerHTML', $c_icommons->consultarDistritos($arrayValues[0], $arrayValues[1], $arrayValues[2], $arrayValues[3], $arrayValues[4]));
    return $rpta;
}

$xajax->registerFunction('_glbConsultarDepartamentos');
$xajax->registerFunction('_glbConsultarProvincias');
$xajax->registerFunction('_glbConsultarDistritos');
?>