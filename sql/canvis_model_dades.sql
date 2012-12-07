-- Canvia el tipus 

ALTER TABLE producte MODIFY es_oferta TINYINT(1) NULL DEFAULT NULL;


-- Canviar les claus foranes a la taula pertanyer

ALTER TABLE pertanyer DROP FOREIGN KEY pertanyer_ibfk_1;
ALTER TABLE pertanyer DROP FOREIGN KEY pertanyer_ibfk_2;

ALTER TABLE pertanyer ADD FOREIGN KEY(id_producte)
    REFERENCES producte(id_producte)
      ON DELETE CASCADE
      ON UPDATE NO ACTION,
  ADD FOREIGN KEY(id_tipus_producte)
    REFERENCES tipus_producte(id_tipus_producte)
      ON DELETE CASCADE
      ON UPDATE NO ACTION