<?php




class interfazAbstract
{
    function seguimiento($array)
    {
        $numerodesplieque = count($array);
            #$_SESSION['url']['dominio']=$_GET['dom'];
            #$_SESSION['url']['modulo']=$_GET['mod'];
        $desplueque = '<ul class="breadcrumb">
                                    <li>
                                        <i class="icon-home"></i>
                                        <a href="index.php?dom=' . $_SESSION['url']['dominio'] . '&mod=' . $_SESSION['url']['modulo'] . '">Principal</a><span class="divider">/</span>
                                </li>';
        $i = 0;
        foreach ($array as $key => $valor) {
            ++$i;
            if ($i < $numerodesplieque) {
                $desplueque .= '<li>
                                    <a href="javascript:void(0);"' . ($valor[1] != '' ? 'onclick="xajax__crearruta(\'' . $valor[0] . '\',\'' . $valor[1] . '\',' . ($key + 1) . ');' . str_replace("*", "'", $valor[1]) . '"' : '') . '>' . $valor[0] . '</a><span class="divider">/</span>
                                </li>';
            } else {
                $desplueque .= '<li class="active">
                                    ' . $valor[0] . '<span class="divider">/</span>
                                </li>';
            }
        }
        $desplueque .= '</ul>';
        return $desplueque;
    }

//    private $msg = '';
//    public function setMessage($_msg) {
//        $this->msg = $_msg;
//    }
//
//    public function getMessage() {
//        return $this->msg;
//    }

    /*
     * function : htmlCombo()
     *
     * Permite dibujar un combo con las propiedades establecidas. En el primer
     * parametro deberan enviarse dos columnas, la primer columna es para el
     * VALUE del OPTION y la segunda columna es para el texto que se mostrara.
     *
     * Parametros:
     *              $data             : Array con los datos. Se cogeran los dos primeros.
     *              $dataNomCols      : Array con el nombre de las columnas en el array anterior.
     *                                  Por defecto se entiende que son "id" y "descripcion", si es
     *                                  asi debe pasar null de lo contrario especifique los nombres
     *                                  de la siguiente manera:
     *
     *                                  $dataNomCols = array('codigo', 'nombre');
     *
     *              $selectPropiedades  : Propiedades del objeto SELECT.
     *              $valorDefecto     : Id Value que se seleccionara por defecto.
     *              $incluirItemTodos : true/false, si es true se agrega
     *                                  un item al inicio de la lista con la
     *                                  palabra TODOS y con el valor _all_
     *              $incluirItemVacio : true/false, si es true se agrega
     *                                  un item vacio al inicio de la lista con
     *                                  el valor vacio
     *
     * Ejemplo:
     *
     *              $selectPropiedades = array ('name'=>'lstPaises',
     *                                          'id'=>'lstPaises',
     *                                          'class'=>'classTabla',
     *                                          'disabled'=>'disabled',
     *                                          'onchange'=>'listarCapitales()');
     *
     *              $c_html->htmlCombo($dataPaises, null, $selectPropiedades, '01', false, true);
     *
     */

    function htmlComboMultiple($data, $dataNombreCols, $selectPropiedades, $valorDefecto = array(), $incluirItemTodos = false, $incluirItemVacio = false, $itemVacioText = '')
    {
        $html = '<select multiple ';
        foreach ($selectPropiedades as $itemPropiedad => $value) {
            if ($value != '') {
                $html .= $itemPropiedad . '="' . $value . '" ';
            }
        }
        $html .= '>';

        if (count($data) > 0) {

            $id = "id";

            if (is_array($data[0])) {
                foreach ($data as $item) {
                    $key = '';
                    if ($dataNombreCols != null) {
                        if (is_array($dataNombreCols[0])) {
                            $datakey = $dataNombreCols[0];
                            for ($i = 0; $i < count($datakey); $i++) {
                                if ($i > 0) {
                                    $key .= '--';
                                }
                                $key .= trim($item[$datakey[$i]]);
                            }
                        } else {
                            $id = trim($dataNombreCols[0]);
                            $key = trim($item[$id]);
                        }
                    } else {
                        $key = trim($item['id']);
                    }

                    $desc = '';
                    if ($dataNombreCols != null) {
                        if (is_array($dataNombreCols[1])) {
                            $datakey = $dataNombreCols[1];
                            for ($i = 0; $i < count($datakey); $i++) {
                                if ($i > 0 && strlen(trim($item[$datakey[$i]])) > 0) {
                                    $desc .= ' - ';
                                }
                                $desc .= trim($item[$datakey[$i]]);
                            }
                        } else {
                            $ds = $dataNombreCols[1];
                            $desc = trim($item[$ds]);
                        }
                    } else {
                        $desc = trim($item['descripcion']);
                    }


                    $selected = "";
                    $existes = array_search($key, $valorDefecto);
                    foreach ($valorDefecto as $vd) {
                        if ($key == $vd) {
                            $selected = '  selected="selected"';
                        }
                    }

                    $html .= '<option title="' . $desc . '" value="' . $key . '"' . $selected . '>' . $desc . '</option>';
                }
            } else {
                for ($i = 0; $i < count($data); $i++) {
                    $selected = "";
                    if ($data[$i] == $valorDefecto) {
                        $selected = ' selected="selected" ';
                    }

                    $html .= '<option value="' . $data[$i] . '"' . $selected . '>' . $data[$i] . '</option>';
                }
            }

            $html .= '</select>';
        } else
            $html .= '<option value=""> - Sin coincidencias - </option></select>';

        //echo $html; exit();
        return $html;
    }

    function htmlCombo($data, $dataNombreCols, $selectPropiedades, $valorDefecto = "", $incluirItemTodos = false, $incluirItemVacio = false, $itemVacioText = '')
    {
        $html = '<select ';
        foreach ($selectPropiedades as $itemPropiedad => $value) {
            if ($value != '') {
                $html .= $itemPropiedad . '="' . $value . '" ';
            }
        }
        $html .= '>';

        if (count($data) > 0) {
            if ($incluirItemVacio)
                $html .= '<option value="_none_">' . $itemVacioText . '</option>';

            if ($incluirItemTodos)
                $html .= '<option value="_all_">Todo(s)</option>';


            $id = "id";

            if (is_array($data[0])) {
                foreach ($data as $item) {
                    $key = '';
                    if ($dataNombreCols != null) {
                        if (is_array($dataNombreCols[0])) {
                            $datakey = $dataNombreCols[0];
                            for ($i = 0; $i < count($datakey); $i++) {
                                if ($i > 0) {
                                    $key .= '--';
                                }
                                $key .= trim($item[$datakey[$i]]);
                            }
                        } else {
                            $id = trim($dataNombreCols[0]);
                            $key = trim($item[$id]);
                        }
                    } else {
                        $key = trim($item['id']);
                    }

                    $desc = '';
                    if ($dataNombreCols != null) {
                        if (is_array($dataNombreCols[1])) {
                            $datakey = $dataNombreCols[1];
                            for ($i = 0; $i < count($datakey); $i++) {
                                if ($i > 0 && strlen(trim($item[$datakey[$i]])) > 0) {
                                    $desc .= ' - ';
                                }
                                $desc .= trim($item[$datakey[$i]]);
                            }
                        } else {
                            $ds = $dataNombreCols[1];
                            $desc = trim($item[$ds]);
                        }
                    } else {
                        $desc = trim($item['descripcion']);
                    }


                    $selected = "";
                    if ($key == $valorDefecto) {
                        $selected = '  selected="selected"';
                    }

                    $html .= '<option title="' . $desc . '" value="' . $key . '"' . $selected . '>' . $desc . '</option>';
                }
            } else {
                for ($i = 0; $i < count($data); $i++) {
                    $selected = "";
                    if ($data[$i] == $valorDefecto) {
                        $selected = ' selected="selected" ';
                    }

                    $html .= '<option value="' . $data[$i] . '"' . $selected . '>' . $data[$i] . '</option>';
                }
            }

            $html .= '</select>';
        } else
            $html .= '<option value=""> - Sin coincidencias - </option></select>';

        //echo $html; exit();
        return $html;
    }

