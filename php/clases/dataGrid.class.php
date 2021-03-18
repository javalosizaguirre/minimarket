<?php

class eGrid extends connectdb{
    
    /*ID de tabla*/
    private $id;

    /*Caption de tabla*/
    public  $caption; 

    /*Total de registros*/
    public  $totalRegistros;

    /*registros por pagina*/
    private $nRegPagina = 1;
    
    /*Almacena las columnas del grid*/
    private $cols   =   array();

    /*Id :: KEY PRIMARY`para columnas editables*/
    private $key='';

    /*Almacena los registros obtenidos de la DB*/
    private $data   =   array();

    /*closure para el recorrido de la data, que se carga en $Grid->data()*/
    private $fnData;
    
    /*Para validar si se muestra los check button*/
    private  $check = false;
    
    /*almacena los values para los checkbox*/
    private $checkValues;
    
    /*checked = false para checkbox y radios*/
    private $checked;
    
    /*almacena closure para checkbox*/
    private $callBackCheck;

    /*permitir seleccionar check dando click a fila*/
    private $clickTdCheckBox = true;
    
    /*Para validar posicion de checkbox*/
    private  $posicionCheck = 'first';

    /*Para validar si se muestra los radio button*/
    private  $radio = false;

    /*almacena los values para los radios*/
    private $radioValues;
    
    /*clmacena closure para radioButton*/
    private $callBackRadio;
    
    /*Para validar posicion de radio*/
    private  $posicionRadio = 'first';   

    /*Almacena las acciones, ELIMINAR EDITAR, etc*/
    private $axion=array(); 		

    /*Para validar si dataGrid usara acciones o no*/
    private $siaccion=false;

    /*Para validar posicion de acciones*/
    public  $posicionAccion = 'first';
    
    /*etiqueta para cabecera accion*/
    public $labelAccion = '';

    /*Para mostrar numeros de registros*/
    private  $numeros = false;

    /*parametro para activar Scroll*/
    private $scroll = false;
    
    private $heightScroll;
    
    private $widthScroll;
    /*parametro para activar verticalScroll*/
    private $verticalScroll = false;
    
    /*parametro para activar horizontalScroll*/
    private $horizontalScroll = false;
    
    /*ancho del horizontal scroll fijo*/
    private $widhScrollLeft;
    
    /*ancho del horizontal scroll nofijo*/
    private $widhScrollRight;
    
    /*numero de columna desde donde inciara el scroll horizaontal*/
    private $piloteColumnScroll;
 
    /*contiene paginacion interna*/
    private $paginIn = '';
    
    /*parametro para mostrar titulos en el footer*/
    private $foot = false;

    /*parametro globar de xajax*/
    private $rpta;
    
    /*posicion donde se insertara la fila*/
    private $posicion;
    
    /*closure q se ejecutara para mostrar los resutados deseados en ultima fila*/
    private $fnCallbackFilaLast = '';
    
    /*closure q se ejecutara para mostrar los resutados deseados en las filas al momento de genearrlas*/
    private $fnCallbackFilaLastMedium = '';
    
    /*closure para ejecutar subconcultas*/
    private $fnCallbackSubFila = '';
    
    /*verificar q exportacion se ejecuta una vez*/
    private $exportado = 0;

    /*parametros para excel*/
    private $excel = false;
    
    /*ruta donde se guardaran los documentos generados*/
    private $rutaDocs = 'archivos/';
    
    /*parametro para generar word*/
    private $word = false;
    
    /*parametro para pdf*/
    private $pdf = false;
    
    /*para eventos clik de acciones mediante jquery.click()*/
    private $jqClick = false;
    
    /*script q cargara los clicks de acciones*/
    public $scriptClick='';
    
    #------------------------------- METODOS ---------------------------------#
    public function __construct($id="tab_",$rpta=''){
        $this->id    =   $id;
        $this->rpta  =   (isset($rpta))?$rpta:'';
    }
    
    /*añade los onclick a loas acciones mediante jquery.click()*/
    function jqueryClick(){
        $this->jqClick = true;
    }
    
    /*asigna el key para celdas editables*/
    public function keyEdit($k){
        $this->key = $k;
    }
        
        /*
         * Genera las columnas
         * 
         * Parametros:
         * 
         *  type:: tipo de dato para la celda, puede ser: label || badge || img || string. 
         *         el tipo string es por defecto
         *  titulo:: el titulo para la columna
         *  campo:: el campo de la DB que se ha de mostrar, tambien puede ser un array, para concatenar
         *  width:: ancho para la columna, en pixeles por defecto
         *  editar:: hace que el dato sea editable o no
         *      type:: tipo de elemento a dibujar, y son: [text, checkbox, radio, textarea, select]
         *      claseEdicion:: en que momento se activa campos editables
         *                     inLoad: se activa al momento de crear el datagrid
         *                     outLoad: se activara mediante una accion
         *      fnCallback:: funcion closure que ejecutara una funcion anonima definida por el desarrollador, y 
         *                   que el resultado reemplazara al registro de la columna
         *  align:: centrado del dato
         *  ruta:: ruta del dato en caso sea una imagen 
         *  xajax:: array para la llamada xajax
         *      fn::la funcion xajax
         *      parametros:: los parametros de la funcion (fn)
         *          flag:: bandera para el sp
         *          form:: formulario que contiene los elementos html
         *          campos:: parametros de la DB para procesar el registro, puede enviarse uno o mas campos
         *  labels:: en caso de necesitar campos con estilo label, se envia la descripcion del dato y el nombre de la clase css
         *  badges:: en caso de necesitar campos con estilo badges, se envia la descripcion del dato y el nombre de la clase css
         *  subFila:: cabeceras anidadas
         *  fnCallback:: closure -- funcion anonima que se ejecutara al crear el grid, el resultado reemplazara la data de la columna
         *               $row -- es el registro que biene de la DB con las columnas configuradas en el SP
         *               $a -- es el numero de fila
         * 
         *$Grid->columna(array(
                "type"=>"label || badge || img || string",
                "titulo"=>"Nombre titulo",
                "campo"=>"campo_de_db",
                "width"=>"8%",
                "editar"=>array(
                    "type"=>"textarea",
                    "claseEdicion"=>"inLoad"//outLoad,
                    "fnCallback"=>function($row,$a){
                        -- ALGO A EJECUTAR --
                        return $cad;
                    }
                )
                "align"=>"center",
                "ruta"=>"ruta_de_imagen/"
                "xajax"=>array(
                                "fn"=>"xajax__interfazCartaFianzaExtraer",
                                "parametros"=>array(
                                    "flag"=>"2",
                                    "form"=>"formulario",
                                    "campos"=>array("cartafianza","importe")
                                )
                            ),
                "labels"=>array(
                    "Activo"=>"label-success",
                    "Inactivo"=>"label-important"
                ),
                "badges"=>array(
                    "Activo"=>"badge-success",
                    "Inactivo"=>"badge-important"
                ),
                "subFila"=>array(
                    array(
                        "titulo"=>"Contrato",
                        "campo"=>"contrato",
                        "width"=>"10%",
                        "align"=>"center"
                    ),
                    array(
                        "titulo"=>"Tipo Carta",
                        "campo"=>"tcarta",
                        "width"=>"10%",
                        "align"=>"center"
                    )
                ),
                "fnCallback"=>function($row,$a){
                    -- ALGUNA INSTRUCCION --
                    return $cad;
                }
            ));
         */
    public function columna($obj){
        $this->cols[]   = $obj; 
    }
	
    public function fila($obj){
        $this->posicion = (isset($obj['posicion']))?$obj['posicion']:'';
        switch (($this->posicion)){
            case 'medium': 
                $this->fnCallbackFilaLastMedium = (isset($obj['fnCallback']))?$obj['fnCallback']:'';
                break;
            case 'last': 
                $this->fnCallbackFilaLast = (isset($obj['fnCallback']))?$obj['fnCallback']:'';
                break;
        }
        
    }
    
    public function subFila($obj){
        $this->fnCallbackSubFila = (isset($obj['fnCallback']))?$obj['fnCallback']:'';
    }
    /*
         * CREA LAS ACCIONES DEL GRID
         * 
         * Parametros
         *  icono:: css que contiene la imagen del icono
         *  titulo:: el head para la columna
         *  xajax:: array para la llamada xajax
         *      fn::la funcion xajax
         *      parametros:: los parametros de la funcion (fn)
         *          flag:: bandera para el sp
         *          form:: formulario que contiene los elementos html
         *          campos:: parametros de la DB para procesar el registro, puede enviarse uno o mas campos
         *          xcampos:: parametros diversos, que no seran de la DB 
         *  fnCallback:: funcion anonima, el resultado reemplazara a la accion riginal
         * 
         * Pasando campos como array para enviar varios KEY
         * ------------------------------------------------
         $Grid->accion(array(
                        "icono"=>"page_white_edit_co",
                        "titulo"=>"Editar",
                        "xajax"=>array(
                            "fn"=>"xajax__interfazCartaFianzaExtraer",
                            "parametros"=>array(
                                "flag"=>"2",
                                "form"=>"formulario",
                                "campos"=>array("cartafianza","importe"),
                                "xcampos"=>array("$('#xxx').val()","'".$rr."'")
                            )
                        ),
                        "fnCallback"=>function($row){
                            switch ($row["estado"]) {
                                case "0":
                                    $cadena = '<a  title="Anulado" href=javascript:void(0) style="text-decoration:none" 
                                                onclick="alert(\'Requerimiento ya se anuló\')">
                                                <i class="color-icons bin_closed_co"></i>
                                            </a> ';
                                    break;
                                default:
                                    $cadena = false;
                                    break;
                            }
                            return $cadena;
                        }
                    ));	
         * 
         * Pasando un solo campos KEY
         * --------------------------
         $Grid->accion(array(
                        "icono"=>"color-icons cross_co",
                        "titulo"=>"Eliminar",
                        "xajax"=>array(
                            "fn"=>"xajax__interfazCartaFianzaMantenimiento",
                            "msn"=>"¿Esta seguro de eliminar Carta Fianza?",
                            "parametros"=>array(
                                "flag"=>"3",
                                "form"=>"formulario",
                                "campos"=>"cartafianza",
                                "xcampos"=>array("$('#xxx').val()","'".$rr."'")
                            )
                        ),
                        "fnCallback"=>function($row){
                            switch ($row["estado"]) {
                                case "0":
                                    $cadena = '<a  title="Anulado" href=javascript:void(0) style="text-decoration:none" 
                                                onclick="alert(\'Requerimiento ya se anuló\')">
                                                <i class="color-icons bin_closed_co"></i>
                                            </a> ';
                                    break;
                                default:
                                    $cadena = false;
                                    break;
                            }
                            return $cadena;
                        }
                    ));
         */
    public function accion($Obj){
        $this->axion[]  = $Obj;
        $this->siaccion = true;		
    }
	
    /*
     *Activa titulos en el footer 
     */
    public function footer(){
        $this->foot = true;
    }
    
    /*
     * Mostrar numeracion
     */
    public function numeracion(){
        $this->numeros = true;
    }
    /*
     * Activar verticalScroll
     */
    public function mostrarVerticalScroll($h){
        $this->verticalScroll = true;
        $this->heightScroll = $h;
    }
        
    /*
     * Activar verticalScroll
     */
    public function mostrarHorizontalScroll($obj){
        $this->horizontalScroll = true;
        $this->widhScrollLeft = $obj['widthLeft'];
        $this->widhScrollRight = $obj['widthRight'];
        $this->piloteColumnScroll = $obj['piloteColum'];
    }
    
    public function mostrarScroll($obj){
        $this->scroll = true;
        $this->heightScroll = (isset($obj['heightScroll']))?' height:'.$obj['heightScroll'].';':'';
        $this->widthScroll = (isset($obj['widthScroll']))?' width:'.$obj['widthScroll'].';':'';
    }
    
    public function exportarExcel(){
        $this->excel = true;
    }
    
    public function exportarWord(){
        $this->word = true;
    }
    
    public function exportarPDF(){
        $this->pdf = true;
    }
    /*
         * Consulta la data a la DB, data con paginacion
         * 
         * PARAMETROS:
         * ------------------------
         *  criterio:: criterios necesarios para el metodo q seleccionara la data, tambien se puede enviar un array
         *  total:: total de registros por paginacion, este parametro es devuelto por la clase eGrid
         *  pagina:: numero de pagina a visualizar
         *  nRegPagina:: numero de registros por pagina a mostrar
         *  class:: clase que se instanciara para seleccionar la data
         *  method:: metodo que reliza la seleccion
         *  fnCallback:: funcion anonima CLOSURE, que servira para mostrar mensajes personalizados,
         *               los datos a utilizar en el resultado de la seleccion son:
         *               msgId:: id del mensaje a personalizar
         *               msgDescripcion:: descripcion del mensaje
         *               estos parametros son estanderes, los cuales denben ser generados en el SP que devuelve los registro,
         *               se podra mostrar el contenido que se desee segun el msgId configurado.
         * USO:
         * ------------------------
         * 
         * $Grid->data(array(
                    "criterio"=>$criterio,
                    "total"=>$Grid->totalRegistros, 
                    "pagina"=>$pagina, 
                    "nRegPagina"=>$nreg_x_pag,
                    "class"=>"con_cartafianza",
                    "method"=>"buscarCartaFianza",
                    "fnCallback"=>function($data){
                        switch($data[0]['msgId']){
                            case 1:
                                $result = '<tr id="noData">
                                        <td colspan="30" style="border-right:1px solid #ccc"><div class="alert alert-danger" >
                                               <strong>'.$data[0]['msgDescripcion'].'</strong>
                                             </div>
                                             </td></tr>';
                                break;
                            case 2:
                                $result = '<tr id="noData">
                                        <td colspan="30" style="border-right:1px solid #ccc"><div class="alert alert-danger" >
                                               <strong>'.$data[0]['msgDescripcion'].'</strong>
                                             </div>
                                             </td></tr>';
                                break;
                            case 3:
                                $result = 'PODRE MOSTRAR LO QUE NECESITE, ESTE RESULTADO SERA UN [tr]';
                                break;
                            default:
                                //al enviar false, se cargara la data seleccionada en el SP
                                $result = false;
                                break;
                        }
                        return $result;
                    }
                )
            );
         */
	public function data($obj){
            $sp         = (isset($obj['sp']))?$obj['sp']:'A'; #existen dos formas de sp para la paginacion (A y B)
            $flag       = (isset($obj['flag']))?$obj['flag']:'';
            $criterio   = (isset($obj['criterio']))?$obj['criterio']:'';
            $total_regs = $obj['total'];
            $pagina     = $obj['pagina'];
            $nreg_x_pag = $obj['nRegPagina'];
            $class      = $obj['class'];
            $method     = $obj['method'];
            $this->fnData = (isset($obj['fnCallback']))?$obj['fnCallback']:'';

            $c_bObj = new $class();

            if($sp == 'A'){ /*sp se ejecuta dos veces*/
                $criterio2 = $criterio;
                if(!is_array($criterio)){
                    $asterisco = substr($criterio, 0, 1);

                }else{
                    $asterisco = substr($criterio[0], 0, 1);
                }
                $buscarPor = 'N';
                if ($asterisco == '*') {
                    $buscarPor = 'C';
                    $criterio2 = substr($criterio, 1);
                }

                if ($total_regs == 0) {

                    $this->data = $c_bObj->$method($criterio2, $buscarPor, 1);

                    if(isset($this->data['error'])){
                        $this->totalRegistros = 0;
                    }else{
                        $this->totalRegistros = $this->data['total'];
                    }
                    if($this->excel || $this->word || $this->pdf){
                        $this->dataDocs = $c_bObj->$method($criterio2, 'C', 0);
                    }
                }
                $this->data = $c_bObj->$method($criterio2, $buscarPor, 0, $pagina, $nreg_x_pag);
            }elseif($sp == 'B'){/*sp se ejecuta una vez*/

                $this->data = $c_bObj->$method($flag, $criterio, $pagina, $nreg_x_pag);

                if(isset($this->data['error'])){
                    $this->totalRegistros = 0;
                }else{
                    $this->totalRegistros = $this->data[0]['total'];
                }
                if($this->excel || $this->word || $this->pdf){
                    /*A: es el flag en el sp que devolvera todos los registros para exportar el documento*/
                    $this->dataDocs = $c_bObj->$method('A', $criterio);
                }
            }
        }

