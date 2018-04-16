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
-- Name: correos_arl; Type: TABLE; Schema: public; Owner: sgarcia; Tablespace: 
--

CREATE TABLE correos_arl (
    arl_id integer NOT NULL,
    nombre_arl character(40),
    correo_arl character(40)
);


ALTER TABLE correos_arl OWNER TO sgarcia;

--
-- Name: TABLE correos_arl; Type: COMMENT; Schema: public; Owner: sgarcia
--

COMMENT ON TABLE correos_arl IS 'Correos arl para el envio de reporte 3823';


--
-- Name: correos_arl_arl_id_seq; Type: SEQUENCE; Schema: public; Owner: sgarcia
--

CREATE SEQUENCE correos_arl_arl_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE correos_arl_arl_id_seq OWNER TO sgarcia;

--
-- Name: correos_arl_arl_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sgarcia
--

ALTER SEQUENCE correos_arl_arl_id_seq OWNED BY correos_arl.arl_id;


--
-- Name: arl_id; Type: DEFAULT; Schema: public; Owner: sgarcia
--

ALTER TABLE ONLY correos_arl ALTER COLUMN arl_id SET DEFAULT nextval('correos_arl_arl_id_seq'::regclass);


--
-- Data for Name: correos_arl; Type: TABLE DATA; Schema: public; Owner: sgarcia
--

COPY correos_arl (arl_id, nombre_arl, correo_arl) FROM stdin;
1	prueba correo arl                       	desarrollador1@clinicacolombiaes.com    
\.


--
-- Name: correos_arl_arl_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sgarcia
--

SELECT pg_catalog.setval('correos_arl_arl_id_seq', 1, true);


--
-- Name: correos_arl_pkey; Type: CONSTRAINT; Schema: public; Owner: sgarcia; Tablespace: 
--

ALTER TABLE ONLY correos_arl
    ADD CONSTRAINT correos_arl_pkey PRIMARY KEY (arl_id);


--
-- PostgreSQL database dump complete
--

