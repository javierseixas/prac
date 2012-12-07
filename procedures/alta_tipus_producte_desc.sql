DELIMITER $$

DROP PROCEDURE IF EXISTS alta_tipus_producte_desc$$
CREATE PROCEDURE alta_tipus_producte_desc (ID_TIP INTEGER, ID_IDIOMA INTEGER, DESCRIPCIO VARCHAR(50), DTE DOUBLE(5,2))
    BEGIN
        INSERT IGNORE INTO tipus_producte(id_tipus_producte, dte)
        VALUES (ID_TIP, DTE);
        INSERT IGNORE INTO desc_tip_prod(id_tipus_producte, id_idioma, descripcio)
        VALUES (ID_TIP, ID_IDIOMA, DESCRIPCIO);
    END$$

DELIMITER ;
