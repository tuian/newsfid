CREATE TABLE  IF NOT EXISTS /*TABLE_PREFIX*/t_user_resource(
    pk_i_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
    fk_i_user_id int(10) UNSIGNED NOT NULL ,
    s_extension VARCHAR(10) NULL ,
    s_name VARCHAR(60) NULL,
    s_content_type VARCHAR(40) NULL,
    s_path VARCHAR(250) NULL,
            PRIMARY KEY (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';