DELIMITER $$

DROP PROCEDURE IF EXISTS baixa_classifica_producte$$
CREATE PROCEDURE baixa_classifica_producte (ID_GEN INTEGER, ID_ESPEC INTEGER)
    BEGIN
        DELETE FROM classificacio 
        WHERE id_tipus_producte_especific = ID_ESPEC
        AND id_tipus_producte_generic = ID_GEN;
    END$$

DELIMITER ;
