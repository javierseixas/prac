DELIMITER $$

DROP PROCEDURE IF EXISTS alta_classifica_producte$$
CREATE PROCEDURE alta_classifica_producte (ID_GEN INTEGER, ID_ESPEC INTEGER)
    BEGIN
        INSERT IGNORE INTO classificacio(id_tipus_producte_especific, id_tipus_producte_generic)
        VALUES (ID_ESPEC, ID_GEN);
    END$$

DELIMITER ;
