<?php

class AtencionVictimasAccidentesSQL extends ConexionBD
{
    /*
     * Inicio funcion de consulta Soat
     */

    public function consultarSOAT($request)
    {
        if ($request['poliza'] != '') {
            $sql = " select  se.evento AS evento, ";
            $sql .= "         se.poliza AS poliza, ";
            $sql .= "         se.tipo_id_paciente AS tipo_documento, ";
            $sql .= "         se.paciente_id AS documento, ";
            $sql .= "         sp.placa_vehiculo AS placa, ";
            $sql .= "         se.fecha_registro AS fecha";
            $sql .= " from    soat_eventos AS se   ";
            $sql .= "     JOIN    soat_polizas AS sp ON (sp.poliza = se.poliza) ";
            $sql .= " WHERE   se.poliza =RTRIM('" . $request['poliza'] . "')";

            //$this->debug = true;

            if (!$rst = $this->ConexionBaseDatos($sql)) {
                return false;
            }

            $datos = array();
            while (!$rst->EOF) {
                $datos[] = $rst->GetRowAssoc($ToUpper = false);
                $rst->MoveNext();
            }

            $rst->Close();

            return $datos;
        }
    }

    /*
     * Fin funcion de consulta Soat
     */

    /*
     * Inicio funcion de consulta view circular 015
     */

    public function consultarViewCircular()
    {

        $sql = "SELECT  id_view,
                        UPPER(nombre_view) AS nombre_view,
                        periodo_reportado,
                        TO_CHAR(fecha_reporte,'DD TMMonth YYYY') AS fecha_reporte,
                        estado,
                        usuario_id,
                        usuario_id_envio ";
        $sql .= "FROM views_cirucular_015 ";
        $sql .= "WHERE id_usuario_eliminar IS NULL ";

        //$this->debug = true;

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $datos = array();
        while (!$rst->EOF) {
            $datos[] = $rst->GetRowAssoc($ToUpper = false);
            $rst->MoveNext();
        }

        $rst->Close();

        return $datos;

    }

    /*
     * Fin funcion de consulta view circular 015
     */

    /*
     * Inicio funcion de consulta Soat
     */

    public function consultarARL()
    {
        $sql = " select nombre_arl, correo_arl from correos_arl ";

        //$this->debug = true;

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $ARL = array();
        while (!$rst->EOF) {
            $ARL[] = $rst->GetRowAssoc($ToUpper = false);
            $rst->MoveNext();
        }

        $rst->Close();

        return $ARL;
    }

    /*
     * Fin funcion de consulta Soat
     */

    /*
     * Inicio funcion de consulta Soat
     */

    public function consultarEPS()
    {
        $sql = " select nombre_eps, correo_eps from correos_eps ";

        //$this->debug = true;

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $EPS = array();
        while (!$rst->EOF) {
            $EPS[] = $rst->GetRowAssoc($ToUpper = false);
            $rst->MoveNext();
        }

        $rst->Close();

        return $EPS;
    }

    /*
     * Fin funcion de consulta Soat
     */

    /*
     * Inicio: Funcion de insercion SQL en la tabla victimas_accidentes
     */

    public function insertVictimaAccidente($request)
    {

        $ruta_archivo = "cache/tmp3823_" . UserGetUID();
        mkdir($ruta_archivo);
        $fichero_subido = $ruta_archivo;

        if (isset($_FILES['fichero_usuario']['name'])) {

            $fichero_subido = $fichero_subido . basename($_FILES['fichero_usuario']['name']);
        }

        if ($fichero_subido != '/') {
            if (move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido)) {

            } else {

            }
        }

        function removeEmptyElements(&$element)
        {
            if (is_array($element)) {
                if ($key = key($element)) {
                    $element[$key] = array_filter($element);
                }

                if (count($element) != count($element, COUNT_RECURSIVE)) {
                    $element = array_filter(current($element), __FUNCTION__);
                }

                $element = array_filter($element);

                return $element;
            } else {
                return empty($element) ? false : $element;
            }
        }

        $sql_id = " SELECT  * ";
        $sql_id .= " FROM    victimas_accidentes";
        $sql_id .= " WHERE radicado_id = '" . $request['radicado_id'] . "'";

        if (!$rst = $this->ConexionBaseDatos($sql_id)) {
            return false;
        }

