-- Commande à exécuter avant de lancer sqlplus :
-- source /oracle/IM2AG/.cshrc

-- LesCategories
CREATE TABLE LesCategories (
    nomC VARCHAR(20), prix NUMBER(4),
    CONSTRAINT c_c1 PRIMARY KEY (nomC),
    CONSTRAINT c_c2 CHECK (prix > 0)
);

INSERT INTO LesCategories VALUES ('orchestre', 50);
INSERT INTO LesCategories VALUES ('1er balcon', 40);
INSERT INTO LesCategories VALUES ('2nd balcon', 20);
INSERT INTO LesCategories VALUES ('poulailler', 10);

-- LesZones
CREATE TABLE LesZones (
    noZone NUMBER(1), nomC VARCHAR(20),
    CONSTRAINT z_c1 PRIMARY KEY (noZone),
    CONSTRAINT z_c2 FOREIGN KEY (nomC) REFERENCES LesCategories(nomC),
    CONSTRAINT z_c3 CHECK (noZone > 0)
);

INSERT INTO LesZones VALUES (1, 'orchestre');
INSERT INTO LesZones VALUES (2, '1er balcon');
INSERT INTO LesZones VALUES (3, '2nd balcon');
INSERT INTO LesZones VALUES (4, 'poulailler');

-- LesSieges
CREATE TABLE LesSieges (
    noPlace NUMBER(2), noRang NUMBER(2), noZone NUMBER(1),
    CONSTRAINT sg_c1 PRIMARY KEY (noPlace, noRang),
    CONSTRAINT sg_c2 FOREIGN KEY (noZone) REFERENCES LesZones(noZone),
    CONSTRAINT sg_c3 CHECK (noPlace > 0 and noRang > 0 and noZone > 0)
);

INSERT INTO LesSieges
SELECT * FROM theatre.LesSieges;

-- LesSpectacles
CREATE TABLE LesSpectacles (
    noSpec NUMBER(1), nomS VARCHAR(30),
    CONSTRAINT sp_c1 PRIMARY KEY (noSpec),
    CONSTRAINT sp_c3 CHECK (noSpec > 0)
);

INSERT INTO LesSpectacles VALUES (1, 'La flute enchantee');
INSERT INTO LesSpectacles VALUES (2, 'Coldplay');
INSERT INTO LesSpectacles VALUES (3, 'Le lac des cygnes');

-- LesRepresentations
CREATE TABLE LesRepresentations (
    noSpec NUMBER(1), dateRep DATE,
    CONSTRAINT r_c1 PRIMARY KEY (dateRep),
    CONSTRAINT r_c2 FOREIGN KEY (noSpec) REFERENCES LesSpectacles(noSpec),
    CONSTRAINT r_c3 CHECK (noSpec > 0)
);

INSERT INTO LesRepresentations
SELECT * FROM theatre.LesRepresentations;

-- LesTickets
CREATE TABLE LesTickets (
    noSerie NUMBER(4), noSpec NUMBER(1), dateRep DATE, noPlace NUMBER(2), noRang NUMBER(2), dateEmission DATE, noDossier NUMBER(2),
    CONSTRAINT t_c1 PRIMARY KEY (noSerie),
    CONSTRAINT t_c2 UNIQUE (noSpec, dateRep, noPlace, noRang),
    -- CONSTRAINT t_c3 FOREIGN KEY (noSpec) REFERENCES LesRepresentations(noSpec),
    -- on ne peut pas ajouter cette requête, car pas de matching key avec lesRepresentations
    CONSTRAINT t_c3 FOREIGN KEY (dateRep) REFERENCES LesRepresentations(dateRep),
    CONSTRAINT t_c4 FOREIGN KEY (noPlace, noRang) REFERENCES LesSieges(noPlace, noRang),
    -- CONSTRAINT t_c5 FOREIGN KEY (noDossier) REFERENCES LesDossiers(noDossier),
    -- on ne peut pas ajouter cette contrainte non plus, car LesDossiers n'est pas encore créé et LesDossiers est une view!
    -- donc même souci qu'avec t_c3 : pas de matching key
    CONSTRAINT t_c6 CHECK (noSpec > 0),
    CONSTRAINT t_c7 CHECK (dateEmission < dateRep)
);

INSERT INTO LesTickets
SELECT * FROM theatre.LesTickets;

-- LesDossiers
CREATE VIEW LesDossiers (noDossier, montant) AS
    SELECT noDossier, SUM(prix) AS montant
    FROM LesTickets NATURAL JOIN LesSieges NATURAL JOIN LesZones NATURAL JOIN LesCategories
    GROUP BY noDossier
    ORDER BY noDossier
;
