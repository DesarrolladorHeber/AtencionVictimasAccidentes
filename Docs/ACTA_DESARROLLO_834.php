<?php
/**
 * PROGRAMA CREADO PARA EL ACTA DE DESARROLLO 384
 *
 * @package Fabilu
 * @version 1.0
 * @copyright (C) 2018
 * @author Steven LVI
 */

$VISTA = 'HTML';
$_ROOT = "../";

include $_ROOT . 'includes/enviroment.inc.php';

IncludeClass("ConexionBD");

$cxn = new ConexionBD();
//$cxn->debug = true;

$sql = " CREATE TABLE views_cirucular_015 ( id_view integer NOT NULL,
                                            nombre_view character varying NOT NULL,
                                            periodo_reportado character varying NOT NULL,
                                            fecha_reporte timestamp without time zone DEFAULT now() NOT NULL,
                                            estado smallint DEFAULT 0 NOT NULL,
                                            usuario_id integer NOT NULL,
                                            usuario_id_envio integer,
                                            id_usuario_eliminar integer,
                                            fecha_eliminacion timestamp without time zone );

         COMMENT ON TABLE views_cirucular_015 IS 'Tabla que contiene información de las view de la circular 015';
         COMMENT ON COLUMN views_cirucular_015.nombre_view IS 'Nombre del a vista de la circular 015';
         COMMENT ON COLUMN views_cirucular_015.periodo_reportado IS 'Periodo del reporte';
         COMMENT ON COLUMN views_cirucular_015.fecha_reporte IS 'Fecha en la que se creo el reporte';
         COMMENT ON COLUMN views_cirucular_015.estado IS '0: creado, 1:en proceso y 2: enviado Estados en el que se encuentra el reporte';
         COMMENT ON COLUMN views_cirucular_015.usuario_id IS 'Usuario que creo el reporte';
         COMMENT ON COLUMN views_cirucular_015.usuario_id_envio IS 'Usuario que marco el envio';
         COMMENT ON COLUMN views_cirucular_015.id_usuario_eliminar IS 'Usuario que realizo la eliminación del reporte.';
         COMMENT ON COLUMN views_cirucular_015.fecha_eliminacion IS 'Fecha en la cual se realiza la eliminación del reporte.';
 
         CREATE SEQUENCE views_cirucular_015_id_view_seq
             START WITH 1
             INCREMENT BY 1
             NO MINVALUE
             NO MAXVALUE
             CACHE 1;
 
         ALTER SEQUENCE views_cirucular_015_id_view_seq OWNED BY views_cirucular_015.id_view;
 
         ALTER TABLE ONLY views_cirucular_015 ALTER COLUMN id_view SET DEFAULT nextval('views_cirucular_015_id_view_seq'::regclass);
 
         ALTER TABLE ONLY views_cirucular_015
             ADD CONSTRAINT views_cirucular_015_pkey PRIMARY KEY (id_view);
 
         ALTER TABLE ONLY views_cirucular_015
             ADD CONSTRAINT usuario_id FOREIGN KEY (usuario_id) REFERENCES system_usuarios(usuario_id) ON UPDATE CASCADE ON DELETE CASCADE; ";

if (!$rst = $cxn->ConexionBaseDatos($sql)) {
    echo "Error al crear table views_cirucular_015: " . $cxn->mensajeDeError;
    exit;
}

echo " Se creo la tabla views_cirucular_015 correctamente. ";
echo "<br>";

$sql = " INSERT INTO public.system_modulos_opciones_permisos (modulo, modulo_tipo, opcion_permiso_nombre, opcion_permiso_descripcion, opcion_permiso_defecto) 
                VALUES ('AtencionVictimasAccidentes', 'app', 'sw_eliminar_circular', 'PERMITE ELIMINAR EL REGISTRO DE LA CIRCULAR.', '0'); ";

if (!$rst = $cxn->ConexionBaseDatos($sql)) {
    echo "Error en el insert en system_modulos_opciones_permisos : " . $cxn->mensajeDeError;
    exit;
}

echo " Se realizo el insert en system_modulos_opciones_permisos. ";
echo "<br>";

$sql = " UPDATE system_modulos_metodos SET sw_variables_adicionales = 1 WHERE modulo = 'AtencionVictimasAccidentes'; ";

if (!$rst = $cxn->ConexionBaseDatos($sql)) {
    echo "Error en el insert en system_modulos_metodos : " . $cxn->mensajeDeError;
    exit;
}

echo " Se realizo el insert en system_modulos_metodos. ";
echo "<br>";

$rst->Close();

echo "ESO FUE TODO.";
