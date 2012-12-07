DELIMITER $$

DROP PROCEDURE IF EXISTS modifica_producte_atribut$$
CREATE PROCEDURE modifica_producte_atribut (PREU_ACTUAL DOUBLE(9,2), ES_OFERTA BIT, PREU_OFERTA DOUBLE(9,2), ESTOC_INI INTEGER, ESTOC_ACT INTEGER, ESTOC_NOT INTEGER, ID INTEGER) 
    BEGIN
        UPDATE producte SET 
        	preu_actual = PREU_ACTUAL, 
        	es_oferta = ES_OFERTA, 
        	preu_oferta = PREU_OFERTA, 
        	estoc_inicial = ESTOC_INI, 
        	estoc_actual = ESTOC_ACT, 
        	estoc_notificacio = ESTOC_NOT
        WHERE
        	id_producte = ID;
    END$$

DELIMITER ;
