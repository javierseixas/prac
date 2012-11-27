DELIMITER $$

CREATE PROCEDURE alta_producte_desc (ID_PROD INTEGER, ID_IDIOMA INTEGER, DESC_CURTA VARCHAR(50), DESC_LLARGA VARCHAR(200))
    BEGIN
        INSERT INTO desc_prod(id_producte, id_idioma, descripcio_curta, descripcio_llarga)
        VALUES (ID_PROD, ID_IDIOMA, DESC_CURTA, DESC_LLARGA);
    END$$

DELIMITER ;