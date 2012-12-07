DELIMITER $$

DROP PROCEDURE IF EXISTS alta_producte_tipus$$
CREATE PROCEDURE alta_producte_tipus (ID_PROD INTEGER, ID_TIP INTEGER)
    BEGIN
        INSERT IGNORE INTO pertanyer(id_tipus_producte, id_producte)
        VALUES (ID_TIP, ID_PROD);
    END$$

DELIMITER ;