    /*
     * function : htmlComboGrupo()
     *
     * Permite dibujar un combo con las propiedades establecidas. En el primer
     * parametro debera enviarse un array con al menos tres columnas, una se empleará para VALUE del OPTION,
     * otra columna es para el TEXTO que se mostrará en el OPTION.
     * Y otra tercera para el grupo.
     *
     * Parametros:
     *              $data             : Array con los datos. Se requiere al menos tres columnas
     *              $dataNomCols      : Array con el nombre de las columnas en el array anterior.
     *                                  Por defecto se entiende que son "id" y "descripcion", si es
     *                                  asi debe pasar null de lo contrario especifique los nombre de columnas
     *                                  de la siguiente manera:
     *
     *                                  $dataNomCols = array('codigo', 'nombre');
     *                                  $dataNomCols = array(array('persona', 'codigo'), 'nombre');
     *                                  $dataNomCols = array(array('persona', 'codigo'), array('apellidos','nombres'));
     *
     *              $columnaGrupo     : Nombre de la columna de $data que se utilizará como grupo.
     *
     *              $selectPropiedades: Propiedades del objeto SELECT.
     *              $valorDefecto     : Id Value que se seleccionara por defecto.
     *              $incluirItemTodos : true/false, si es true se agrega
     *                                  un item al inicio de la lista con la
     *                                  palabra TODOS y con el valor _all_
     *              $incluirItemVacio : true/false, si es true se agrega
     *                                  un item vacio al inicio de la lista con
     *                                  el valor vacio
     *
     * Ejemplo:
     *
     *              $selectPropiedades = array ('name'=>'lstPaises',
     *                                          'id'=>'lstPaises',
     *                                          'class'=>'classTabla',
     *                                          'disabled'=>'disabled',
     *                                          'onchange'=>'listarCapitales()');
     *
     *              $c_html->htmlComboGrupo($dataPaises, null, 'categoria' $selectPropiedades, '01', false, true);
     *
     */

    function htmlComboGrupo($data, $dataNombreCols, $columnaGrupo, $selectPropiedades, $valorDefecto = "", $incluirItemTodos = false, $incluirItemVacio = false)
    {
        $html = '<select ';
        foreach ($selectPropiedades as $itemPropiedad => $value) {
            if ($value != '') {
                $html .= $itemPropiedad . '="' . $value . '" ';
            }
        }
        $html .= '>';

        if (count($data) > 0) {
            if ($incluirItemVacio)
                $html .= '<option value="_none_"></option>';
            if ($incluirItemTodos)
                $html .= '<option value="_all_">Todo(s)</option>';

            $id = "id";

            $grupoAntes = '';
            if (is_array($data[0])) {

                foreach ($data as $item) {
                    $key = '';
                    if ($dataNombreCols != null) {
                        if (is_array($dataNombreCols[0])) {
                            $datakey = $dataNombreCols[0];
                            for ($i = 0; $i < count($datakey); $i++) {
                                if ($i > 0) {
                                    $key .= '--';
                                }
                                $key .= $item[$datakey[$i]];
                            }
                        } else {
                            $id = $dataNombreCols[0];
                            $key = $item[$id];
                        }
                    } else {
                        $key = $item['id'];
                    }


                    $desc = '';
                    if ($dataNombreCols != null) {
                        if (is_array($dataNombreCols[1])) {
                            $datakey = $dataNombreCols[1];
                            for ($i = 0; $i < count($datakey); $i++) {
                                if ($i > 0 && strlen(trim($item[$datakey[$i]])) > 0) {
                                    $desc .= ' - ';
                                }
                                $desc .= $item[$datakey[$i]];
                            }
                        } else {
                            $ds = $dataNombreCols[1];
                            $desc = $item[$ds];
                        }
                    } else {
                        $desc = $item['descripcion'];
                    }

                    /* <grupo> */
                    if (count($data) >= 3) {
                        if ($grupoAntes != $item[$columnaGrupo]) {
                            if ($grupoAntes != '') {
                                $html .= '</optgroup>';
                            }

                            $grupoAntes = $item[$columnaGrupo];

                            $html .= '<optgroup label="' . $grupoAntes . '">';
                        }
                    }

                    /* </ grupo> */


                    $selected = "";
                    if ($key == $valorDefecto) {
                        $selected = ' selected';
                    }

                    $html .= '<option title="' . $desc . '" value="' . $key . '"' . $selected . '>' . $desc . '</option>';
                }
            } else {
                for ($i = 0; $i < count($data); $i++) {
                    $selected = "";
                    if ($data[$i] == $valorDefecto) {
                        $selected = ' selected';
                    }

                    $html .= '<option value="' . $data[$i] . '"' . $selected . '>' . $data[$i] . '</option>';
                }
            }

            $html .= '</select>';
        } else
            $html .= '<option value="">(sin coincidencias)</option></select>';
        return $html;
    }

    /*
     * function : htmlDiasSemana()
     * Dibuja una lista con los dias de la semana.
     *
     * Parametros:
     *
     *            $nomObjeto    : Id/Nombre del objeto
     *            $incluirVacio : True, incluir un item vacio
     * Retorno:
     *            Codigo html con la lista de los dias.
     */

    function htmlDiasSemana($nomObjeto = 'lstDiaSemana', $incluirVacio = true)
    {
        $html .= '
         <select name="' . $nomObjeto . '" id="' . $nomObjeto . '" style="width:50px;">';
        if ($incluirVacio) {
            $html .= '<option value="">&nbsp;</option>';
        }
        $html .= '  <option value="1">Lunes</option>
                    <option value="2">Martes</option>
                    <option value="3">Mi&eacute;rcoles</option>
                    <option value="4">Jueves</option>
                    <option value="5">Viernes</option>
                    <option value="6">S&aacute;bado</option>
                    <option value="7">Domingo</option>
                ';

        $html .= '</select>';

        return $html;
    }

    /*
     * function : htmlDias()
     * Dibuja una lista con los dias del mes.
     *
     * Parametros:
     *
     *            $nomObjeto    : Id/Nombre del objeto
     *            $incluirVacio : True, incluir un item vacio
     *            $selDia       : El dia que se selecciona
     * Retorno:
     *            Codigo html con la lista de los dias.
     */

    function htmlDias($nomObjeto = 'lstDia', $incluirVacio = true, $selDia = 'CURRENT')
    {
        $html = '
         <select name="' . $nomObjeto . '" id="' . $nomObjeto . '" style="width:50px;">';
        if ($incluirVacio) {
            $html .= '<option value="">&nbsp;</option>';
        }

        $diaActual = '';
        if ($selDia == 'CURRENT') {
            $diaActual = date('d');
        } else if ($selDia != '') {
            $diaActual = $selDia;
        }

        for ($i = 1; $i <= 31; $i++) {
            $selected = '';
            if ($i == $diaActual) {
                $selected = ' selected';
            }

            $html .= '<option value="' . str_pad($i, 2, '0', STR_PAD_LEFT) . '" ' . $selected . '>' . str_pad($i, 2, '0', STR_PAD_LEFT) . '</option>';
        }

        $html .= '   </select>';

        return $html;
    }

    /*
     * function : htmlMeses()
     * Dibuja una lista con los meses de anio.
     *
     * Parametros:
     *
     *            $nomObjeto    : Id/Nombre del objeto
     *            $incluirVacio : True, incluir un item vacio
     *            $selMes       : El mes que se seleccionara.
     * Retorno:
     *            Codigo html con la lista de meses.
     */

