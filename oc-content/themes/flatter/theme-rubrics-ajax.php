<?php

require_once '../../../oc-load.php';
require_once 'functions.php';
if ($_REQUEST['action'] == 'theme-rubrics'):
    $user_id = osc_logged_user_id();
    if ($_REQUEST['check_type'] == 'interest'):
        $db_prefix = DB_TABLE_PREFIX;
        $interest['rubric_id'] = $_REQUEST['cat_id'];
        $interest['user_id'] = $user_id;

        $rubric_data = new DAO();
        $rubric_data->dao->select("rubrics.*");
        $rubric_data->dao->from("{$db_prefix}t_user_rubrics AS rubrics");
        $rubric_data->dao->where('rubrics.user_id=' . $user_id . ' AND rubrics.rubric_id=' . $_REQUEST['cat_id']);
        $rubric = $rubric_data->dao->get();
        $rubrics = $rubric->row();
        echo "<pre>";
        print_r($rubrics);
        if (!empty($rubrics)):
            $rubric_data->dao->delete("{$db_prefix}t_user_rubrics", "id=" . $rubrics['id']);
        else:
            $interest_data = new DAO();
            $interest_data->dao->insert("{$db_prefix}t_user_rubrics", $interest);
        endif;
    elseif ($_REQUEST['check_type'] == 'theme') :
        $db_prefix = DB_TABLE_PREFIX;
        $interest['theme_id'] = $_REQUEST['cat_id'];
        $interest['user_id'] = $user_id;
        $interest_data = new DAO();
        $interest_data->dao->select("theme.*");
        $interest_data->dao->from("{$db_prefix}t_user_themes AS theme");
        $interest_data->dao->where('theme.user_id=' . $user_id . ' AND theme.theme_id=' . $_REQUEST['cat_id']);
        $theme = $interest_data->dao->get();
        $themes = $theme->row();
        if (!empty($themes)):
            $interest_data->dao->delete("{$db_prefix}t_user_themes", "id=" . $themes['id']);
        else:
            $interest_data = new DAO();
            $interest_data->dao->insert("{$db_prefix}t_user_themes", $interest);
        endif;

    endif;
endif;