        /*
         * Datos sin paginacion
         *
         * PARAMETROS:
         * ------------------------
         *  criterio:: criterios necesarios para el metodo q seleccionara la data, tambien se puede enviar un array
         *  flag:: bandera para el SP
         *  class:: clase que se instanciara para seleccionar la data
         *  method:: metodo que reliza la seleccion
         *  fnCallback:: funcion anonima CLOSURE, que servira para mostrar mensajes personalizados,
         *               los datos a utilizar en el resultado de la seleccion son:
         *               msgId:: id del mensaje a personalizar
         *               msgDescripcion:: descripcion del mensaje
         *               estos parametros son estanderes, los cuales denben ser generados en el SP que devuelve los registro,
         *               se podra mostrar el contenido que se desee segun el msgId configurado.
         * USO:
         * ------------------------
         *
         * $Grid->data(array(
                    "criterio"=>$criterio,
                    "flag"=>"1",
                    "class"=>"con_cartafianza",
                    "method"=>"buscarCartaFianza",
                    "fnCallback"=>function($data){
                        switch($data[0]['msgId']){
                            case 1:
                                $result = '<tr id="noData">
                                        <td colspan="30" style="border-right:1px solid #ccc"><div class="alert alert-danger" >
                                               <strong>'.$data[0]['msgDescripcion'].'</strong>
                                             </div>
                                             </td></tr>';
                                break;
                            case 2:
                                $result = '<tr id="noData">
                                        <td colspan="30" style="border-right:1px solid #ccc"><div class="alert alert-danger" >
                                               <strong>'.$data[0]['msgDescripcion'].'</strong>
                                             </div>
                                             </td></tr>';
                                break;
                            case 3:
                                $result = 'PODRE MOSTRAR LO QUE NECESITE, ESTE RESULTADO SERA UN [tr]';
                                break;
                            default:
                                //al enviar false, se cargara la data seleccionada en el SP
                                $result = false;
                                break;
                        }
                        return $result;
                    }
                )
            );
         */
        public function dataSimple($obj){
            $criterio   = (isset($obj['criterio']))?$obj['criterio']:'';
            $class      = $obj['class'];
            $method     = $obj['method'];
            $flag       = (isset($obj['flag']))?$obj['flag']:'';
            $this->fnData = (isset($obj['fnCallback']))?$obj['fnCallback']:'';

            $c_bObj = new $class();
            if($flag ==! ''){
                $this->data = $c_bObj->$method($flag,$criterio);
                if($this->excel || $this->word || $this->pdf){
                    $this->dataDocs = $c_bObj->$method($flag, $criterio);
                }
            }else{
                $this->data = $c_bObj->$method($criterio);
                if($this->excel || $this->word || $this->pdf){
                    $this->dataDocs = $c_bObj->$method($criterio);
                }
            }
            if(isset($this->data['error'])){
                $this->totalRegistros = 0;
            }else{
                $this->totalRegistros = sizeof($this->data);
            }
	}

        /*calculael width del div scrollvertical*/
        private function widthContScroll(){
            $w = 8;//8 es el width del sacroll
            $paddCss = 4;//4 es el paddin del css
            /*si tiene acciones sumo sus widths*/
            if($this->siaccion){
                $lenAcc = sizeof($this->axion);
                if($lenAcc == 1){/*se suma 40*/
                    $w += 40 + $paddCss;
                }elseif($lenAcc > 1){/*si es mayor q uno se suma 25*/
                    $m = 27 * $lenAcc;/*se multiplica por la cantidad de acciones*/
                    $w += $m + $paddCss;
                }
            }
            /*se suma el width del checkbox*/
            if($this->check){
                $w += 20 + $paddCss;
            }
            /*se suma el width del radio*/
            if($this->radio){
                $w += 25 + $paddCss;
            }
            /*se suma el width de los numeros*/
            if($this->numeros){
                $w += 20 + $paddCss;
            }
            /*se suma los widths de las columnas*/
            foreach ($this->cols as $col) {
                $w += $col['width'] + $paddCss;
            }
            return $w.'px';
        }

        public function render(){
            $result = '<div class="btn-group">';
            if($this->excel){
                $result .= '<button type="button" class="btn" onclick="self.location = \''.$this->rutaDocs.'tmpExcel.xls\';"><i class="icon-cog"></i>Excel</button>';
            }
            if($this->word){
                $result .= '<button type="button" class="btn" onclick="
                                self.location = \''.$this->rutaDocs.'tmpWord.doc\';
                            "><i class="icon-file"></i>Word</button>';
            }
            if($this->pdf){
                $result .= '<button type="button" class="btn btn-primary" onclick="
                                window.open(\''.$this->rutaDocs.'tmpPDF.pdf\',\'\',\'width=10px,height=10px\');
                            "><i class="icon-file"></i>PDF</button>';
            }
            $result .= '</div>';
            if($this->excel || $this->word || $this->pdf){
                $result .= '<br>';
            }
            /*sin no hay data colocar width de tabla*/
            $wt = '';
            if(sizeof($this->data) < 1){
                $wt = 'width:100%;';
            }
            if($this->verticalScroll){
               $result.='
               <div style="width:100%">
                        <table class="data-tbl-simple table table-bordered">';//style="width:99%"
                            $result.=self::cabecera(true); //true es para mostrar el caption
               $result.='</table>
               </div>';
               /*el contenido*/
               $widthScroll = self::widthContScroll();
               $result.='<div style="width:;height:'.$this->heightScroll.';background:#fff;overflow:auto;overflow-y:scroll;margin-top:-17px;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border:#ccc solid 1px">
                            <table id="'.$this->id.'" class="data-tbl-simple table table-bordered" style="'.$wt.'margin-bottom:0px;border-right:0px;border-left:0px;border-top:0px;-moz-border-radius: 0px;-webkit-border-radius: 0px;border-radius: 0px;">';
                                $result.=self::contDataScroll();
               $result.='   </table>
                        </div>';
               /*verificar si se insertara fila al final*/
                if($this->fnCallbackFilaLast != ''){
                    $result .= '<table class="data-tbl-simple table table-bordered" style="margin-bottom:0px;border-right:1px solid #ccc;border-left:0px solid #ccc;border-top:0px;-moz-border-radius: 0px;-webkit-border-radius: 4px;border-radius: 0 0 4px 4px;">';
                    if(is_callable($this->fnCallbackFilaLast)){
                        $call = call_user_func_array($this->fnCallbackFilaLast,array($this->data));
                        if($call == false){
                            //no se ejecuta nada
                        }else{
                            $result .= $call; //retorna resultado del closure
                        }
                    }else{
                        $result.='<tr id="noData"><td colspan="50">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback], en metodo $Grid->fila().</strong>
                                      </div>
                                </td></tr>';
                    }
                    $result .= '</table>';
                }
               /*el footer*/
               if($this->foot){
                        $result.='
                        <div style="width:100%">
                                 <table class="data-tbl-simple table table-bordered" >';//style="width:99%"
                                     $result.=self::cabecera();
                        $result.='</table>
                        </div>';
                }
               if($this->paginIn != ''){
                   /*al activar scrool margin-top = 17, para equilibrarlo con margin-top: 19 de paginador en abstract*/
                   $result .='<div style="margin-top:17px;">'.$this->paginIn.'</div>';
               }
            }else{
                if($this->horizontalScroll){/*scrool horizontal activo, la estructura es diferente*/
                    $result .= '<style>
                                .table tbody tr:hover td, .table tbody tr:hover th {
                                        background-color: #fff;
                                }
                                </style>';
                    $result .=self::contData();
                }else{
                    $scrollcss = '';
                    $wt = 'width:100%;';//cuando no hay scroll width tiene q ser full
                    if($this->scroll){
                        $scrollcss = ' class="sScrollLCont" ';
                        $wt = 'width:98.5%;';//cuando hay scroll es 98 porq sino se actva el hrizaontal, q no es necesario cuando solo es vertical scroll
                    }
                    $result.='<div '.$scrollcss.' style="'.$this->heightScroll.'overflow: hidden">
                                <table id="'.$this->id.'" class="data-tbl-simple table table-bordered"  style="border-left:#ccc 1px solid;border-right:0px;'.$wt.'">';
                    $result.=self::contData();
                    $result.='  </table>
                            </div>';
                    if($this->scroll){//si activo scroll mostrar ultima fila en otra tabla, para q no se muestre dentro del scroll
                        /*verificar si se insertara fila al final*/
                        if($this->fnCallbackFilaLast != ''){
                            $result .='<table class="data-tbl-simple table table-bordered"  style="border-left:#ccc 1px solid;border-right:#ccc 1px solid;border-top:0px;-webkit-border-radius: 0px 0px 4px 4px;-moz-border-radius: 0px 0px 4px 4px;border-radius: 0px 0px 4px 4px  ;">';
                            if(is_callable($this->fnCallbackFilaLast)){
                                $call = call_user_func_array($this->fnCallbackFilaLast,array($this->data));
                                if($call == false){
                                    //no se ejecuta nada
                                }else{
                                    $result .= $call; //retorna resultado del closure
                                }
                            }else{
                                $result.='<tr id="noData"><td colspan="50">
                                             <div class="alert alert-danger">                                                                        
                                                <strong>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback], en metodo $Grid->fila().</strong>
                                              </div>
                                        </td></tr>';
                            }
                            $result .='</table>';
                        }
                    }
                }

               if($this->paginIn != ''){

                   $result .='<div>'.$this->paginIn.'</div>';
               }

               if($this->excel || $this->word || $this->pdf){
                    if($this->exportado == 1){
                        self::renderDocs();
                    }
               }
            }
            /*mostrando scroll*/
            if($this->scroll){
                $result.= $GLOBALS['scrollCss'];
                if($this->rpta != ''){
                    $this->rpta->addScript("".$GLOBALS['scrollTable']."");//se carga funcion js para scroll
                }else{
                    $result.='<div class="alert alert-danger" style="width:100%">                                                                        
                                   <strong><br>ERROR: [$rpta] no definido. Objeto XAJAX no ha sido enviado.</strong>
                                 </div>';
                }
            }

            return $result;
	}

        private function renderDocs(){
            $td ='<table class="data-tbl-simple table table-bordered">';
            $h = self::cabeceraPrincipal($this->cols);

            $td .= '<thead><tr><th>Nro</th>'.$h[0].'</tr>'.$h[1].'</thead>';
                $td.= '<tbody>';
                        /*se verifica si hay data*/
                        if(sizeof($this->data)>0 && !isset($this->data['error'])){
                            if($this->fnData != ''){//se definio una funcion anonima
                                if(is_callable($this->fnData)){//se verifica si es un closure
                                    $call = call_user_func_array($this->fnData,array($this->data));
                                    if($call == false){//si el resultado es false, se generan os registros
                                        $td .= self::registrosExportar();
                                    }else{//si hay algun resultado, se reemplaza por algun contenido predeterminado
                                        $td.= $call;
                                    }
                                }else{//se definio closure incorrecto
                                    $td.='<tr id="noData"><td colspan="30">
                                            <div class="alert alert-danger" style="width:100%">                                                                        
                                               <strong><br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].</strong>
                                             </div>
                                       </td></tr>';
                                }
                            }else{//no existe closure definido or el desarrollador, se carga la data
                                $td .= self::registrosExportar();
                            }
                        }elseif(sizeof($this->data) == 0){//no hay data
                            $td.='<tr id="noData"><td colspan="30" style="border-right:1px solid #ccc">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>No se encontraron registros</strong>
                                      </div>
                                </td></tr>';
                        }
                        $td.='</tbody>';

            $td .='</table>';

