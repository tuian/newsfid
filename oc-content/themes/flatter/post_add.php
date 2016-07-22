<?php
$like_array['fk_i_category_id'] = $_REQUEST['sCategory'];

$like_data = new DAO();
$like_data->dao->insert(sprintf('%st_item', DB_TABLE_PREFIX), $like_array);
$item_id = $like_data->dao->insertedId();
if($item_id){
$item_desc['s_title'] = $_REQUEST['p_title'];
$item_desc['s_description'] = $_REQUEST['p_disc'];
$item_desc['fk_c_locale_code'] = 'en_US';
$item_desc['fk_i_item_id'] = $item_id;
$like_data = new DAO();
$like_data->dao->insert(sprintf('%st_item_description', DB_TABLE_PREFIX), $item_desc);
}
?>