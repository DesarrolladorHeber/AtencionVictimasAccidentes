--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'LATIN1';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: victimas_accidentes; Type: TABLE; Schema: public; Owner: sgarcia; Tablespace: 
--

CREATE TABLE victimas_accidentes (
    radicado_id character varying(70) NOT NULL,
    primerapellidovictima character varying(70),
    segundoapellidovictima character varying(70),
    primernombrevictima character varying(70),
    segundonombrevictima character varying(70),
    tipoidentificacionvictima character varying(70),
    numeroindentificacionvictima character varying(70) NOT NULL,
    fechanacimientovictima character varying(70),
    tipoatencion character varying(70),
    datetimeatencion character varying(70),
    remision character varying(70),
    prestadorservicio character varying(70),
    codigohabilitacion character varying(70),
    departamentoremision character varying(70),
    municipioremision character varying(70),
    transporteespecial character varying(70),
    transportecodigo character varying(70),
    transporteplaca character varying(70),
    datetimeaccidente character varying(70),
    departamentoaccidente character varying(70),
    municipioaccidente character varying(70),
    direccionaccidente character varying(70),
    vehiculoinvolucrado character varying(10),
    placavehiculoinvolucrado character varying(70),
    primerapellidoinvolucrado character varying(70),
    segundoapellidoinvolucrado character varying(70),
    primernombreinvolucrado character varying(70),
    segundonombreinvolucrado character varying(70),
    tipoidentificacioninvolucrado character varying(70),
    numeroindentificacioninvolucrado character varying(70),
    direccioninvolucrado character varying(70),
    departamentoconductorinvolucrado character varying(70),
    municipioconductorinvolucrado character varying(70),
    telefonoinvolucrado character varying(70),
    primerapellidoencargado character varying(70),
    segundoapellidoencargado character varying(70),
    primernombreencargado character varying(70),
    segundonombreencargado character varying(70),
    tipoidentificacionencargado character varying(70),
    numeroindentificacionencargado character varying(70),
    telefonoencargado character varying(70),
    extencionencargado character varying(70),
    cargoencargado character varying(70),
    date_create character varying(70),
    correo_eps character varying(60),
    correo_arl character varying(60),
    estado smallint DEFAULT 0
);


ALTER TABLE victimas_accidentes OWNER TO sgarcia;

--
-- PostgreSQL database dump complete
--

