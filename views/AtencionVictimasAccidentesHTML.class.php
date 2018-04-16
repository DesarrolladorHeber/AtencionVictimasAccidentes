<?php

/**
 *
 */
class AtencionVictimasAccidentesHTML
{

    public function consultarSoat($action, $datos, $conteo, $pagina)
    {
        /*
         * Inicio: Funcion de envio de soat a consultar
         */
        $html .= "<script>";
        $html .= "  function Validar(formulario)";
        $html .= "  {";
        $html .= "      if(formulario.poliza.value == \"\")";
        $html .= "      document.getElementById('error').innerHTML = 'INGRESAR UN NUMERO DE POLIZA PARA REALIZAR LA BUSQUEDA';\n";
        $html .= "      formulario.action = \"" . $action['buscar'] . "\";\n";
        $html .= "      formulario.submit();\n";
        $html .= "  }";
        $html .= "</script>";
        /*
         * Fin: Funcion de envio de soat a consultar.
         */

        /*
         * Inicio: Consulta victimas de accidentes SOAT.
         */
        $html .= ThemeAbrirTabla('victimasAccidentes');
        $html .= "<table border=\"0\" width=\"80%\" align=\"center\">";

        $html .= "  <tr>\n";
        $html .= "      <td align=\"center\">";
        $html .= "      <div class=\"label_error\" id=\"error\"></div>";
        $html .= "      </td>\n";
        $html .= "  </tr>";

        $html .= "  <tr>\n";
        $html .= "    <td>\n";

        $html .= "      <form name=\"generador_reportes\" method=\"post\" action=\"javascript:Validar(document.generador_reportes)\" id=\"generador_reportes\">\n";
        $html .= "        <table border=\"0\" width=\"75%\" align=\"center\" class=\"modulo_table_list\">";

        $html .= "          <tr class=\"modulo_table_list_title\">";
        $html .= "            <td align=\"center\" colspan=\"4\">";
        $html .= "              VERIFICAR POLIZA";
        $html .= "            </td>\n";
        $html .= "          </tr>\n";

        $html .= "          <tr class=\"modulo_list_claro\">";
        $html .= "            <td width=\"18%\" class=\"formulacion_table_list\" align=\"center\">";
        $html .= "              Poliza";
        $html .= "            </td>";
        $html .= "            <td class=\"label\" align=\"center\">";
        $html .= "              <input size=\"30\" type=\"text\" class=\"input-text\" id=\"poliza\" name=\"poliza\">";
        $html .= "            </td>";
        $html .= "          </tr>";

        $html .= "          <tr class=\"modulo_table_list_title\">";
        $html .= "            <td align=\"center\" colspan=\"2\">";
        $html .= "              <input type=\"submit\" class=\"input-submit\" value=\"Consultar poliza\">";
        $html .= "            </td>";
        $html .= "          </tr>";

        $html .= "        </table>";
        $html .= "      </form>";

        $html .= "    </td>\n";
        $html .= "  </tr>";

        $html .= "</table>";
        $html .= "<br>\n";

        $html .= "<script>";
        $html .= "  function MostrarInformacion(datosPaciente)";
        $html .= "  {";
        $html .= "    xajax_MostrarInformacion(datosPaciente);";
        $html .= "  }";
        $html .= "</script>";

        if (!empty($datos)) {

            $html .= "<table class='modulo_table_list' width='100%' align='center'>";
            $html .= "  <tr class='formulacion_table_list'>";
            $html .= "      <td>EVENTO</td>";
            $html .= "      <td>POLIZA</td>";
            $html .= "      <td>PACIENTE</td>";
            $html .= "      <td>PLACA VEHICULO</td>";
            $html .= "      <td>FECHA</td>";
            $html .= "  </tr>";

            foreach ($datos as $dato => $value) {
                $est = ($est == "modulo_list_claro") ? "modulo_list_oscuro" : "modulo_list_claro";
                $html .= "<tr class=" . $est . ">";
                $html .= "  <td>" . $value['evento'] . "</td>";
                $html .= "  <td>" . $value['poliza'] . "</td>";
                $html .= "  <td>" . $value['tipo_documento'] . " " . $value['documento'] . "</td>";
                $html .= "  <td>" . $value['placa'] . "</td>";
                $html .= "  <td>" . $value['fecha'] . "</td>";
                $html .= "</tr>";
            }
            $html .= "</table>";

            $paginado = AutoCarga::factory('ClaseHTML');

            $html .= $paginado->ObtenerPaginado($conteo, $pagina, $action['paginador']);

        } else {
            $html .= "<br>";
            $html .= "<div style=\"text-align:center\" class=\"label_error\">";
            $html .= "  Busqueda sin resultados.";
            $html .= "</div>";
            $html .= "<div id='contenido'></div>";
        }

        $html .= "<br>";

        $html .= "<div style=\"text-align:center\" class=\"label_error\">";
        $html .= "  <a href=\"" . $action['registrarAccidente'] . "\"><input type=\"submit\" class=\"input-submit\" value=\"REPORTAR VICTIMA\"></a>";
        $html .= "</div>";

        $html .= "<br>";

        $html .= "<div style=\"text-align:center\" class=\"label_error\">";
        $html .= "  <a href=\"" . $action['volver'] . "\">VOLVER</a>";
        $html .= "</div>";

        $html .= "<div id='contenido'></div>";
        $html .= CloseTable();

        return $html;
    }