    function htmlMeses($nomObjeto = 'lstMeses', $incluirVacio = true, $selMes = 'CURRENT')
    {
        $html = '
            <select name="' . $nomObjeto . '" id="' . $nomObjeto . '" style="width:70px;">';
        if ($incluirVacio) {
            $html .= '<option value="">&nbsp;</option>';
        }

        $arrMeses = array(
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
            'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'
        );

        $mesActual = '';
        if ($selMes == 'CURRENT') {
            $mesActual = str_pad((int)date('m'), 2, '0', STR_PAD_LEFT);
        } elseif ($selMes != '') {
            $mesActual = str_pad($selMes, 2, '0', STR_PAD_LEFT);
        }

        for ($i = 0; $i < count($arrMeses); $i++) {
            $selected = '';
            if ($mesActual == str_pad($i + 1, 2, '0', STR_PAD_LEFT)) {
                $selected = ' selected';
            }

            $html .= '<option value="' . str_pad($i + 1, 2, '0', STR_PAD_LEFT) . '" ' . $selected . '>' .
                $arrMeses[$i] . '</option>';
        }

        $html .= '</select>';

        return $html;
    }

    /*
     * function : htmlAnios()
     * Dibuja una lista con anios.
     *
     * Parametros:
     *
     *            $nomObjeto    : Id/Nombre del objeto.
     *            $desdeAnio    : Anio desde donde se empezar a listar.
     *            $hastaAnio    : Anio final hasta donde se listara.
     *            $incluirVacio : True, incluir un item vacio .
     *            $selAnio      : El anio que se seleccionara.
     * Retorno:
     *            Codigo html con la lista de anios.
     */

    function htmlAnios($nomObjeto = 'lstAnio', $desdeAnio = null, $hastaAnio = null, $incluirVacio = true, $selAnio = 'CURRENT')
    {
        if ($desdeAnio == null)
            $desdeAnio = 1920;
        if ($hastaAnio == null)
            $hastaAnio = (int)date('Y');

        $anioActual = '';
        if ($selAnio == 'CURRENT') {
            $anioActual = (int)date('Y');
        } else if ($selAnio != '') {
            $anioActual = $selAnio;
        }

        $html = '
            <select name="' . $nomObjeto . '" id="' . $nomObjeto . '" style="width:60px;">';
        if ($incluirVacio) {
            $html .= '<option value="">&nbsp;</option>';
        }

        for ($i = $hastaAnio; $i >= $desdeAnio; $i--) {
            $selected = '';
            if ($i == $anioActual) {
                $selected = ' selected';
            }

            $html .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
        }

        $html .= '  </select>';

        return $html;
    }

    /**
     * function htmlReporteCabecera()
     *
     *
     * @param type $botonImprimir  : true=mostrar un boton imprimir, false=no
     * @param type $orientacion    : 1=vertical, 2=horizontal
     *
     * @return string              : codigo HTML
     */
    function htmlReporteCabecera($botonImprimir = true, $urlExportPDF = '', $urlExportXLS = '', $orientacion = '1')
    {
        $claseOrientacion = 'rpthead_horz';
        if ($orientacion == '1') {
            $claseOrientacion = 'rpthead';
        }

        $_html = '<div>';
        $_html .= '<table border="0" cellpadding="0" cellspacing="0" class="' . $claseOrientacion . '" align="center">';
        $_html .= '  <tr>';
        $_html .= '    <td valign="top"><img src="' . GL_DIR_WS_HTTP_APP . 'img/logoinscripcion.jpg"/></td>';
        $_html .= '    <td width="238"  align="right">Erp University<br>';
        $commons = new commons();
        $fechasistema = $commons->fechaSistema('');
        $_html .= dmy($fechasistema) . '<br/>';
        //$_html .= date('d-m-Y H:i:s'). '<br/>';
        $_html .= ' USER: ' . $_SESSION['sys_usuario'] . '</br>';

        if ($botonImprimir == true) {
            $_html .= ' <a href="javascript:window.print()">
                <img src="' . GL_DIR_WS_HTTP_APP . 'img/16x16/imprimir.gif" width="16" height="16" border="0"></a>';
        }
        if (trim($urlExportPDF) != '') {
            $_html .= ' <a target="wexport" href="' . GL_DIR_WS_HTTP_APP . $urlExportPDF . '">
                <img src="' . GL_DIR_WS_HTTP_APP . 'img/16x16/pdf.gif" width="16" height="16" border="0" style="padding-left:3px"></a>';
        }
        if (trim($urlExportXLS) != '') {
            $_html .= ' <a target="wexport" href="' . GL_DIR_WS_HTTP_APP . $urlExportXLS . '">
                <img src="' . GL_DIR_WS_HTTP_APP . 'img/16x16/xls.gif" width="16" height="16" border="0" style="padding-left:3px"></a>';
        }

        $_html .= '  </td>';
        $_html .= '  </tr>';
         //$_html .= '<tr><td colspan="2"><hr/></td></tr>';
        $_html .= '</table>';



        $_html .= '</div>';
        $_html .= '<iframe width="0" height="0" src="" frameborder="0" name="wexport" style="margin:0px; padding:0px"></iframe>';



        return $_html;
    }

    function htmlReporteCabeceraEEFF($botonImprimir = true, $urlExportPDF = '', $urlExportXLS = '', $orientacion = '1')
    {
        $claseOrientacion = 'rpthead_horz';
        if ($orientacion == '1') {
            $claseOrientacion = 'rpthead';
        }

        $_html = '<div>';
        $_html .= '<table border="0" cellpadding="0" cellspacing="0" class="' . $claseOrientacion . '" align="center">';
        $_html .= '  <tr>';
        $_html .= '    <td valign="top"><img src="' . GL_DIR_WS_HTTP_APP . 'img/logo_institucion.png"/></td>';
        $_html .= '    <td width="223" valign="bottom" align="right"><br><br>';

        if ($botonImprimir == true) {
            $_html .= ' <a href="javascript:window.print()">
                <img src="' . GL_DIR_WS_HTTP_APP . 'img/16x16/imprimir.gif" width="16" height="16" border="0"></a>';
        }
        if (trim($urlExportPDF) != '') {
            $_html .= ' <a target="wexport" href="' . GL_DIR_WS_HTTP_APP . $urlExportPDF . '">
                <img src="' . GL_DIR_WS_HTTP_APP . 'img/16x16/pdf.gif" width="16" height="16" border="0" style="padding-left:3px"></a>';
        }
        if (trim($urlExportXLS) != '') {
            $_html .= ' <a target="wexport" href="' . GL_DIR_WS_HTTP_APP . $urlExportXLS . '">
                <img src="' . GL_DIR_WS_HTTP_APP . 'img/16x16/xls.gif" width="16" height="16" border="0" style="padding-left:3px"></a>';
        }

        $_html .= '  </td>';
        $_html .= '  </tr>';
        $_html .= '<tr><td colspan="2"><hr/></td></tr>';
        $_html .= '</table>';



        $_html .= '</div>';
        $_html .= '<iframe width="0" height="0" src="" frameborder="0" name="wexport" style="margin:0px; padding:0px"></iframe>';



        return $_html;
    }

    function htmlFecha()
    {
        $c_commonss = new commons();
        return $c_commonss->fechaSistema();
    }

    function htmlFechaHora()
    {
        $c_commonss = new commons();
        return $c_commonss->fechaHoraSistema();
    }
    function htmlIncrementaFecha($flag, $fechaAMD, $numeroIncremento)
    {
        $c_commonss = new commons();
        return $c_commonss->incrementaFecha($flag, $fechaAMD, $numeroIncremento);
    }

    function htmlObtenerValorConfig($codigo)
    {
        $c_commonss = new commons();
        return $c_commonss->consultarValorConfig($codigo);
    }

