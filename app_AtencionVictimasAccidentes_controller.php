<?php

/**
 * @package Fabilu
 * @version 1.0
 * @copyright (C) 2018
 * @author Steven Garcia
 */

class app_AtencionVictimasAccidentes_controller extends classModulo
{
    public function main()
    {
        $request = $_REQUEST;

        $usuario  = UserGetUID();
        $permisos = ModuloGetPermisos($request['contenedor'], $request['modulo'], $usuario);

        SessionDelVar("AtencionVictimasAccidentes");

        $url[0] = 'app'; // Tipo de módulo
        $url[1] = 'AtencionVictimasAccidentes'; // Nombre del módulo
        $url[2] = 'controller'; // Tipo metodología
        $url[3] = 'consultarSoat'; // Método al que se va a dirigir
        $url[4] = 'Permisos';

        $arreglo[0] = 'EMPRESA'; // Permisos por empresa

        $this->salida = MenuAcceso('ATENCION VICTIMAS ACCIDENTES', $arreglo, $permisos, $url, ModuloGetURL('system', 'Menu'));
        return true;
    }

    public function reporte()
    {
        $request  = $_REQUEST;
        $empresa  = UserGetEmpresas(UserGetUID());
        $usuario  = UserGetUID();
        $permisos = ModuloGetPermisos("app", "AtencionVictimasAccidentes", $usuario);

        $Obj_Menu = AutoCarga::factory("AtencionVictimasAccidentesHTML", "views", "app", "AtencionVictimasAccidentes");
        $sql      = AutoCarga::factory('AtencionVictimasAccidentesSQL', 'classes', 'app', 'AtencionVictimasAccidentes');
        IncludeFileModulo('AtencionVictimasAccidentesXajax', 'RemoteXajax', 'app', 'AtencionVictimasAccidentes');
        $this->SetXajax(array('GenerarReporte', 'EnviarReporte', 'EliminarReporteCircular'), null, 'ISO-8859-1');

        $datos = $sql->consultarViewCircular();

        // echo "<pre>";
        // print_r($empresa);
        // echo "</pre>";

        // echo "<pre>";
        // print_r($permisos[$empresa['01']]);
        // echo "</pre>";

        $permisos = ($permisos[$empresa['01']]);

        $action['volver']         = ModuloGetURL('system', 'Menu');
        $action['detalleReporte'] = ModuloGetURL('app', 'AtencionVictimasAccidentes', 'controller', 'DetalleReporte');
        $this->salida             = $Obj_Menu->CrearReportes($action, $request, $reportes, $datos, $permisos);
        return true;
    }

    public function DetalleReporte()
    {
        // $objResponse = new xajaxResponse();
        $sql  = AutoCarga::factory('AtencionVictimasAccidentesSQL', 'classes', 'app', 'AtencionVictimasAccidentes');
        $html = AutoCarga::factory("AtencionVictimasAccidentesHTML", "views", "app", "AtencionVictimasAccidentes");

        $this->IncludeJS('CrossBrowserEvent');
        $this->IncludeJS('CrossBrowserDrag');
        $this->IncludeJS('CrossBrowser');

        $request = $_REQUEST;
        // echo "<pre>";
        // print_r($request);
        // echo "</pre>";
        $datos = $sql->ConsultarReporteCircular($request);

        // echo "<pre>";
        // print_r($datos);
        // echo "</pre>";

        $action['volver']    = ModuloGetURL('app', 'AtencionVictimasAccidentes', 'controller', 'reporte');
        $action['paginador'] = ModuloGetURL('app', 'AtencionVictimasAccidentes', 'controller', 'DetalleReporte', array(
            'id_view' => $request['id_view'])
        );

        $this->salida .= $html->DetalladoCircular($action, $datos, $sql->conteo, $sql->pagina);

        return true;

        // if ($rst) {
        //     $objResponse->alert("EL REPORTE SE ELIMINO CORRECTAMENTE.");
        //     $objResponse->script("location.reload();");
        // } else {
        //     $objResponse->alert("ERROR " . $obje->mensajeDeError);
        // }

        // return $objResponse;
    }

