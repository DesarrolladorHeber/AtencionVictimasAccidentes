<?php
/**
 * @package Fabilu
 * @version 1.0
 * @copyright (C) 2018
 * @author Steven Garcia
 */

$VISTA = 'HTML';
$_ROOT = "../";

include $_ROOT . 'includes/enviroment.inc.php';

IncludeClass("ConexionBD");

$cxn = new ConexionBD();
//$cxn->debug = true;

$sql .= "CREATE TABLE correos_envio_reporte_victimas (
        correo_id integer NOT NULL,
        descripcion character(40),
        correo character(40)
        );

        COMMENT ON TABLE correos_envio_reporte_victimas IS 'Correos institucionales para el envio del reporte de victimas';

        CREATE SEQUENCE correos_envio_reporte_victimas_correo_id_seq
            START WITH 1
            INCREMENT BY 1
            NO MINVALUE
            NO MAXVALUE
            CACHE 1;


        ALTER SEQUENCE correos_envio_reporte_victimas_correo_id_seq OWNED BY correos_envio_reporte_victimas.correo_id;

        ALTER TABLE ONLY correos_envio_reporte_victimas ALTER COLUMN correo_id SET DEFAULT nextval('correos_envio_reporte_victimas_correo_id_seq'::regclass);

        ALTER TABLE ONLY correos_envio_reporte_victimas
            ADD CONSTRAINT correos_envio_reporte_victimas_pkey PRIMARY KEY (correo_id);

        COMMENT ON COLUMN correos_envio_reporte_victimas.correo_id IS
                                  'Identificador unico de la tabla.';
        COMMENT ON COLUMN correos_envio_reporte_victimas.descripcion IS
                                  'Nombre o descripcion del correo.';
        COMMENT ON COLUMN correos_envio_reporte_victimas.correo IS
                                  'Correo institucional.'; ";

if (!$rst = $cxn->ConexionBaseDatos($sql)) {
    echo "Error al crear tabla correos_envio_reporte_victimas: " . $cxn->mensajeDeError;
    exit;
}

$rst->Close();

echo "<br>";
echo "<br>";
echo "PROGRAMA EJECUTADO CON EXITO.";
