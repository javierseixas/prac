DELIMITER $$

DROP PROCEDURE IF EXISTS alta_producte_atribut$$
CREATE PROCEDURE alta_producte_atribut (PREU_ACTUAL DOUBLE(9,2), ES_OFERTA BIT, PREU_OFERTA DOUBLE(9,2), ESTOC_INI INTEGER, ESTOC_ACT INTEGER, ESTOC_NOT INTEGER, OUT ID_PRODUCTE INTEGER) 
    BEGIN
        INSERT INTO producte(preu_actual, es_oferta, preu_oferta, estoc_inicial, estoc_actual, estoc_notificacio)
        VALUES (PREU_ACTUAL, ES_OFERTA, PREU_OFERTA, ESTOC_INI, ESTOC_ACT, ESTOC_NOT);
    END$$

DELIMITER ;


DELIMITER $$

DROP PROCEDURE IF EXISTS recupera_ultim_producte$$
CREATE PROCEDURE recupera_ultim_producte(OUT ID INTEGER) 
    BEGIN
        SELECT id_producte FROM producte ORDER BY id_producte DESC LIMIT 1;
    END$$

DELIMITER ;