    public function consultarSoat()
    {
        $html = AutoCarga::factory('AtencionVictimasAccidentesHTML', 'views', 'app', 'AtencionVictimasAccidentes');
        $sql  = AutoCarga::factory('AtencionVictimasAccidentesSQL', 'classes', 'app', 'AtencionVictimasAccidentes');

        $this->IncludeJS('CrossBrowserEvent');
        $this->IncludeJS('CrossBrowserDrag');
        $this->IncludeJS('CrossBrowser');

        IncludeFileModulo('AtencionVictimasAccidentesXajax', 'RemoteXajax', 'app', 'AtencionVictimasAccidentes');
        $this->SetXajax(array('MostrarInformacion'), null, 'ISO-8859-1');

        $request = $_REQUEST;
        $datos   = $sql->consultarSOAT($request);

        $action['volver']             = ModuloGetURL('app', 'AtencionVictimasAccidentes', 'controller', 'main');
        $action['registrarAccidente'] = ModuloGetURL('app', 'AtencionVictimasAccidentes', 'controller', 'registrarAccidente');
        $action['paginador']          = ModuloGetURL('app', 'AtencionVictimasAccidentes', 'controller', 'consultarSoat', array(
            'mensaje' => 'PAGINANDO')
        );

        $this->salida .= $html->consultarSoat($action, $datos, $sql->conteo, $sql->pagina);

        return true;
    }

    public function consultarVictimasAccidentes()
    {
        $html = AutoCarga::factory('AtencionVictimasAccidentesHTML', 'views', 'app', 'AtencionVictimasAccidentes');
        $sql  = AutoCarga::factory('AtencionVictimasAccidentesSQL', 'classes', 'app', 'AtencionVictimasAccidentes');

        $this->IncludeJS('CrossBrowserEvent');
        $this->IncludeJS('CrossBrowserDrag');
        $this->IncludeJS('CrossBrowser');

        IncludeFileModulo('AtencionVictimasAccidentesXajax', 'RemoteXajax', 'app', 'AtencionVictimasAccidentes');
        $this->SetXajax(array('MostrarInformacion'), null, 'ISO-8859-1');

        $request = $_REQUEST;
        $datos   = $sql->consultarVictimas($request);

        $action['volver']             = ModuloGetURL('app', 'AtencionVictimasAccidentes', 'controller', 'main');
        $action['registrarAccidente'] = ModuloGetURL('app', 'AtencionVictimasAccidentes', 'controller', 'registrarAccidente');
        $action['paginador']          = ModuloGetURL('app', 'AtencionVictimasAccidentes', 'controller', 'consultarVictimasAccidentes', array(
            'mensaje' => 'PAGINANDO')
        );

        $this->salida .= $html->consultarVictimasAccidentes($action, $datos, $sql->conteo, $sql->pagina);

        return true;
    }

    public function registrarAccidente()
    {
        $request           = $_REQUEST;
        $empresa           = SessionGetVar("empresa_id");
        $action['volver']  = ModuloGetURL('app', 'AtencionVictimasAccidentes', 'controller', 'consultarVictimasAccidentes');
        $action['guardar'] = ModuloGetURL("app", "AtencionVictimasAccidentes", "controller", "registrarAccidente");
        if ($request['radicado_id']) {
            $sql      = AutoCarga::factory("AtencionVictimasAccidentesSQL", "classes", "app", "AtencionVictimasAccidentes");
            $reportes = $sql->insertVictimaAccidente($request);
        }
        $Obj_Menu = AutoCarga::factory("AtencionVictimasAccidentesHTML", "views", "app", "AtencionVictimasAccidentes");

        $sql = AutoCarga::factory("AtencionVictimasAccidentesSQL", "classes", "app", "AtencionVictimasAccidentes");
        $ARL = $sql->consultarARL();
        $EPS = $sql->consultarEPS();

        $this->salida = $Obj_Menu->registrarAccidente($action, $request, $reportes, $EPS, $ARL);
        return true;
    }