    /**
     * function htmlAutoCompletar()
     *
     *
     * @param type $funcXAJAX      : Nombre de la funcion xajax que se empleará para realizar la busqueda.
     *                               No incluya los parantesis solo debe especificar el nombre.
     *                               Se usara el primer parametro para enviar el criterio de busqueda.
     *                               Y el segundo es el id del objeto donde se colocara el valor del elemento seleccionado
     *
     *                               Ejemplo:
     *
     *                               function _buscarTrabajador($criterio, $objectResult=''){
     *                                   $rpta = new xajaxResponse('UTF-8');
     *
     *                                   $c_personal = new pers_personal();
     *                                   $data = $c_personal->buscarPersonal($criterio, 0);
     *
     *                                   # en R=debe enviarse el nombre de la clase CSS
     *                                   $rpta->addScript(searchResult($data, array('persona', 'nombres'), $objectResult), 20);
     *
     *                                   return $rpta;
     *                               }
     *                               $xajax->registerFunction('_buscarTrabajador');
     *
     * @param type $objectResult      : Id del objeto donde se almacenara el valor seleccioando.
     * @param type $dataValuesDefault : Array con dos elementos, el primero el valor seleccionado y el segundo es la descripcion que se mostrara en la caja de busqueda.
     *                                  Por defecto es NULL
     * @param type $width             : Array con una etiqueta html (style.width, clase) y el valor para el tamanio del buscador.
     * @param type $longMinCharSens   : Longitud minima requerida para invocar a la función de la busqueda (valido solo cuando $sensitivity=true)
     * @param type $sensitivity       : Habilita/deshabilita la busqueda automatica.
     *
     * @return string              : codigo HTML
     */
    function htmlAutoCompletar($funcXAJAX, $objectResult = 'txtSearchSelected', $dataValuesDefault = null, $class = 'input-xlarge', $longMinCharSens = 3, $sensitivity = false, $disabled = false)
    {

        $objectResult = (trim($objectResult) == '' ? 'txtSearchSelected' : $objectResult);

        $objSearch = $objectResult . 'Criterio';
        $objValue = $objectResult;
        $objectLayer = $objectResult . 'Layer';

        if ($class == null || $class == '') {
            $class = "input-xlarge";
        }

        $longMinChar1 = 2; #cuando pulsa Enter debe al menos haber escrito dos caracteres
        $longMinChar2 = ((int)$longMinCharSens == 0 ? 1 : $longMinCharSens); #valido para $sensitivity=true

        $func = ' onkeypress="if(gKeyEnter(event)) { if(this.value.length==0) {getElemento(\'' . $objectLayer . '\').style.display=\'none\';} else if(this.value.length>=' . $longMinChar1 . '){ ' . $funcXAJAX . '(this.value, \'' . $objectResult . '\') } }"';
        if ($sensitivity) {
            $func .= ' onkeyup="if(this.value.length==0) {getElemento(\'' . $objectLayer . '\').style.display=\'none\';} else if(this.value.length>=' . $longMinChar2 . ') {' . $funcXAJAX . '(this.value, \'' . $objectResult . '\') }"';
        }

        $funcXAJAX = (trim($funcXAJAX) != '' ? $func : '');

        $id = '';
        $descripcion = '';
        if (is_array($dataValuesDefault) && count($dataValuesDefault) == 2) {
            $id = $dataValuesDefault[0];
            $descripcion = $dataValuesDefault[1];
        }


        $sdisabled = ($disabled ? ' disabled ' : '');

        $html = '
                <label>
                    <input type="hidden" name="' . $objValue . '" id="' . $objValue . '" value="' . $id . '"/>
                    <input ' . $sdisabled . ' type="text" name="' . $objSearch . '" id="' . $objSearch . '" class="' . $class . '" maxlength="30"' . $funcXAJAX . ' onfocus="this.select();" onclick="getElemento(\'' . $objectLayer . '\').style.display=\'none\';" onblur="if(this.value.length==0) getElemento(\'' . $objValue . '\').value=\'\'" value="' . $descripcion . '" placeholder="escriba el criterio y pulse [enter]..."/>
                </label>
                <div id="' . $objectLayer . '" class="autoCompleteErp ' . $class . '" onblur="this.style.display=\'none\'"></div>';

        return $html;
    }


    function htmlAutoCompletar2($data)
    {

        $objectResult = (isset($data['id']) ? $data['id'] : 'txtSearchSelected');
        $dataValuesDefault = (isset($data['default']) ? $data['default'] : null);
        $class = (isset($data['classSearch']) ? $data['classSearch'] : 'input-xlarge');
        $classResult = (isset($data['classResult']) ? $data['classResult'] : $class);
        $styleResult = (isset($data['styleResult']) ? $data['styleResult'] : '');
        $control = (isset($data['controlFilter']) ? $data['controlFilter'] : '');
        $sensitivity = (isset($data['sensitivity']) ? $data['sensitivity'] : false);
        $sensitivityMaxLength = (isset($data['sensitivityMaxLength']) ? (int)$data['sensitivityMaxLength'] : 3);
        $funcXAJAX = (isset($data['fn']) ? $data['fn'] : '');
        $func2 = (isset($data['fn2']) ? $data['fn2'] . ';' : '');
        $disabled = (isset($data['disabled']) ? $data['disabled'] : false);
        $arrShowID = (isset($data['showID']) ? $data['showID'] : null);

        $objSearch = $objectResult . 'Criterio';
        $objValue = $objectResult;
        $objectLayer = $objectResult . 'Layer';

        $control2 = '';
        if ($control != '') {
            $control2 = ',getElemento(\'' . $control . '\').value';
        }

        $htmlMostrarId = '';
        if (is_array($arrShowID)) {
            if (!isset($arrShowID['class']) || $arrShowID['class'] == '') {
                $arrShowID['class'] = 'span3';
            }
            if (!isset($arrShowID['posValue'])) {
                $arrShowID['posValue'] = 0;
            }

            $htmlMostrarId = '<input type="hidden" name="' . $objValue . 'Id__" id="' . $objValue . 'Id__" value="' . $arrShowID['posValue'] . '"/><input type="text" readonly class="readonly ' . $arrShowID['class'] . '" name="' . $objValue . 'Id" id="' . $objValue . 'Id"/>';
        }


        $longMinChar1 = 2; #cuando pulsa Enter debe al menos haber escrito dos caracteres
        $longMinChar2 = ((int)$sensitivityMaxLength == 0 ? 1 : $sensitivityMaxLength); #valido para $sensitivity=true

        $func = ' onkeypress="if(this.value.length<=1) {' . $func2 . 'getElemento(\'' . $objectResult . '\').value=\'\';' . ($htmlMostrarId != '' ? 'getElemento(\'' . $objectResult . 'Id\').value=\'\';' : '') . '} if(gKeyEnter(event)) { if(this.value.length==0) {getElemento(\'' . $objectLayer . '\').style.display=\'none\';} else if(this.value.length>=' . $longMinChar1 . '){ ' . $funcXAJAX . '(this.value, \'' . $objectResult . '\'' . $control2 . ');} }"';
        if ($sensitivity) {
            $func .= ' onkeyup="if(this.value.length==0) {getElemento(\'' . $objectLayer . '\').style.display=\'none\';} else if(this.value.length>=' . $longMinChar2 . ') {' . $funcXAJAX . '(this.value, \'' . $objectResult . '\');' . $func2 . ' }"';
        }

        $funcXAJAX = (trim($funcXAJAX) != '' ? $func : '');

        $id = '';
        $descripcion = '';
        if (is_array($dataValuesDefault) && count($dataValuesDefault) == 2) {
            $id = $dataValuesDefault[0];
            $descripcion = $dataValuesDefault[1];
        }


        $sdisabled = ($disabled ? ' disabled ' : '');
        $html = '<input type="hidden" name="' . $objValue . '" id="' . $objValue . '" value="' . $id . '"/>' .
            '<input ' . $sdisabled . ' type="text" name="' . $objSearch . '" id="' . $objSearch . '" class="' . $class . '" maxlength="30"' . $funcXAJAX . ' onfocus="this.select(); " onclick="getElemento(\'' . $objectLayer . '\').style.display=\'none\';" onblur="if(this.value.length==0) getElemento(\'' . $objValue . '\').value=\'\';" value="' . $descripcion . '" placeholder="escriba el criterio y pulse [enter]..."/>&nbsp;' . $htmlMostrarId .
            '<div id="' . $objectLayer . '" style="margin:0;' . $styleResult . '" class="autoCompleteErp ' . $classResult . '" onblur="this.style.display=\'none\'"></div>';

        return $html;
    }

