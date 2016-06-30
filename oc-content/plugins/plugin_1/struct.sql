CREATE TABLE /*TABLE_PREFIX*/t_item_plugin_1 (
    pk_i_id INT  NOT NULL AUTO_INCREMENT,
    fk_i_item_id INT UNSIGNED NOT NULL,
	
	s_plugin1_first_name VARCHAR(255) NOT NULL DEFAULT '',
	
	
           PRIMARY KEY (pk_i_id),
        FOREIGN KEY (fk_i_item_id) REFERENCES /*TABLE_PREFIX*/t_item (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';




