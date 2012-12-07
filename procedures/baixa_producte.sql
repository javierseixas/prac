DELIMITER $$

CREATE PROCEDURE baixa_producte (ID INTEGER)
    BEGIN
        DELETE FROM producte WHERE id_producte = ID;
    END$$

DELIMITER ;
