DELIMITER $$

DROP PROCEDURE IF EXISTS modifica_producte_desc$$
CREATE PROCEDURE modifica_producte_desc (ID_PROD INTEGER, ID_IDI INTEGER, DESC_CURTA VARCHAR(50), DESC_LLARGA VARCHAR(200))
    BEGIN
        UPDATE desc_prod SET 
        	descripcio_curta = DESC_CURTA,
        	descripcio_llarga = DESC_LLARGA
        WHERE
        	id_producte = ID_PROD
        	AND id_idioma = ID_IDI;
    END$$

DELIMITER ;
