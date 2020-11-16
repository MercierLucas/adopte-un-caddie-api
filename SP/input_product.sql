use adopte_un_caddie_api;

drop PROCEDURE if EXISTS input_product;

DELIMITER &&

CREATE PROCEDURE input_product(
    IN product_name VARCHAR(255),
    IN product_desc VARCHAR(255),
    IN price FLOAT,
    IN quantity VARCHAR(255),
    IN shop_uid INT
)
BEGIN
    DECLARE product_uid int;

    if (select count(*) from product where product.name = product_name) = 0
    then
        -- product doesn't exist yet, creating it
        INSERT INTO `product`
            (`uid`, `name`, `description`, `url`, `category_uid`) 
            VALUES 
            (NULL, product_name, product_desc, '', 0);
    end if;
    select product.uid into product_uid
        from product where product.name = product_name;
    
    INSERT INTO `product_shop_xref`
        (`uid`, `product_uid`, `shop_uid`, `price`, `quantity`)
        VALUES
        (NULL, product_uid, shop_uid, price, quantity);

    
END &&
DELIMITER ;



