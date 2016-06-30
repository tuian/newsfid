UPDATE `oc_t_preference` SET `s_section`= "plugin_madhouse_avatar" WHERE `s_section` = "plugin_UserResource"


ALTER TABLE oc_t_user_resource ADD s_content_type VARCHAR(40) NULL DEFAULT NULL;
ALTER TABLE oc_t_user_resource ADD s_path VARCHAR(250) NULL DEFAULT NULL;