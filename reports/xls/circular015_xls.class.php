<?php

class circular015_xls
{

    public function circular015_xls()
    {}

    public function GetReporteXls($datos = array())
    {

        $datos2 = $this->datosAccidente($datos);
        //var_dump($datos2);

        //$resultado=$sql->ObtenerInfoGeneralKardex($datos,0,1);

        $html .= "<table class=\"normal_10\" align=\"center\" width=\"100%\" border=\"1\" rules=\"all\">\n";
        $html .= "  <tr>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>idPoliza</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>fechaVencimiento</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>idvictima</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>codigoPrestador</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>idPrestador</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>fechaSiniestro</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>idPagador</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>idFactura</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>fechaFactura</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>fechaRadicacion</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>valorProcedimientos</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>valorInsumos</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>valorMedicamentos</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>valorOtros</b></td>\n";
        $html .= "    <td width=\"7%\" align=\"center\"><b>valorFactura</b></td>\n";
        $html .= "  </tr>\n";

        foreach ($datos2 as $dato2) {
            $html .= "  <tr>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['idpoliza'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['fechavencimiento'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['idvictima'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['codigoprestador'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['idprestador'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['fechasiniestro'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['idpagador'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['idfactura'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['fechafactura'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['fecharadicacion'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['valorprocedimientos'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['valorinsumos'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['valormedicamentos'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['valorotros'] . "</td>\n";
            $html .= "    <td align=\"LEFT\" style=\"mso-number-format:'\@'\">" . $dato2['valorfactura'] . "</td>\n";
            $html .= "  </tr>\n";
        }
        $html .= "</table>\n";

        return $html;
    }

    public function datosAccidente($datos)
    {
        list($dbconn) = GetDBconn();

        if ($datos['estado'] != 2) {
            $sql = "UPDATE views_cirucular_015 ";
            $sql .= "SET    estado = 1 ";
            $sql .= "WHERE  id_view  = '" . $datos['id_view'] . "' ";

            $resulta = $dbconn->Execute($sql);
        }

        $sql = "SELECT nombre_view FROM views_cirucular_015 ";
        $sql .= "WHERE  id_view  = '" . $datos['id_view'] . "' ";

        $resulta = $dbconn->Execute($sql);

        $nombreView = $resulta->fields[0];

        $sql = "SELECT * FROM " . $nombreView . " ";
        $sql .= " ORDER BY fecharadicacion ASC ";

        $resulta = $dbconn->Execute($sql);
        if ($dbconn->ErrorNo() != 0) {
            $this->error          = "Error al Cargar el Modulo";
            $this->mensajeDeError = "Error DB : " . $dbconn->ErrorMsg();
            return false;
        }
        while (!$resulta->EOF) {
            $var[] = $resulta->GetRowAssoc($ToUpper = false);
            $resulta->MoveNext();
        }

        return $var;
    }
}
