CREATE DATABASE	tecnico_dp;

USE tecnico_dp;

CREATE TABLE cat_menus (
	menu_id			INT NOT NULL AUTO_INCREMENT,
	menu_name 		VARCHAR (30) NOT NULL,
	menu_desc		VARCHAR (100) NOT NULL,
	menu_parent		INT,
	PRIMARY KEY (menu_id)
)

/* INSERT INTO cat_menus (menu_name, menu_desc) VALUES ("Primer menu", "prueba, primer menu") */
SELECT * FROM cat_menus