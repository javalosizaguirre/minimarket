$(document).ready(function(){
    $("#txtBuscar").keypress(function(e) {
        //no recuerdo la fuente pero lo recomiendan para
        //mayor compatibilidad entre navegadores.
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
            obtenerDatos();
        }
    });
});


var tableToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,',
        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
        base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) },
        format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(table, name) {
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
        window.location.href = uri + base64(format(template, ctx))
    }
})()


function gKeyAceptaSoloDigitos(evt){
    var key = ('charCode' in evt) ? evt.charCode : evt.keyCode;
    var num = (key <= 13 || (key >= 48 && key <= 57)) ? true:false;
    return num ;
}

function gKeyAceptaSoloAlfanumericos(evt) {
    var key = ('charCode' in evt) ? evt.charCode : evt.keyCode;

    return (key <= 13 || (key >= 65 && key <= 90) || (key >= 97 && key <= 122) || key == 45 || key==32);
}
function gKeyAceptaSoloDigitosPunto(evt) {
    var key = ('charCode' in evt) ? evt.charCode : evt.keyCode;
    return (key <= 13 || (key >= 48 && key <= 57) || key == 46);
}
function validarEnter(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13) document.getElementById('btnBuscar').click();
}

function validarEnterCliente(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13) document.getElementById('btnBuscarCliente').click();
}

function validarEnterBusquedaProducto(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13) xajax__resultadoProductos($('#txtBuscarProducto').val());
}



function sumaSubtotales(){
    let subtotales = 0;
    let total = 0.00;
    let igv = 1.18;
    let base = 0.00;    
    let tipocomprobante = $("#lstTipoDocumento").val();

    /*Calculo de subtotales*/
    $(".subtotales").each(function(){
        total = parseFloat(total) + parseFloat($(this).text());
    })
    $("#tdtotal").text(total.toFixed(2));
    

    if(tipocomprobante==='01'){/**/
        subtotales = parseFloat(total.toFixed(2));
        base = parseFloat(subtotales.toFixed(2))/parseFloat(igv.toFixed(2))
        igv = parseFloat(total.toFixed(2))-parseFloat(base.toFixed(2))
        $("#tdSubtotal").text(base.toFixed(2));
        $("#tdigv").text(igv.toFixed(2));

        $("#txtSubtotal").val(base.toFixed(2));
        $("#txtIgv").val(igv.toFixed(2));
        $("#txtTotal").val(total.toFixed(2));
    }else{
        subtotales = parseFloat(total.toFixed(2));
        base = parseFloat(subtotales.toFixed(2))/parseFloat(igv.toFixed(2))
        igv = parseFloat(total.toFixed(2))-parseFloat(base.toFixed(2))

        $("#txtSubtotalBoleta").val(base.toFixed(2));
        $("#txtIgvBoleta").val(igv.toFixed(2));
        $("#txtTotalBoleta").val(total.toFixed(2));

        $("#tdSubtotal").text('0.00');
        $("#tdigv").text('0.00');
       
    }            
}

function calcularSubtotalItem(guia){
    let subtotal = 0;    
    let cantidad = parseFloat(($('#tdCantidad_'+guia)).html());
    let precio = parseFloat(($('#tdPrecio_'+guia)).html());
    let subtotalitem = parseFloat(cantidad*precio);
    $('#tdSub_'+guia).text(subtotalitem.toFixed(2));    
    sumaSubtotales();
    xajax__actualizarCantidad(($('#tdProducto_'+guia)).html(),cantidad, subtotalitem);
}

function calcularVuelto(){
    let cantidad = parseFloat(($('#tdtotal')).html());
    let pago = $("#txtPagoCon").val();
    let vuelto = pago - cantidad;
    $("#txtVuelto").val(vuelto.toFixed(2));
}

function calcularDetlladoBilletasMonedas(){
    let billetes200 = $('#txt200').val() === '' ? '0.00' : parseFloat($('#txt200').val());
    let billetes100 = $('#txt100').val() === '' ? '0.00' : parseFloat($('#txt100').val());
    let billetes50 = $('#txt50').val() === '' ? '0.00' : parseFloat($('#txt50').val());
    let billetes20 = $('#txt20').val() === '' ? '0.00' : parseFloat($('#txt20').val());
    let billetes10 = $('#txt10').val() === '' ? '0.00' : parseFloat($('#txt10').val());

    let monedas5 = $('#txt5').val() === '' ? '0.00' : parseFloat($('#txt5').val());
    let monedas2 = $('#txt2').val() === '' ? '0.00' : parseFloat($('#txt2').val());
    let monedas1 = $('#txt1').val() === '' ? '0.00' : parseFloat($('#txt1').val());
    let monedas05 = $('#txt05').val() === '' ? '0.00' : parseFloat($('#txt05').val());
    let monedas02 = $('#txt02').val() === '' ? '0.00' : parseFloat($('#txt02').val());
    let monedas01 = $('#txt01').val() === '' ? '0.00' : parseFloat($('#txt01').val());



    let totalbilletes = parseFloat((billetes200 * 200)) + parseFloat((billetes100 * 100)) + parseFloat((billetes50 * 50)) + parseFloat((billetes20 * 20)) + parseFloat((billetes10 * 10));
    let totalmonedas = parseFloat((monedas5 * 5)) + parseFloat((monedas2 * 2)) + parseFloat((monedas1 * 1)) + parseFloat((monedas05 * 0.5)) + parseFloat((monedas02 * 0.2))+ parseFloat((monedas01 * 0.1)); 

    let totaldinero = parseFloat(totalbilletes) + parseFloat(totalmonedas)
    $('#txtBilletesyMonedas').val(totaldinero.toFixed(2))
}