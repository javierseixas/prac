DELIMITER $$

DROP PROCEDURE IF EXISTS baixa_producte_tipus$$
CREATE PROCEDURE baixa_producte_tipus (ID_PROD INTEGER, ID_TIP INTEGER)
    BEGIN
        DELETE FROM pertanyer WHERE id_tipus_producte = ID_TIP AND id_producte = ID_PROD;
    END$$

DELIMITER ;
