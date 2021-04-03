<?php
include_once RUTA_CLASES . 'ventas.class.php';
include_once RUTA_CLASES . 'ventasdetalle.class.php';
include_once RUTA_CLASES . 'caja.class.php';
class interfazCreadorCodigoBarras
{
    function principal()
    {
        $clsabstract = new interfazAbstract();
        $clasetipocomprobante = new tipocomprobante();
        $clsabstract->legenda('fas fa-search', 'Ver detalle');
        $clsabstract->legenda('fas fa-arrow-circle-right', 'Enviar Comprobante');
        $datostipocomprobante = $clasetipocomprobante->consultar('3', '');
        $leyenda = $clsabstract->renderLegenda('30%');
        $titulo = "Ventas";
        $html = ' 
    
    <div class="card">
        <div class="card-header">' . $titulo . '</div>
            <div class="card-body">        
            
                <form class="form-inline" onsubmit="return false;" id="frmConsulta">
                    <table style="width:100%" >
                        <tr>
                            <td style="width:20%">Valor</td>
                            <td  style="width:30%">
                                <input  type="text" id="txtValorCodigoBarras" name="txtValorCodigoBarras" class="form-control">
                            </td>
                            <td style="width:60%"></td>
                        </tr>
                        <tr>
                            <td style="width:20%">Mostrar valor</td>
                            <td  style="width:30%">
                                <input type="checkbox" value="1" id="chkMostrar" name="chkMostrar">
                            </td>
                            <td style="width:60%"></td>
                        </tr>
                                                
                        <tr>
                            <td colspan="3" style="text-align:center">
                                <button type="button" class="btn btn-secondary" id="btnBuscar">Generar</button>                                
                                <button type="button" class="btn btn-secondary" id="btnImprimir" onclick="$(\'#inTexto\').css(\'border\', \'0\'); imprSelec(\'imprimir\')"> Imprimir</button>                                
                                
                            </td>
                        </tr>    
                    </table>
                                               
                    
            </form>                
            </div>    
            <div id="imprimir">        
            <table style="width:50%" align="center">
                <tr>
                    <td id="inTexto" align="center" contenteditable style="border:1px solid; font-size:30px; font-weight: bold" height="30px" placeholder="Ingresar un texto">
                        
                    </td>
                </tr>
                <tr>
                    <td align="center" style="border:0px; font-size:30px">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td id="outQuery"  style="text-align:center"></td>
                </tr>
            </table>
            </div>
            </form>    
        </div>
        </div>
          
    </div>';

        return $html;
    }
}

function _interfazCreadorCodigoBarras()
{
    $rpta = new xajaxResponse();
    $cls = new interfazCreadorCodigoBarras();

    $html = $cls->principal();
    $rpta->assign("container", "innerHTML", $html);

    $rpta->script("
    $('#btnBuscar').unbind('click').click(function() {
       
            xajax__generarCodigoBarra(xajax.getFormValues('frmConsulta'));
        
    });");

    return $rpta;
}

function _generarCodigoBarra($form)
{
    $rpta = new xajaxResponse();
    $cls = new interfazCreadorCodigoBarras();
    if (isset($form["chkMostrar"])) {
        $mostrar = "true";
    } else {
        $mostrar = "false";
    }
    $html = '<img src="tools/php-barcode-master/barcode.php?text=' . $form["txtValorCodigoBarras"] . '&size=50&sizefactor=2&codetype=Code39&print=' . $mostrar . '" />';
    $rpta->assign("outQuery", "innerHTML", $html);
    $rpta->script("
        function imprSelec(nombre) {                
        var ficha = document.getElementById(nombre);
        var ventimp = window.open(' ', 'popimpr');
        ventimp.document.write( ficha.innerHTML );        
        ventimp.document.close();
        ventimp.print( );
        ventimp.close();
        
        }
    ");


    return $rpta;
}


$xajax->register(XAJAX_FUNCTION, '_interfazCreadorCodigoBarras');
$xajax->register(XAJAX_FUNCTION, '_generarCodigoBarra');
