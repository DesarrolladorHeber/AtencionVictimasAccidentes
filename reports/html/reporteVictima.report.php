<?php

/**
 * $Id: Soat_Anexo1.report.php,v 1.1.1.1 2012/05/08 16:36:42 hugo Exp $
 * @copyright (C) 2005 IPSOFT - SA (www.ipsoft-sa.com)
 * @package IPSOFT-SIIS
 *
 * Archivo que imprime el formulario anexo1 que se entrega al FOSYGA
 */

class reporteVictima_report
{
	function reporteVictima_report($datos=array())
	{
		$this->datos=$datos;
		return true;
	}

	var $datos;
	//PARAMETROS PARA LA CONFIGURACION DEL REPORTE
	//NO MODIFICAR POR EL MOMENTO - DELEN UN TIEMPITO PARA TERMINAR EL DESARROLLO
	var $title       = '';
	var $author      = '';
	var $sizepage    = 'leter';
	var $Orientation = '';
	var $grayScale   = false;
	var $headers     = array();
	var $footers     = array();

	function CrearReporte()
	{
		$datos1=$this->empresa($this->datos['var']);
		$datos2=$this->datosAccidente($this->datos['radicado_id']);
		// echo "<pre>";
		// print_r($datos2);
		// echo "</pre>";
		$HTML_WEB_PAGE ="<HTML><BODY>";
		$HTML_WEB_PAGE.="<TABLE WIDTH='100%' BORDER=0>";

		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
		$HTML_WEB_PAGE.="<b>REPÚBLICA DE COLOMBIA</b>";
		$HTML_WEB_PAGE.="</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";

		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
		$HTML_WEB_PAGE.="<b>MINISTERIO DE SALUD Y PROTECCION SOCIAL</b>";
		$HTML_WEB_PAGE.="</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";

		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'><br>";
		$HTML_WEB_PAGE.="INFORME DE LA ATENCION EN SALUD PRESTADA A VICTIMAS DE ACCIDENTES<br>";
		$HTML_WEB_PAGE.="DE TRANSITO<br></FONT>";
		$HTML_WEB_PAGE.="</TD>";
		$HTML_WEB_PAGE.="</TR>";

		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Fecha de radicación:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['date_create']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>No. Radicado:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['radicado_id']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";

		$HTML_WEB_PAGE.="</TABLE>";

		$HTML_WEB_PAGE.="<TABLE WIDTH='100%' BORDER=1>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
		$HTML_WEB_PAGE.="&nbsp;<br><b>I. INFORMACION DEL PRESTADOR </b>&nbsp;<br>&nbsp;<br>";
		$HTML_WEB_PAGE.="</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Nombre o razón Social:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD COLSPAN='3' ALIGN='LEFT'><FONT SIZE='1'>".$datos1['razon_social']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Identificación:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos1['tipo_id_tercero']." ".$datos1['id']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Codigo de habilitacion:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos1['codigo_sgsss']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Dirección del prestador:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD COLSPAN='3' ALIGN='LEFT'><FONT SIZE='1'>".$datos1['direccion']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Teléfono: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD COLSPAN='3' ALIGN='LEFT'><FONT SIZE='1'>".$datos1['telefonos']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Departamento:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos1['departamento']." Cód.: ".$datos1['tipo_dpto_id']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Municipio:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos1['municipio']." Cód.: ".$datos1['tipo_mpio_id']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="</TABLE>";


		$HTML_WEB_PAGE.="<TABLE WIDTH='100%' BORDER=1>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
		$HTML_WEB_PAGE.="&nbsp;<br><b>II. DATOS DE LA VICTIMA DEL ACCIDENTE DE TRANSITO</b>&nbsp;<br>&nbsp;<br>";
		$HTML_WEB_PAGE.="</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['primerapellidovictima']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['segundoapellidovictima']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['primernombrevictima']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['segundonombrevictima']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>1er Apellido</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>2do Apellido</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>1er Nombre</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>2do Nombre</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Identificación: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['tipoidentificacionvictima']." ".$datos2[0]['numeroindentificacionvictima']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Fecha de nacimiento: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['fechanacimientovictima']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="</TABLE>";

		$HTML_WEB_PAGE.="<TABLE WIDTH='100%' BORDER=1>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
		$HTML_WEB_PAGE.="&nbsp;<br><b>III. TIPO DE INGRESO A LOS SERVICIOS DE SALUD</b>&nbsp;<br>&nbsp;<br>";
		$HTML_WEB_PAGE.="</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>Tipo de atencion: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['tipoatencion']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>fecha de atencion: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['datetimeatencion']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>Victima viene remitida: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['remision']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>Codigo de habilitacion: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['codigohabilitacion']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='2'  WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>Razón social del prestador de servicio de salud que remite: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD COLSPAN='2' WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['prestadorservicio']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Departamento: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['departamentoremision']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Municipio: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['municipioremision']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="</TABLE>";

		$HTML_WEB_PAGE.="<TABLE WIDTH='100%' BORDER=1>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='2' ALIGN='CENTER'><FONT SIZE='1'>";
		$HTML_WEB_PAGE.="&nbsp;<br><b>IV. INFORMACIÓN DEL TRASPORTE AL PRIMER SITIO DE ATENCIÓN </b>&nbsp;<br>&nbsp;<br>";
		$HTML_WEB_PAGE.="</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>Víctima fue trasladada en trasporte especial de paciente : </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['transporteespecial']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>Codigo del prestador de transporte especial: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['transportecodigo']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>placa del vehiculo: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['transporteplaca']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="</TABLE>";

		$HTML_WEB_PAGE.="<TABLE WIDTH='100%' BORDER=1>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
		$HTML_WEB_PAGE.="&nbsp;<br><b>V. DATOS DEL ACCIDENTE </b>&nbsp;<br>&nbsp;<br>";
		$HTML_WEB_PAGE.="</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='2' WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>Fecha del accidente: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD COLSPAN='2' WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['datetimeaccidente']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='2' WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>Dirección: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD COLSPAN='2' WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['direccionaccidente']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Departamento: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['departamentoaccidente']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Municipio: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['municipioaccidente']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="</TABLE>";

		$HTML_WEB_PAGE.="<TABLE WIDTH='100%' BORDER=1>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
		$HTML_WEB_PAGE.="&nbsp;<br><b>VI. DATOS DEL VEHICULÓ INVOLUCRADO EN EL ACCIDENTE DE TRANSITO </b>&nbsp;<br>&nbsp;<br>";
		$HTML_WEB_PAGE.="</FONT></TD>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Placa: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['placavehiculoinvolucrado']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Vehiculó no identificado: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['vehiculoinvolucrado']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="</TABLE>";

		$HTML_WEB_PAGE.="<TABLE WIDTH='100%' BORDER=1>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
		$HTML_WEB_PAGE.="&nbsp;<br><b>VII. DATOS DEL CONDUCTOR DEL VEHICULÓ INVOLUCRADO EN EL ACCIDENTE </b>&nbsp;<br>&nbsp;<br>";
		$HTML_WEB_PAGE.="</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['primerapellidoinvolucrado']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['segundoapellidoinvolucrado']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['primernombreinvolucrado']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['segundonombreinvolucrado']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>1er Apellido</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>2do Apellido</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>1er Nombre</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>2do Nombre</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='2' WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>Identificación: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD COLSPAN='2' WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['tipoidentificacioninvolucrado']." ".$datos2[0]['numeroindentificacioninvolucrado']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Dirección del conductor:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD COLSPAN='3' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['direccioninvolucrado']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Teléfono: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD COLSPAN='3' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['telefonoinvolucrado']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Departamento:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['departamentoconductorinvolucrado']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Municipio:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['municipioconductorinvolucrado']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="</TABLE>";

		$HTML_WEB_PAGE.="<TABLE WIDTH='100%' BORDER=1>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='4' ALIGN='CENTER'><FONT SIZE='1'>";
		$HTML_WEB_PAGE.="&nbsp;<br><b>VIII. INFORMACIÓN DE LA PERONA QUE REPORTA LA ATENCIÓN </b>&nbsp;<br>&nbsp;<br>";
		$HTML_WEB_PAGE.="</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['primerapellidoencargado']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['segundoapellidoencargado']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['primernombreencargado']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['segundonombreencargado']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>1er Apellido</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>2do Apellido</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>1er Nombre</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='25%' ALIGN='LEFT'><FONT SIZE='1'>2do Nombre</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD COLSPAN='2' WIDTH='40%' ALIGN='LEFT'><FONT SIZE='1'>Identificación: </FONT></TD>";
		$HTML_WEB_PAGE.="<TD COLSPAN='2' WIDTH='60%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['tipoidentificacionencargado']." ".$datos2[0]['numeroindentificacionencargado']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Cargo :</FONT></TD>";
		$HTML_WEB_PAGE.="<TD COLSPAN='3' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['cargoencargado']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="<TR>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Telefono:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['telefonoencargado']."</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='20%' ALIGN='LEFT'><FONT SIZE='1'>Extencion:</FONT></TD>";
		$HTML_WEB_PAGE.="<TD WIDTH='30%' ALIGN='LEFT'><FONT SIZE='1'>".$datos2[0]['extencionencargado']."</FONT></TD>";
		$HTML_WEB_PAGE.="</TR>";
		$HTML_WEB_PAGE.="</TABLE>";

		return $HTML_WEB_PAGE;
	}