    /**
     * function htmlBuscador()
     *
     *
     * @param type $funcXAJAX      : Nombre de la funcion xajax que se empleará para realizar la busqueda.
     *                               No incluya los parantesis solo debe especificar el nombre.
     *                               Se usara el primer parametro para enviar el criterio de busqueda.
     *                               Y el segundo es el id del objeto donde se colocara el valor del elemento seleccionado
     *
     *                               Ejemplo:
     *
     *                               function _buscarTrabajador($criterio, $objectResult=''){
     *                                   $rpta = new xajaxResponse('UTF-8');
     *
     *                                   $c_personal = new pers_personal();
     *                                   $data = $c_personal->buscarPersonal($criterio, 0);
     *
     *                                   $rpta->addScript(searchResult($data, array('persona', 'nombres'), $objectResult), 250);

     *                                   return $rpta;
     *                               }
     *                               $xajax->registerFunction('_buscarTrabajador');
     *
     * @param type $objectResult      : Id del objeto donde se almacenara el valor seleccioando.
     * @param type $dataValuesDefault : Array con dos elementos, el primero el valor seleccionado y el segundo es la descripcion que se mostrara en la caja de busqueda.
     *                                  Por defecto es NULL
     * @param type $width             : Valor numérico para el tamanio del buscador.
     * @param type $longMinChar       : Longitud minima requerida para invocar a la función de la busqueda.
     * @param type $sensitivity       : Habilita/deshabilita la busqueda automatica.
     *
     * @return string              : codigo HTML
     */
    function htmlBuscador($funcXAJAX, $objectResult = 'txtSearchSelected', $dataValuesDefault = null, $width = 200, $longMinChar = 3, $sensitivity = false, $disabled = false)
    {

        $objectResult = (trim($objectResult) == '' ? 'txtSearchSelected' : $objectResult);

        $objSearch = $objectResult . 'Criterio';
        $objValue = $objectResult;
        $objectLayer = $objectResult . 'Layer';

        $width = ((int)$width == 0 ? 200 : (int)$width);

        $swidth = ' width:' . $width . 'px;';
        $longMinChar = ((int)$longMinChar == 0 ? 1 : $longMinChar);

        $styleLayerOut = ' style="width:' . ($width + 2) . 'px"';
        $style = ' style="' . $swidth . '"';

        $func = '';
        if ($sensitivity) {
            $func = ' onkeyup="if(this.value.length==0) {getElemento(\'' . $objectLayer . '\').style.display=\'none\';} else if(this.value.length>=' . $longMinChar . ') {' . $funcXAJAX . '(this.value, \'' . $objectResult . '\') }"';
        } else {
            $func = ' onkeypress="if(gKeyEnter(event)) { if(this.value.length==0) {getElemento(\'' . $objectLayer . '\').style.display=\'none\';} else if(this.value.length>=' . $longMinChar . '){ ' . $funcXAJAX . '(this.value, \'' . $objectResult . '\') } }"';
        }

        $funcXAJAX = (trim($funcXAJAX) != '' ? $func : '');

        $id = '';
        $descripcion = '';
        if (is_array($dataValuesDefault) && count($dataValuesDefault) == 2) {
            $id = $dataValuesDefault[0];
            $descripcion = $dataValuesDefault[1];
        }


        $sdisabled = ($disabled ? ' disabled ' : '');

        $html = '
                <div>
                    <input type="hidden" name="' . $objValue . '" id="' . $objValue . '" value="' . $id . '"/>
                    <input ' . $sdisabled . ' type="text" name="' . $objSearch . '" id="' . $objSearch . '"' . $style . ' maxlength="30"' . $funcXAJAX . ' onfocus="this.select();" onclick="getElemento(\'' . $objectLayer . '\').style.display=\'none\';" onblur="if(this.value.length==0) getElemento(\'' . $objValue . '\').value=\'\'" value="' . $descripcion . '" />
                </div>
                <div id="' . $objectLayer . '" class="autoCompleteErp" ' . $styleLayerOut . ' onblur="this.style.display=\'none\'"></div>';

        return $html;
    }

    function htmlBuscadorTree($funcXAJAX, $objectResult = 'txtSearchSelected', $dataValuesDefault = null, $width = 200, $longMinChar = 3, $sensitivity = false, $disabled = false)
    {

        $objectResult = (trim($objectResult) == '' ? 'txtSearchSelected' : $objectResult);

        $objSearch = $objectResult . 'Criterio';
        $objValue = $objectResult;
        $objectLayer = $objectResult . 'Layer';

        $width = ((int)$width == 0 ? 200 : (int)$width);

        $swidth = ' width:' . $width . 'px;';
        $longMinChar = ((int)$longMinChar == 0 ? 1 : $longMinChar);

        $styleLayerOut = ' style="width:' . ($width + 2) . 'px"';
        $style = ' style="' . $swidth . '"';

        $func = '';
        if ($sensitivity) {
            $func = ' onkeyup="if(this.value.length==0) {getElemento(\'' . $objectLayer . '\').style.display=\'none\';} else if(this.value.length>=' . $longMinChar . ') {' . $funcXAJAX . '(this.value, \'' . $objectResult . '\') }"';
        } else {
            $func = ' onkeypress="if(gKeyEnter(event)) { if(this.value.length==0) {getElemento(\'' . $objectLayer . '\').style.display=\'none\';} else if(this.value.length>=' . $longMinChar . '){ ' . $funcXAJAX . '(this.value, \'' . $objectResult . '\') } }"';
        }

        $funcXAJAX = (trim($funcXAJAX) != '' ? $func : '');

        $id = '';
        $descripcion = '';
        if (is_array($dataValuesDefault) && count($dataValuesDefault) == 2) {
            $id = $dataValuesDefault[0];
            $descripcion = $dataValuesDefault[1];
        }


        $sdisabled = ($disabled ? ' disabled ' : '');

        $html = '
                <div>
                    <input type="hidden" name="' . $objValue . '" id="' . $objValue . '" value="' . $id . '"/>
                    <input ' . $sdisabled . ' type="text" name="' . $objSearch . '" id="' . $objSearch . '"' . $style . ' maxlength="30"' . $funcXAJAX . ' onfocus="this.select();" onclick="getElemento(\'' . $objectLayer . '\').style.display=\'none\';" onblur="if(this.value.length==0) getElemento(\'' . $objValue . '\').value=\'\'" value="' . $descripcion . '" />
                </div>
                <div id="' . $objectLayer . '" class="autoCompleteErp" ' . $styleLayerOut . ' onblur="this.style.display=\'none\'"></div>';

        return $html;
    }