            /*crear excel*/
            if($this->excel){
                $nuevoarchivo = fopen($this->rutaDocs.'tmpExcel.xls', "w+");
                fwrite($nuevoarchivo,$td);
                fclose($nuevoarchivo);
            }
            /*crear word*/
            if($this->word){
                $nuevoarchivo = fopen($this->rutaDocs.'tmpWord.doc', "w+");
                fwrite($nuevoarchivo,$td);
                fclose($nuevoarchivo);
            }
            /*crear pdf*/
            if($this->pdf){
                $pdf = new fpdfHTML();
                $pdf->AddPage('L');
                $pdf->SetFont('Arial','B',10);

                $pdf->WriteHTML($td);
                $pdf->Output($this->rutaDocs.'tmpPDF.pdf','F');
            }
        }

        /*Genera el contenido del data grid, sin verticalScroll*/
	private function contData(){
            if($this->horizontalScroll){
                $td = '';
                /*el caption*/
                if($this->caption!=""){
                    $td.='<table class="data-tbl-simple table table-bordered"  style="margin-bottom:0px;width:99.1%;">
                            <thead>
                            <tr><th colspan="70" style="text-align:center">'.$this->caption.'</th></tr>
                            </thead>
                          </table>';
                }
                /*===================LAS COLUMNAS FIJAS=========================*/
                $td.='<div style="float: left;width:'.$this->widhScrollLeft.'">
                     <table id="'.$this->id.'" class="data-tbl-simple table table-bordered"  style="border-left:#ccc 1px solid;border-right:0px;width:100%;-webkit-border-radius: 4px 0px 0px 4px;-moz-border-radius: 4px 0px 0px 4px;border-radius: 4px 0px 0px 4px;">';
                    $td.= self::cabecera(true,'left'); //true es para mostrar el caption
                $td.= '<tbody id="'.$this->id.'_Body">';
                        /*se verifica si hay data*/
                        if(sizeof($this->data)>0 && !isset($this->data['error'])){
                            if($this->fnData != ''){//se definio una funcion anonima
                                if(is_callable($this->fnData)){//se verifica si es un closure
                                    $call = call_user_func_array($this->fnData,array($this->data));
                                    if($call == false){//si el resultado es false, se generan os registros
                                        $td .= self::registros('left');
                                    }else{//si hay algun resultado, se reemplaza por algun contenido predeterminado
                                        $td.= $call;
                                    }
                                }else{//se definio closure incorrecto
                                    $td.='<tr id="noData"><td colspan="30">
                                            <div class="alert alert-danger" style="width:100%">                                                                        
                                               <strong><br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].</strong>
                                             </div>
                                       </td></tr>';
                                }
                            }else{//no existe closure definido or el desarrollador, se carga la data
                                $td .= self::registros('left');
                            }
                        }elseif(sizeof($this->data) == 0){//no hay data
                            $td.='<tr id="noData"><td colspan="30" style="border-right:1px solid #ccc">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>No se encontraron registros</strong>
                                      </div>
                                </td></tr>';
                        }elseif(isset($this->data['error'])){//error en sp
                            $td.='<tr id="noData"><td colspan="30" style="border-right:1px solid #ccc">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>'.$this->data['error'].'</strong>
                                      </div>
                                </td></tr>';
                        }
                        $td.='</tbody>';
                $td.='</table>';
                $td.='</div>';
                /*=============================CLUMNAS NO FIJAS =======================================*/
                /*ancho de tabla*/
                $wtabHS = 0;
                foreach ($this->cols as $keyy=>$col) {
                    /*validar q sus propiedades existan*/
                    $width  = isset($col['width'])?$col['width']:'';
                    if($keyy >= $this->piloteColumnScroll){
                        $wtabHS += $width;
                    }
                }
                $td.='<div style="width:'.$this->widhScrollRight.';float: left;overflow:auto; overflow-y:hidden;border-right:1px solid #ccc;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;">
                        <div style="width:'.$wtabHS.'px;">
                        <table id="'.$this->id.'_right" class="data-tbl-simple table table-bordered"  style="border-left:#ccc 0px solid;border-right:0px;margin-bottom:0px;-webkit-border-radius: 0px 4px 4px 0px;-moz-border-radius: 0px 4px 4px 0px;border-radius: 0px 4px 4px 0px;">';
                        $td.= self::cabecera(true,'right'); //true es para mostrar el caption
                        $td.= '<tbody id="'.$this->id.'_rightBody">';
                        /*se verifica si hay data*/
                        if(sizeof($this->data)>0 && !isset($this->data['error'])){
                            if($this->fnData != ''){//se definio una funcion anonima
                                if(is_callable($this->fnData)){//se verifica si es un closure
                                    $call = call_user_func_array($this->fnData,array($this->data));
                                    if($call == false){//si el resultado es false, se generan os registros
                                        $td .= self::registros('right');
                                    }else{//si hay algun resultado, se reemplaza por algun contenido predeterminado
                                        $td.= $call;
                                    }
                                }else{//se definio closure incorrecto
                                    $td.='<tr id="noData"><td colspan="30">
                                            <div class="alert alert-danger" style="width:100%">                                                                        
                                               <strong><br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].</strong>
                                             </div>
                                       </td></tr>';
                                }
                            }else{//no existe closure definido or el desarrollador, se carga la data
                                $td .= self::registros('right');
                            }
                        }elseif(sizeof($this->data) == 0){//no hay data
                            $td.='<tr id="noData"><td colspan="30" style="border-right:1px solid #ccc">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>No se encontraron registros</strong>
                                      </div>
                                </td></tr>';
                        }elseif(isset($this->data['error'])){//error en sp
                            $td.='<tr id="noData"><td colspan="30" style="border-right:1px solid #ccc">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>'.$this->data['error'].'</strong>
                                      </div>
                                </td></tr>';
                        }
                        $td.='</tbody>';
                $td.='</table>';
                $td.='</div></div>';
            }else{
                $td = self::cabecera(true); //true es para mostrar el caption
                $td.= '<tbody id="'.$this->id.'Body">';
                        /*se verifica si hay data*/
                        if(sizeof($this->data)>0 && !isset($this->data['error'])){
                            if($this->fnData != ''){//se definio una funcion anonima
                                if(is_callable($this->fnData)){//se verifica si es un closure
                                    $call = call_user_func_array($this->fnData,array($this->data));
                                    if($call == false){//si el resultado es false, se generan os registros
                                        $td .= self::registros();
                                    }else{//si hay algun resultado, se reemplaza por algun contenido predeterminado
                                        $td.= $call;
                                    }
                                }else{//se definio closure incorrecto
                                    $td.='<tr id="noData"><td colspan="30">
                                            <div class="alert alert-danger" style="width:100%">                                                                        
                                               <strong><br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].</strong>
                                             </div>
                                       </td></tr>';
                                }
                            }else{//no existe closure definido or el desarrollador, se carga la data
                                $td .= self::registros();
                            }
                        }elseif(sizeof($this->data) == 0){//no hay data
                            $td.='<tr id="noData"><td colspan="30" style="border-right:1px solid #ccc">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>No se encontraron registros</strong>
                                      </div>
                                </td></tr>';
                        }elseif(isset($this->data['error'])){//error en sp
                            $td.='<tr id="noData"><td colspan="30" style="border-right:1px solid #ccc">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>'.$this->data['error'].'</strong>
                                      </div>
                                </td></tr>';
                        }
                        $td.='</tbody>';
                        if($this->foot){
                            $td .= self::cabecera();
                        }
            }
            return $td;
	}

        /*Genera contenido de data grid con el verticalScroll activo*/
        private function contDataScroll(){
            $td = '';
            $td.= '<tbody id="'.$this->id.'Body">';
                    /*se verifica si hay data*/
                    if(sizeof($this->data)>0 && !isset($this->data['error'])){
                        if($this->fnData != ''){//se definio una funcion anonima
                            if(is_callable($this->fnData)){//se verifica si es un closure
                                $call = call_user_func_array($this->fnData,array($this->data));
                                if($call == false){//si el resultado es false, se generan os registros
                                    $td .= self::registrosScroll();
                                }else{//si hay algun resultado, se reemplaza por algun contenido predeterminado
                                    $td.= $call;
                                }
                            }else{//se definio closure incorrecto
                                $td.='<tr id="noData"><td colspan="30">
                                        <div class="alert alert-danger">                                                                        
                                           <strong><br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].</strong>
                                         </div>
                                   </td></tr>';
                            }
                        }else{//no no existe closure definido or el desarrollador, se carga la data
                            $td .= self::registrosScroll();
                        }
                    }elseif(sizeof($this->data) == 0){//no hay data
                        $td.='<tr id="noData"><td>
                                 <div class="alert alert-danger">                                                                        
                                    <strong>No se encontraron registros</strong>
                                  </div>
                            </td></tr>';
                    }elseif(isset($this->data['error'])){//error en sp
                            $td.='<tr id="noData"><td colspan="30" style="border-right:1px solid #ccc">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>'.$this->data['error'].'</strong>
                                      </div>
                                </td></tr>';
                        }
                    $td.='</tbody>';
            return $td;
        }

        /*registros con verticalScroll*/
        private function registrosScroll(){
            $id_t   =   $this->id;
            $a      =	0;
            $f = 0;
            $td = '';
            /*recorrido de la data*/
            foreach($this->data as $row){
                $a++;
                if(isset($row['rownum'])){
                    $a = $row['rownum'];
                }
                $td.='<tr id="tr_'.$id_t.$a.'">';
                /*cuando se ejecuta una funcion en el momento de genearr las celdas*/
                if($this->fnCallbackFilaLastMedium != ''){
                    if(is_callable($this->fnCallbackFilaLastMedium)){
                        $call = call_user_func_array($this->fnCallbackFilaLastMedium,array($a,$row));
                        if($call === false){
                            $f++; //flag para restar $row['rownum'];
                            //no se ejecuta nada
                        }if($call === true){
                            //se ejecuta normalmente
                            /*agregando numeros de registros*/
                            if($this->numeros==true){
                                if($f > 0){
                                    $a -= $f;
                                    $f = 0;
                                }
                                $td.='<th style="width:20px;text-align:center;border-right:1px solid #ccc;border-left:0px">'.$a.'</th>';
                            }
                            /*validar posicion de accion*/
                            if(strtolower($this->posicionAccion) == 'first'){
                                $td.= $this->acciones($row,$a);
                            }
                            /*validar posicion de CheckBox*/
                            if(strtolower($this->posicionCheck) == 'first'){
                                $td.= $this->crearCheckBox($row, $a);
                            }
                            /*validar posicion de radio*/
                            if(strtolower($this->posicionRadio) == 'first'){
                                $td.= $this->crearRadio($row, $a);
                            }

                            /*crear celdas*/
                            $td.= self::creaCelda($row,$this->cols,$a);

                            /*validar posicion de CheckBox*/
                            if(strtolower($this->posicionCheck) == 'last'){
                                $td.= $this->crearCheckBox($row, $a);
                            }
                            /*validar posicion de radio*/
                            if(strtolower($this->posicionRadio) == 'last'){
                                $td.= $this->crearRadio($row, $a);
                            }
                            /*validar posicion de accion*/
                            if(strtolower($this->posicionAccion) == 'last'){
                                $td.= $this->acciones($row,$a);
                            }
                            $td.='</tr>';
                        }else{
                            $td .= $call; //retorna resultado del closure
                        }
                    }else{
                        $td.='<tr id="noData"><td colspan="50">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback], en metodo $Grid->fila().</strong>
                                      </div>
                                </td></tr>';
                    }
                }else{
                    /*agregando numeros de registros*/
                    if($this->numeros==true){
                        $td.='<th style="width:20px;text-align:center;border-right:1px solid #ccc;border-left:0px">'.$a.'</th>';
                    }
                    /*validar posicion de accion*/
                    if(strtolower($this->posicionAccion) == 'first'){
                        $td.= $this->acciones($row,$a);
                    }
                    /*validar posicion de CheckBox*/
                    if(strtolower($this->posicionCheck) == 'first'){
                        $td.= $this->crearCheckBox($row, $a);
                    }
                    /*validar posicion de radio*/
                    if(strtolower($this->posicionRadio) == 'first'){
                        $td.= $this->crearRadio($row, $a);
                    }

                    /*crear celdas*/
                    $td.= self::creaCelda($row,$this->cols,$a);

                    /*validar posicion de CheckBox*/
                    if(strtolower($this->posicionCheck) == 'last'){
                        $td.= $this->crearCheckBox($row, $a);
                    }
                    /*validar posicion de radio*/
                    if(strtolower($this->posicionRadio) == 'last'){
                        $td.= $this->crearRadio($row, $a);
                    }
                    /*validar posicion de accion*/
                    if(strtolower($this->posicionAccion) == 'last'){
                        $td.= $this->acciones($row,$a);
                    }
                    $td.='</tr>';
                }
                /*para ejecutar subconsultas*/
                if($this->fnCallbackSubFila != ''){
                    if(is_callable($this->fnCallbackSubFila)){
                        $td .='<tr>';
                        $call = call_user_func_array($this->fnCallbackSubFila,array($a,$row));
                        if($call === false){
                            //no se ejecuta nada
                        }else{
                            $td .= $call; //retorna resultado del closure
                        }
                        $td .='</tr>';
                    }
                }
            }
            return $td;
        }

        /*registros sin verticalScroll*/
        private function registros($float=''){
            $id_t   =   $this->id;
            $a      =	0;
            $f = 0;
            $td = '';
            /*recorrido de la data*/
            foreach($this->data as $row){
                $a++;
                $td.='<tr id="tr_'.$id_t.$a.'">';
                if(isset($row['rownum'])){
                    $a = $row['rownum'];
                }
                /*cuando se ejecuta una funcion en el momento de genearar las celdas*/
                if($this->fnCallbackFilaLastMedium != ''){

                    if(is_callable($this->fnCallbackFilaLastMedium)){
                        $call = call_user_func_array($this->fnCallbackFilaLastMedium,array($a,$row));
                        if($call === false){
                            $f++; //flag para restar $row['rownum'];
                            //no se ejecuta nada
                        }elseif($call === true){
                            //se ejecuta normalmente
                            /*agregando numeros de registros*/
                            if($this->numeros==true){
                                if(($this->horizontalScroll && $float == 'left') || (!$this->horizontalScroll)){
                                    if($f > 0){
                                        $a -= $f;
                                        $f = 0;
                                    }
                                    $td.='<th style="width:20px;text-align:center;border-right:1px solid #ccc;border-left:0px">'.$a.'</th>';
                                }
                            }
                            /*validar posicion de accion*/
                            if(strtolower($this->posicionAccion) == 'first'){
                                if(($this->horizontalScroll && $float == 'left') || (!$this->horizontalScroll)){
                                    $td.= $this->acciones($row,$a);
                                }
                            }
                            /*validar posicion de CheckBox*/
                            if(strtolower($this->posicionCheck) == 'first'){
                                if(($this->horizontalScroll && $float == 'left') || (!$this->horizontalScroll)){
                                    $td.= $this->crearCheckBox($row, $a);
                                }
                            }
                            /*validar posicion de radio*/
                            if(strtolower($this->posicionRadio) == 'first'){
                                if(($this->horizontalScroll && $float == 'left') || (!$this->horizontalScroll)){
                                    $td.= $this->crearRadio($row, $a);
                                }
                            }
                            /*crear celdas*/
                            $td.= self::creaCelda($row,$this->cols,$a,$float);

                            /*validar posicion de CheckBox*/
                            if(strtolower($this->posicionCheck) == 'last'){
                                if(($this->horizontalScroll && $float == 'right') || (!$this->horizontalScroll)){
                                    $td.= $this->crearCheckBox($row, $a);
                                }
                            }
                            /*validar posicion de radio*/
                            if(strtolower($this->posicionRadio) == 'last'){
                                if(($this->horizontalScroll && $float == 'right') || (!$this->horizontalScroll)){
                                    $td.= $this->crearRadio($row, $a);
                                }
                            }
                            /*validar posicion de accion*/
                            if(strtolower($this->posicionAccion) == 'last'){
                                if(($this->horizontalScroll && $float == 'right') || (!$this->horizontalScroll)){
                                    $td.= $this->acciones($row,$a);
                                }
                            }
                            $td.='</tr>';
                        }else{
                            $td .= $call; //retorna resultado del closure
                        }
                    }else{
                        $td.='<td colspan="50">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback], en metodo $Grid->fila().</strong>
                                      </div>
                                </td></tr>';
                    }
                }else{
                    /*agregando numeros de registros*/
                    if($this->numeros==true){
                        if(($this->horizontalScroll && $float == 'left') || (!$this->horizontalScroll)){
                            $td.='<th style="width:20px;text-align:center;border-right:1px solid #ccc;border-left:0px">'.$a.'</th>';
                        }
                    }
                    /*validar posicion de accion*/
                    if(strtolower($this->posicionAccion) == 'first'){
                        if(($this->horizontalScroll && $float == 'left') || (!$this->horizontalScroll)){
                            $td.= $this->acciones($row,$a);
                        }
                    }
                    /*validar posicion de CheckBox*/
                    if(strtolower($this->posicionCheck) == 'first'){
                        if(($this->horizontalScroll && $float == 'left') || (!$this->horizontalScroll)){
                            $td.= $this->crearCheckBox($row, $a);
                        }
                    }
                    /*validar posicion de radio*/
                    if(strtolower($this->posicionRadio) == 'first'){
                        if(($this->horizontalScroll && $float == 'left') || (!$this->horizontalScroll)){
                            $td.= $this->crearRadio($row, $a);
                        }
                    }
                    /*crear celdas*/
                    $td.= self::creaCelda($row,$this->cols,$a,$float);

                    /*validar posicion de CheckBox*/
                    if(strtolower($this->posicionCheck) == 'last'){
                        if(($this->horizontalScroll && $float == 'right') || (!$this->horizontalScroll)){
                            $td.= $this->crearCheckBox($row, $a);
                        }
                    }
                    /*validar posicion de radio*/
                    if(strtolower($this->posicionRadio) == 'last'){
                        if(($this->horizontalScroll && $float == 'right') || (!$this->horizontalScroll)){
                            $td.= $this->crearRadio($row, $a);
                        }
                    }
                    /*validar posicion de accion*/
                    if(strtolower($this->posicionAccion) == 'last'){
                        if(($this->horizontalScroll && $float == 'right') || (!$this->horizontalScroll)){
                            $td.= $this->acciones($row,$a);
                        }
                    }
                    $td.='</tr>';
                }
                /*para ejecutar subconsultas*/
                if($this->fnCallbackSubFila != ''){
                    if(is_callable($this->fnCallbackSubFila)){
                        $td .='<tr>';
                        $call = call_user_func_array($this->fnCallbackSubFila,array($a,$row));
                        if($call === false){
                            //no se ejecuta nada
                        }else{
                            $td .= $call; //retorna resultado del closure
                        }
                        $td .='</tr>';
                    }
                }
            }
            /*si scroll esta inactivo muestro ultima fila dentro de la misma tabla*/
            if(!$this->scroll){
                /*verificar si se insertara fila al final*/
                if($this->fnCallbackFilaLast != ''){
                    if(is_callable($this->fnCallbackFilaLast)){
                        $call = call_user_func_array($this->fnCallbackFilaLast,array($this->data));
                        if($call == false){
                            //no se ejecuta nada
                        }else{
                            $td .= $call; //retorna resultado del closure
                        }
                    }else{
                        $td.='<tr id="noData"><td colspan="50">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback], en metodo $Grid->fila().</strong>
                                      </div>
                                </td></tr>';
                    }
                }
            }
            return $td;
        }

        /*registros sin verticalScroll*/
        private function registrosExportar(){
            $a      =	0;
            $td = '';
            /*recorrido de la data*/
            foreach($this->dataDocs as $row){
                $a++;
                $td.='<tr>
                        <td>'.$a.'</td>';
                /*crear celdas*/
                $td.= self::creaCelda($row,$this->cols,$a);
                $td.='</tr>';
            }
            /*si scroll esta inactivo muestro ultima fila dentro de la misma tabla*/
            if(!$this->scroll){
                /*verificar si se insertara fila al final*/
                if($this->fnCallbackFilaLast != ''){
                    if(is_callable($this->fnCallbackFilaLast)){
                        $call = call_user_func_array($this->fnCallbackFilaLast,array($this->data));
                        if($call == false){
                            //no se ejecuta nada
                        }else{
                            $td .= $call; //retorna resultado del closure
                        }
                    }else{
                        $td.='<tr id="noData"><td colspan="50">
                                     <div class="alert alert-danger">                                                                        
                                        <strong>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback], en metodo $Grid->fila().</strong>
                                      </div>
                                </td></tr>';
                    }
                }
            }
            return $td;
        }
        
        /*crear las celdas del grid*/
        private function creaCelda($row,$cols,$a,$float=''){
            $td = '';
            $lenCols = sizeof($cols) - 1;
            $nCol = 0;
            foreach ($cols as $key=>$col) {
                /*validar q existan sus propiedades*/
                $type   = isset($col['type'])?strtolower($col['type']):'string';
                $campo  = isset($col['campo'])?$col['campo']:'';
                $editar = isset($col['editar'])?$col['editar']:false;
                $width  = isset($col['width'])?$col['width']:'';
                $bgColor= isset($col['bgColor'])?' background:'.$col['bgColor'].';':'';
                $length = isset($col['length'])?$col['length']:0;
                $align  = isset($col['align'])?$col['align']:false;
                $xajax  = isset($col['xajax'])?$col['xajax']:'0';
                $labels = isset($col['labels'])?$col['labels']:'';
                $badges = isset($col['badges'])?$col['badges']:'';
                $ruta   = isset($col['ruta'])?$col['ruta']:'';
                $ancho  = isset($col['ancho'])?'width="'.$col['ancho'].'"':'';
                $alto   = isset($col['alto'])?'height="'.$col['alto'].'"':'';
                $closure= isset($col['fnCallback'])?$col['fnCallback']:'';
                $subFila= isset($col['subFila'])?$col['subFila']:'0';
                
                if(is_array($subFila) && $subFila != '0'){
                    $td.= self::creaCelda($row,$subFila,$a);
                }else{
                    $cadena = '';
                    $back   = '';
                    switch ($type) {
                        case 'string':
                            if($campo != ''){/*si no tiene campo no hace nada*/
                                /*verificar si campos es array*/
                                if(is_array($campo)){
                                    foreach ($campo as $kampo) {
                                        $cadena .= $row[$kampo].' ';
                                    }
                                }else{
                                    $cadena = $row[$campo];
                                }
                                /*validar si cadena se cortara, si no tiene length no se ejecuta*/
                                if($length > 0){
                                    if(strlen($cadena) > $length){
                                        $cadena = substr($cadena,0,$length).'...';
                                    }
                                }
                                /*verificar si tendra algun evento, si no tiene evento no se ejecuta*/
                                if($xajax != '0'){
                                    $onc = $xajax['fn']; 
                                    /*verificar si existe flag*/
                                    $flag = isset($xajax['parametros']['flag'])?"'".$xajax['parametros']['flag']."',":'';
                                    /*verificar si existe formulario*/
                                    $form = isset($xajax['parametros']['form'])?"xajax.getFormValues('".$xajax['parametros']['form']."'),":'';
                                    if($a%2 == 0){//coloreado de campo con link
                                        $back = 'background-color:#F2F3FF;';
                                    }else{
                                        $back = 'background-color:#F9F9FF;';
                                    } 
                                    /*verificar si campos es array o no*/
                                    $campos = '';
                                    $arrCampos = (isset($xajax['parametros']['campos']))?$xajax['parametros']['campos']:'';
                                    if($arrCampos != ''){
                                        if(isset($arrCampos) && is_array($arrCampos)){
                                            foreach ($arrCampos as $value) {
                                                $campos .= "'".$row[$value]."',";//se cargan los campos definidos, es un array
                                            }
                                        }else{
                                            $campos = "'".$row[$arrCampos]."',";//se carga campo, no es array
                                        }
                                    }
                                    $allParametros = $flag.$campos.$form;
                                    /*eliminando ultima coma*/
                                    $allParametros = substr_replace( $allParametros, "", -1 );
                                    $onc .= '('.$allParametros.');';

                                    /*verificar si existe mensaje antes de ejecutar evento js*/
                                    $onclick = $onc;
                                    if(isset($xajax['msn'])){
                                       $onclick = "if(confirm('".$xajax['msn']."')){
                                                        ".$onc."
                                                   }"; 
                                    }
                                    $cadena = '<a href="javascript:void(0)" onclick="'.$onclick.'">'.$cadena.'</a>';
                                }
                            }else{
                                $cadena = 'ERROR: [campo] no definido.';
                            }
                            break;
                        case 'number':
                            if($campo != ''){/*si no tiene campo no hace nada*/
                                /*verificar si campos es array*/
                                if(is_array($campo)){
                                    foreach ($campo as $kampo) {
                                        if(is_numeric($row[$kampo])){
                                            $cadena .= number_format($row[$kampo],2).' ';//se cargan los campos definidos, es un array
                                        }else{
                                            $cadena.='<b style="color:red">ERROR: Dato no es un n&uacute;mero.</b>';
                                        }
                                    }
                                }else{
                                    if(is_numeric($row[$campo])){
                                        $cadena = number_format($row[$campo],2);//se carga campo, no es array
                                    }else{
                                        $cadena.='<b style="color:red">ERROR: Dato no es un n&uacute;mero.</b>';
                                    }
                                }
                                /*verificar si tendra algun evento*/
                                if($xajax != '0'){
                                    $onc = $xajax['fn']; 
                                    /*verificar si existe flag*/
                                    $flag = isset($xajax['parametros']['flag'])?"'".$xajax['parametros']['flag']."',":'';
                                    /*verificar si existe formulario*/
                                    $form = isset($xajax['parametros']['form'])?"xajax.getFormValues('".$xajax['parametros']['form']."'),":'';
                                    if($a%2 == 0){//coloreado de campo con link
                                        $back = 'background-color:#F2F3FF;';
                                    }else{
                                        $back = 'background-color:#F9F9FF;';
                                    } 
                                    /*verificar si campos es array o no*/
                                    $campos = '';
                                    $arrCampos = (isset($xajax['parametros']['campos']))?$xajax['parametros']['campos']:'';
                                    if($arrCampos != ''){
                                        if(isset($arrCampos) && is_array($arrCampos)){
                                            foreach ($arrCampos as $value) {
                                                $campos .= "'".$row[$value]."',";
                                            }
                                        }else{
                                            $campos = "'".$row[$arrCampos]."',";
                                        }
                                    }
                                    $allParametros = $flag.$campos.$form;
                                    /*eliminando ultima coma*/
                                    $allParametros = substr_replace( $allParametros, "", -1 );
                                    $onc .= '('.$allParametros.');';

                                    /*verificar si existe mensaje antes de ejecutar evento js*/
                                    $onclick = $onc;
                                    if(isset($xajax['msn'])){
                                       $onclick = "if(confirm('".$xajax['msn']."')){
                                                        ".$onc."
                                                   }"; 
                                    }
                                    $cadena = '<a href="javascript:void(0)" onclick="'.$onclick.'">'.number_format($cadena,2).'</a>';
                                }
                            }else{
                                $cadena = 'ERROR: [campo] no definido.';
                            }
                            break;
                        case 'label':
                            if(is_array($labels)){
                                foreach ($labels as $kk=>$vv){                                                 
                                    if(strtolower($row[$campo]) == strtolower($kk)){
                                        $cadena = '<span class="label '.$vv.'" >'.$row[$campo].'</span>';
                                    }
                                }
                            }else{//si no es array recibe el nombre de la clase para el label
                                $cadena = '<span class="label '.$labels.'" >'.$row[$campo].'</span>';
                            }
                            break;
                        case 'badge':
                            if(is_array($badges)){
                                foreach ($badges as $kk=>$vv){                                                 
                                    if(strtolower($row[$campo]) == strtolower($kk)){
                                        $cadena = '<span class="badge '.$vv.'" >'.$row[$campo].'</span>';
                                    }
                                }
                            }else{//si no es array recibe el nombre de la clase para el label
                                $cadena = '<span class="badge '.$badges.'" >'.$row[$campo].'</span>';
                            }
                            break;
                        case 'img':
                            $cadena = '<img src="'.$ruta.$row[$campo].'" '.$ancho.' '.$alto.'>';
                            break;
                        default:
                            $cadena = 'ERROR: Ha sucedido algun error con el parametro [type] de columna';
                            break;
                    }
                
                    $keyEdit = '';
                    /*verificar si es editable*/                    
                    if(is_array($editar)){
                        $nCol++;
                        $e = self::editCelda($editar,$row,$a,$campo,$nCol);
                        $keyEdit = $e[0];
                        $cadena  = $e[1];
                    }
                    
                    /*verificar si tiene alguna funcion a ejecutar*/
                    if($closure != ''){//se definio una funcion anonima
                        if(is_callable($closure)){//se verifica si es un closure
                            $call = call_user_func_array($closure,array($row,$a));
                            if($call == false){
                                $cadena = $cadena; //no se ejecuta nada, retorna valor normal
                            }else{
                                $cadena = $call; //retorna resultado del closure
                            }
                        }else{
                            $cadena = '<br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].';
                        }
                    }
                    /*border de ultima columna*/
                    $bordertTd = '1';
                    /*validar ancho de ultima columna cuando se activa el verticalScroll*/
                    if($this->verticalScroll && $lenCols == $key && strtolower($this->posicionRadio) == 'first' && strtolower($this->posicionCheck) == 'first' && strtolower($this->posicionAccion) == 'first'){
                        $bordertTd = '0';
                    }
                    $selCheck = '';
                    if($this->check && $this->clickTdCheckBox){
                        $selCheck = 'onclick="if($(\'#rd_'.$this->id.$a.'\').is(\':checked\')){
                                                $(\'#rd_'.$this->id.$a.'\').attr(\'checked\',false);
                                              }else{
                                                $(\'#rd_'.$this->id.$a.'\').attr(\'checked\',true);
                                              }"';
                    }
                    if($this->horizontalScroll){/*scroll horizontal activo*/
                        if($float == 'left'){/*mostrar columnas fijas -- height:25px;*/
                            if($key < $this->piloteColumnScroll){                                
                                $td.='<td '.$selCheck.' style="'.$bgColor.$back.'text-align:'.$align.';vertical-align:middle;width:'.$width.'px;border-left:0px;border-right:1px solid #ccc;-webkit-border-radius: 0px;-moz-border-radius: 0px;border-radius:0px;">';
                                $td.=   $keyEdit.$cadena;
                                $td.='</td>';
                            }
                        }elseif($float == 'right'){/*mostrar columnas no fijas*/
                            if($key >= $this->piloteColumnScroll){
                                $bordertTd = 1;
                                if($key == (sizeof($cols) - 1)){/*se quita borde a la ultima columna -- height:25px;*/
                                    $bordertTd = 0;
                                }
                                $td.='<td '.$selCheck.' style="'.$bgColor.$back.'text-align:'.$align.';vertical-align:middle;width:'.$width.'px;border-left:0px;border-right:'.$bordertTd.'px solid #ccc;">';
                                $td.=   $keyEdit.$cadena;
                                $td.='</td>';
                            }
                        }
                    }else{/*scroll horizontal inactivo -- height:25px;*/
                        $td.='<td '.$selCheck.' style="'.$bgColor.$back.'text-align:'.$align.';vertical-align:middle;width:'.$width.'px;border-left:0px;border-right:1px solid #ccc;">';
                        $td.=   $keyEdit.$cadena;
                        $td.='</td>';
                    }
                }
            }
            return $td;
        }
        
        private function editCelda($editar,$row,$a,$campo,$nCol){
            if($this->key == ''){ 
                $keyEdit = 'ERROR: No existe key, asigne un key para editar celdas => $Grid->keyEdit("campoKey");'; 
            }else{
                if($nCol == 1){//solo se mostrara para la primera columna, no es necesario para todas, este es la clave primaria para editar las celdas editables
                    $keyEdit = '<input type="hidden" id="txtKey'.$this->key.$a.'" name="txtKey'.$this->key.'[]" value="'.$row[$this->key].'"/>';
                }else{
                    $keyEdit = '';
                }
            }
            $type  = $editar['type'];
            $clase = (isset($editar['claseEdicion']))?$editar['claseEdicion']:'';            
            $fnCallback = (isset($editar['fnCallback']))?$editar['fnCallback']:'';
            switch($type){
                case "text":
                    if($clase == 'inLoad'){//se activa edicion al cargar la data
                        if($fnCallback != ''){//se definio una funcion anonima
                            if(is_callable($fnCallback)){//se verifica si es un closure
                                $call = call_user_func_array($fnCallback,array($row,$a));
                                if($call == false){
                                    $cadena = $cadena; //no se ejecuta nada, retorna valor normal
                                }else{
                                    $cadena = $call; //retorna resultado del closure
                                } 
                            }else{
                                $cadena = '<br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].';
                            }
                        }else{//no se definio una funcion
                            $cadena = '<input type="text" id="txt_'.$campo.$a.'" name="txt_'.$campo.'[]" value="'.$row[$campo].'"  style="width:85%;" />';
                        }
                    }elseif($clase == 'outLoad'){//se actica edicion con una accion AUN NO TERMINADA
                        $cadena = '<div id="d_escritura_'.$this->id.$campo.$a.'" style="display:none">
                                    <input type="text" id="txt_'.$campo.$a.'" name="txt_'.$campo.'[]" value="'.$row[$campo].'"  style="width:85%;" />
                                   </div>
                                   <div id="d_lectura_'.$this->id.$campo.$a.'">
                                       '.$row[$campo].'
                                   </div>';
                    }else{
                        $cadena = '<br>ERROR: [claseEdicion] incorrecto.<br>Indique clase de edición: outLoad / inLoad ';
                    }
                    break;
                case "checkbox":
                    if($fnCallback != ''){//se definio una funcion anonima
                        if(is_callable($fnCallback)){//se verifica si es un closure
                            $call = call_user_func_array($fnCallback,array($row,$a));
                            if($call == false){
                                $cadena = $cadena; //no se ejecuta nada, retorna valor normal
                            }else{
                                $cadena = $call; //retorna resultado del closure
                            } 
                        }else{
                            $cadena = '<br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].';
                        }
                    }else{//no se definio una funcion
                        $cadena = '<input type="checkbox" id="txt_'.$campo.$a.'" name="txt_'.$campo.'[]" value="'.$row[$campo].'" style="margin:0px"/>';
                    }
                    break;
                case "radio":
                    if($fnCallback != ''){//se definio una funcion anonima
                        if(is_callable($fnCallback)){//se verifica si es un closure
                            $call = call_user_func_array($fnCallback,array($row,$a));
                            if($call == false){
                                $cadena = $cadena; //no se ejecuta nada, retorna valor normal
                            }else{
                                $cadena = $call; //retorna resultado del closure
                            }
                        }else{
                            $cadena = '<br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].';
                        }
                    }else{//no se definio una funcion
                        $cadena = '<input type="radio" id="txt_'.$campo.$a.'" name="txt_'.$campo.'[]" value="'.$row[$campo].'"/>';
                    }
                    break;
                case "select":
                    if($fnCallback != '' && is_callable($fnCallback)){
                        $call = call_user_func_array($fnCallback,array($row,$a));
                        if($call == false){
                            $cadena = $cadena; //no se ejecuta nada, retorna valor normal
                        }else{
                            $cadena = $call; //retorna resultado del closure
                        }
                    }else{
                        $cadena = '<br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].';
                    }
                    break;
                case "textarea":
                    if($clase == 'inLoad'){//se activa edicion al cargar la data
                        if($fnCallback != ''){//se definio una funcion anonima
                            if(is_callable($fnCallback)){//se verifica si es un closure
                                $call = call_user_func_array($fnCallback,array($row,$a));
                                if($call == false){
                                    $cadena = $cadena; //no se ejecuta nada, retorna valor normal
                                }else{
                                    $cadena = $call; //retorna resultado del closure
                                }
                            }else{
                                $cadena = '<br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].';
                            }
                        }else{//no se definio una funcion
                            $cadena = '<textarea id="txt_'.$campo.$a.'" name="txt_'.$campo.'[]">'.$row[$campo].'</textarea>';
                        }
                    }elseif($clase == 'outLoad'){//se actica edicion con una accion AUN NO TERMINADA
                        $cadena = '[EN CONSTRUCCION]';
                    }else{
                        $cadena = '<br>ERROR: [claseEdicion] incorrecto.<br>Indique clase de edición: outLoad / inLoad ';
                    }
                    break;
                default:
                    $cadena = '<br>ERROR: [type] incorrecto, defina un tipo de elemento.';
                    break;
            }                
            return array($keyEdit,$cadena);
        }
        
        /*Crea cabecera de tabla*/
        private function cabecera($foot=false,$float=''){
            $id_t   = $this->id;
            $result='<thead>';
                if($this->caption!="" && $foot && !$this->horizontalScroll){//en el footer no se muestra
                    $result.='<tr><th colspan="70" style="text-align:center">'.$this->caption.'</th></tr>';
                }                    
             $result.=' <tr>';      
                        /*agregando numeros de registros*/                        
                        if($this->numeros==true){
                            if($this->horizontalScroll && $float == 'left'){
                                $result.='<th style="width:20px;vertical-align:middle;text-align:center" rowspan="5">Nro</th>';
                            }
                            if(!$this->horizontalScroll){
                                $result.='<th style="width:20px;vertical-align:middle;text-align:center" rowspan="5">Nro</th>';
                            }
                        }
                        /*validar posicion de accion*/
                        if(strtolower($this->posicionAccion) == 'first'){
                            /*si hay acciones agrego titulo*/
                            $accx = 'Acciones';
                            if($this->siaccion==true){
                                /*validar ancho de th accion segun numero de acciones*/
                                switch(sizeof($this->axion)){
                                    case 1: $wa = 40;$accx='Ac.'; break;
                                    case 2: $wa = 59; break;
                                    case 3: $wa = 92; break;
                                    case 4: $wa = 125; break;
                                    case 5: $wa = 160; break;
                                    default: $wa = 160; break;
                                }
                                /*verificar si no se configuro label para accion*/
                                if($this->labelAccion != ''){
                                    $accx = $this->labelAccion;
                                }
                                /*se muestra acciones cuando existe horizontalscroll y en el lado izquierdo o cuando no existe horizontalscroll*/
                                if(($this->horizontalScroll && $float == 'left') || (!$this->horizontalScroll)){
                                    $result.='<th style="width:'.$wa.'px;text-align:center;vertical-align:middle;" colspan="'.  sizeof($this->axion).'" rowspan="5">
                                            '.$accx.'
                                          </th>';
                                }
                            }     
                        }
                        /*validar posicion de check*/
                        if(strtolower($this->posicionCheck) == 'first'){
                            if($this->check == true){
                                /*aqui se checkbox del head*/
                                $chk ='<th style="width:20px;text-align:center;vertical-align:middle" rowspan="5">
                                            <input name="rd_'.$id_t.'" id="rd_'.$id_t.'" type="checkbox" style="margin:0px" '.$this->checked.' onclick="
                                                if($(this).is(\':checked\')){
                                                    $(\'#'.$id_t.' tbody tr\').each(function(){       
                                                        if($(this).find(\':checkbox\').attr(\'disabled\')!==\'disabled\'){
                                                            $(this).find(\':checkbox\').attr(\'checked\',true);    
                                                        }
                                                    });
                                                }else{
                                                    $(\'#'.$id_t.' tbody tr\').each(function(){    
                                                        if($(this).find(\':checkbox\').attr(\'disabled\')!==\'disabled\'){
                                                            $(this).find(\':checkbox\').attr(\'checked\',false);     
                                                        }
                                                    });
                                                }    "/>
                                      </th>';
                                /*se muestra check cuando existe horizontalscroll y en el lado izquierdo o cuando no existe horizontalscroll*/
                                if(($this->horizontalScroll && $float == 'left') || (!$this->horizontalScroll)){
                                    $result.= $chk;
                                }                                
                            }
                        }
                        /*validar posicion de radio*/
                        if(strtolower($this->posicionRadio) == 'first'){
                            if($this->radio == true){
                                /*se muestra radio cuando existe horizontalscroll y en el lado izquierdo o cuando no existe horizontalscroll*/
                                if(($this->horizontalScroll && $float == 'left') || (!$this->horizontalScroll)){
                                    $result.='<th style="width:1%;text-align:center" rowspan="5">
                                            <button class="btn" type="button" onclick="
                                                    $(\'#'.$this->id.' tbody\').find(\'tr\').find(\':radio\').each(function(){
                                                        $(this).attr(\'checked\',false);
                                                    });
                                                " title="Limpiar" >#</button>
                                        </th>';
                                } 
                            }
                        }
                        //muestra cabecera nivel 1
                        $h = self::cabeceraPrincipal($this->cols,$float);
                        
                        $result .= $h[0];
                        /*validar posicion de check*/
                        if(strtolower($this->posicionCheck) == 'last'){
                            if($this->check == true){
                                $w = '20px';
                                /*si radio es ultimo se le suma lo 16 del verticalScroll*/
//                                if(strtolower($this->posicionRadio) == 'first' && strtolower($this->posicionAccion) == 'first'){
//                                    $w = '36px';
//                                }
                                /*se muestra check cuando existe horizontalscroll y en el lado derecho o cuando no existe horizontalscroll*/
                                if(($this->horizontalScroll && $float == 'right') || (!$this->horizontalScroll)){
                                    /*aqui se checkbox del head*/
                                    $result.='<th style="width:'.$w.';text-align:center;vertical-align:middle" rowspan="5">
                                                <input name="rd_'.$id_t.'" id="rd_'.$id_t.'" type="checkbox" '.$this->checked.' onclick="
                                                    if($(this).is(\':checked\')){
                                                        $(\'#'.$id_t.' tbody tr\').each(function(){       
                                                            if($(this).find(\':checkbox\').attr(\'disabled\')!==\'disabled\'){
                                                                $(this).find(\':checkbox\').attr(\'checked\',true);    
                                                            }
                                                        });
                                                    }else{
                                                        $(\'#'.$id_t.' tbody tr\').each(function(){    
                                                            if($(this).find(\':checkbox\').attr(\'disabled\')!==\'disabled\'){
                                                                $(this).find(\':checkbox\').attr(\'checked\',false);     
                                                            }
                                                        });
                                                    }    "/>
                                          </th>';
                                }
                            }
                        }
                        /*validar posicion de radio*/
                        if(strtolower($this->posicionRadio) == 'last'){
                            if($this->radio == true){
                                $w = '25px';
                                /*si radio es ultimo se le suma lo 16 del verticalScroll*/
//                                if(strtolower($this->posicionAccion) == 'first'){
//                                    $w = '36px';
//                                }
                                /*se muestra radio cuando existe horizontalscroll y en el lado derecho o cuando no existe horizontalscroll*/
                                if(($this->horizontalScroll && $float == 'right') || (!$this->horizontalScroll)){
                                    $result.='<th style="width:'.$w.';text-align:center" rowspan="5">
                                                <button class="btn" type="button" onclick="
                                                        $(\'#'.$this->id.' tbody\').find(\'tr\').find(\':radio\').each(function(){
                                                            $(this).attr(\'checked\',false);
                                                        });
                                                    " title="Limpiar" >#</button>
                                            </th>';
                                }
                            }
                        }
                        /*validar posicion de accion*/
                        if(strtolower($this->posicionAccion) == 'last'){
                            /*si hay acciones agrego titulo*/
                            $accx = 'Acciones';
                            if($this->siaccion==true){
                                /*validar ancho de th accion segun numero de acciones*/
                                switch(sizeof($this->axion)){
                                    case 1: $wa = 40;$accx='Ac.'; break;
                                    case 2: $wa = 59; break;
                                    case 3: $wa = 92; break;
                                    case 4: $wa = 125; break;
                                    case 5: $wa = 160; break;
                                    default: $wa = 160; break;
                                }
                                /*verificar si no se configuro label para accion*/
                                if($this->labelAccion != ''){
                                    $accx = $this->labelAccion;
                                }
                                /*se muestra check cuando existe horizontalscroll y en el lado derecho o cuando no existe horizontalscroll*/
                                if(($this->horizontalScroll && $float == 'right') || (!$this->horizontalScroll)){
                                    $result.='<th style="width:'.$wa.'px;text-align:center;vertical-align:middle;" colspan="'.  sizeof($this->axion).'" rowspan="5">
                                            '.$accx.'
                                          </th>';
                                }
                            }     
                        }
              $result.='</tr>';
              $result .= $h[1];
              $result.='
                 </thead>';
              return $result;
        }
        
        private function cabeceraPrincipal($cols,$float=''){
            $result  = '';
            $result2 = '';
            $lenCols = sizeof($cols) - 1;
            foreach ($cols as $key=>$col) {
                /*validar q sus propiedades existan*/
                $titulo = isset($col['titulo'])?$col['titulo']:'Titulo';
                $width  = isset($col['width'])?$col['width']:'';
                $align  = isset($col['align'])?$col['align']:false;
                $subFila= isset($col['subFila'])?$col['subFila']:'0';

                /*verificar si contiene subniveles y obtener colspan*/
                $colspan = '';
                $rowspan = '';
                if(is_array($subFila) && $subFila != '0'){
                    $colspan = ' colspan="'.sizeof($subFila).'" ';
                    $rowspan = 'rowspan="2"';                    
                }
                /*validar ancho de ultima columna cuando se activa el verticalScroll*/
//                if($this->verticalScroll && $lenCols == $key && strtolower($this->posicionRadio) == 'first' && strtolower($this->posicionCheck) == 'first' && strtolower($this->posicionAccion) == 'first'){
//                    $width = $width + 9;// se le suma el ancho de la barra verticalScroll que es 15
//                }
                if($this->horizontalScroll){/*scroll horizontal activo*/
                    $radius = '';
                    if($float == 'left'){
                        /*mostrar solo los menores a piloteScroll, cabeceras fijas*/
                        if($key < $this->piloteColumnScroll){
                            if($key == ($this->piloteColumnScroll - 1)){
                                $radius = '-webkit-border-radius: 0px;
                                            -moz-border-radius: 0px;
                                            border-radius: 0px;';
                            }
                            $result.='<th '.$colspan.' style="'.$radius.'width:'.$width.'px;text-align:center;vertical-align:middle" '.$rowspan.' >
                                '.$titulo.'</th>';
                        }
                    }elseif($float == 'right'){
                        /*mostrar cabecera no fija*/
                        if($key >= $this->piloteColumnScroll){
                            if($key == $this->piloteColumnScroll){
                                $radius = '-webkit-border-radius: 0px;
                                            -moz-border-radius: 0px;
                                            border-radius: 0px;';
                            }
                            $result.='<th '.$colspan.' style="'.$radius.'width:'.$width.'px;text-align:center;vertical-align:middle" '.$rowspan.' >
                                '.$titulo.'</th>';
                        }
                    }
                }else{
                    $result.='<th '.$colspan.' style="width:'.$width.'px;text-align:center;vertical-align:middle" '.$rowspan.' >
                        '.$titulo.'</th>';
                }
            }
            
            $result2.= '<tr>';
           //muestra cabecera nivel 2
            foreach ($cols as $colx) {
                if(isset($colx['subFila'])){
                    $lenCols = sizeof($colx['subFila']) - 1;
                    foreach ($colx['subFila'] as $key=>$jcol) {
                        /*validar q sus propiedades existan*/
                        $titulo = isset($jcol['titulo'])?$jcol['titulo']:'Titulo';
                        $width  = isset($jcol['width'])?$jcol['width']:'';
                        $align  = isset($jcol['align'])?$jcol['align']:false;
                        $subFila= isset($jcol['subFila'])?$jcol['subFila']:'0';
                       
                         /*verificar si contiene subniveles*/
                        if(is_array($subFila) && $subFila != '0'){
//                            foreach ($subFila as $ycol) { 
//                                $result .= self::cabeceraSecundaria($ycol);
//                            }
                        }else{
                            /*validar ancho de ultima columna cuando se activa el verticalScroll-- si cuadra bien sin estos 15 px....va!*/
//                            if($this->verticalScroll && $lenCols == $key && strtolower($this->posicionRadio) == 'first' && strtolower($this->posicionCheck) == 'first' && strtolower($this->posicionAccion) == 'first'){
//                                $width = $width + 15;// se le suma el ancho de la barra verticalScroll que es 15
//                            }
                            $result2.='<th style="width:'.$width.'px;text-align:center;vertical-align:middle"  >'.$titulo.'</th>';
                        }
                    }
                }
            }
            $result2.= '</tr>';
            return array($result,$result2);
        }
       
        /*genera las acciones*/
        private function acciones($row,$a){
            $td = '';
            /*valido acciones &nbsp;*/
            if($this->siaccion==true){
                $td=	'';
                /*recorrido acciones*/
                foreach($this->axion as $ax){
                    $onclick='';
                    $fnCallback = isset($ax['fnCallback'])?$ax['fnCallback']:'';
                    $idAcc= isset($ax['id'])? $ax['id'].$a:'';
                    $titulo= isset($ax['titulo'])?$ax['titulo']:'';
                    $icono= isset($ax['icono'])?$ax['icono']:'';
                    /*se verifica si se definio xajax*/
                    if(isset($ax['xajax'])){
                        $onc = $ax['xajax']['fn'];  
                        /*verificar si existe flag*/
                        $flag = isset($ax['xajax']['parametros']['flag'])?"'".$ax['xajax']['parametros']['flag']."',":'';
                        /*verificar si existe formulario*/
                        $form = isset($ax['xajax']['parametros']['form'])?"xajax.getFormValues('".$ax['xajax']['parametros']['form']."'),":'';
                        /*verificar si campos es array o no*/
                        $campos = '';
                        $arrCampos = (isset($ax['xajax']['parametros']['campos']))?$ax['xajax']['parametros']['campos']:'';
                        if($arrCampos != ''){
                            if(isset($arrCampos) && is_array($arrCampos)){
                                foreach ($arrCampos as $value) {
                                    $campos .= "'".$row[$value]."',";
                                }
                            }else{
                                $campos = "'".$row[$arrCampos]."',";
                            }
                        }
                        /*verificar si xcampos es array o no*/
                        $xcampos = '';
                        $arrxCampos = isset($ax['xajax']['parametros']['xcampos'])?$ax['xajax']['parametros']['xcampos']:'';
                        if($arrxCampos != ''){
                            if(isset($arrxCampos) && is_array($arrxCampos)){
                                foreach ($arrxCampos as $value) {
                                    if($value != ''){
                                        $xcampos .= $value.",";
                                    }else{
                                        $xcampos .= "'',";
                                    }
                                }
                            }else{
                                $xcampos = $arrxCampos.",";
                            }
                        }
                        $allParametros = $flag.$campos.$xcampos.$form;
                        /*eliminando ultima coma*/
                        $allParametros = substr_replace( $allParametros, "", -1 );
                        $onc .= '('.$allParametros.');';

                        /*verificar si existe mensaje antes de ejecutar evento js*/
                        $onclick = $onc;
                        if(isset($ax['xajax']['msn'])){
                           $onclick = "if(confirm('".$ax['xajax']['msn']."')){".$onc."}"; 
                        }
                    }
                    $wa = '25';
                    if(sizeof($this->axion) == 1){
                        $wa = '40';//para una sola accion 
                    }
                    /*========================PARA AGREGAR ONCLICK MEDIANTE JQUERY===================*/
                    $errorID = '';
                    $evtOnclick = 'onclick="'.$onclick.'"';//se ejecuta sin jquery
                    if($this->jqClick){
                        $evtOnclick = '';//vacio porq se cargara mediante jquery
                        /*se verifica si ID se definio*/
                        if($idAcc == ''){
                            $errorID = 'ERROR: [id] no definido, defina [id] para agregar eventos onclick mediante JQUERY.';
                        }else{
                            $onclick = str_replace("'","\'",$onclick);
                            $this->scriptClick .="
                                $('#".$idAcc."').off('click');
                                $('#".$idAcc."').on({
                                    click:function(){
                                        eval('".$onclick."');
                                    }
                                });
                            "; //se carga el script jquery q cargara los onclick de las acciones
                        }
                    }
                    $idaxx = ($idAcc != '')?' id="'.$idAcc.'" ':'';
                    $accionlink = '<a '.$idaxx.'  title="'.$titulo.'" href=javascript:void(0) style="text-decoration:none; color:black" 
                                       '.$evtOnclick.' >
                                        <i class="'.$icono.'" style="width:18px;height:18px;"></i>'.$errorID.'
                                    </a> ';
                    /*===================================validar si existe closure==============================================*/
                    if($fnCallback != ''){//se definio una funcion anonima
                        if(is_callable($fnCallback)){//se verifica si es un closure
                            $call = call_user_func_array($fnCallback,array($row,$a));
                            if($call == false){//si resultado es false se carga data normalmente
                                $accionlink = $accionlink; //resultado normal
                            }else{
                                $accionlink = $call; //resultado de closure
                            }
                        }else{
                            $accionlink = '<br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].';
                        }
                    }
                    /*===============================FIN CLOSURE==============================================================*/
                    $td.='<td style="text-align:center;width:'.$wa.'px;vertical-align:middle;border-left:0px;border-right:1px solid #ccc;">
                            '.$accionlink.'
                          </td>';
                }
            }
            return $td;
        }
        
        /*Crea la paginacion*/
        public function paginador($obj){
            $ajax       = $obj['xajax'];
            $criterio   = $obj['criterio']; 
            $total_regs = $obj['total'];
            $nreg_x_pag = $obj['nRegPagina']; 
            $this->nRegPagina = (isset($obj['nRegPagina']))?$obj['nRegPagina']:1; 
            $pagina     = $obj['pagina']; 
            $n          = $obj['nItems']; 
            $lugar      = (isset($obj['lugar']))?$obj['lugar']:'out';//in
            
            $this->exportado = $pagina;
            
            $html = new interfazAbstract;
            if($lugar == 'out'){
                return $html->htmlPaginador($ajax,$criterio, $total_regs, $nreg_x_pag, $pagina, $n);
            }else{
                $this->paginIn = $html->htmlPaginador($ajax,$criterio, $total_regs, $nreg_x_pag, $pagina, $n);
            }
        }
        
        /*
         * Mostrar los values del checkbox
         * 
         * Parametros 
         *  values:: nombre del campo de la DB, tambien puede ser un array
         *  posicion:: posicion en donde se generara los checkbox (first || last),
         *  fnCallback:: closure -- funcion anonima, el resultado reemplazara a la data de la columna.
         *               $row -- es el registro que viene de la DB con las columnas configuradas en el SP
         *               $a -- es el numero de fila
         * USO
         * 
         * $Grid->mostrarCheck(
                    array(
                        "posicion"=>"first",
                        "values"=>"campo_db",
                        "fnCallback"=>function($row,$a){
                            if($row['tipocartafianza'] == 1){
                                $cadena = '<input name="rd_ee[]" id="rd_'.$a.'" type="checkbox" value="" />';
                            }else{
                                $cadena = '<input name="rd_ee[]" id="rd_'.$a.'" type="checkbox" value="" disabled/>';
                            }
                            return $cadena;
                        }
                    )
            );
         */
        public function mostrarCheck($obj){
            $this->posicionCheck = isset($obj['posicion'])?$obj['posicion']:'first';
            $this->callBackCheck = isset($obj['fnCallback'])?$obj['fnCallback']:'';
            $this->clickTdCheckBox = isset($obj['clickTd'])?$obj['clickTd']:true;
            $this->check = true;
            $this->checkValues = $obj['values'];
            $this->checked = (isset($obj['checked']) && $obj['checked'] == true)?'checked = "'.$obj['checked'].'" ':'';
        }
        
        /*Crea los checkbox*/
        private function crearCheckBox($row, $a){
            $td ='';
            if($this->check == true){
                if($this->callBackCheck != ''){
                    if(is_callable($this->callBackCheck)){
                       /*ejecutar closure*/
                        $call = call_user_func_array($this->callBackCheck,array($row,$a)); 
                        if($call == false){
                            $cadena = $cadena; //no se ejecuta nada, retorna valor normal
                        }else{
                            $cadena = $call; //retorna resultado del closure
                        }
                    }else{
                        $cadena = '<br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].';
                    }
                }else{
                    $values = '';
                    if(is_array($this->checkValues)){
                        foreach ($this->checkValues as $val) {
                            $values .= $row[$val].'*';
                        }
                    }else{
                        $values = $row[$this->checkValues];
                    }
                    $cadena = '<input name="rd_'.$this->id.'[]" id="rd_'.$this->id.$a.'" type="checkbox" value="'.$values.'" style="margin:0px" '.$this->checked.' />';
                }
                $td.='<th style="text-align:center;vertical-align:middle;width:20px;border-left:0px;border-right:1px solid #ccc">
                        '.$cadena.'
                      </th>';
            } 
            return $td;
        }
        
        /*
         * Mostrar los values del radios
         * 
         * Parametros 
         *  values:: nombre del campo de la DB, tambien puede ser una array
         *  posicion:: posicion en donde se generara los radioButton (first || last)
         *  fnCallback:: closure -- funcion anonima, el resultado reemplazara a la data de la columna.
         *               $row -- es el registro que viene de la DB con las columnas configuradas en el SP
         *               $a -- es el numero de fila
         * USO:
         * 
         * $Grid->mostrarRadio(
                    array(
                        "posicion"=>"first",
                        "values"=>"campo_db",
                        "fnCallback"=>function($row,$a){
                            if($row['tipocartafianza'] == 1){
                                $cadena = '<input type="radio" id="rd_'.$a.'" name="rd_[]"  value="" disabled>';
                            }else{
                                $cadena = '<input type="radio" id="rd_'.$a.'" name="rd_[]"  value="">';
                            }
                            return $cadena;
                        }
                    )
            );
         */
        public function mostrarRadio($obj){
            $this->posicionRadio = isset($obj['posicion'])?$obj['posicion']:'first';
            $this->callBackRadio = isset($obj['fnCallback'])?$obj['fnCallback']:'';
            $this->radio = true;
            $this->radioValues = $obj['values'];
        }
        
        /*Crea los radioBbutton*/
        private function crearRadio($row, $a){
            $td ='';
            if($this->radio == true){
                if($this->callBackRadio != ''){
                    if(is_callable($this->callBackRadio)){
                       /*ejecutar closure*/
                        $call = call_user_func_array($this->callBackRadio,array($row,$a)); 
                        if($call == false){
                            $cadena = $cadena; //no se ejecuta nada, retorna valor normal
                        }else{
                            $cadena = $call; //retorna resultado del closure
                        }
                    }else{
                        $cadena = '<br>ERROR: [fnCallback] incorrecto, defina [closure] para [fnCallback].';
                    }
                }else{
                    $values = '';
                    if(is_array($this->radioValues)){
                        foreach ($this->radioValues as $val) {
                            $values .= $row[$val].'*';
                        }
                    }else{
                        $values = $row[$this->radioValues];
                    }
                    $cadena = '<input type="radio" id="rd_'.$this->id.$a.'" name="rd_'.$this->id.'[]"  value="'.$values.'" style="margin:0px">';
                }
                
                $td.='<th style="text-align:center;vertical-align:middle;width:25px;border-left:0px;border-right:1px solid #ccc">
                        '.$cadena.'
                      </th>';
            } 
            return $td;
        }
             
}
/*OBSOLETO NO UTILIZAR*/
/*clase antigua, se recomienda no usarla mas*/
class DataGrid extends connectdb{
    
        /*ID de tabla*/
	private $id;
        
        /*Caption de tabla*/
	public  $caption; 
        
        /*Total de registros*/
	public  $allreg;
        
        /*Almacena las cabeceras de la tabla HTML*/
	private $head   =   array();

        /*Almacena los campos que se extraeran de la DB*/
	private $campos_db  =   array();
        
        /*Almacena los width de las columnas HTML*/
	private $width_col  =   array();
        
        /*Valor booleano que sirve para editar o no, una celda de dataGrid*/
        private $edit_col = array();
        
        /*Almacena link para registro en datagrid, de ser necesario*/
        private $linkCol = array();
        
        /*para dar estilo a campo con label de bootstrap -- <span class="label label-success">Success</span>*/
        private $label;
        
        /*Numero de columnas de tabla HTML*/
	private $num_col;
        
        /*Id :: KEY PRIMARY de tabla consultada en query para procesar aaciones*/
        private $id_gestor='';
        
        /*Id :: KEY PRIMARY2 (para concatenar campos u usar como KEY) de tabla consultada en query para procesar aaciones*/
        private $id_newGestor='';
        
        /*Numero de regitros a mostrar por pagina*/
	private $tam;
        
        /*Almacena los registros obtenidos de la DB*/
	private $data   =   array();
        
        /*Para validar si se muestra los check button*/
	public  $check = false;
        
        /*Para intercalar visualizacion de check*/
        public  $checkIf;
        
        /*Para validar posicion de checkbox*/
        public  $posicionCheck = 'first';
        
        /*Para validar si se muestra los radio button*/
	public  $radio = false;
        
        /*Para intercalar visualizacion de radio*/
        public  $radioIf;
        
        /*Para validar posicion de radio*/
        public  $posicionRadio = 'first';   
        
        /*Parametro q permite hacer click en fila, el cual permite marcar el checkbox al clicar la fila*/
        public  $onCheckInFila = true;
        /*
         * Para las acciones
         * Almacena los flag para los Stored Procedure
         */
        private $flag=array();
        
        /*Almacena el formulario :: <form>, que contiene los datos a procesar*/
        private $form=array();
        
        /*Almacena las acciones, ELIMINAR EDITAR, etc*/
	private $axion=array(); 		
        
        /*Almacena los eventos js para las acciones*/
	private	$evento=array(); 	
        
        /*Numero de acciones asignadas*/
	private	$num_accion=array();               
        
        /*Almacena los titles de las acciones*/
	private	$title=array();	
        
        /*Para validar si dataGrid usara acciones o no*/
	private $siaccion=false;
        
        /*Para validar posicion de acciones*/
        public  $posicionAccion = 'first';
        
        /*Para mostrar numeracion de registros*/
        public  $numeracion = false;
        
        /*Para algin de cada data del grid*/
        public $align;
        
	public function __construct($id="tab_"){
            $this->id            =   $id;
	}	      
        
        /*Recibe el id :: KEY PRIMARY de la tabla de la DB*/
	public function idGestor($idg){
            $this->id_gestor    =   $idg;
	}
        
        /*Recibe el id :: KEY PRIMARY2 (concatena campos para usar como KEY) de la tabla de la DB*/
	public function newIdGestor($idArray){
            if(is_array($idArray)){
               $this->id_newGestor = $idArray;
            }elseif($idArray!=''){
               $this->id_newGestor    =   '0'; 
            }            
	} 
        
        /*
         * Genera las columnas
         * Uso para nivel1:
         * $Grid->column("cabecera","campo_db");
         * 
         * Uso para subcabecera nivel2:
         * campo_db === Es el campo de la consulta a la DB
         * 
         * $Grid->columna(
         *           array(
         *               "nivel1"=>array("titulo"=>"Tarea","width"=>"30%"),
         *               "nivel2"=>array(
         *                   array("titulo"=>"Programado","data"=>"campo_db","width"=>"4%"),
         *                   array("titulo"=>"Aprobado","data"=>"campo_db","width"=>"4%")
         *               )
         *           )
         *   );
         */
	public function columna($head,$col_db='',$width='',$edit=false,$label="",$align='left',$link=""){
            $this->head[]       = $head; 
            $this->campos_db[]  = $col_db; 
            $this->num_col      = sizeof($this->head);
            $this->width_col[]  = $width;   
            $this->edit_col[]   = $edit;
            $this->label[]      = $label;
            $this->align[]      = $align;
            $this->linkCol[]      = $link;
	}
	
	/*inserta acciones :: EDITAR, ELIMINAR, etc*/
	public function accion($acc,$titu,$evt,$flag='',$form=''){
            $this->title[] 	= $titu;    
            $this->axion[] 	= $acc;     
            $this->evento[]     = $evt;     
            $this->flag[]       = $flag;    
            $this->form[]       = $form;    
            $this->num_accion	= sizeof($this->axion);
            $this->siaccion	= true;		
	}
	
        /*Consulta la data a la DB, data con paginacion*/
	public function data($criterio, $total_regs = 0, $pagina = 1, $nreg_x_pag = 10, $class, $method){  
            $criterio2 = $criterio;
            if(!is_array($criterio)){
                $asterisco = substr($criterio, 0, 1);
                
            }else{                
                $asterisco = substr($criterio[0], 0, 1);              
            }
            $buscarPor = 'N';
            if ($asterisco == '*') {
                $buscarPor = 'C';
                $criterio2 = substr($criterio, 1);
            }
            $c_bObj = new $class();        
            if ($total_regs == 0) {            
                $this->data = $c_bObj->$method($criterio2, $buscarPor, 1);
                if(isset($this->data['error'])){
                    echo $this->data['error'];
                }else{
                    $this->allreg = $this->data['total'];
                }
            }
            $this->data = $c_bObj->$method($criterio2, $buscarPor, 0, $pagina, $nreg_x_pag);  
//            $this->tam = $nreg_x_pag;
            if(isset($this->data['error'])){
                echo $this->data['error'];
            }else{
                $this->tam = $nreg_x_pag;
            }
    }  
        
        /*Muestra datos sin paginacion*/
        public function dataSimple($criterio, $class, $method, $flag=''){               
            $c_bObj = new $class();   
            $this->data = $c_bObj->$method($criterio, $flag);
            $x = 0;
            foreach($this->data as $row){	
                $x++;
            }
            $this->allreg = $x;
	}
        
        public function sData($criterio, $class, $method, $flag=''){               
            $c_bObj = new $class();   
            $this->data = $c_bObj->$method($flag,$criterio);
            $x = 0;
            foreach($this->data as $row){	
                $x++;
            }
            $this->allreg = $x;
	}
        
        public function render(){				
            $result='<table id="'.$this->id.'" class="data-tbl-simple table table-bordered" width="100%">';
            $result.=self::contData();
            $result.='</table>';
            $result.='
                <input name="txt_gridfila'.$this->id.'" id="txt_gridfila'.$this->id.'" type="hidden" />
                <input name="txt_allreg'.$this->id.'" id="txt_allreg'.$this->id.'" type="hidden" value="'.$this->allreg.'"/>';		
            /*los txt son para validar la sonbra en mas de un grid a la vez*/
            return $result;
	}
        
	/*Genera el contenido del data grid*/
	private function contData(){
            $id_t   =   $this->id;
            $a      =	0;
            $td = self::cabecera($this->num_col).'
                     <tbody id="'.$this->id.'Body">';
                    /*se verifica si hay data*/
                    if(sizeof($this->data)>0){
                        /*recorrido de la data*/
                        foreach($this->data as $row){
                            $a++;
                            $td.='<tr id="tr_'.$id_t.$a.'">';                            	                           
                            if($this->id_gestor!=''){
                                for ($j=-1;$j< $this->num_col;$j++){
                                    $id_regDB = $row[$this->id_gestor];
                                }
                            }
                            /*agregando numeracion de registros*/
                            if($this->numeracion==true){
                                if(isset($row['rownum'])){
                                    $td.='<th style="text-align:center;">'.$row['rownum'].'</th>';
                                }else{
                                    $td.='<th style="text-align:center;">'.$a.'</th>';
                                }                                
                            }
                            /*validar posicion de accion*/
                            $newInputIdgestor='';
                            if(strtolower($this->posicionAccion) == 'first'){ 
                                /*agregando newIidGestor*/
                                if($this->id_newGestor == '0'){
                                    $newInputIdgestor = 'xxxxxxx';
                                }elseif(is_array($this->id_newGestor)){
                                    $sep = '*';
                                    $len = sizeof($this->id_newGestor);
                                    foreach ($this->id_newGestor as $key=>$value) {
                                        if(($len-1) == $key){
                                           $sep = ''; 
                                        }
                                        $newInputIdgestor.= ($row[$value]=='')?'NULL'.$sep:$row[$value].$sep;
                                    }
                                }
                                $td.= $this->acciones($id_regDB,$a,$newInputIdgestor);
                            }
                            /*recorrido de data*/
                            for ($j=-1;$j< $this->num_col;$j++){   
                                $id_regDB = '';
                                if($this->id_gestor!=''){
                                    $id_regDB = $row[$this->id_gestor];
                                }
                                
                                if($j=="-1"){//primera columna para los checkbox
                                    /*validar posicion de CheckBox*/
                                    if(strtolower($this->posicionCheck) == 'first'){                            
                                        $td.= $this->crearCheckBox($row, $id_t, $a, $id_regDB);
                                    }   
                                    /*validar posicion de radio*/
                                    if(strtolower($this->posicionRadio) == 'first'){                            
                                        $td.= $this->crearRadio($row, $id_t, $a, $id_regDB);
                                    } 
                                }else{                                    
                                    if(is_array($this->head[$j])){
                                        foreach($this->head[$j]['nivel2'] as $n2){
                                            $derecha = '';
                                            $subcadena = $row[$n2['data']];
                                            $td.='<td style="text-align:'.$derecha.'">'.$subcadena.'</td>'; 
                                        }
                                    }else{
                                        $derecha = '';
                                        if(is_array($this->campos_db[$j])){//es una imagen
                                           $cadena = '<img src="'.$this->campos_db[$j]['ruta'].$row[$this->campos_db[$j]['campo']].'" width="'.$this->campos_db[$j]['ancho'].'" height="'.$this->campos_db[$j]['alto'].'">';
                                        }else{
                                           $cadena = isset($row[$this->campos_db[$j]])?$row[$this->campos_db[$j]]:'<span style="color:red">['.$this->campos_db[$j].'] no existe.</span>';   
                                        }
                                          
                                            
                                        /*alternar estilos de labels*/
                                        $cadenax = '';
                                        if($this->label[$j]!=""){
                                            if(is_array($this->label[$j])){
                                                foreach ($this->label[$j] as $kk=>$vv){                                                 
                                                    if(strtolower($row[$this->campos_db[$j]]) == strtolower($vv)){
//                                                        echo strtolower($row[$this->campos_db[$j]]) .'=='. strtolower($vv).'<br>';
                                                        $cadenax = '<span class="label '.$kk.'" >'.$cadena.'</span>';
                                                    }
                                                }
                                            }else{//si no es array recube el nombre de la clase para el label
                                                $cadenax = '<span class="label '.$this->label[$j].'" >'.$cadena.'</span>';
                                            }
                                            $cadena = $cadenax;
                                        }
                                        /*para idGgestor oculto
                                         * esto servira para grabar los input editables
                                         */
                                        $inputIdgestor = '';
                                        $newInputIdgestor = '';
                                        if($j===0){
                                            $inputIdgestor = '<input type="hidden" id="txt_'.$this->id_gestor.$a.'" name="txt_'.$this->id_gestor.'[]" value="'.$id_regDB.'" />';
                                            /*agregando newIidGestor*/
                                            if($this->id_newGestor == '0'){
                                                $newInputIdgestor = '<b class="label label-important">Error: newIdGestor incorrecto.</b>';
                                            }elseif(is_array($this->id_newGestor)){
                                                $sep = '*';
                                                $len = sizeof($this->id_newGestor);
                                                foreach ($this->id_newGestor as $key=>$value) {
                                                    if(($len-1) == $key){
                                                       $sep = ''; 
                                                    }
                                                    $newInputIdgestor.= ($row[$value]=='')?'NULL'.$sep:$row[$value].$sep;
                                                }
                                                $newInputIdgestor = '<input type="hidden" id="txt_newIdGestor'.$a.'" name="txt_newIdGestor[]" value="'.$newInputIdgestor.'" />';
                                            }
                                        }
                                        /*verificar si cadena lleva link o no*/
                                        $back = '';
                                        if($this->linkCol[$j]!=''){
                                            if($a%2 == 0){
                                                $back = 'background-color:#F2F3FF;';
                                            }else{
                                                $back = 'background-color:#F9F9FF;';
                                            }                                            
                                            $cadena = '<a href="javascript:void(0)" onclick="'.$this->linkCol[$j].'(\''.$id_regDB.'\')">'.$cadena.'</a>';
                                        }
                                        /*validar si celda se editara o no*/
                                        if($this->edit_col[$j]==true){
                                            $td.='<td>'.$inputIdgestor.$newInputIdgestor.'
                                                  <input type="text" id="txt_'.$this->campos_db[$j].$a.'" name="txt_'.$this->campos_db[$j].'[]" value="'.$row[$this->campos_db[$j]].'"  style="width:85%;text-align:'.$derecha.'" />
                                              </td>';
                                        }else{
                                            /*verificar si al clicar td se marcara check o noonclick="clickDataGridTrRadio(\'rd_'.$id_t.$a.'\')*/
                                            $clickTd = '';
                                            if($this->onCheckInFila == true){
                                                $clickTd = ' onclick = "clickDataGridTrRadio(\'rd_'.$id_t.$a.'\')" ';
                                            }
                                            $td.='<td style="'.$back.'text-align:'.$this->align[$j].';vertical-align:middle" '.$clickTd.'>
                                                  '.$cadena.$inputIdgestor.$newInputIdgestor.'
                                              </td>';
                                        }                                          
                                    }
                                }
                            }
                            /*validar posicion de CheckBox*/
                            if(strtolower($this->posicionCheck) == 'last'){                            
                                $td.= $this->crearCheckBox($row, $id_t, $a, $id_regDB);
                            } 
                            /*validar posicion de radio*/
                            if(strtolower($this->posicionRadio) == 'last'){                            
                                $td.= $this->crearRadio($row, $id_t, $a, $id_regDB);
                            }
                            /*validar posicion de accion*/
                            if(strtolower($this->posicionAccion) == 'last'){   
                                /*agregando newIidGestor*/
                                if($this->id_newGestor == '0'){
                                    $newInputIdgestor = 'xxxxxxx';
                                }elseif(is_array($this->id_newGestor)){
                                    $sep = '*';
                                    $len = sizeof($this->id_newGestor);
                                    foreach ($this->id_newGestor as $key=>$value) {
                                        if(($len-1) == $key){
                                           $sep = ''; 
                                        }
                                        $newInputIdgestor.= ($row[$value]=='')?'NULL'.$sep:$row[$value].$sep;
                                    }
                                }
                                $td.= $this->acciones($id_regDB,$a,$newInputIdgestor);
                            }                            
                            $td.='</tr>';
                        }
                    }else{
                        $td.='<tr id="noData"><td colspan="30">
                                 <div class="alert alert-danger">                                                                        
                                    <strong>No se encontraron registros</strong>
                                  </div>
                            </td></tr>';
                    }
                    $td.='</tbody>';
            return $td;	
	}
        
        /*Crea cabecera de tabla*/
        private function cabecera($num_col){
            $id_t   =   $this->id;
            $result='<thead>';
                if($this->caption!=""){
                    $result.='<tr><th colspan="70" style="text-align:center">'.$this->caption.'</th></tr>';
                }                    
             $result.=' <tr>';      
                        /*agregando numeracion de registros*/
                        if($this->numeracion==true){
                            $result.='<th style="width:1%;vertical-align:middle" rowspan="5" >Nro</th>';
                        }
                        /*validar posicion de accion*/
                        if(strtolower($this->posicionAccion) == 'first'){
                            /*si hay acciones agrego titulo*/
                            // width:'.( * 3).'%;
                            if($this->siaccion==true){
                                $result.='<th style="text-align:center" rowspan="5" colspan="'.$this->num_accion.'">Acciones</th>';
                            }     
                        }
                        //muestra cabecera nivel 1
                        for ($i=-1;$i< ($num_col);$i++){
                            if( $i== -1){
                                /*validar posicion de check*/
                                if(strtolower($this->posicionCheck) == 'first'){
                                    if($this->check == true){
                                        /*aqui se genera checkbox*/
                                        $result.='<th rowspan="5" style="width:1%">
                                                    <input name="all_filas'.$id_t.'" id="all_filas'.$id_t.'" type="hidden" value="'.$this->tam.'" />
                                                    <input name="rd_'.$id_t.'" id="rd_'.$id_t.'" type="checkbox" onclick="clickAllRadioDataGrid(this,\''.$id_t.'\')" style="margin:0px"/>
                                              </th>';
                                    }
                                }
                                /*validar posicion de radio*/
                                if(strtolower($this->posicionRadio) == 'first'){
                                    if($this->radio == true){
                                        $result.='<th rowspan="5" style="width:1%;text-align:center">
                                                    #
                                              </th>';
                                    }
                                }
                            }else{                                  
                                /*aqui se generan las cabeceras de la tabla HTML*/
                                if(is_array($this->head[$i])){
                                    /*como tiene sub nivel se coloca al colspan el total de subcabeceras almacenadas en nivel2*/
                                    $result.='<th colspan="'.sizeof($this->head[$i]['nivel2']).'" style="text-align:center;width:'.$this->head[$i]['nivel1']['width'].'">
                                                '.$this->head[$i]['nivel1']['titulo'].'
                                              </th>';                                     
                                }else{                                   
                                    $result.='<th rowspan="5" style="width:'.$this->width_col[$i].';text-align:'.$this->align[$i].'"  >'.$this->head[$i].'</th>';                                                                       
                                }
                            }	
                        }
                        /*validar posicion de check*/
                        if(strtolower($this->posicionCheck) == 'last'){
                            if($this->check == true){
                                /*aqui se genera checkbox*/
                                $result.='<th rowspan="5" style="width:1%">
                                            <input name="all_filas'.$id_t.'" id="all_filas'.$id_t.'" type="hidden" value="'.$this->tam.'" />
                                            <input name="rd_'.$id_t.'" id="rd_'.$id_t.'" type="checkbox" onclick="clickAllRadioDataGrid(this,\''.$id_t.'\')"/>
                                      </th>';
                            }
                        }
                        /*validar posicion de radio*/
                        if(strtolower($this->posicionRadio) == 'last'){
                            if($this->radio == true){
                                $result.='<th rowspan="5" style="width:1%;text-align:center">
                                            #
                                      </th>';
                            }
                        }
                        /*validar posicion de accion*/
                        if(strtolower($this->posicionAccion) == 'last'){
                            /*si hay acciones agrego titulo*/
                            if($this->siaccion==true){
                                $result.='<th style="text-align:center" rowspan="5" colspan="'.$this->num_accion.'">Acciones</th>';
                            }     
                        }
              $result.='</tr>
                        <tr>';
                        //muestra cabecera para segundo nivel2
                        for ($i=1;$i< ($num_col);$i++){                                                         
                                /*aqui se generan las subcabeceras de la tabla HTML*/
                                if(is_array($this->head[$i])){   
                                    foreach($this->head[$i]['nivel2'] as $n2){
                                        $result.='<th style="width:'.$n2['width'].';text-align:center">'.$n2['titulo'].'</th>'; 
                                    }                                          
                                }                            	
                        }
              $result.='</tr>
                 </thead>';
              return $result;
        }
        /*crea las accione*/
        private function acciones($id_regDB,$a,$newInputIdgestor=''){
            $id_t   =   $this->id;
            $td = '';
            /*valido acciones &nbsp;*/
            if($this->siaccion==true){
                $td=	'';
                /*visualizo acciones*/
                for($ax=0;$ax<$this->num_accion;$ax++){
                    $flag = '';
                    if($this->flag[$ax]!=""){
                         $flag = $this->flag[$ax].',';
                    }
                    if($this->form[$ax] != ""){
                        $formvalue = ",xajax.getFormValues('".$this->form[$ax]."')";
                    }else{
                        $formvalue = "";
                    }
                    /*newIdGestor*/
                    $newIdgestor = '';
                    if($newInputIdgestor!=''){
                        $newIdgestor = ",'".$newInputIdgestor."'";
                    }

                    if(is_array($this->evento[$ax])){
                        /*cuando es una accion que elimina, anula, etc y se tiene q quitar el registro*/
                        $onc =  "if(confirm('".$this->evento[$ax][1]."')){ ".$this->evento[$ax][0]."(".$flag."'".$id_regDB."'".$formvalue.$newIdgestor."); $(this).tooltip('hide')}";
                    }else{
                        $onc = $this->evento[$ax]."(".$flag."'".$id_regDB."'".$formvalue.$newIdgestor.");$(this).tooltip('hide')";
                    }

                    $td.='<td style="text-align:center;width:1%">
                            <a  title="'.$this->title[$ax].'" href=javascript:void(0) onClick="'.$onc.'" style="text-decoration:none">
                                <i class="color-icons '.$this->axion[$ax].'"></i>
                            </a> 
                          </td>';
                }
                $td.='';
            }
            return $td;
        }
        
        /*Crea la paginacion*/
        public function paginador($ajax,$criterio, $total_regs, $nreg_x_pag, $pagina, $n){
            $html = new interfazAbstract;
            return $html->htmlPaginador($ajax,$criterio, $total_regs, $nreg_x_pag, $pagina, $n);
        }
        
        /*Crea los checkbox*/
        private function crearCheckBox($row,$id_t,$a,$id_regDB){
            $td ='';
            $enabled = '';
            if($this->check == true){
                /*validando visibilidad de check*/
                if($this->checkIf != "" ){   
                    if($this->checkIf[3]!=1){$this->checkIf[3]=0;}
                    if($this->checkIf[4]!=1){$this->checkIf[4]=0;}
                    /*se coloco en cadena para q funcione el if*/
                   $r='if('.$row[$this->checkIf[0]] . $this->checkIf[1] . $this->checkIf[2].'){                                           
                        /*verificando si es tur o false la visualizacion*/
                        if('.$this->checkIf[3].' == 1){
                            $enabled = "";
                        }else{
                            $enabled = " disabled = true ";
                        }
                    }else{                                         
                        /*verificando si es tur o false la visualizacion*/
                        if('.$this->checkIf[4].' == 1){
                            $enabled = "";
                        }else{
                            $enabled = " disabled = true ";
                        }
                    }';
                   eval($r);
                }                                      
                $td.='<th>
                        <input name="rd_'.$id_t.'[]" id="rd_'.$id_t.$a.'" type="checkbox" value="'.$id_regDB.'" '.$enabled.'/>
                      </th>';
            } 
            return $td;
        }
        
        /*Crea los radioBbutton*/
        private function crearRadio($row,$id_t,$a,$id_regDB){
            $td ='';
            $enabled = '';
            if($this->radio == true){
                /*validando visibilidad de check*/
                if($this->radioIf != "" ){   
                    if($this->radioIf[3]!=1){$this->radioIf[3]=0;}
                    if($this->radioIf[4]!=1){$this->radioIf[4]=0;}
                    /*se coloco en cadena para q funcione el if*/
                   $r='if('.$row[$this->radioIf[0]] . $this->radioIf[1] . $this->radioIf[2].'){                                           
                        /*verificando si es true o false la visualizacion*/
                        if('.$this->radioIf[3].' == 1){
                            $enabled = "";
                        }else{
                            $enabled = " disabled = true ";
                        }
                    }else{                                         
                        /*verificando si es tur o false la visualizacion*/
                        if('.$this->radioIf[4].' == 1){
                            $enabled = "";
                        }else{
                            $enabled = " disabled = true ";
                        }
                    }';
                   eval($r);
                }                                      
                $td.='<th style="text-align:center">
                        <input type="radio" id="rd_'.$id_t.$a.'" name="rd_'.$id_t.'[]"  value="'.$id_regDB.'" '.$enabled.'>
                      </th>';
            } 
            return $td;
        }
}

$scrollTable = "
var scrollTable = function (tableId, options) {
/////* Initialize */
	options = options || {};
	this.cssSkin = \"sDefault\";
	this.headerRows = parseInt(options.headerRows || \"1\");
	this.fixedCols = parseInt(options.fixedCols || \"0\");
	this.colWidths = options.colWidths || [];
	this.initFunc = options.onStart || null;
	this.callbackFunc = options.onFinish || null;
	this.initFunc && this.initFunc();

/////* Create the framework dom */
	this.sBase = document.createElement(\"div\");
	this.sFHeader = this.sBase.cloneNode(false);
	this.sHeader = this.sBase.cloneNode(false);
	this.sHeaderInner = this.sBase.cloneNode(false);
	this.sFData = this.sBase.cloneNode(false);
	this.sFDataInner = this.sBase.cloneNode(false);
	this.sData = this.sBase.cloneNode(false);
	this.sColGroup = document.createElement(\"COLGROUP\");
	
	this.sDataTable = document.getElementById(tableId);
	this.sDataTable.style.margin = \"0px\"; /* Otherwise looks bad */
	if (this.cssSkin !== \"\") {
		this.sDataTable.className += \" \" + this.cssSkin;
	}
	if (this.sDataTable.getElementsByTagName(\"COLGROUP\").length > 0) {
		this.sDataTable.removeChild(this.sDataTable.getElementsByTagName(\"COLGROUP\")[0]); /* Making our own */
	}
	this.sParent = this.sDataTable.parentNode;
	this.sParentHeight = this.sParent.offsetHeight;
	this.sParentWidth = this.sParent.offsetWidth;
	
/////* Attach the required classNames */
	this.sBase.className = \"sBase\";
	this.sFHeader.className = \"sFHeader\";
	this.sHeader.className = \"sHeader\";
	this.sHeaderInner.className = \"sHeaderInner\";
	this.sFData.className = \"sFData\";
	this.sFDataInner.className = \"sFDataInner\";
	this.sData.className = \"sData\";
	
/////* Clone parts of the data table for the new header table */
	var alpha, beta, touched, clean, cleanRow, i, j, k, m, n, p;
	this.sHeaderTable = this.sDataTable.cloneNode(false);
    
	if (this.sDataTable.tHead) {
		alpha = this.sDataTable.tHead;
		this.sHeaderTable.appendChild(alpha.cloneNode(false));
		beta = this.sHeaderTable.tHead;
	} else {
		alpha = this.sDataTable.tBodies[0];
		this.sHeaderTable.appendChild(alpha.cloneNode(false));
		beta = this.sHeaderTable.tBodies[0];
	}
	alpha = alpha.rows;
	for (i=0; i<this.headerRows; i++) {
		beta.appendChild(alpha[i].cloneNode(true));
	}
	this.sHeaderInner.appendChild(this.sHeaderTable);
	
	if (this.fixedCols > 0) {
		this.sFHeaderTable = this.sHeaderTable.cloneNode(true);
		this.sFHeader.appendChild(this.sFHeaderTable);
		this.sFDataTable = this.sDataTable.cloneNode(true);
		this.sFDataInner.appendChild(this.sFDataTable);
	}
	
/////* Set up the colGroup */
	alpha = this.sDataTable.tBodies[0].rows;
	for (i=0, j=alpha.length; i<j; i++) {
		clean = true;
		for (k=0, m=alpha[i].cells.length; k<m; k++) {
			if (alpha[i].cells[k].colSpan !== 1 || alpha[i].cells[k].rowSpan !== 1) {
				i += alpha[i].cells[k].rowSpan - 1;
				clean = false;
				break;
			}
		}
		if (clean === true) break; /* A row with no cells of colSpan > 1 || rowSpan > 1 has been found */
	}
	cleanRow = (clean === true) ? i : 0; /* Use this row index to calculate the column widths */
	for (i=0, j=alpha[cleanRow].cells.length; i<j; i++) {
		if (i === this.colWidths.length || this.colWidths[i] === -1) {
			this.colWidths[i] = alpha[cleanRow].cells[i].offsetWidth;
		}
	}
	for (i=0, j=this.colWidths.length; i<j; i++) {
		this.sColGroup.appendChild(document.createElement(\"COL\"));
		this.sColGroup.lastChild.setAttribute(\"width\", this.colWidths[i]);
	}
	this.sDataTable.insertBefore(this.sColGroup.cloneNode(true), this.sDataTable.firstChild);
	this.sHeaderTable.insertBefore(this.sColGroup.cloneNode(true), this.sHeaderTable.firstChild);
	if (this.fixedCols > 0) {
		this.sFDataTable.insertBefore(this.sColGroup.cloneNode(true), this.sFDataTable.firstChild);
		this.sFHeaderTable.insertBefore(this.sColGroup.cloneNode(true), this.sFHeaderTable.firstChild);
	}
	
/////* Style the tables individually if applicable */
	if (this.cssSkin !== \"\") {
		this.sDataTable.className += \" \" + this.cssSkin + \"-Main\";
		this.sHeaderTable.className += \" \" + this.cssSkin + \"-Headers\";
		if (this.fixedCols > 0) {
			this.sFDataTable.className += \" \" + this.cssSkin + \"-Fixed\";
			this.sFHeaderTable.className += \" \" + this.cssSkin + \"-FixedHeaders\";
		}
	}
	
/////* Throw everything into sBase */
	if (this.fixedCols > 0) {
		this.sBase.appendChild(this.sFHeader);
	}
	this.sHeader.appendChild(this.sHeaderInner);
	this.sBase.appendChild(this.sHeader);
	if (this.fixedCols > 0) {
		this.sFData.appendChild(this.sFDataInner);
		this.sBase.appendChild(this.sFData);
	}
	this.sBase.appendChild(this.sData);
	this.sParent.insertBefore(this.sBase, this.sDataTable);
	this.sData.appendChild(this.sDataTable);
	
/////* Align the tables */
	var sDataStyles, sDataTableStyles;
	this.sHeaderHeight = this.sDataTable.tBodies[0].rows[(this.sDataTable.tHead) ? 0 : this.headerRows].offsetTop;
	sDataTableStyles = \"margin-top: \" + (this.sHeaderHeight * -1) + \"px;\";
	sDataStyles = \"margin-top: \" + this.sHeaderHeight + \"px;\";
	sDataStyles += \"height: \" + (this.sParentHeight - this.sHeaderHeight) + \"px;\";
	if (this.fixedCols > 0) {		
		/* A collapsed table's cell's offsetLeft is calculated differently (w/ or w/out border included) across broswers - adjust: */
		this.sFHeaderWidth = this.sDataTable.tBodies[0].rows[cleanRow].cells[this.fixedCols].offsetLeft;
		if (window.getComputedStyle) {
			alpha = document.defaultView;
			beta = this.sDataTable.tBodies[0].rows[0].cells[0];
			if (navigator.taintEnabled) { /* If not Safari */
				this.sFHeaderWidth += Math.ceil(parseInt(alpha.getComputedStyle(beta, null).getPropertyValue(\"border-right-width\")) / 2);
			} else {
				this.sFHeaderWidth += parseInt(alpha.getComputedStyle(beta, null).getPropertyValue(\"border-right-width\"));
			}
		} else if (/*@cc_on!@*/0) { /* Internet Explorer */
			alpha = this.sDataTable.tBodies[0].rows[0].cells[0];
			beta = [alpha.currentStyle[\"borderRightWidth\"], alpha.currentStyle[\"borderLeftWidth\"]];
			if(/px/i.test(beta[0]) && /px/i.test(beta[1])) {
				beta = [parseInt(beta[0]), parseInt(beta[1])].sort();
				this.sFHeaderWidth += Math.ceil(parseInt(beta[1]) / 2);
			}
		}
		
		/* Opera 9.5 issue - a sizeable data table may cause the document scrollbars to appear without this: */
		if (window.opera) {
			this.sFData.style.height = this.sParentHeight + \"px\";
		}
		
		this.sFHeader.style.width = this.sFHeaderWidth + \"px\";
		sDataTableStyles += \"margin-left: \" + (this.sFHeaderWidth * -1) + \"px;\";
		sDataStyles += \"margin-left: \" + this.sFHeaderWidth + \"px;\";
		sDataStyles += \"width: \" + (this.sParentWidth - this.sFHeaderWidth) + \"px;\";
	} else {
		sDataStyles += \"width: \" + this.sParentWidth + \"px;\";
	}
        
	this.sData.style.cssText = sDataStyles;
	this.sDataTable.style.cssText = sDataTableStyles;
	
/////* Set up table scrolling and IE's onunload event for garbage collection */
	(function (st) {
		if (st.fixedCols > 0) {
			st.sData.onscroll = function () {
				st.sHeaderInner.style.right = st.sData.scrollLeft + \"px\";
				st.sFDataInner.style.top = (st.sData.scrollTop * -1) + \"px\";
			};
		} else {
			st.sData.onscroll = function () {
				st.sHeaderInner.style.right = st.sData.scrollLeft + \"px\";
			};
		}
		if (/*@cc_on!@*/0) { /* Internet Explorer */
			window.attachEvent(\"onunload\", function () {
				st.sData.onscroll = null;
				st = null;
			});
		}
	})(this);
	
	this.callbackFunc && this.callbackFunc();
};";

$scrollCss = '
<style>
.sBase {
	OVERFLOW: hidden; WIDTH: 100%; POSITION: relative; HEIGHT: 100%
}
.sHeader {
	Z-INDEX: 3; POSITION: absolute; BACKGROUND-COLOR: #ffffff
}
.sHeaderInner {
	POSITION: relative
}
.sHeaderInner TABLE {
	TABLE-LAYOUT: fixed! important; WIDTH: 1px! important; BORDER-COLLAPSE: collapse! important;border-spacing: 0px 0px
}
.sFHeader {
	Z-INDEX: 4; OVERFLOW: hidden; POSITION: absolute
}
.sFHeader TABLE {
	TABLE-LAYOUT: fixed! important; WIDTH: 1px! important; BORDER-COLLAPSE: collapse! important; BACKGROUND-COLOR: #ffffff; border-spacing: 0px 0px
}
.sData {
	Z-INDEX: 2; OVERFLOW: auto; POSITION: absolute; BACKGROUND-COLOR: #ffffff
}
.sData TABLE {
	TABLE-LAYOUT: fixed! important; WIDTH: 1px! important; BORDER-COLLAPSE: collapse! important; border-spacing: 0px 0px
}
.sFData {
	Z-INDEX: 1; POSITION: absolute; 
}
.sFDataInner {
	POSITION: relative;
}
.sFData TABLE {
	TABLE-LAYOUT: fixed! important; WIDTH: 1px! important; BORDER-COLLAPSE: collapse! important; border-spacing: 0px 0px;
}
.sDefault {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; BORDER-TOP-STYLE: none; PADDING-TOP: 0px;  BORDER-RIGHT-STYLE: none; BORDER-LEFT-STYLE: none; BORDER-BOTTOM-STYLE: none
}
.sDefault TH {
	PADDING-RIGHT: 6px; PADDING-LEFT: 4px; PADDING-BOTTOM: 3px; PADDING-TOP: 3px;  WHITE-SPACE: nowrap
}
.sDefault TD {
 PADDING-RIGHT: 6px;  PADDING-LEFT: 4px; PADDING-BOTTOM: 3px; PADDING-TOP: 3px;  /*WHITE-SPACE: nowrap*/
}
.sScrollLCont{-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border:1px solid #ccc;background:#fff}
</style>';
?>