    public function CrearReportes($action, $request, $reportes, $datos, $permisos)
    {
        /*
         * Inicio: Funcion de validacion de fecha inicial y final para los reportes.
         */
        $ctl = AutoCarga::factory("ClaseUtil");
        $csv = Autocarga::factory("ReportesCsv");

        // $mostrar = $rpt->GetJavaReport('app', 'AtencionVictimasAccidentes', 'reporteVictima', array('fecha_inicial' => '01/01/16', 'fecha_final' => '31/12/16'), array('rpt_name' => '', 'rpt_dir' => 'cache', 'rpt_rewrite' => true, 'csv' => true, 'pdf' => false, 'xls' => true));
        // $html .= $mostrar;
        // $nombreFuncion = $rpt->GetJavaFunction();

        $html .= $ctl->LimpiarCampos();
        $html .= $ctl->RollOverFilas();
        $html .= $ctl->AcceptDate("/");
        $html .= $ctl->IsDate("/");
        $html .= "<script>";

        $html .= "  function Validar(formulario)";
        $html .= "  {";
        $html .= "      if(!IsDate(formulario.fecha_inicial.value))";
        $html .= "      document.getElementById('error').innerHTML = 'LA FECHA INICIAL NO PUEDE ESTAR VACIA';\n";
        $html .= "        else if(!IsDate(formulario.fecha_final.value))";
        $html .= "      document.getElementById('error').innerHTML = 'LA FECHA FINAL NO PUEDE ESTAR VACIA';\n";
        $html .= "      else\n";
        $html .= "      {\n";
        $html .= "          f = formulario.fecha_inicial.value.split('/')\n";
        $html .= "          var f1 = new Date(f[2]+'/'+ f[1]+'/'+ f[0]); \n";
        $html .= "          f = formulario.fecha_final.value.split('/')\n";
        $html .= "          var f2 = new Date(f[2]+'/'+f[1]+'/'+f[0]);\n";
        $html .= "          if(f1 >= f2 )\n";
        $html .= "          {\n";
        $html .= "          document.getElementById('error').innerHTML = 'LA FECHA INICIAL NO PUEDE SER MAYOR A LA FECHA FINAL';\n";
        $html .= "          return;\n";
        $html .= "        } \n";
        $html .= "        else";
        $html .= "          {";
        $html .= "          xajax_GenerarReporte(xajax.getFormValues('generador_reportes'));";
        // $html .= "          ".$nombreFuncion.";";
        $html .= "        }";
        $html .= "      }\n"; //Cierra else de primera validacion de campos
        $html .= "  }\n";

        $html .= "  function EliminarReporteCircular(codigo_reporte,estado)\n";
        $html .= "  {\n";
        $html .= "    if(estado == 2)\n";
        $html .= "      {\n";
        $html .= "          alert('ESTE REPORTE NO PUEDE SER ELIMINADO, YA FUE ENVIADO.');\n";
        $html .= "      }\n";
        $html .= "    if(estado != 2)\n";
        $html .= "      {\n";
        $html .= "    if(confirm('ESTA SEGURO QUE DESEA ELIMINAR ESTA REPORTE?'))\n";
        $html .= "      {\n";
        $html .= "          xajax_EliminarReporteCircular(codigo_reporte);\n";
        $html .= "      }\n";
        $html .= "      }\n";
        $html .= "  }\n";

        $html .= "  function EnviarReporte(codigo_reporte)\n";
        $html .= "  {\n";
        $html .= "    if(confirm('DESEA MARCAR ESTA REPORTE COMO ENVIADO?'))\n";
        $html .= "      {\n";
        $html .= "          xajax_EnviarReporte(codigo_reporte);\n";
        $html .= "      }\n";
        $html .= "  }\n";

        // $html .= "  function DetalleReporte(codigo_reporte)\n";
        // $html .= "  {\n";
        // $html .= "     xajax_DetalleReporte(codigo_reporte);\n";
        // $html .= "  }\n";

        $html .= "</script>";
        /*
         * Fin: Funcion de validacion de fecha inicial y final para los reportes.
         */

        /*
         * Inicio: opciones para la generacion de reporte.
         */
        $html .= ThemeAbrirTabla('REPORTES');
        $html .= "<table border=\"0\" width=\"80%\" align=\"center\">";

        $html .= "  <tr>\n";
        $html .= "      <td align=\"center\">";
        $html .= "      <div class=\"label_error\" id=\"error\"></div>";
        $html .= "      </td>\n";
        $html .= "  </tr>";

        $html .= "  <tr>\n";
        $html .= "    <td>\n";

        $html .= "      <form name=\"generador_reportes\" method=\"post\" action=\"javascript:Validar(document.generador_reportes)\" id=\"generador_reportes\">\n";
        $html .= "        <table border=\"0\" width=\"75%\" align=\"center\" class=\"modulo_table_list\">";

        $html .= "          <tr class=\"modulo_table_list_title\">";
        $html .= "            <td align=\"center\" colspan=\"4\">";
        $html .= "              REPORTE DE RECLAMACIONES POR ACCIDENTES DE TRANSITO ST006";
        $html .= "            </td>\n";
        $html .= "          </tr>\n";

        $html .= "          <tr class=\"modulo_list_claro\">";
        $html .= "            <td width=\"18%\" class=\"formulacion_table_list\" align=\"center\">";
        $html .= "              Fecha Inicial";
        $html .= "            </td>";
        $html .= "            <td class=\"label\" align=\"center\">";
        $html .= "              <input size=\"12\" type=\"text\" class=\"input-text\" id=\"fecha_inicial\" name=\"fecha_inicial\" readonly=\"true\" value=\"" . $request['fecha_inicial'] . "\">";
        $html .= "                " . ReturnOpenCalendario('generador_reportes', 'fecha_inicial', "/", 1);
        $html .= "            </td>";
        $html .= "            <td width=\"18%\" class=\"formulacion_table_list\" align=\"center\">";
        $html .= "              Fecha Final";
        $html .= "            </td>";
        $html .= "            <td class=\"label\" align=\"center\">";
        $html .= "              <input size=\"12\" type=\"text\" class=\"input-text\" id=\"fecha_final\" name=\"fecha_final\" readonly=\"true\" value=\"" . $request['fecha_final'] . "\">";
        $html .= "                " . ReturnOpenCalendario('generador_reportes', 'fecha_final', "/", 1);
        $html .= "            </td>";
        $html .= "          </tr>";

        $html .= "          <tr>";

        $html .= "            <td align=\"center\" colspan=\"2\">";
        $html .= "              <input type=\"submit\" class=\"input-submit\" value=\"GENERAR REPORTE\">";
        $html .= "            </td>";

        $html .= "            <td align=\"center\" colspan=\"2\">\n";
        $html .= "              <input class=\"input-submit\" type=\"button\" name=\"limpiar\"
                                       onclick=\"LimpiarCampos(document.generador_reportes)\" value=\"LIMPIAR CAMPOS\">\n";
        $html .= "            </td>\n";

        $html .= "          </tr>";

        $html .= "        </table>";
        $html .= "      </form>";

        $html .= "    </td>\n";
        $html .= "  </tr>";

        $html .= "</table>";
        $html .= "<br>\n";

        if (!empty($datos)) {

            $html .= "  <table width=\"80%\" class=\"modulo_table_list\"   align=\"center\">";
            $html .= "    <tr class=\"formulacion_table_list\" >\n";
            $html .= "      <td width=\"15%\">REPORTE</td>\n";
            $html .= "      <td width=\"7%\">PERIODO REPORTADO</td>\n";
            $html .= "      <td width=\"7%\">FECHA EXPORTACION</td>\n";
            $html .= "      <td width=\"7%\" >ESTADO</td>\n";
            $html .= "      <td width=\"7%\">DETALLE</td>\n";
            $html .= "      <td width=\"7%\">DESCARGAR ARCHIVO PLANO</td>\n";
            $html .= "      <td width=\"7%\" >MARCAR ENVIADO</td>\n";
            // $html .= "      <td width=\"5%\" >MARCAR DEVUELTO</td>\n";
            if ($permisos['sw_eliminar_circular'] == 1) {
                $html .= "      <td width=\"7%\" >ELIMINAR</td>\n";
            }
            $html .= "    </tr>\n";

            // $rpt = new GetReports();

            foreach ($datos as $key => $reporte) {
                $est         = ($est == "modulo_list_claro") ? "modulo_list_oscuro" : "modulo_list_claro";
                $bck         = ($bck == "#DDDDDD") ? "#CCCCCC" : "#DDDDDD";
                $nombre_view = str_replace("MATVIEW.VIEW_", "", $reporte['nombre_view']);
                $html .= "   <tr class=\"" . $est . "\" onmouseout=mOut(this,\"" . $bck . "\"); onmouseover=\"mOvr(this,'#FFFFFF');\" >\n";
                $html .= "      <td width=\"15%\" align=\"left\" >" . $nombre_view . "</td>\n";
                $html .= "      <td width=\"7%\" align=\"left\" >" . $reporte['periodo_reportado'] . "</td>\n";
                $html .= "      <td width=\"7%\" align=\"left\" >" . $reporte['fecha_reporte'] . "</td>\n";
                $html .= "      <td width=\"7%\"  align=\"left\" >\n";

                switch ($reporte['estado']) {
                    case 0:
                        $html .= "CREADO";
                        break;
                    case 1:
                        $html .= "PROCESADO";
                        break;
                    case 2:
                        $html .= "ENVIADO";
                        break;
                }

                $html .= "    </td>\n";

                $html .= "      <td width=\"7%\" align=\"center\" >";
                if ($reporte['usuario_id_envio'] == null) {
                    $html .= "        <a href=\"" . $action['detalleReporte'] . URLRequest(array("id_view" => $reporte['id_view'])) . "\"
                                     class=\"label_error\" title=\"DETALLADO REPORTE.\">\n";
                    $html .= "          <img src=\"" . GetThemePath() . "/images/pcargos.png\" border=\"0\">\n";
                    $html .= "        </a>\n";
                } else {
                    $html .= "          <img src=\"" . GetThemePath() . "/images/pcargos.png\"
                                             border=\"0\" title=\"ESTE REPORTE YA FUE ENVIADO.\">\n";
                }

                $html .= "      </td>\n";
                $html .= "      <td width=\"7%\" align=\"center\" >";

                // $mostrar = $rpt->GetJavaReport('app', 'AtencionVictimasAccidentes', 'circular015',
                //     array('id_view' => $reporte['id_view'], 'estado' => $reporte['estado']),
                //     array('rpt_name' => '', 'rpt_dir' => 'cache', 'rpt_rewrite' => true, 'xls' => true, 'csv' => true));
                // $html .= $mostrar;
                // $nombreFuncion = $rpt->GetJavaFunction();

                $mostrar = $csv->GetJavacriptReporte('app','AtencionVictimasAccidentes','circular015',array('id_view' => $reporte['id_view'], 'estado' => $reporte['estado'], 'interface'=>1, 'cabecera'=>1, 'nombre'=>'Perros', 'extension' => 'csv', 'xml' => true));
                $html .= $mostrar;
                $nombreFuncion = $csv->GetJavaFunction();  
                $html .= "        <a href=\"javascript:" . $nombreFuncion . ",location.reload();\" class=\"label_error\">";
                $html .= "          <img src=\"" . GetThemePath() . "/images/abajo.png\" border=\"0\">\n";
                $html .= "        </a>\n";
                $html .= "      </td>\n";

                $html .= "      <td width=\"7%\"  align=\"center\" >\n";

                if ($reporte['usuario_id_envio'] == null) {

                    $html .= "        <a href=\"javascript:EnviarReporte(" . $reporte['id_view'] . ")\"
                                         class=\"label_error\" title=\"MARCAR COMO ENVIAR.\">\n";
                    $html .= "          <img src=\"" . GetThemePath() . "/images/no_autorizado.png\" border=\"0\">\n";
                    $html .= "        </a>\n";
                } else {
                    $html .= "          <img src=\"" . GetThemePath() . "/images/autorizado.png\"
                                             border=\"0\" title=\"ESTE REPORTE YA FUE ENVIADO.\">\n";
                }

                $html .= "    </td>\n";

                // $html .= "      <td width=\"5%\"  align=\"right\" >MARCAR DEVUELTO</td>\n";

                if ($permisos['sw_eliminar_circular'] == 1) {
                    $html .= "      <td width=\"7%\" align=\"center\" >";
                    $html .= "        <a href=\"javascript:EliminarReporteCircular(" . $reporte['id_view'] . "," . $reporte['estado'] . ")\"
                                     class=\"label_error\" title=\"ELIMINAR REPORTE.\">\n";
                    $html .= "          <img src=\"" . GetThemePath() . "/images/elimina.png\" border=\"0\">\n";
                    $html .= "        </a>\n";
                    $html .= "      </td>\n";
                }
                $html .= "    </tr>\n";
            }

            $html .= "  </table>";

        } else {
            $html .= "    <div style=\"text-align:center\" class=\"label_error\">\n";
            $html .= "      NO SE ENCONTRARON REPORTES GENERADOS A LA FECHA.\n";
            $html .= "    </div>\n";
        }

        $html .= "<form name=\"forma\" action=\"" . $action['volver'] . "\" method=\"post\">";
        $html .= "  <table width=\"50%\" align=\"center\">\n";
        $html .= "    <tr>";
        $html .= "      <td align=\"center\"><br>";
        $html .= "        <input class=\"input-submit\" type=\"submit\" name=\"volver\" value=\"Volver\">";
        $html .= "      </td>";
        $html .= "    </tr>";
        $html .= "  </table>";
        $html .= "</form>";

        $html .= ThemeCerrarTabla();
        return $html;
    }

