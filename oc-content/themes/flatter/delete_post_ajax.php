<?php

require '../../../oc-load.php';
require 'functions.php';

$user_id = $_REQUEST['user_id'];
$post_id = $_REQUEST['post_id'];
$db_prefix = DB_TABLE_PREFIX;
if ($_REQUEST['action'] == 'delete_post'):
    
    $delete_item_comment = new DAO();
    $delete_item_comment->dao->delete("{$db_prefix}t_item_comment", "fk_i_item_id= $post_id");
    $comment_result = $delete_item_comment->dao->get();

    $delete_item_description = new DAO();
    $delete_item_description->dao->delete("{$db_prefix}t_item_description", "fk_i_item_id= $post_id");
    $description_result = $delete_item_description->dao->get();

    $delete_item_like = new DAO();
    $delete_item_like->dao->delete("{$db_prefix}t_item_likes", "item_id= $post_id");
    $like_result = $delete_item_like->dao->get();

    $delete_item_location = new DAO();
    $delete_item_location->dao->delete("{$db_prefix}t_item_location", "fk_i_item_id= $post_id");
    $location_result = $delete_item_location->dao->get();

    $delete_item_meta = new DAO();
    $delete_item_meta->dao->delete("{$db_prefix}t_item_meta", "fk_i_item_id= $post_id");
    $meta_result = $delete_item_meta->dao->get();

    $delete_item_mp3 = new DAO();
    $delete_item_mp3->dao->delete("{$db_prefix}t_item_mp3_files", "fk_i_item_id= $post_id");
    $mp3_result = $delete_item_mp3->dao->get();

    $delete_item_podcast = new DAO();
    $delete_item_podcast->dao->delete("{$db_prefix}t_item_podcasts", "fk_i_item_id= $post_id");
    $podcast_result = $delete_item_podcast->dao->get();

    $delete_item_resource = new DAO();
    $delete_item_resource->dao->delete("{$db_prefix}t_item_resource", "fk_i_item_id= $post_id");
    $resource_result = $delete_item_resource->dao->get();

    $delete_item_stats = new DAO();
    $delete_item_stats->dao->delete("{$db_prefix}t_item_stats", "fk_i_item_id= $post_id");
    $stats_result = $delete_item_stats->dao->get();

    $delete_item_video = new DAO();
    $delete_item_video->dao->delete("{$db_prefix}t_item_video_files", "fk_i_item_id= $post_id");
    $video_result = $delete_item_video->dao->get();

    $delete_item_watchlist = new DAO();
    $delete_item_watchlist->dao->delete("{$db_prefix}t_item_watchlist", "item_id= $post_id");
    $watchlist_result = $delete_item_watchlist->dao->get();
    
    $delete_item_premium = new DAO();
    $delete_item_premium->dao->delete("{$db_prefix}t_premium_items", "item_id= $post_id AND user_id = $user_id");
    $watchlist_result = $delete_item_premium->dao->get();

    $delete_user_post = new DAO();
    $delete_user_post->dao->delete("{$db_prefix}t_item", "pk_i_id= $post_id AND fk_i_user_id = $user_id");
    $post_result = $delete_user_post->dao->get();
    
     osc_add_flash_ok_message(_e('Your Post Succsessfully Deleted...!!', 'flatter')); 
endif;
?>
