<?php
class interfazdataGrid extends interfazAbstract
{
    function GridGeneral($nameGrid,$columna=array(),$clase,$metodo,$criterio,$criteriopaginacion, $total_regs = 0, $pagina = 1, $nreg_x_pag = GL_NUM_REG_X_PAG,$xajaxpag='',$accion=array(),$porcentaje='1%'){
        $Grid = new eGrid($nameGrid);
        $Grid->numeracion();
        $Grid->keyEdit("alumno");
        foreach($columna as $arylista) {
            foreach($arylista as $key=>$valor) {
                $array[$key ]= $valor;
            }
            $Grid->columna($array);
        }
        foreach($accion as $valor){
            $Grid->accion($valor);
            $this->legenda($valor['icono'],$valor['titulo']);
        }
        $Grid->data(array(

            "criterio" =>$criterio,
            "total" => $Grid->totalRegistros,
            "pagina" => $pagina,
            "nRegPagina" => $nreg_x_pag,
            "class" => $clase,
            "method" => $metodo,
            "sp"=>"B"
        ));
        $Grid->paginador(array(
            "xajax" => $xajaxpag,
            "criterio" =>$criteriopaginacion,
            "total" => $Grid->totalRegistros,
            "nRegPagina" => $nreg_x_pag,
            "pagina" => $pagina,
            "nItems" => "5",
            "lugar" => "in"
        ));
        $html = '
            <style>
                .table thead th{border:0px};
            </style>
        ' . $Grid->render();
        if(count($accion)>0){
            $html .= '<br>'.$leyenda = $this->renderLegenda($porcentaje);
        }

        return $html;
    }
}