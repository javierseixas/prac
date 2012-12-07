DELIMITER $$

DROP PROCEDURE IF EXISTS modifica_estoc_actual$$
CREATE PROCEDURE modifica_estoc_actual (ESTOC_ACT INTEGER, ID INTEGER) 
    BEGIN
        UPDATE producte SET 
        	estoc_actual = ESTOC_ACT 
        WHERE
        	id_producte = ID;
    END$$

DELIMITER ;
