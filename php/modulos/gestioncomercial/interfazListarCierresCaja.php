<?php
include_once RUTA_CLASES . 'caja.class.php';
class interfazListarCierresCaja
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clasecaja = new caja();
        $datacaja = $clasecaja->consultar("2", "");
        $clsabstract->legenda('fa fa-user-edit', 'Editar');
        $clsabstract->legenda('fa fa-times-circle', 'Eliminar');

        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Productos";
        $html = ' 
    
    <div class="card">
        <div class="card-header">' . $titulo . '</div>
            <div class="card-body">        
                <form class="form-inline" onsubmit="return false;">                    
                    <input type="text" class="form-control" id="txtBuscar" placeholder="Buscar por descripcion" style="width:70%">                           
                    <button type="button" class="btn btn-secondary" id="btnBuscar"><i class="fas fa-search"></i>Buscar</button>                                          
                </form>             
            </div>
            
            <div class="card-body" id="outQuery">
                ' . $this->datagrid('') . '
            </div>
            <p><center>' . $leyenda . '</center></p>
        
        
           <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contenido">
                    
                </div>
                <div class="modal-footer" id="footer">
                </div>
                </div>
            </div>
            </div>


        </div>

        </div>
    </div>
    
    ';

        return $html;
    }

    function datagrid($criterio, $total_regs = 0, $pagina = 1, $nreg_x_pag = 100)
    {
        $Grid = new eGrid();
        $Grid->numeracion();

        $Grid->columna(array(
            "titulo" => "Caja",
            "campo" => "descripcion",
            "width" => "50"
        ));


        $Grid->columna(array(
            "titulo" => "Fecha de Apertura",
            "campo" => "fechaapertura",
            "width" => "50"
        ));
        $Grid->columna(array(
            "titulo" => "Fecha de Cierre",
            "campo" => "fechacierre",
            "width" => "250"
        ));


        $Grid->columna(array(
            "titulo" => "Monto de Apertura",
            "campo" => "montoapertura",
            "width" => "50",
            "align" => "right"
        ));
        $Grid->columna(array(
            "titulo" => "Efectivo",
            "campo" => "efectivo",
            "width" => "50",
            "align" => "right"
        ));
        $Grid->columna(array(
            "titulo" => "Tarjeta",
            "campo" => "tarjeta",
            "width" => "50",
            "align" => "right"
        ));
        $Grid->columna(array(
            "titulo" => "Total",
            "campo" => "total",
            "width" => "50",
            "align" => "right"
        ));

        $Grid->columna(array(
            "titulo" => "Estado",
            "campo" => "cerrado",
            "width" => "20",
            "fnCallback" => function ($row) {
                if ($row["cerrado"] == '1') {
                    $cadena = '<span class = "badge badge-success">Cerrado</span>';
                } elseif ($row["cerrado"] == '0') {
                    $cadena = '<span class = "badge badge-danger">Pendiente</span>';
                }
                return $cadena;
            }
        ));



        $Grid->data(array(
            "criterio" => $criterio,
            "total" => $Grid->totalRegistros,
            "pagina" => $pagina,
            "nRegPagina" => $nreg_x_pag,
            "class" => "caja",
            "method" => "buscar"
        ));
        $Grid->paginador(array(
            "xajax" => "xajax__cierrecajaDatagrid",
            "criterio" => array($criterio),
            "total" => $Grid->totalRegistros,
            "nRegPagina" => $nreg_x_pag,
            "pagina" => $pagina,
            "nItems" => "5",
            "lugar" => "in"
        ));
        $html = $Grid->render();
        return $html;
    }
}


function _interfazListarCierresCaja()
{
    $rpta = new xajaxResponse();
    $cls = new interfazListarCierresCaja();
    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);
    $rpta->script("
    $('#btnBuscar').unbind('click').click(function() {
    xajax__cierrecajaDatagrid(document.getElementById('txtBuscar').value);
    });");
    $rpta->script("
    $('#txtBuscar').unbind('keypress').keypress(function() {
        validarEnter(event)
    });");
    return $rpta;
}

function _cierrecajaDatagrid($criterio, $total_regs = 0, $pagina = 1, $nregs = 100)
{
    $rpta = new xajaxResponse();
    $cls = new interfazListarCierresCaja();
    $html = $cls->datagrid($criterio, $total_regs, $pagina, $nregs);
    $rpta->assign("outQuery", "innerHTML", $html);
    return $rpta;
}

$xajax->register(XAJAX_FUNCTION, '_interfazListarCierresCaja');
$xajax->register(XAJAX_FUNCTION, '_cierrecajaDatagrid');