	function empresa()
	{
		list($dbconn) = GetDBconn();
		$query = "SELECT * 
				  from empresas AS e 
				  join tipo_mpios AS m on (e.tipo_mpio_id = m.tipo_mpio_id and e.tipo_dpto_id = m.tipo_dpto_id)
				  join tipo_dptos AS d ON (m.tipo_dpto_id = d.tipo_dpto_id and d.tipo_pais_id = m.tipo_pais_id)
				  limit 1";
		$resulta = $dbconn->Execute($query);
		if ($dbconn->ErrorNo() != 0)
		{
			$this->error = "Error al Cargar el Modulo";
			$this->mensajeDeError = "Error DB : " . $dbconn->ErrorMsg();
			return false;
		}
		while(!$resulta->EOF)
		{
			$var=$resulta->GetRowAssoc($ToUpper = false);
			$resulta->MoveNext();
		}
		return $var;
	}

	function datosAccidente($radicado_id)
	{
		list($dbconn) = GetDBconn();
		$query = "SELECT *
				FROM victimas_accidentes
				WHERE radicado_id = '".$radicado_id."'";

		$resulta = $dbconn->Execute($query);
		if ($dbconn->ErrorNo() != 0)
		{
			$this->error = "Error al Cargar el Modulo";
			$this->mensajeDeError = "Error DB : " . $dbconn->ErrorMsg();
			return false;
		}
		while(!$resulta->EOF)
		{
			$var[]=$resulta->GetRowAssoc($ToUpper = false);
			$resulta->MoveNext();
		}

		return $var;
	}

}

?>
