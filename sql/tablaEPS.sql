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
-- Name: correos_eps; Type: TABLE; Schema: public; Owner: sgarcia; Tablespace: 
--

CREATE TABLE correos_eps (
    eps_id integer NOT NULL,
    nombre_eps character(40),
    correo_eps character(40)
);


ALTER TABLE correos_eps OWNER TO sgarcia;

--
-- Name: TABLE correos_eps; Type: COMMENT; Schema: public; Owner: sgarcia
--

COMMENT ON TABLE correos_eps IS 'Correos de eps para el envió de reporte 3823';


--
-- Name: correos_eps_eps_id_seq; Type: SEQUENCE; Schema: public; Owner: sgarcia
--

CREATE SEQUENCE correos_eps_eps_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE correos_eps_eps_id_seq OWNER TO sgarcia;

--
-- Name: correos_eps_eps_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sgarcia
--

ALTER SEQUENCE correos_eps_eps_id_seq OWNED BY correos_eps.eps_id;


--
-- Name: eps_id; Type: DEFAULT; Schema: public; Owner: sgarcia
--

ALTER TABLE ONLY correos_eps ALTER COLUMN eps_id SET DEFAULT nextval('correos_eps_eps_id_seq'::regclass);


--
-- Data for Name: correos_eps; Type: TABLE DATA; Schema: public; Owner: sgarcia
--

COPY correos_eps (eps_id, nombre_eps, correo_eps) FROM stdin;
1	Correo prueba 1                         	desarrollador1@clinicacolombiaes.com    
\.


--
-- Name: correos_eps_eps_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sgarcia
--

SELECT pg_catalog.setval('correos_eps_eps_id_seq', 1, true);


--
-- Name: correos_eps_pkey; Type: CONSTRAINT; Schema: public; Owner: sgarcia; Tablespace: 
--

ALTER TABLE ONLY correos_eps
    ADD CONSTRAINT correos_eps_pkey PRIMARY KEY (eps_id);


--
-- PostgreSQL database dump complete
--

