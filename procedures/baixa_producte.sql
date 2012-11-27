DELIMITER $$

CREATE PROCEDURE baixa_producte (ID_PROD INTEGER)
    BEGIN
        DELETE FROM producte WHERE id_producte = ID_PROD
    END$$

DELIMITER ;