DELIMITER $$

DROP PROCEDURE IF EXISTS baixa_tipus_producte$$
CREATE PROCEDURE baixa_tipus_producte (ID_TIP INTEGER)
    BEGIN
        DELETE FROM classificacio WHERE id_tipus_producte_especific = ID_TIP OR id_tipus_producte_generic = ID_TIP;
        DELETE FROM tipus_producte WHERE id_tipus_producte = ID_TIP;
    END$$

DELIMITER ;
