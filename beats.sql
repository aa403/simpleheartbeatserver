--beats.sql

-- Table: beats

-- DROP TABLE beats;

CREATE TABLE beats
(
  id serial NOT NULL,
  source character varying(5000) NOT NULL,
  message character varying(50000) NOT NULL,
  created_date timestamp without time zone DEFAULT now(),
  CONSTRAINT beats_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE beats
  OWNER TO brtyotuudkzajb;