   /* function htmlPaginador($nombreFuncionCambiaPagina, $dataParametrosFuncionCambiaPagina, $totalRegs, $regsPorPag = 10, $paginaActual = 1, $paginasMostrar = 5) {
        $html = '';
//        echo $nombreFuncionCambiaPagina."-".$dataParametrosFuncionCambiaPagina."-".$totalRegs."-". $regsPorPag."-".$paginaActual."-".$paginasMostrar;
        $paginasMostrar = ($paginasMostrar == 0 ? 5 : $paginasMostrar);
        $regsPorPag = ($regsPorPag == 0 ? 10 : $regsPorPag);

        if ($totalRegs > 0) {
            $params = '';

            if (trim($nombreFuncionCambiaPagina) != '') {
                if (is_array($dataParametrosFuncionCambiaPagina)) {
                    # armando parametros que se enviaran en la funcion
                    for ($i = 0; $i < count($dataParametrosFuncionCambiaPagina); $i++) {
                        if ($i > 0) {
                            $params .= ',';
                        }
                        if (gettype($dataParametrosFuncionCambiaPagina[$i]) == 'string') {
                            $params .= "'" . $dataParametrosFuncionCambiaPagina[$i] . "'";
                        } else {
                            $params .= $dataParametrosFuncionCambiaPagina[$i];
                        }
                    }
                } elseif (trim($dataParametrosFuncionCambiaPagina) != '') {
                    $params = "'" . $dataParametrosFuncionCambiaPagina . "'";
                }
            }


            $html = '

                    <div class="rxpag" style="width:160px;">
                        <div class="pull-left pagination" style="padding-top:5px;padding-left:5px;">
                            <ul><li><a>Reg. x Pag:</a></li></ul></div>
                        <div class="pull-left" style="padding-top:5px;padding-left:5px;">';
            $onclick = $nombreFuncionCambiaPagina . '(' . $params . ',' . $totalRegs . ',1,this.value);';

            $html .= '         <select name="lstRegsByPage" id="lstRegsByPage" style="width:50px;" onchange="' . $onclick . '">
                                <option value="10" ' . ($regsPorPag == 10 ? 'selected' : '') . '>10</option>
                                <option value="20" ' . ($regsPorPag == 20 ? 'selected' : '') . '>20</option>
                                <option value="30" ' . ($regsPorPag == 30 ? 'selected' : '') . '>30</option>
                                <option value="50" ' . ($regsPorPag == 50 ? 'selected' : '') . '>50</option>
                                <option value="100" ' . ($regsPorPag == 100 ? 'selected' : '') . '>100</option>
                            </select>
                        </div>
                    </div>';


            $html .= '<div class="" style="padding-bottom:5px;padding-right:5px;padding-left:5px;
                border-width: 1px 1px 1px 0px;
border-style: solid solid solid none;
border-color: rgb(221, 221, 221) rgb(221, 221, 221) rgb(221, 221, 221) -moz-use-text-color;
border:1px solid #ccc;
border-image: none;
border-collapse: separate;
border-radius: 4px;
background: linear-gradient(to bottom, rgb(241, 241, 241) 0%, rgb(219, 219, 219) 100%) repeat scroll 0% 0% transparent;
">
                        <span class="pagination pull-left" style="padding-top:4px;margin-left:6px">
                            <ul>
                                <li>
                                    <a>Total de registros: '.$totalRegs.'</a>
                                </li>
                                <li>
                                    <a>Pag. '.$paginaActual.' de '.ceil($totalRegs/$regsPorPag).'</a>
                                </li>
                            </ul>
                        </span>

                    <div class="pagination pagination-right">
                    <ul style="padding-top:7px">';

            $paginas = ceil($totalRegs / $regsPorPag); #determinando el numero de paginas

            $mediaPag = ceil($paginasMostrar / 2);
            $pagInicio = ($paginaActual - $mediaPag);
            $pagInicio = ($pagInicio <= 0 ? 1 : $pagInicio);
            $pagFinal = ($pagInicio + ($paginasMostrar - 1));

            if ($paginaActual > 1) {
                $onclick = $nombreFuncionCambiaPagina . '(' . $params . ',' . $totalRegs . ',1, ' . $regsPorPag . ');';
                $html .= '<li><a href="#" onclick="' . $onclick . '">&#124;&lt;</a></li>';

                $onclick = $nombreFuncionCambiaPagina . '(' . $params . ',' . $totalRegs . ',' . ($paginaActual - 1) . ', ' . $regsPorPag . ');';
                $html .= '<li><a href="#" onclick="' . $onclick . '">&lt;&lt;</a></li>';
            } else {
                $html .= '<li class="disabled"><a href="#" style="text-decoration:none;cursor:auto">&#124;&lt;</a></li>';
                $html .= '<li class="disabled"><a href="#" style="text-decoration:none;cursor:auto">&lt;&lt;</a></li>';
            }

            $sw = true;
            for ($i = $pagInicio; $i <= $pagFinal; $i++) {
                if ($i <= $paginas) {
                    $onclick = $nombreFuncionCambiaPagina . '(' . $params . ',' . $totalRegs . ',' . $i . ', ' . $regsPorPag . ');';
                    $a = '<a href="#" onclick="' . $onclick . '">' . $i . '</a>';

                    $css = '';
                    if ($i == $paginaActual) {
                        $a = '<a href="#" style="text-decoration:none;cursor:auto">' . $i . '</a>';
                        $css = ' class ="active" ';
                    }

                    $html .= '<li ' . $css . '>' . $a . '</li>';
                } else {
                    $sw = false;
                    break;
                    //$html .= '<li class="disabled"><a href="#" style="text-decoration:none;cursor:auto">' . $i . '</a></li>';
                }
            }

            if ($paginas > 1 && $paginaActual != $paginas) {

                $onclick = $nombreFuncionCambiaPagina . '(' . $params . ',' . $totalRegs . ',' . ($paginaActual + 1) . ', ' . $regsPorPag . ');';
                $html .= '<li><a href="#" onclick="' . $onclick . '">&gt;&gt;</a></li>';

                $onclick = $nombreFuncionCambiaPagina . '(' . $params . ',' . $totalRegs . ',' . $paginas . ', ' . $regsPorPag . ');';
                $html .= '<li><a href="#" onclick="' . $onclick . '">&gt;&#124;</a></li>';
            } else {
                $html .= '<li class="disabled"><a href="#" style="text-decoration:none;cursor:auto">&gt;&gt;</a></li>';
                $html .= '<li class="disabled"><a href="#" style="text-decoration:none;cursor:auto">&gt;&#124;</a></li>';
            }

            $html .= '
                    </ul>
                    </div></div>

                <!--</td></tr></table>  -->';
        }

        return $html;
    }
     */
    function htmlPaginador($nombreFuncionCambiaPagina, $dataParametrosFuncionCambiaPagina, $totalRegs, $regsPorPag = GL_NUM_REG_X_PAG, $paginaActual = 1, $paginasMostrar = 5)
    {
        $html = '';

        $paginasMostrar = ($paginasMostrar == 0 ? 5 : $paginasMostrar);
        $regsPorPag = ($regsPorPag == 0 ? 10 : $regsPorPag);

        if ($totalRegs > 0) {
            $params = '';

            if (trim($nombreFuncionCambiaPagina) != '') {
                if (is_array($dataParametrosFuncionCambiaPagina)) {
                    # armando parametros que se enviaran en la funcion
                    for ($i = 0; $i < count($dataParametrosFuncionCambiaPagina); $i++) {
                        if ($i > 0) {
                            $params .= ',';
                        }
                        if (gettype($dataParametrosFuncionCambiaPagina[$i]) == 'string' && substr($dataParametrosFuncionCambiaPagina[$i], 0, 5) != 'xajax') {
                            $params .= "'" . $dataParametrosFuncionCambiaPagina[$i] . "'";
                        } elseif (substr($dataParametrosFuncionCambiaPagina[$i], 0, 5) == 'xajax') {
                            $params .= $dataParametrosFuncionCambiaPagina[$i];
                        } else {
                            $params .= $dataParametrosFuncionCambiaPagina[$i];
                        }
                    }
                } elseif (substr($dataParametrosFuncionCambiaPagina, 0, 5) == 'xajax') {
                    $params = $dataParametrosFuncionCambiaPagina;
                } elseif (trim($dataParametrosFuncionCambiaPagina) != '') {
                    $params = "'" . $dataParametrosFuncionCambiaPagina . "'";
                }
            }


            $html = '
              <div class="rxpag" style="width:174px;">
                        <div class="pull-left-1 paginacion" style="margin-top:-1px; padding-top:5px;padding-left:5px;">
                            <ul><li><a>Reg. x P&aacute;g:</a></li></ul></div>
                        <div class="pull-left-1" style="padding-top:8px;padding-left:5px;">';
            $onclick = $nombreFuncionCambiaPagina . '(' . $params . ',' . $totalRegs . ',1,this.value);';

            $html .= '         <select name="lstRegsByPage" id="lstRegsByPage" style="width:60px;" onchange="' . $onclick . '">
                                <option value="10" ' . ($regsPorPag == 10 ? 'selected' : '') . '>10</option>
                                <option value="20" ' . ($regsPorPag == 20 ? 'selected' : '') . '>20</option>
                                <option value="30" ' . ($regsPorPag == 30 ? 'selected' : '') . '>30</option>
                                <option value="50" ' . ($regsPorPag == 50 ? 'selected' : '') . '>50</option>
                                <option value="100" ' . ($regsPorPag == 100 ? 'selected' : '') . '>100</option>
                            </select>
                        </div>
                    </div>';


            $html .= '<div class="" style="margin-top:-20px;height:45px; padding-bottom:5px;padding-right:5px;padding-left:5px;
                border-width: 1px 1px 1px 0px;
border-style: solid solid solid none;
border-color: rgb(221, 221, 221) rgb(221, 221, 221) rgb(221, 221, 221) -moz-use-text-color;
border:1px solid #ccc;
border-image: none;
border-collapse: separate;
border-radius: 4px;
background: linear-gradient(to bottom, rgb(241, 241, 241) 0%, rgb(219, 219, 219) 100%) repeat scroll 0% 0% transparent;
">
                        <span class="paginacion pull-left-1" style="margin-top:3px;;margin-left:6px">
                            <ul>
                                <li>
                                    <a>Total de registros: ' . $totalRegs . '</a>
                                </li>
                                <li>
                                    <a>Pag. ' . $paginaActual . ' de ' . ceil($totalRegs / $regsPorPag) . '</a>
                                </li>
                            </ul>
                        </span>

                    <div class="paginacion paginacion-right" style="margin-top:0px; color:black; font-weight:bold">
                    <ul style="margin-top:4px">';

            $paginas = ceil($totalRegs / $regsPorPag); #determinando el numero de paginas

            $mediaPag = ceil($paginasMostrar / 2);
            $pagInicio = ($paginaActual - $mediaPag);
            $pagInicio = ($pagInicio <= 0 ? 1 : $pagInicio);
            $pagFinal = ($pagInicio + ($paginasMostrar - 1));

            if ($paginaActual > 1) {
                $onclick = $nombreFuncionCambiaPagina . '(' . $params . ',' . $totalRegs . ',1, ' . $regsPorPag . ');';
                $html .= '<li><a href="#" onclick="' . $onclick . '" style="color:black">|&lt;&lt;</a></li>';

                $onclick = $nombreFuncionCambiaPagina . '(' . $params . ',' . $totalRegs . ',' . ($paginaActual - 1) . ', ' . $regsPorPag . ');';
                $html .= '<li><a href="#" onclick="' . $onclick . '" style="color:black">&lt;&lt;</a></li>';
            } else {
                $html .= '<li class="disabled"><a href="#" style="text-decoration:none;cursor:auto; color:black">&#124;&lt;&lt;</a></li>';
                $html .= '<li class="disabled"><a href="#" style="text-decoration:none;cursor:auto; color:black">&lt;&lt;</a></li>';
            }

            $sw = true;
            for ($i = $pagInicio; $i <= $pagFinal; $i++) {
                if ($i <= $paginas) {
                    $onclick = $nombreFuncionCambiaPagina . '(' . $params . ',' . $totalRegs . ',' . $i . ', ' . $regsPorPag . ');';
                    $a = '<a href="#" onclick="' . $onclick . '" style="color:black">' . $i . '</a>';

                    $css = '';
                    if ($i == $paginaActual) {
                        $a = '<a href="#" style="text-decoration:none;cursor:auto" style="color:black">' . $i . '</a>';
                        $css = ' class ="active" ';
                    }

                    $html .= '<li ' . $css . '>' . $a . '</li>';
                } else {
                    $sw = false;
                    break;
                    //$html .= '<li class="disabled"><a href="#" style="text-decoration:none;cursor:auto">' . $i . '</a></li>';
                }
            }

            if ($paginas > 1 && $paginaActual != $paginas) {

                $onclick = $nombreFuncionCambiaPagina . '(' . $params . ',' . $totalRegs . ',' . ($paginaActual + 1) . ', ' . $regsPorPag . ');';
                $html .= '<li><a href="#" onclick="' . $onclick . '" style="color:black">&gt;&gt;</a></li>';

                $onclick = $nombreFuncionCambiaPagina . '(' . $params . ',' . $totalRegs . ',' . $paginas . ', ' . $regsPorPag . ');';
                $html .= '<li><a href="#" onclick="' . $onclick . '" style="color:black">&gt;&gt;|</a></li>';
            } else {
                $html .= '<li class="disabled"><a href="#" style="text-decoration:none;cursor:auto; color:black">&gt;&gt;</a></li>';
                $html .= '<li class="disabled"><a href="#" style="text-decoration:none;cursor:auto; color:black">&gt;&#124;</a></li>';
            }

            $html .= '
                    </ul>
                    </div></div>

                <!--</td></tr></table>  -->';
        }
        return $html;
    }

