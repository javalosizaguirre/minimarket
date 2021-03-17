<?php

// RUTA para enviar documentos: Tu puedes definir tu propia ruta, en nustro caso la tenemos en la siguiente dirección
//$ruta = "http://localhost/FAE/UBL21/ws/factura.php";
$ruta = 'http://api.corporacion3v.com/UBL21/ws/factura.php';
//se recomienda leer: http://cpe.sunat.gob.pe/sites/default/files/inline-images/Guia%2BXML%2BFactura%2Bversion%202-1%2B1%2B0%20%282%29.pdf

$data = array(
    "tipo_proceso" => 3,
    "pass_firma" => '123456',
    //Cabecera del documento
    "tipo_operacion" => "0101",
    "total_gravadas" => "84.75",
    "total_inafecta" => "0",
    "total_exoneradas" => "0",
    "total_gratuitas" => "0",
    "total_exportacion" => "0",
    "total_descuento" => "0",
    "sub_total" => "84.75",
    "porcentaje_igv" => "18.00",
    "total_igv" => "15.25",
    "total_isc" => "0",
    "total_otr_imp" => "0",
    "total" => "100",
    "total_letras" => "SON CIEN",
    "nro_guia_remision" => "",
    "cod_guia_remision" => "",
    "nro_otr_comprobante" => "",
    "serie_comprobante" => "F001", //Para Facturas la serie debe comenzar por la letra F, seguido de tres dígitos
    "numero_comprobante" => (string) generar_numero_aleatorio(6),
    "fecha_comprobante" => date('Y-m-d'),
    "fecha_vto_comprobante" => date('Y-m-d'),
    "cod_tipo_documento" => "01",
    "cod_moneda" => "PEN",
    //Datos del cliente
    "cliente_numerodocumento" => "20100065403",
    "cliente_nombre" => "GRAFICA INDUSTRIAL SRL",
    "cliente_tipodocumento" => "6", //6: RUC
    "cliente_direccion" => "CAL.LOS PLATEROS NRO. 229",
    "cliente_pais" => "PE",
    "cliente_ciudad" => "Lima",
    "cliente_codigoubigeo" => "",
    "cliente_departamento" => "",
    "cliente_provincia" => "",
    "cliente_distrito" => "",
    //data de la empresa emisora o contribuyente que entrega el documento electrónico.
    "emisor" => array(
        "ruc" => "20100077707",
        "tipo_doc" => "6",
        "nom_comercial" => "Tu Empresa SRL",
        "razon_social" => "Tu Empresa SRL",
        "codigo_ubigeo" => "070104",
        "direccion" => "Jr. Puno 4654",
        "direccion_departamento" => "LIMA",
        "direccion_provincia" => "LIMA",
        "direccion_distrito" => "LIMA",
        "direccion_codigopais" => "PE",
        "usuariosol" => "MODDATOS",
        "clavesol" => "moddatos"
    ),
    //items del documento
    "detalle" => array(
        array(
            "txtITEM" => 1,
            "txtUNIDAD_MEDIDA_DET" => "NIU",
            "txtCANTIDAD_DET" => "1",
            "txtPRECIO_DET" => "100",
            "txtSUB_TOTAL_DET" => "84.75",
            "txtPRECIO_TIPO_CODIGO" => "01",
            "txtIGV" => "15.25",
            "txtISC" => "0",
            "txtIMPORTE_DET" => "84.75",
            "txtCOD_TIPO_OPERACION" => "10",
            "txtCODIGO_DET" => "DSDFG",
            "txtDESCRIPCION_DET" => "Producto 01",
            "txtPRECIO_SIN_IGV_DET" => 84.75
        )
    )
);

//Invocamos el servicio
$token = ''; //en caso quieras utilizar algún token generado desde tu sistema
//codificamos la data
$data_json = json_encode($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $ruta);
curl_setopt(
        $ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Token token="' . $token . '"',
    'Content-Type: application/json',
        )
);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$respuesta = curl_exec($ch);
curl_close($ch);

$response = json_decode($respuesta, true);

echo "=========== DATA RETORNO =============== ";
echo "<br /><br />respuesta	: " . $response['respuesta'];
echo "<br /><br />hash_cpe	: " . $response['hash_cpe'];
echo "<br /><br />hash_cdr	: " . $response['hash_cdr'];
echo "<br /><br />msj_sunat	: " . $response['msj_sunat'];

function generar_numero_aleatorio($longitud) {
    $key = '';
    $pattern = '1234567890';
    $max = strlen($pattern) - 1;
    for ($i = 0; $i < $longitud; $i++)
        $key .= $pattern{mt_rand(0, $max)};
    return $key;
}
