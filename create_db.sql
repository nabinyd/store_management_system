CREATE DATABASE store_db;

USE store_db;

CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    product_id INT,
    quantity INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);



-- Create a index for products table
CREATE INDEX idx_product_id ON products(product_id);
CREATE INDEX idx_product_id ON products(name);




-- Create view 

CREATE VIEW customer_product_view AS
SELECT 
    customers.customer_id, 
    customers.customer_name, 
    products.product_name,
    orders.quantity,
    orders.order_date
FROM 
    orders
JOIN 
    customers ON orders.customer_id = customers.customer_id
JOIN 
    products ON orders.product_id = products.product_id;


-- Create a trigger for update stock_quantity in products table after insert into orders table
DELIMITER $$

CREATE TRIGGER after_order_insert
AFTER INSERT ON orders
FOR EACH ROW
BEGIN
    UPDATE products
    SET stock_quantity = stock_quantity - NEW.quantity
    WHERE product_id = NEW.product_id;
END$$

DELIMITER ;


--  Create a trigger for delete product from products table on cascade delete from orders table
DELIMITER $$

CREATE TRIGGER before_product_delete
BEFORE DELETE ON products
FOR EACH ROW
BEGIN
    DELETE FROM orders WHERE product_id = OLD.product_id;
END$$

DELIMITER ;