    private $legendIcon = array();
    private $legendLabel = array();

    function legenda($icon, $label)
    {
        $this->legendIcon[] = $icon;
        $this->legendLabel[] = $label;
    }

    function renderLegenda($w = "25%")
    {
        $html = '
        <table class="data-tbl-simple table table-bordered" align="center" style="width:' . $w . '">
            <thead>
                <tr><th colspan="' . (sizeof($this->legendIcon) * 2) . '" style="text-align:center">Leyenda</th></tr>
            </thead>
            <tbody>
            <tr>';
        foreach ($this->legendIcon as $key => $icon) {
            $html .= '<td ><span class="' . $icon . '"></span></td><td style="font-size:12px">' . $this->legendLabel[$key] . '</td>';
        }
        $html .= '
            </tr>
            </tbody>
        </table>';
        return $html;
    }
    function enviaremail($user, $psw, $remi, $nomremi, $asunto, $texto, $desti, $nomdesti, &$error = array(), $smtp = "smtp.gmail.com")
    {
        #########################################
        $error = array();
        if (is_array($desti)) {
            foreach ($desti as $key => $valor) {
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "tls";
                $mail->SMTPDebug = 0;
                $mail->Host = $smtp; // SMTP a utilizar. Por ej. smtp.elserver.com
                $mail->Username = $user; // cuenta de correo
                $mail->Password = $psw; // Contraseña
                $mail->Port = 587; // Puerto
                $mail->From = $remi; // Desde donde enviamos (Para mostrar)
                $mail->FromName = $nomremi;
                $mail->ConfirmReadingTo = $remi;
                $mail->AddReplyTo($remi, $nomremi);
                $mail->SMTPAuth = true;
                $mail->CharSet = "UTF-8";
                $mail->IsHTML(true); // El correo se envía como HTML
                $mail->Subject = $asunto; // Este es el titulo del email.
                $mail->Body = $texto; // Mensaje a enviar
                $mail->AltBody = $_SERVER['HTTP_HOST'];
                $mail->AddAddress($valor, $nomdesti[$key]); // Esta es la dirección a donde enviamos
                $error = $mail->Send();
                $mail->ClearAddresses();
            }
        } else {
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->SMTPDebug = 0;
            $mail->Host = $smtp; // SMTP a utilizar.
            $mail->Username = $user; // cuenta de correo
            $mail->Password = $psw; // Contraseña
            $mail->Port = 587; // Puerto
            $mail->From = $remi; // Desde donde enviamos (Para mostrar)
            $mail->FromName = $nomremi;
            $mail->ConfirmReadingTo = $remi;
            $mail->AddReplyTo($remi, $nomremi);
            $mail->SMTPAuth = true;
            $mail->CharSet = "UTF-8";
            $mail->IsHTML(true); // El correo se envía como HTML
            $mail->Subject = $asunto; // Este es el titulo del email.
            $mail->Body = $texto; // Mensaje a enviar
            $mail->AltBody = $_SERVER['HTTP_HOST'];

            $mail->AddAddress($desti, $nomdesti); // Esta es la dirección a donde enviamos
            $error = $mail->Send();
            $mail->ClearAddresses();
        }
    }