        $datos = array();
        while (!$rst->EOF) {
            $datos[] = $rst->GetRowAssoc($ToUpper = false);
            $rst->MoveNext();
        }

        if (!empty($datos)) {
            echo "<center><b><h3><font color=\"red\">El numero de radicado ya existe.</font></h3></b></center>";
            return false;
        }

        $csvReporte = str_getcsv(file_get_contents($fichero_subido));

        $dataReporte = $csvReporte;

        if ($dataReporte[10] == 'SISTEMA DE INFORMACION DE REPORTES DE ATENCION EN SALUD A VICTIMAS DE ACCIDENTES  DE TRANSITO') {

            $ReporteAcccidente = array(

                "primerApellidoVictima"            => $dataReporte[88],
                "segundoApellidoVictima"           => $dataReporte[95],
                "primerNombreVictima"              => $dataReporte[106],
                "segundoNombreVictima"             => $dataReporte[119],
                "tipoIdentificacionVictima"        => $dataReporte[177],
                "numeroIndentificacionVictima"     => $dataReporte[199],
                "fechaNacimientoVictima"           => $dataReporte[217],
                "tipoAtencion"                     => $dataReporte[291],
                "datetimeAtencion"                 => $dataReporte[313],
                "remision"                         => $dataReporte[331],
                "prestadorServicio"                => $dataReporte[371],
                "codigoHabilitacion"               => $dataReporte[411],
                "departamentoRemision"             => $dataReporte[652],
                "municipioRemision"                => $dataReporte[714],
                "transporteEspecial"               => $dataReporte[499],
                "transporteCodigo"                 => $dataReporte[539],
                "transportePlaca"                  => $dataReporte[556],
                "datetimeAccidente"                => $dataReporte[612],
                "departamentoAccidente"            => $dataReporte[652],
                "municipioAccidente"               => $dataReporte[714],
                "direccionAccidente"               => $dataReporte[772],
                "vehiculoInvolucrado"              => $dataReporte[858],
                "placaVehiculoInvolucrado"         => $dataReporte[873],
                "primerApellidoInvolucrado"        => $dataReporte[927],
                "segundoApellidoInvolucrado"       => $dataReporte[934],
                "primerNombreInvolucrado"          => $dataReporte[945],
                "segundoNombreInvolucrado"         => $dataReporte[958],
                "tipoIdentificacionInvolucrado"    => $dataReporte[1017],
                "numeroIndentificacionInvolucrado" => $dataReporte[1035],
                "direccionInvolucrado"             => $dataReporte[1057],
                "DepartamentoConductorInvolucrado" => $dataReporte[1097],
                "municipioConductorInvolucrado"    => $dataReporte[1115],
                "telefonoInvolucrado"              => "",
                "primerApellidoEncargado"          => $dataReporte[1205],
                "segundoApellidoEncargado"         => $dataReporte[1213],
                "primerNombreEncargado"            => $dataReporte[1224],
                "segundoNombreEncargado"           => $dataReporte[1237],
                "tipoIdentificacionEncargado"      => $dataReporte[1296],
                "numeroIndentificacionEncargado"   => $dataReporte[1317],
                "telefonoEncargado"                => $dataReporte[1336],
                "extencionEncargado"               => $dataReporte[1357],
                "cargoEncargado"                   => $dataReporte[1376],

            );

            $sql .= " INSERT INTO victimas_accidentes ";
            $sql .= " ( ";
            $sql .= "    radicado_id, ";
            $sql .= "    primerapellidovictima, ";
            $sql .= "    segundoapellidovictima, ";
            $sql .= "    primernombrevictima, ";
            $sql .= "    segundonombrevictima, ";
            $sql .= "    tipoidentificacionvictima, ";
            $sql .= "    numeroindentificacionvictima, ";
            $sql .= "    fechanacimientovictima, ";
            $sql .= "    tipoatencion, ";
            $sql .= "    datetimeatencion, ";
            $sql .= "    remision, ";
            $sql .= "    prestadorservicio, ";
            $sql .= "    codigohabilitacion, ";
            $sql .= "    departamentoremision, ";
            $sql .= "    municipioremision, ";
            $sql .= "    transporteespecial, ";
            $sql .= "    transportecodigo, ";
            $sql .= "    transporteplaca, ";
            $sql .= "    datetimeaccidente, ";
            $sql .= "    departamentoaccidente, ";
            $sql .= "    municipioaccidente, ";
            $sql .= "    direccionaccidente, ";
            $sql .= "    vehiculoinvolucrado, ";
            $sql .= "    placavehiculoinvolucrado, ";
            $sql .= "    primerapellidoinvolucrado, ";
            $sql .= "    segundoapellidoinvolucrado, ";
            $sql .= "    primernombreinvolucrado, ";
            $sql .= "    segundonombreinvolucrado, ";
            $sql .= "    tipoidentificacioninvolucrado, ";
            $sql .= "    numeroindentificacioninvolucrado, ";
            $sql .= "    direccioninvolucrado, ";
            $sql .= "    departamentoconductorinvolucrado, ";
            $sql .= "    municipioconductorinvolucrado, ";
            $sql .= "    telefonoinvolucrado, ";
            $sql .= "    primerapellidoencargado, ";
            $sql .= "    segundoapellidoencargado, ";
            $sql .= "    primernombreencargado, ";
            $sql .= "    segundonombreencargado, ";
            $sql .= "    tipoidentificacionencargado, ";
            $sql .= "    numeroindentificacionencargado, ";
            $sql .= "    telefonoencargado, ";
            $sql .= "    extencionencargado, ";
            $sql .= "    cargoencargado, ";
            $sql .= "    date_create, ";
            $sql .= "    correo_eps, ";
            $sql .= "    correo_arl ";
            $sql .= " ) ";
            $sql .= " VALUES ";
            $sql .= " ( ";
            $sql .= "    '" . $request['radicado_id'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['primerApellidoVictima'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['segundoApellidoVictima'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['primerNombreVictima'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['segundoNombreVictima'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['tipoIdentificacionVictima'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['numeroIndentificacionVictima'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['fechaNacimientoVictima'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['tipoAtencion'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['datetimeAtencion'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['remision'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['prestadorServicio'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['codigoHabilitacion'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['departamentoRemision'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['municipioRemision'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['transporteEspecial'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['transporteCodigo'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['transportePlaca'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['datetimeAccidente'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['departamentoAccidente'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['municipioAccidente'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['direccionAccidente'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['vehiculoInvolucrado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['placaVehiculoInvolucrado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['primerApellidoInvolucrado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['segundoApellidoInvolucrado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['primerNombreInvolucrado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['segundoNombreInvolucrado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['tipoIdentificacionInvolucrado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['numeroIndentificacionInvolucrado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['direccionInvolucrado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['DepartamentoConductorInvolucrado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['municipioConductorInvolucrado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['telefonoInvolucrado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['primerApellidoEncargado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['segundoApellidoEncargado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['primerNombreEncargado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['segundoNombreEncargado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['tipoIdentificacionEncargado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['numeroIndentificacionEncargado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['telefonoEncargado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['extencionEncargado'] . "', ";
            $sql .= "    '" . $ReporteAcccidente['cargoEncargado'] . "', ";
            $sql .= "    '" . date('m/d/Y g:ia') . "', ";
            $sql .= "    '" . $request['EPS'] . "', ";
            $sql .= "    '" . $request['ARL'] . "' ";
            $sql .= " ) ";

            //echo $sql;
            //$this->debug = true;

            if (!$rst = $this->ConexionBaseDatos($sql)) {
                return false;
            }
            $ir = ModuloGetURL('app', 'AtencionVictimasAccidentes', 'controller', 'consultarVictimasAccidentes');
            header('Location:' . $ir);
            return true;
        } else {
            echo "<center><b><h3><font color=\"red\">El archivo que se esta cargando no es el correcto.</font></h3></b></center>";
        }
    }

    /*
     * Fin: Funcion de insercion SQL en la tabla victimas_accidentes
     */

    /*
     * Inicio funcion de consulta Soat
     */

    public function consultarVictimas($request)
    {
        // echo "<pre>";
        // print_r($request);
        // echo "</pre>";

        $sql = " SELECT  * ";
        $sql .= " FROM    victimas_accidentes";
        if ($request[radicado_id] != '') {
            $sql .= " WHERE radicado_id = '" . $request['radicado_id'] . "' ";
        }
        if (!$this->ProcesarSqlConteo("SELECT COUNT(*) FROM (" . $sql . ") A", $form['offset'])) {
            return false;
        }

        $sql .= " ORDER BY estado ASC ";
        $sql .= " LIMIT " . $this->limit . " OFFSET " . $this->offset . " ";

        //$this->debug = true;

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $datos = array();
        while (!$rst->EOF) {
            $datos[] = $rst->GetRowAssoc($ToUpper = false);
            $rst->MoveNext();
        }

        $rst->Close();

        return $datos;
    }

    /*
     * Fin funcion de consulta Soat
     */

    public function empresa()
    {
        $sql = "SELECT *
          from empresas AS e
          join tipo_mpios AS m on (e.tipo_mpio_id = m.tipo_mpio_id and e.tipo_dpto_id = m.tipo_dpto_id)
          join tipo_dptos AS d ON (m.tipo_dpto_id = d.tipo_dpto_id and d.tipo_pais_id = m.tipo_pais_id)
          limit 1";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $datos = array();
        while (!$rst->EOF) {
            $datos[] = $rst->GetRowAssoc($ToUpper = false);
            $rst->MoveNext();
        }

        $rst->Close();

        return $datos;
    }

    public function datosAccidente($radicado_id)
    {

        $sql = "SELECT *
            FROM victimas_accidentes
            WHERE radicado_id = '" . $radicado_id . "'";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $datos = array();
        while (!$rst->EOF) {
            $datos[] = $rst->GetRowAssoc($ToUpper = false);
            $rst->MoveNext();
        }

        $rst->Close();

        return $datos;
    }

    public function ActualizarEnvioAccidente($radicado_id)
    {

        $sql = "UPDATE victimas_accidentes ";
        $sql .= "SET    estado = 1 ";
        $sql .= "WHERE  radicado_id  = '" . $radicado_id . "' ";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        return true;
    }

    public function CrearViewCircular015($form)
    {
        // $this->debug = true;

        $sql = " SELECT valor ";
        $sql .= " FROM system_modulos_variables ";
        $sql .= " WHERE variable = 'id_FIDUFOSYGA' AND ";
        $sql .= "       modulo = '' ";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $id_FIDUFOSYGA = $rst->fields[0];

        $sql = " SELECT valor ";
        $sql .= " FROM system_modulos_variables ";
        $sql .= " WHERE variable = 'id_FIDUFOSYGA_ADRES' AND ";
        $sql .= "       modulo = '' ";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $id_FIDUFOSYGA_ADRES = $rst->fields[0];

        $fecha_inicial = str_replace("/", "", $form['fecha_inicial']);
        $fecha_final   = str_replace("/", "", $form['fecha_final']);

        $nombreView = "matview.view_circular_" . $fecha_inicial . "_" . $fecha_final . "";

        $sql = " create materialized view " . $nombreView . " AS ";
        $sql .= " SELECT  CASE  WHEN pz.tercero_id = '" . $id_FIDUFOSYGA . "' OR
                                     pz.tercero_id = '" . $id_FIDUFOSYGA_ADRES . "'
                                THEN '0'
                                ELSE SUBSTRING(REPLACE(pz.poliza,' ',''), 1, 20)
                          END                                                                               AS  idPoliza, ";
        $sql .= "         CASE WHEN pz.tercero_id = '" . $id_FIDUFOSYGA . "' OR
                                     pz.tercero_id = '" . $id_FIDUFOSYGA_ADRES . "'
                               THEN '00000000'
                               WHEN pz.vigencia_hasta IS NULL
                               THEN '00000000'
                               ELSE TO_CHAR(pz.vigencia_hasta, 'YYYYMMDD')
                          END                                                                               AS  fechaVencimiento, ";
        $sql .= "         CONCAT  (ev.tipo_id_paciente, ' ', ev.paciente_id)                                AS  idvictima, ";
        $sql .= "         em.codigo_sgsss                                                                   AS  codigoPrestador, ";
        $sql .= "         em.id                                                                             AS  idPrestador, ";
        $sql .= "         CASE WHEN sa.fecha_accidente IS NULL THEN '00000000'
                               ELSE TO_CHAR(sa.fecha_accidente, 'YYYYMMDD') END                             AS  fechaSiniestro, ";
        $sql .= "         pz.tercero_id                                                                     AS  idPagador, ";
        $sql .= "         CONCAT  (f.prefijo, ' ', f.factura_fiscal)                                        AS  idFactura, ";
        $sql .= "CASE WHEN f.fecha_registro IS NULL THEN '00000000' ELSE TO_CHAR(f.fecha_registro,'YYYYMMDD') END        AS  fechaFactura,
       CASE WHEN e.fecha_radicacion IS NULL THEN '00000000' ELSE TO_CHAR(e.fecha_radicacion, 'YYYYMMDD') END    AS  fechaRadicacion,

        CASE WHEN vp.valorPro IS NULL AND  vp2.valorPaquetes > 0 THEN ROUND(vp2.valorPaquetes, 0)
                WHEN vp.valorPro IS NULL AND  vp2.valorPaquetes IS NULL THEN 0
                ELSE ROUND((vp.valorPro + CASE WHEN vp2.valorPaquetes IS NULL THEN 0
                                               ELSE vp2.valorPaquetes
                                          END), 0)
        END                                                                                                     AS  valorProcedimientos,

        CASE WHEN ROUND((f.total_factura-
                        (CASE WHEN vp2.valorPaquetes IS NULL THEN 0 ELSE vp2.valorPaquetes END
                       + CASE WHEN vi.valoInsu  IS NULL THEN 0 ELSE vi.valoInsu  END
                       + CASE WHEN vm.valorMed IS NULL THEN 0 ELSE vm.valorMed END
                       + CASE WHEN vp.valorPro IS NULL THEN 0 ELSE vp.valorPro END )), 0) > 0

             THEN CASE WHEN vi.valoInsu IS NULL THEN 0 ELSE ROUND(vi.valoInsu, 0) END +
                            ROUND((f.total_factura-
                                     (CASE WHEN vp2.valorPaquetes IS NULL THEN 0 ELSE vp2.valorPaquetes END
                                    + CASE WHEN vi.valoInsu  IS NULL THEN 0 ELSE vi.valoInsu  END
                                    + CASE WHEN vm.valorMed IS NULL THEN 0 ELSE vm.valorMed END
                                    + CASE WHEN vp.valorPro IS NULL THEN 0 ELSE vp.valorPro END )), 0)


             WHEN ROUND((f.total_factura-
                        (CASE WHEN vp2.valorPaquetes IS NULL THEN 0 ELSE vp2.valorPaquetes END
                       + CASE WHEN vi.valoInsu  IS NULL THEN 0 ELSE vi.valoInsu  END
                       + CASE WHEN vm.valorMed IS NULL THEN 0 ELSE vm.valorMed END
                       + CASE WHEN vp.valorPro IS NULL THEN 0 ELSE vp.valorPro END )), 0) < 0

             THEN CASE WHEN vi.valoInsu IS NULL THEN 0 ELSE ROUND(vi.valoInsu, 0) END +
                      ROUND((f.total_factura-
                             (CASE WHEN vp2.valorPaquetes IS NULL THEN 0 ELSE vp2.valorPaquetes END
                            + CASE WHEN vi.valoInsu  IS NULL THEN 0 ELSE vi.valoInsu  END
                            + CASE WHEN vm.valorMed IS NULL THEN 0 ELSE vm.valorMed END
                            + CASE WHEN vp.valorPro IS NULL THEN 0 ELSE vp.valorPro END )), 0)

             ELSE CASE WHEN vi.valoInsu IS NULL THEN 0 ELSE ROUND(vi.valoInsu, 0) END
        END                                                                                                         AS  valorInsumos,




          CASE WHEN vm.valorMed IS NULL THEN 0 ELSE ROUND(vm.valorMed, 0) END                                       AS  valorMedicamentos,
          0                                                                                                         AS  valorOtros,
          CASE WHEN f.total_factura IS NULL THEN 0 ELSE ROUND(f.total_factura, 0) END                               AS  valorFactura ";

        $sql .= " FROM fac_facturas    AS  f ";
        $sql .= "   JOIN    fac_facturas_cuentas    AS  fc  ON  ( f.prefijo = fc.prefijo AND ";
        $sql .= "                                                 f.factura_fiscal = fc.factura_fiscal ) ";
        $sql .= "   JOIN    envios_detalle          AS  ed  ON  ( ed.prefijo = f.prefijo AND ";
        $sql .= "                                                 ed.factura_fiscal = f.factura_fiscal ) ";
        $sql .= "   JOIN    cuentas                 AS  c   ON  ( c.numerodecuenta = fc.numerodecuenta ) ";
        $sql .= "   JOIN    ingresos                AS  i   ON  ( i.ingreso = c.ingreso ) ";
        $sql .= "   JOIN    ingresos_soat           AS  ins ON  ( i.ingreso = ins.ingreso ) ";
        $sql .= "   JOIN    soat_eventos            AS  ev  ON  ( ins.evento = ev.evento ) ";
        $sql .= "   JOIN    planes                  AS  pl  ON  ( pl.plan_id = f.plan_id ) ";
        $sql .= "   JOIN    soat_polizas            AS  pz  ON  ( pz.poliza  = ev.poliza AND ";
        $sql .= "                                                 pz.tercero_id = pl.tercero_id AND ";
        $sql .= "                                                 pz.tipo_id_tercero = pl.tipo_tercero_id) ";
        $sql .= "   JOIN    envios                  AS  e   ON  ( ed.envio_id = e.envio_id ) ";
        $sql .= "   LEFT JOIN    soat_accidente     AS  sa  ON  ( ev.accidente_id = sa.accidente_id) ";
        $sql .= "   LEFT JOIN    empresas           AS  em  ON  ( ev.empresa_id   = em.empresa_id ) ";
        $sql .= "   LEFT JOIN  (SELECT numerodecuenta, ";
        $sql .= "                       SUM(valor_cubierto) AS  valorPro ";
        $sql .= "               FROM    cuentas_detalle AS  ed ";
        $sql .= "               WHERE   facturado = '1' ";
        $sql .= "                   AND    ed.paquete_codigo_id IS NULL";
        $sql .= "                   AND    cargo_cups IS NOT NULL";
        $sql .= "               GROUP BY numerodecuenta)  AS  vp  ON  (c.numerodecuenta = vp.numerodecuenta)";

        $sql .= "   LEFT JOIN  (SELECT  numerodecuenta,";
        $sql .= "                       CASE WHEN sum(valor_cubierto) IS NULL THEN 0 ELSE ROUND(sum(valor_cubierto), 0) END AS valorPaquetes";
        $sql .= "               FROM     cuentas_detalle cd";
        $sql .= "               WHERE    cd.paquete_codigo_id IS NOT NULL";
        $sql .= "                   AND  cargo_cups IS NOT NULL";
        $sql .= "                   AND  cd.sw_paquete_facturado = '1'";
        $sql .= "                   AND  facturado = '1'";
        $sql .= "               GROUP BY numerodecuenta) AS vp2 ON (c.numerodecuenta = vp2.numerodecuenta)";

        $sql .= "   LEFT JOIN  (SELECT  numerodecuenta, ";
        $sql .= "                       SUM(cd.valor_cubierto) AS  valorMed ";
        $sql .= "               FROM    cuentas_detalle cd ";
        $sql .= "                   JOIN    bodegas_documentos_d    AS bd    ON  (cd.consecutivo = bd.consecutivo) ";
        $sql .= "                   JOIN    inventarios_productos   AS inv   ON  (bd.codigo_producto = inv.codigo_producto) ";
        $sql .= "                   JOIN    inv_grupos_inventarios  AS gi    ON  (gi.grupo_id = inv.grupo_id) ";
        $sql .= "              WHERE   bd.consecutivo IS NOT NULL ";
        $sql .= "                   AND     cd.paquete_codigo_id IS NULL ";
        $sql .= "                   AND     facturado = '1' ";
        $sql .= "                   AND     sw_medicamento = '1' ";
        $sql .= "               GROUP BY numerodecuenta) AS vm   ON  (c.numerodecuenta = vm.numerodecuenta) ";

        $sql .= "   LEFT JOIN  (SELECT  numerodecuenta, ";
        $sql .= "                       SUM(cd.valor_cubierto) AS  valoInsu ";
        $sql .= "               FROM    cuentas_detalle cd ";
        $sql .= "                   JOIN    bodegas_documentos_d    AS bd    ON  (cd.consecutivo = bd.consecutivo) ";
        $sql .= "                   JOIN    inventarios_productos   AS inv   ON  (bd.codigo_producto = inv.codigo_producto) ";
        $sql .= "                   JOIN    inv_grupos_inventarios  AS gi    ON  (gi.grupo_id = inv.grupo_id) ";
        $sql .= "               WHERE   bd.consecutivo IS NOT NULL ";
        $sql .= "                   AND cd.paquete_codigo_id IS NULL ";
        $sql .= "                   AND facturado = '1' ";
        $sql .= "                   AND sw_insumos = '1' ";
        $sql .= "               GROUP BY numerodecuenta)   AS  vi  ON  (c.numerodecuenta = vi.numerodecuenta) ";
        $sql .= " WHERE       (e.fecha_radicacion)::DATE >= '" . $form['fecha_inicial'] . "' ";
        $sql .= "   AND   (e.fecha_radicacion)::DATE <= '" . $form['fecha_final'] . "' ";
        $sql .= "   AND   pl.tipo_cliente = '20' ";
        $sql .= "   AND   f.estado    IN  ('0', '1') ";
        $sql .= "   AND   e.sw_estado   IN  ('0', '1', '3') ";
        $sql .= "   AND   e.fecha_radicacion::DATE >= f.fecha_registro::DATE ";
        $sql .= "   AND   sa.fecha_accidente::DATE <= pz.vigencia_hasta::DATE ";
        $sql .= "   AND   f.fecha_registro::DATE >= sa.fecha_accidente::DATE ";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $sql1 = " INSERT INTO views_cirucular_015 ";
        $sql1 .= " (nombre_view, periodo_reportado, usuario_id)";
        $sql1 .= " VALUES (";
        $sql1 .= "'" . $nombreView . "', ";
        $sql1 .= "'" . $form['year'] . "', ";
        $sql1 .= UserGetUID();
        $sql1 .= " )";

        if (!$rst = $this->ConexionBaseDatos($sql1)) {
            return false;
        }

        return true;
    }

    public function MarcarComoEnviadaCircular($codigo_reporte)
    {

        $sql = "UPDATE views_cirucular_015 ";
        $sql .= "SET    estado = 2, ";
        $sql .= "       usuario_id_envio = " . UserGetUID() . " ";
        $sql .= "WHERE  id_view  = '" . $codigo_reporte . "' ";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        return true;
    }

    public function EliminarViewReporte($codigo_reporte)
    {
        // $this->debug = true;

        $sql = "SELECT nombre_view FROM views_cirucular_015 ";
        $sql .= "WHERE  id_view  = '" . $codigo_reporte . "' ";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $nombreView = $rst->fields[0];

        $sql = " drop materialized view " . $nombreView . " ";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $sql = " UPDATE views_cirucular_015 ";
        $sql .= " SET    fecha_eliminacion = NOW(), ";
        $sql .= "        id_usuario_eliminar = " . UserGetUID() . " ";
        $sql .= " WHERE  id_view  = '" . $codigo_reporte . "' ";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        return true;
    }

    public function ConsultarReporteCircular($request)
    {
        // $this->debug = true;

        $sql = "SELECT nombre_view FROM views_cirucular_015 ";
        $sql .= "WHERE  id_view  = '" . $request['id_view'] . "' ";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $nombreView = $rst->fields[0];

        $sql = "SELECT * FROM " . trim($nombreView) . " ";
        if ($request[id_documento] != '' || $request[mes_registro] != '') {
            $request['offset'] = 0;
            $sql .= " WHERE ";
            if ($request[id_documento] != '') {
                $sql .= " idvictima LIKE '%" . $request['id_documento'] . "%' ";
            } elseif ($request[mes_registro] != '') {
                $sql .= " EXTRACT(MONTH FROM CAST(fecharadicacion AS DATE))::INTEGER = '" . $request['mes_registro'] . "' ";
            }
        }

        if (!$this->ProcesarSqlConteo("SELECT COUNT(*) FROM (" . $sql . ") A", $request['offset'])) {
            return false;
        }

        // $sql .= " ORDER BY fecharadicacion ASC ";
        $sql .= " LIMIT " . $this->limit . " OFFSET " . $this->offset . " ";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $datos = array();
        while (!$rst->EOF) {
            $datos[] = $rst->GetRowAssoc($ToUpper = false);
            $rst->MoveNext();
        }

        $rst->Close();

        return $datos;
    }

    public function consultarCorreosInstitucionales()
    {
        // $this->debug = true;

        $sql = "SELECT * FROM correos_envio_reporte_victimas ";

        if (!$rst = $this->ConexionBaseDatos($sql)) {
            return false;
        }

        $datos = array();
        while (!$rst->EOF) {
            $datos[] = $rst->GetRowAssoc($ToUpper = false);
            $rst->MoveNext();
        }
        // echo "<pre>";
        // print_r($datos);
        // echo "</pre>";
        $rst->Close();

        return $datos;
    }

};