    public function EnviarNotificacionAccidente()
    {

        $request = $_REQUEST;

        $sql                     = AutoCarga::factory("AtencionVictimasAccidentesSQL", "classes", "app", "AtencionVictimasAccidentes");
        $datos1                  = $sql->empresa();
        $envio                   = $sql->ActualizarEnvioAccidente($request['radicado_id']);
        $datos2                  = $sql->datosAccidente($request['radicado_id']);
        $correos_institucionales = $sql->consultarCorreosInstitucionales();

        $mail = AutoCarga::factory("Mail");

        $email_envia  = "fabilu.clinicacolombia@gmail.com";
        $email_nombre = "Fabilu - Clinica Colombia.";

        $email_eps = $datos2[0]['correo_eps'];
        $email_arl = $datos2[0]['correo_arl'];

        foreach ($correos_institucionales as $key => $correo) {
            $correoEnvio = $correo['correo'];
            $mail->SetDestinatarios($correoEnvio);
        }

        $mail->SetDestinatarios($email_arl);
        $mail->SetDestinatarios($email_eps);
        // $mail->SetDestinatarios($email_clinica);
        // $mail->SetDestinatarios($email_clinica2);
        $mail->SetDestinatariosCC($email_envia, $email_nombre);

        $mail->SetRemitente($email_envia, $email_nombre);

        $asunto = "Informe de atencion de victima de accidente de transito, No. Radicado " . $request['radicado_id'];

        $contenido = "Mensaje enviado automaticamente, por favor nos responder a este correo. De acuerdo a la resolucion numero 3823, en la cual se establecio el mecanismo para el reporte de informacion de la atencion en ";
        $contenido .= "salud a victimas de accidentes de transito, asi como las condiciones para la realizacion de las autoridades por las atenciones en salud brindadas a ";
        //$contenido .= "victimas de estos eventos. se le informa a la entidad el acontecimiento sucedido con uno de sus afiliados.";
        $contenido .= "victimas de estos eventos. se le informa a la entidad el acontecimiento sucedido con uno de sus afiliados. Se envía una copia de este correo a las siguientes direcciones." . $datos2[0]['correo_arl'] . ", " . $datos2[0]['correo_eps'] . ".";

        $contenido .= "<HTML><BODY>";
        $contenido .= "<TABLE WIDTH='100%' BORDER=0>";

        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
        $contenido .= "<b>REPÚBLICA DE COLOMBIA</b>";
        $contenido .= "</FONT></TD>";
        $contenido .= "</TR>";

        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
        $contenido .= "<b>MINISTERIO DE SALUD Y PROTECCION SOCIAL</b>";
        $contenido .= "</FONT></TD>";
        $contenido .= "</TR>";

        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'><br>";
        $contenido .= "INFORME DE LA ATENCION EN SALUD PRESTADA A VICTIMAS DE ACCIDENTES<br>";
        $contenido .= "DE TRANSITO<br></FONT>";
        $contenido .= "</TD>";
        $contenido .= "</TR>";

        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Fecha de radicación:</FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['date_create'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>No. Radicado:</FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['radicado_id'] . "</FONT></TD>";
        $contenido .= "</TR>";

        $contenido .= "</TABLE>";

        $contenido .= "<TABLE WIDTH='100%' BORDER=1>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
        $contenido .= "&nbsp;<br><b>I. INFORMACION DEL PRESTADOR </b>&nbsp;<br>&nbsp;<br>";
        $contenido .= "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Nombre o razón Social:</FONT></TD>";
        $contenido .= "<TD COLSPAN='3' ALIGN='LEFT'><FONT SIZE='1'>" . $datos1[0]['razon_social'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Identificación:</FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos1[0]['tipo_id_tercero'] . " " . $datos1[0]['id'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Codigo de habilitacion:</FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos1[0]['codigo_sgsss'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Dirección del prestador:</FONT></TD>";
        $contenido .= "<TD COLSPAN='3' ALIGN='LEFT'><FONT SIZE='1'>" . $datos1[0]['direccion'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Teléfono: </FONT></TD>";
        $contenido .= "<TD COLSPAN='3' ALIGN='LEFT'><FONT SIZE='1'>" . $datos1[0]['telefonos'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Departamento:</FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos1[0]['departamento'] . " Cód.: " . $datos1[0]['tipo_dpto_id'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Municipio:</FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos1[0]['municipio'] . " Cód.: " . $datos1[0]['tipo_mpio_id'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "</TABLE>";

        $contenido .= "<TABLE WIDTH='100%' BORDER=1>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
        $contenido .= "&nbsp;<br><b>II. DATOS DE LA VICTIMA DEL ACCIDENTE DE TRANSITO</b>&nbsp;<br>&nbsp;<br>";
        $contenido .= "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['primerapellidovictima'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['segundoapellidovictima'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['primernombrevictima'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['segundonombrevictima'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>1er Apellido</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>2do Apellido</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>1er Nombre</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>2do Nombre</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Identificación: </FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['tipoidentificacionvictima'] . " " . $datos2[0]['numeroindentificacionvictima'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Fecha de nacimiento: </FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['fechanacimientovictima'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "</TABLE>";

        $contenido .= "<TABLE WIDTH='100%' BORDER=1>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
        $contenido .= "&nbsp;<br><b>III. TIPO DE INGRESO A LOS SERVICIOS DE SALUD</b>&nbsp;<br>&nbsp;<br>";
        $contenido .= "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>Tipo de atencion: </FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['tipoatencion'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>fecha de atencion: </FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['datetimeatencion'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>Victima viene remitida: </FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['remision'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>Codigo de habilitacion: </FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['codigohabilitacion'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='2'  WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>Razón social del prestador de servicio de salud que remite: </FONT></TD>";
        $contenido .= "<TD COLSPAN='2' WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['prestadorservicio'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Departamento: </FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['departamentoremision'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Municipio: </FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['municipioremision'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "</TABLE>";

        $contenido .= "<TABLE WIDTH='100%' BORDER=1>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='2' ALIGN='CENTER'><FONT SIZE='1'>";
        $contenido .= "&nbsp;<br><b>IV. INFORMACIÓN DEL TRASPORTE AL PRIMER SITIO DE ATENCIÓN </b>&nbsp;<br>&nbsp;<br>";
        $contenido .= "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>Víctima fue trasladada en trasporte especial de paciente : </FONT></TD>";
        $contenido .= "<TD WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['transporteespecial'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>Codigo del prestador de transporte especial: </FONT></TD>";
        $contenido .= "<TD WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['transportecodigo'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>placa del vehiculo: </FONT></TD>";
        $contenido .= "<TD WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['transporteplaca'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "</TABLE>";

        $contenido .= "<TABLE WIDTH='100%' BORDER=1>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
        $contenido .= "&nbsp;<br><b>V. DATOS DEL ACCIDENTE </b>&nbsp;<br>&nbsp;<br>";
        $contenido .= "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='2' WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>Fecha del accidente: </FONT></TD>";
        $contenido .= "<TD COLSPAN='2' WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['datetimeaccidente'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='2' WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>Dirección: </FONT></TD>";
        $contenido .= "<TD COLSPAN='2' WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['direccionaccidente'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Departamento: </FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['departamentoaccidente'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Municipio: </FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['municipioaccidente'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "</TABLE>";

        $contenido .= "<TABLE WIDTH='100%' BORDER=1>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
        $contenido .= "&nbsp;<br><b>VI. DATOS DEL VEHICULÓ INVOLUCRADO EN EL ACCIDENTE DE TRANSITO </b>&nbsp;<br>&nbsp;<br>";
        $contenido .= "</FONT></TD>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Placa: </FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['placavehiculoinvolucrado'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Vehiculó no identificado: </FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['vehiculoinvolucrado'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "</TABLE>";

        $contenido .= "<TABLE WIDTH='100%' BORDER=1>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
        $contenido .= "&nbsp;<br><b>VII. DATOS DEL CONDUCTOR DEL VEHICULÓ INVOLUCRADO EN EL ACCIDENTE </b>&nbsp;<br>&nbsp;<br>";
        $contenido .= "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['primerapellidoinvolucrado'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['segundoapellidoinvolucrado'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['primernombreinvolucrado'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['segundonombreinvolucrado'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>1er Apellido</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>2do Apellido</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>1er Nombre</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>2do Nombre</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='2' WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>Identificación: </FONT></TD>";
        $contenido .= "<TD COLSPAN='2' WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['tipoidentificacioninvolucrado'] . " " . $datos2[0]['numeroindentificacioninvolucrado'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Dirección del conductor:</FONT></TD>";
        $contenido .= "<TD COLSPAN='3' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['direccioninvolucrado'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Teléfono: </FONT></TD>";
        $contenido .= "<TD COLSPAN='3' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['telefonoinvolucrado'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Departamento:</FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['departamentoconductorinvolucrado'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Municipio:</FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['municipioconductorinvolucrado'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "</TABLE>";

        $contenido .= "<TABLE WIDTH='100%' BORDER=1>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
        $contenido .= "&nbsp;<br><b>VIII. INFORMACIÓN DE LA PERONA QUE REPORTA LA ATENCIÓN </b>&nbsp;<br>&nbsp;<br>";
        $contenido .= "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['primerapellidoencargado'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['segundoapellidoencargado'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['primernombreencargado'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['segundonombreencargado'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>1er Apellido</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>2do Apellido</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>1er Nombre</FONT></TD>";
        $contenido .= "<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>2do Nombre</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD COLSPAN='2' WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>Identificación: </FONT></TD>";
        $contenido .= "<TD COLSPAN='2' WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['tipoidentificacionencargado'] . " " . $datos2[0]['numeroindentificacionencargado'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Cargo :</FONT></TD>";
        $contenido .= "<TD COLSPAN='3' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['cargoencargado'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "<TR>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Telefono:</FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['telefonoencargado'] . "</FONT></TD>";
        $contenido .= "<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Extencion:</FONT></TD>";
        $contenido .= "<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>" . $datos2[0]['extencionencargado'] . "</FONT></TD>";
        $contenido .= "</TR>";
        $contenido .= "</TABLE>";

        $mail->SetAsunto($asunto);

        $mail->SetMensaje($contenido);

        //$mail->SetAdjunto($tmpname);

        $rst = $mail->EnviarMail();
        if (!$rst) {
            $mensaje .= "<br>" . $mail->mensajeDeError;
        } else {
            echo "<center><b><h3><font color=\"red\">Mensaje enviado.</font></h3></b></center>";
        }

        $ir = ModuloGetURL('app', 'AtencionVictimasAccidentes', 'controller', 'consultarVictimasAccidentes');
        header('Location:' . $ir);
        return true;
    }
}
