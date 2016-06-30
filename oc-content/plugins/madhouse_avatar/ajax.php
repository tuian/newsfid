<?php

//Load ajax controller and run doModel
mdh_current_plugin_path("classes/Madhouse/Avatar/Controllers/Ajax.php");
$do = new Madhouse_Avatar_Controllers_Ajax();
$do->doModel();
?>