    function htmlAutoCompletarNew($funcXAJAX, $objectResult = 'txtSearchSelected', $dataValuesDefault = null, $class = '', $longMinCharSens = 3, $sensitivity = false, $disabled = false, $width = 'width:440px', $condicion = '')
    {

        $objectResult = (trim($objectResult) == '' ? 'txtSearchSelected' : $objectResult);

        $objSearch = $objectResult . 'Criterio';
        $objValue = $objectResult;
        $objectLayer = $objectResult . 'Layer';

        if ($class == null || $class == '') {
            $class = "input-xlarge";
        }

        $longMinChar1 = 2; #cuando pulsa Enter debe al menos haber escrito dos caracteres
        $longMinChar2 = ((int)$longMinCharSens == 0 ? 1 : $longMinCharSens); #valido para $sensitivity=true

        $func = ' onkeypress="
                        if(gKeyEnter(event)) {
                            if(this.value.length==0) {
                                getElemento(\'' . $objectLayer . '\').style.display=\'none\';}
                            else if(this.value.length>=' . $longMinChar1 . '){
                                ' . $funcXAJAX . '(this.value, \'' . $objectResult . '\', ($(\'#lstCondicion\').length != 0? document.getElementById(\'lstCondicion\').value : \'\'))
                            }
                        }"';

        if ($sensitivity) {
            $func .= ' onkeyup="
                        if(this.value.length==0) {
                            getElemento(\'' . $objectLayer . '\').style.display=\'none\';
                        } else if(this.value.length>=' . $longMinChar2 . ') {
                            ' . $funcXAJAX . '(this.value, \'' . $objectResult . '\',($(\'#lstCondicion\').length != 0? document.getElementById(\'lstCondicion\').value : \'\'))
                        }"';
        }

        $funcXAJAX = (trim($funcXAJAX) != '' ? $func : '');

        $id = '';
        $descripcion = '';
        if (is_array($dataValuesDefault) && count($dataValuesDefault) == 2) {
            $id = $dataValuesDefault[0];
            $descripcion = $dataValuesDefault[1];
        }


        $sdisabled = ($disabled ? ' disabled ' : '');

        $html = '
                <label>
                    <input type="hidden" name="' . $objValue . '" id="' . $objValue . '" value="' . $id . '"/>
                    <input ' . $sdisabled . ' type="text" name="' . $objSearch . '" id="' . $objSearch . '" class="' . $class . '" maxlength="30"' . $funcXAJAX . ' onfocus="this.select();" onclick="getElemento(\'' . $objectLayer . '\').style.display=\'none\';" onblur="if(this.value.length==0) getElemento(\'' . $objValue . '\').value=\'\'" value="' . $descripcion . '" style="' . $width . '" placeholder="escriba el criterio y pulse [enter]..."/>
                </label>
                <div id="' . $objectLayer . '" class="autoCompleteErp ' . $class . '" onblur="this.style.display=\'none\'" style="' . $width . '"></div>';

        return $html;
    }


    function htmlAutoCompletarDenunciado($funcXAJAX, $objectResult = 'txtSearchSelected', $dataValuesDefault = null, $class = '', $longMinCharSens = 3, $sensitivity = false, $disabled = false, $width = 'width:440px')
    {

        $objectResult = (trim($objectResult) == '' ? 'txtSearchSelected' : $objectResult);

        $objSearch = $objectResult . 'Criterio';
        $objValue = $objectResult;
        $objectLayer = $objectResult . 'Layer';

        if ($class == null || $class == '') {
            $class = "input-xlarge";
        }

        $longMinChar1 = 2; #cuando pulsa Enter debe al menos haber escrito dos caracteres
        $longMinChar2 = ((int)$longMinCharSens == 0 ? 1 : $longMinCharSens); #valido para $sensitivity=true

        $func = ' onkeypress="
                        if(gKeyEnter(event)) {
                            if(this.value.length==0) {
                                getElemento(\'' . $objectLayer . '\').style.display=\'none\';}
                            else if(this.value.length>=' . $longMinChar1 . '){
                                ' . $funcXAJAX . '(this.value, \'' . $objectResult . '\', document.getElementById(\'lstTipoDenunciado\').value)
                            }
                        }"';

        if ($sensitivity) {
            $func .= ' onkeyup="
                        if(this.value.length==0) {
                            getElemento(\'' . $objectLayer . '\').style.display=\'none\';
                        } else if(this.value.length>=' . $longMinChar2 . ') {
                            ' . $funcXAJAX . '(this.value, \'' . $objectResult . '\', document.getElementById(\'lstTipoDenunciado\').value)
                        }"';
        }

        $funcXAJAX = (trim($funcXAJAX) != '' ? $func : '');

        $id = '';
        $descripcion = '';
        if (is_array($dataValuesDefault) && count($dataValuesDefault) == 2) {
            $id = $dataValuesDefault[0];
            $descripcion = $dataValuesDefault[1];
        }


        $sdisabled = ($disabled ? ' disabled ' : '');

        $html = '
                <label>
                    <input type="hidden" name="' . $objValue . '" id="' . $objValue . '" value="' . $id . '"/>
                    <input ' . $sdisabled . ' type="text" name="' . $objSearch . '" id="' . $objSearch . '" class="' . $class . '" maxlength="30"' . $funcXAJAX . ' onfocus="this.select();" onclick="getElemento(\'' . $objectLayer . '\').style.display=\'none\';" onblur="if(this.value.length==0) getElemento(\'' . $objValue . '\').value=\'\'" value="' . $descripcion . '" style="' . $width . '" placeholder="escriba el criterio y pulse [enter]..."/>
                </label>
                <div id="' . $objectLayer . '" class="autoCompleteErp ' . $class . '" onblur="this.style.display=\'none\'" style="' . $width . '"></div>';

        return $html;
    }

    function htmlAutoCompletarAgraviado($funcXAJAX, $objectResult = 'txtSearchSelected', $dataValuesDefault = null, $class = '', $longMinCharSens = 3, $sensitivity = false, $disabled = false, $width = 'width:440px')
    {

        $objectResult = (trim($objectResult) == '' ? 'txtSearchSelected' : $objectResult);

        $objSearch = $objectResult . 'Criterio';
        $objValue = $objectResult;
        $objectLayer = $objectResult . 'Layer';

        if ($class == null || $class == '') {
            $class = "input-xlarge";
        }

        $longMinChar1 = 2; #cuando pulsa Enter debe al menos haber escrito dos caracteres
        $longMinChar2 = ((int)$longMinCharSens == 0 ? 1 : $longMinCharSens); #valido para $sensitivity=true

        $func = ' onkeypress="
                        if(gKeyEnter(event)) {
                            if(this.value.length==0) {
                                getElemento(\'' . $objectLayer . '\').style.display=\'none\';}
                            else if(this.value.length>=' . $longMinChar1 . '){
                                ' . $funcXAJAX . '(this.value, \'' . $objectResult . '\', document.getElementById(\'lstTipoAgraviado\').value)
                            }
                        }"';

        if ($sensitivity) {
            $func .= ' onkeyup="
                        if(this.value.length==0) {
                            getElemento(\'' . $objectLayer . '\').style.display=\'none\';
                        } else if(this.value.length>=' . $longMinChar2 . ') {
                            ' . $funcXAJAX . '(this.value, \'' . $objectResult . '\', document.getElementById(\'lstTipoAgraviado\').value)
                        }"';
        }

        $funcXAJAX = (trim($funcXAJAX) != '' ? $func : '');

        $id = '';
        $descripcion = '';
        if (is_array($dataValuesDefault) && count($dataValuesDefault) == 2) {
            $id = $dataValuesDefault[0];
            $descripcion = $dataValuesDefault[1];
        }


        $sdisabled = ($disabled ? ' disabled ' : '');

        $html = '
                <label>
                    <input type="hidden" name="' . $objValue . '" id="' . $objValue . '" value="' . $id . '"/>
                    <input ' . $sdisabled . ' type="text" name="' . $objSearch . '" id="' . $objSearch . '" class="' . $class . '" maxlength="30"' . $funcXAJAX . ' onfocus="this.select();" onclick="getElemento(\'' . $objectLayer . '\').style.display=\'none\';" onblur="if(this.value.length==0) getElemento(\'' . $objValue . '\').value=\'\'" value="' . $descripcion . '" style="' . $width . '" placeholder="escriba el criterio y pulse [enter]..."/>
                </label>
                <div id="' . $objectLayer . '" class="autoCompleteErp ' . $class . '" onblur="this.style.display=\'none\'" style="' . $width . '"></div>';

        return $html;
    }
}

?>