    public function registrarAccidente($action, $request, $reportes, $EPS, $ARL)
    {
        /*
         * Inicio: opciones para registro de accidentes de transito.
         */
        $html .= ThemeAbrirTabla('REGISTRO POR ACCIDENTES DE TRANSITO ST006');

        $html .= "<table border=\"0\" width=\"80%\" align=\"center\">";

        $html .= "  <tr>\n";
        $html .= "      <td align=\"center\">";
        $html .= "      <div class=\"label_error\" id=\"error\"></div>";
        $html .= "      </td>\n";
        $html .= "  </tr>";

        $html .= "  <tr>\n";
        $html .= "    <td>\n";
        $html .= "      <form name=\"generador_reportes\" enctype=\"multipart/form-data\" method=\"post\" action=\"" . $action['guardar'] . "\" id=\"generador_reportes\">\n";

        $html .= "        <table border=\"0\" width=\"75%\" align=\"center\" class=\"modulo_table_list\">";

        $html .= "          <tr class=\"modulo_table_list_title\">";
        $html .= "            <td align=\"center\" colspan=\"4\">";
        $html .= "              REGISTRO POR ACCIDENTES DE TRANSITO ST006";
        $html .= "            </td>\n";
        $html .= "          </tr>\n";

        $html .= "          <tr class=\"modulo_list_claro\">";
        $html .= "            <td width=\"18%\" class=\"formulacion_table_list\" align=\"center\">";
        $html .= "              Numero de radicado";
        $html .= "            </td>";
        $html .= "            <td class=\"label\" align=\"left\">";
        $html .= "              <input size=\"15\" type=\"text\" class=\"input-text\" id=\"radicado_id\" name=\"radicado_id\">";
        $html .= "            </td>";
        $html .= "          </tr>";

        $html .= "          <tr class=\"modulo_list_claro\">";
        $html .= "            <td width=\"18%\" class=\"formulacion_table_list\" align=\"center\">";
        $html .= "              Archivo SIRAS";
        $html .= "            </td>";
        $html .= "            <td class=\"label\" align=\"left\">";
        $html .= "                  <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"30000\" /> ";
        $html .= "                  <input name=\"fichero_usuario\" type=\"file\" required = \"required\"/> ";
        $html .= "            </td>";

        $html .= "          <tr class=\"modulo_list_claro\">";
        $html .= "            <td width=\"18%\" class=\"formulacion_table_list\" align=\"center\">";
        $html .= "              EPS";
        $html .= "            </td>";
        $html .= "            <td class=\"label\" align=\"left\">";
        $html .= "              <select name=\"EPS\" class=\"select\">";
        $html .= "                  <option value=\"\">---SELECCIONE---</option>";
        for ($i = 0; $i < sizeof($EPS); $i++) {
            $html .= "<option value=" . $EPS[$i]['correo_eps'] . ">" . $EPS[$i]['nombre_eps'] . "</option>";
        }
        $html .= "              </select>\n";
        $html .= "            </td>";

        $html .= "          <tr class=\"modulo_list_claro\">";
        $html .= "            <td width=\"18%\" class=\"formulacion_table_list\" align=\"center\">";
        $html .= "              ARL";
        $html .= "            </td>";
        $html .= "            <td class=\"label\" align=\"left\">";
        $html .= "              <select name=\"ARL\" class=\"select\">";
        $html .= "                  <option value=\"\">---SELECCIONE---</option>";
        for ($i = 0; $i < sizeof($ARL); $i++) {
            $html .= "<option value=" . $ARL[$i]['correo_arl'] . ">" . $ARL[$i]['nombre_arl'] . "</option>";
        }
        $html .= "              </select>\n";
        $html .= "            </td>";
        $html .= "          </tr>";

        $html .= "          <tr class=\"modulo_table_list_title\">";
        $html .= "            <td align=\"center\" colspan=\"2\">";
        $html .= "              <input type=\"submit\" class=\"input-submit\" value=\"REGISTRAR\">";
        $html .= "            </td>";
        $html .= "          </tr>";

        $html .= "        </table>";
        $html .= "      </form>";

        $html .= "    </td>\n";
        $html .= "  </tr>";

        $html .= "</table>";
        $html .= "<br>\n";

        $html .= "<form name=\"forma\" action=\"" . $action['volver'] . "\" method=\"post\">";
        $html .= "  <table width=\"50%\" align=\"center\">\n";
        $html .= "    <tr>";
        $html .= "      <td align=\"center\"><br>";
        $html .= "        <input class=\"input-submit\" type=\"submit\" name=\"volver\" value=\"Volver\">";
        $html .= "      </td>";
        $html .= "    </tr>";
        $html .= "  </table>";
        $html .= "</form>";

        $html .= ThemeCerrarTabla();

        $html .= "<script>";
        $html .= "$('#generador_reportes').submit(function(){

                    if($('#generador_reportes').find('input#radicado_id').val() == \"\"){
                        document.getElementById('error').innerHTML = 'ES NECESARIO EL NUMERO DE RADICADO.';

                        return false;
                    }
                    return true;
                });";
        $html .= "</script>";
        return $html;
    }

    public function consultarVictimasAccidentes($action, $datos, $conteo, $pagina)
    {

        /*
         * Inicio: Funcion de envio de soat a consultar
         */
        $html .= "<script>";
        $html .= "  function Validar(formulario)";
        $html .= "  {";
        $html .= "          formulario.action = \"" . $action['buscar'] . "\";\n";
        $html .= "          formulario.submit();\n";
        $html .= "  }";
        $html .= "</script>";
        /*
         * Fin: Funcion de envio de soat a consultar.
         */

        /*
         * Inicio: Consulta victimas de accidentes SOAT.
         */
        $html .= ThemeAbrirTabla(' ');
        $html .= "<table border=\"0\" width=\"80%\" align=\"center\">";

        $html .= "  <tr>\n";
        $html .= "      <td align=\"center\">";
        $html .= "      <div class=\"label_error\" id=\"error\"></div>";
        $html .= "      </td>\n";
        $html .= "  </tr>";

        $html .= "  <tr>\n";
        $html .= "    <td>\n";

        $html .= "      <form name=\"generador_reportes\" method=\"post\" action=\"javascript:Validar(document.generador_reportes)\" id=\"generador_reportes\">\n";
        $html .= "        <table border=\"0\" width=\"75%\" align=\"center\" class=\"modulo_table_list\">";

        $html .= "          <tr class=\"modulo_table_list_title\">";
        $html .= "            <td align=\"center\" colspan=\"4\">";
        $html .= "              ViCTIMAS DE ACCIDENTES DE TRANSITO";
        $html .= "            </td>\n";
        $html .= "          </tr>\n";

        $html .= "          <tr class=\"modulo_list_claro\">";
        $html .= "            <td width=\"18%\" class=\"formulacion_table_list\" align=\"center\">";
        $html .= "              No. Radicado";
        $html .= "            </td>";
        $html .= "            <td class=\"label\" align=\"center\">";
        $html .= "              <input size=\"30\" type=\"text\" class=\"input-text\" id=\"radicado_id\" name=\"radicado_id\">";
        $html .= "            </td>";
        $html .= "          </tr>";

        $html .= "          <tr class=\"modulo_table_list_title\">";
        $html .= "            <td align=\"center\" colspan=\"2\">";
        $html .= "              <input type=\"submit\" class=\"input-submit\" value=\"Consultar\">";
        $html .= "            </td>";
        $html .= "          </tr>";

        $html .= "        </table>";
        $html .= "      </form>";

        $html .= "    </td>\n";
        $html .= "  </tr>";

        $html .= "</table>";
        $html .= "<br>\n";

        $html .= "<script>";
        $html .= "  function MostrarInformacion(datosPaciente)";
        $html .= "  {";
        $html .= "    xajax_MostrarInformacion(datosPaciente);";
        $html .= "  }";
        $html .= "</script>";

        if (!empty($datos)) {

            $html .= "<table class='modulo_table_list' width='100%' align='center'>";
            $html .= "  <tr class='formulacion_table_list'>";
            $html .= "      <td>No. RADICADO</td>";
            $html .= "      <td>IDENTIFICACION VICTIMA</td>";
            $html .= "      <td>NOMBRE</td>";
            $html .= "      <td>TIPO ATENCION</td>";
            $html .= "      <td>FECHA REGISTRO</td>";
            $html .= "      <td>IMPRIMIR</td>";
            $html .= "      <td colspan='2'>ESTADO</td>";
            $html .= "  </tr>";

            $rpt = new GetReports();

            foreach ($datos as $dato => $value) {
                $est = ($est == "modulo_list_claro") ? "modulo_list_oscuro" : "modulo_list_claro";
                $html .= "<tr class=" . $est . ">";
                $html .= "  <td>" . $value['radicado_id'] . "</td>";
                $html .= "  <td>" . $value['tipoidentificacionvictima'] . " " . $value['numeroindentificacionvictima'] . "</td>";
                $html .= "  <td>" . $value['primerapellidovictima'] . " " . $value['segundoapellidovictima'] . " " . $value['primernombrevictima'] . " " . $value['segundonombrevictima'] . "</td>";
                $html .= "  <td>" . $value['tipoatencion'] . "</td>";
                $html .= "  <td>" . $value['date_create'] . "</td>";
                $html .= "  <td align='center'>";

                $mostrar = $rpt->GetJavaReport('app', 'AtencionVictimasAccidentes', 'reporteVictima',
                    array('radicado_id' => $value['radicado_id']),
                    array('rpt_name' => '', 'rpt_dir' => 'cache', 'rpt_rewrite' => true));
                $html .= $mostrar;
                $nombreFuncion = $rpt->GetJavaFunction();
                $html .= "  <a href=\"javascript:" . $nombreFuncion . "\" class=\"label_error\">";
                $html .= "      <img src=\"" . GetThemePath() . "/images/imprimir.png\" border=\"0\" >";
                $html .= "  </a>";

                $html .= "  </td>";

                $html .= "  <td><center>";
                if ($value['estado'] == 0) {
                    $html .= "Sin enviar";
                } else {
                    $html .= "Enviado";
                }
                $html .= "  </center></td>";

                $html .= "<td>";

                $actionenvio = ModuloGetURL("app", "AtencionVictimasAccidentes", "controller", "EnviarNotificacionAccidente", array('radicado_id' => $value['radicado_id']));

                $html .= "      <center><a href=\"" . $actionenvio . "\">";
                $html .= "          ENVIAR";
                $html .= "      </a></center>";

                $html .= "  </td>";

                $html .= "</tr>";
            }
            $html .= "</table>";

            $paginado = AutoCarga::factory('ClaseHTML');

            $html .= $paginado->ObtenerPaginado($conteo, $pagina, $action['paginador']);

        } else {
            $html .= "<br>";
            $html .= "<div style=\"text-align:center\" class=\"label_error\">";
            $html .= "  Busqueda sin resultados.";
            $html .= "</div>";
            $html .= "<div id='contenido'></div>";
        }

        $html .= "<br>";

        $html .= "<div style=\"text-align:center\" class=\"label_error\">";
        $html .= "  <a href=\"" . $action['registrarAccidente'] . "\"><input type=\"submit\" class=\"input-submit\" value=\"REPORTAR VICTIMA\"></a>";
        $html .= "</div>";

        $html .= "<br>";

        $html .= "<div style=\"text-align:center\" class=\"label_error\">";
        $html .= "  <a href=\"" . $action['volver'] . "\">VOLVER</a>";
        $html .= "</div>";

        $html .= "<div id='contenido'></div>";
        $html .= CloseTable();

        return $html;
    }

    public function DetalladoCircular($action, $datos, $conteo, $pagina)
    {

        $html = "<script>";
        $html .= "  function Validar(formulario)";
        $html .= "  {";
        $html .= "          formulario.action = \"" . $action['buscar'] . "\";\n";
        $html .= "          formulario.submit();\n";
        $html .= "  }";
        $html .= "</script>";

        $html .= ThemeAbrirTabla(' ');
        $html .= "<table border=\"0\" width=\"80%\" align=\"center\">";

        $html .= "  <tr>\n";
        $html .= "      <td align=\"center\">";
        $html .= "      <div class=\"label_error\" id=\"error\"></div>";
        $html .= "      </td>\n";
        $html .= "  </tr>";

        $html .= "  <tr>\n";
        $html .= "    <td>\n";

        $html .= "      <form name=\"generador_reportes\" method=\"post\" action=\"javascript:Validar(document.generador_reportes)\" id=\"generador_reportes\">\n";
        $html .= "        <table border=\"0\" width=\"75%\" align=\"center\" class=\"modulo_table_list\">";

        $html .= "          <tr class=\"modulo_table_list_title\">";
        $html .= "            <td align=\"center\" colspan=\"4\">";
        $html .= "              DETALLADO CIRUCULAR";
        $html .= "            </td>\n";
        $html .= "          </tr>\n";

        $html .= "          <tr class=\"modulo_list_claro\">";
        $html .= "            <td width=\"18%\" class=\"formulacion_table_list\" align=\"center\">";
        $html .= "              NUMERO DE DOCUMENTO";
        $html .= "            </td>";
        $html .= "            <td class=\"label\" align=\"LEFT\">";
        $html .= "              <input size=\"30\" type=\"number\" class=\"input-text\" id=\"id_documento\" name=\"id_documento\">";
        $html .= "            </td>";
        $html .= "            <td width=\"18%\" class=\"formulacion_table_list\" align=\"center\">";
        $html .= "              MES";
        $html .= "            </td>";
        $html .= "            <td class=\"label\" align=\"LEFT\">";
        $html .= "              <select name=\"mes_registro\" id=\"mes_registro\" class=\"select\">";
        $html .= "                  <option value=\"\">---SELECCIONAR---</option>";
        $html .= "                  <option value=\"01\"> ENERO </option>";
        $html .= "                  <option value=\"02\"> FEBRERO </option>";
        $html .= "                  <option value=\"03\"> MARZO </option>";
        $html .= "                  <option value=\"04\"> ABRIL </option>";
        $html .= "                  <option value=\"05\"> MAYO </option>";
        $html .= "                  <option value=\"06\"> JUNIO </option>";
        $html .= "                  <option value=\"07\"> JULIO </option>";
        $html .= "                  <option value=\"08\"> AGOSTO </option>";
        $html .= "                  <option value=\"09\"> SEPTIEMBRE </option>";
        $html .= "                  <option value=\"10\"> OCTUBRE </option>";
        $html .= "                  <option value=\"11\"> NOVIEMBRE </option>";
        $html .= "                  <option value=\"12\"> DICIEMBRE </option>";
        $html .= "            </td>";
        $html .= "          </tr>";

        $html .= "          <tr class=\"modulo_table_list_title\">";
        $html .= "            <td align=\"center\" colspan=\"4\">";
        $html .= "              <input type=\"submit\" class=\"input-submit\" value=\"BUSCAR\">";
        $html .= "            </td>";
        $html .= "          </tr>";

        $html .= "        </table>";
        $html .= "      </form>";

        $html .= "    </td>\n";
        $html .= "  </tr>";

        $html .= "</table>";
        $html .= "<br>\n";

        $html .= "<script>";
        $html .= "  function MostrarInformacion(datosPaciente)";
        $html .= "  {";
        $html .= "    xajax_MostrarInformacion(datosPaciente);";
        $html .= "  }";
        $html .= "</script>";

        if (!empty($datos)) {

            $html .= "<table class='modulo_table_list' width='100%' align='center'>";
            $html .= "  <tr class='formulacion_table_list'>";
            $html .= "      <td width=\"7%\" align=\"center\"><b> ID POLIZA </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> FECHA VENCIMIENTO </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> ID VICTIMA </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> CODIGO PRESTADOR </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> ID PRESTADOR </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> FECHA SINIESTRO </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> ID PAGADOR </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> ID FACTURA </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> FECHA FACTURA </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> FECHA RADICACION </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> COSTO PROCEDIMIENTOS </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> COSTO INSUMOS </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> COSTO MEDICAMENTOS </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> OTROS </b></td>\n";
            $html .= "      <td width=\"7%\" align=\"center\"><b> VALOR FACTURA </b></td>\n";
            $html .= "  </tr>";

            $rpt = new GetReports();

            foreach ($datos as $key => $value) {
                $est = ($est == "modulo_list_claro") ? "modulo_list_oscuro" : "modulo_list_claro";
                $html .= "<tr class=" . $est . ">";
                $html .= "    <td align=\"left\">" . $value['idpoliza'] . "</td>\n";
                $html .= "    <td align=\"left\">" . $value['fechavencimiento'] . "</td>\n";
                $html .= "    <td align=\"left\">" . $value['idvictima'] . "</td>\n";
                $html .= "    <td align=\"left\">" . $value['codigoprestador'] . "</td>\n";
                $html .= "    <td align=\"left\">" . $value['idprestador'] . "</td>\n";
                $html .= "    <td align=\"left\">" . $value['fechasiniestro'] . "</td>\n";
                $html .= "    <td align=\"left\">" . $value['idpagador'] . "</td>\n";
                $html .= "    <td align=\"left\">" . $value['idfactura'] . "</td>\n";
                $html .= "    <td align=\"left\">" . $value['fechafactura'] . "</td>\n";
                $html .= "    <td align=\"left\">" . $value['fecharadicacion'] . "</td>\n";
                $html .= "    <td align=\"left\">$ " . Formatovalor($value['valorprocedimientos']) . "</td>\n";
                $html .= "    <td align=\"left\">$ " . Formatovalor($value['valorinsumos']) . "</td>\n";
                $html .= "    <td align=\"left\">$ " . Formatovalor($value['valormedicamentos']) . "</td>\n";
                $html .= "    <td align=\"left\">$ " . Formatovalor($value['valorotros']) . "</td>\n";
                $html .= "    <td align=\"left\">$ " . Formatovalor($value['valorfactura']) . "</td>\n";
                $html .= "</tr>";
            }
            $html .= "</table>";

            $paginado = AutoCarga::factory('ClaseHTML');

            $html .= $paginado->ObtenerPaginado($conteo, $pagina, $action['paginador']);

        } else {
            $html .= "<br>";
            $html .= "<div style=\"text-align:center\" class=\"label_error\">";
            $html .= "  EL PERIODO REPORTADO NO CONTIENE DATOS.";
            $html .= "</div>";
            $html .= "<div id='contenido'></div>";
        }

        $html .= "<br>";

        $html .= "<div style=\"text-align:center\" class=\"label_error\">";
        $html .= "  <a href=\"" . $action['volver'] . "\">VOLVER</a>";
        $html .= "</div>";

        $html .= "<div id='contenido'></div>";
        $html .= CloseTable();

        return $html;
    }

}
