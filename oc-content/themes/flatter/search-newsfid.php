<?php
require '../../../oc-load.php';
require 'functions.php';

$search_newsfid = $_REQUEST['search_newsfid_text'];

$db_prefix = DB_TABLE_PREFIX;

$user_search_data = new DAO();
$user_search_data->dao->select('user.pk_i_id as user_id, user.s_name as user_name, user.s_email, user.fk_i_city_id, user.fk_c_country_code');
$user_search_data->dao->from("{$db_prefix}t_user AS user");
$user_search_data->dao->where(sprintf("user.s_name LIKE '%s'", '%' . $search_newsfid . '%'));
$user_search_data->dao->orderBy('user.s_name', 'ASC');
$user_search_result = $user_search_data->dao->get();
$user_search_array = $user_search_result->result();


$item_search_data = new DAO();
$item_search_data->dao->select('item.pk_i_id, item.b_enabled, item.b_active, item_description.fk_i_item_id, item_description.s_title');
$item_search_data->dao->from("{$db_prefix}t_item AS item");
$item_search_data->dao->join("{$db_prefix}t_item_description AS item_description", "item_description.fk_i_item_id = item.pk_i_id", "INNER");
$item_search_data->dao->where(array("item.b_enabled" => 1, "item.b_active" => 1));
$item_search_data->dao->where(sprintf("item_description.s_title LIKE '%s'", '%' . $search_newsfid . '%'));
$item_search_data->dao->orderBy('item_description.s_title', 'ASC');

$item_search_result = $item_search_data->dao->get();
$item_search_array = $item_search_result->result();
//pr($item_search_array);
?>

        <!-- Modal content-->
    <?php get_search_popup($search_newsfid, $item_search_array, $user_search_array); ?>
