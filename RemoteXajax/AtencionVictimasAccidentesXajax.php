<?php

/**
 *
 */
function MostrarInformacion($datos)
{
    $objResponse = new xajaxResponse();
    $sql         = AutoCarga::factory('AtencionVictimasAccidentesSQL', 'classes', 'app', 'consultarSoat');

    $datosPaciente = explode(' ', $datos);

    $info = $sql->consultarSoat($datos[0]);

    $objResponse->assign("contenido", "innerHTML", $info[0]['evento']);

    return $objResponse;
}

function GenerarReporte($form)
{
    $objResponse = new xajaxResponse();
    $sql         = AutoCarga::factory('AtencionVictimasAccidentesSQL', 'classes', 'app', 'AtencionVictimasAccidentes');

    // echo "<pre>";
    // print_r($form);
    // echo "</pre>";
    // $datosPaciente = explode(' ', $datos);

    $rst = $sql->CrearViewCircular015($form);

    if ($rst) {
        $objResponse->alert("EL REPORTE SE CREO CORRECTAMENTE.");
        $objResponse->script("location.reload();");
    } else {
        $objResponse->alert("EL REPORTE YA FUE GENERADO, SE REQUIERE QUE SE ELIMINE PARA PODER GENERAR UNO NUEVO." . $obje->mensajeDeError);
    }

    return $objResponse;
}

function EnviarReporte($codigo_reporte)
{
    $objResponse = new xajaxResponse();
    $mdl         = AutoCarga::factory('AtencionVictimasAccidentesSQL', 'classes', 'app', 'AtencionVictimasAccidentes');

    $rst = $mdl->MarcarComoEnviadaCircular($codigo_reporte);

    if ($rst) {
        $objResponse->alert("SE MARCO COMO ENVIADO EL REPORTE.");
        $objResponse->script("location.reload();");
    } else {
        $objResponse->alert("ERROR " . $obje->mensajeDeError);
    }

    return $objResponse;
}

function EliminarReporteCircular($codigo_reporte)
{
    $objResponse = new xajaxResponse();
    $mdl         = AutoCarga::factory('AtencionVictimasAccidentesSQL', 'classes', 'app', 'AtencionVictimasAccidentes');

    $rst = $mdl->EliminarViewReporte($codigo_reporte);

    if ($rst) {
        $objResponse->alert("EL REPORTE SE ELIMINO CORRECTAMENTE.");
        $objResponse->script("location.reload();");
    } else {
        $objResponse->alert("ERROR " . $obje->mensajeDeError);
    }

    return $objResponse;
}


