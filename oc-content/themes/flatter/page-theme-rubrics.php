<?php
osc_add_hook('header', 'flatter_nofollow_construct');
flatter_add_body_class('register');
osc_enqueue_script('jquery-validate');
osc_current_web_theme_path('header.php');

$data = new DAO();

$user_id = osc_logged_user_id();
$data = new DAO();
$data->dao->select("theme.theme_id");
$data->dao->from(DB_TABLE_PREFIX . 't_user_themes as theme');
$data->dao->where("theme.user_id = $user_id");
$theme_list = $data->dao->get();
$selected_themes = $theme_list->result();
$selected_themes_arr = array();
foreach ($selected_themes as $sl):
    $selected_themes_arr[] = $sl['theme_id'];
endforeach;

$data1 = new DAO();
$data1->dao->select("a.*, b.*, d.*");
$data1->dao->from(DB_TABLE_PREFIX . 't_category as a');
$data1->dao->join(DB_TABLE_PREFIX . 't_category_description as b', 'a.pk_i_id = b.fk_i_category_id', 'INNER');
//$data1->dao->join(DB_TABLE_PREFIX . 't_category_stats  as c ', 'a.pk_i_id = c.fk_i_category_id', 'LEFT');
$data1->dao->join(DB_TABLE_PREFIX . 'bs_theme_category_icon  as d ', 'a.pk_i_id = d.pk_i_id', 'LEFT');
$data1->dao->where("a.fk_i_parent_id IS NULL AND b.fk_c_locale_code = 'en_US'");
$data1->dao->orderBy('a.pk_i_id', 'ASC');
$result1 = $data1->dao->get();
$themes = $result1->result();
$active = '1';
if (isset($_GET['type']) && $_GET['type'] == 'interest'):
    $active = '2';
    $intrest_data = new DAO();
    $intrest_data->dao->select("a.*, b.*, d.*");
    $intrest_data->dao->from(DB_TABLE_PREFIX . 't_category as a');
    $intrest_data->dao->join(DB_TABLE_PREFIX . 't_category_description as b', 'a.pk_i_id = b.fk_i_category_id', 'INNER');
    //$intrest_data->dao->join(DB_TABLE_PREFIX . 't_category_stats  as c ', 'a.pk_i_id = c.fk_i_category_id', 'LEFT');
    $intrest_data->dao->join(DB_TABLE_PREFIX . 'bs_theme_category_icon  as d ', 'a.pk_i_id = d.pk_i_id', 'LEFT');
    $intrest_data->dao->where(sprintf("a.fk_i_parent_id in (%s) AND b.fk_c_locale_code = 'en_US'", implode(",", $selected_themes_arr)));
    $intrest_data->dao->orderBy('a.pk_i_id', 'ASC');
    $result = $intrest_data->dao->get();
    $interest = $result->result();
   
    $rdata = new DAO();
    $rdata->dao->select("rubric.rubric_id");
    $rdata->dao->from(DB_TABLE_PREFIX . 't_user_rubrics as rubric');
    $rdata->dao->where("rubric.user_id = $user_id");
    $theme_list = $rdata->dao->get();
    $selected_rubric = $theme_list->result();
    $selected_rubric_arr = array();
    foreach ($selected_rubric as $sl):
        $selected_rubric_arr[] = $sl['rubric_id'];
    endforeach;
endif;



if ($_POST):
    $conn = getConnection();
    if (isset($_GET['type']) && $_GET['type'] == 'interest'):
        if (count($_REQUEST['cat_id']) >= 4):
            $conn->osc_dbExec("DELETE FROM `%st_user_rubrics` WHERE `user_id` = %s", DB_TABLE_PREFIX, $user_id);
            foreach ($_REQUEST['cat_id'] as $k => $v):
                $conn->osc_dbExec("INSERT INTO %st_user_rubrics ( user_id, rubric_id) VALUES (%s,'%s' )", DB_TABLE_PREFIX, $user_id, $v);
            endforeach;           
            osc_add_flash_info_message(_m('Rubriques updated successfully'));
            header("Location: " . $_SERVER['REQUEST_URI']);
        else:
            osc_add_flash_error_message(_m('You must select at least four rubrics'));
            header("Location: " . $_SERVER['REQUEST_URI']);
        endif;
    else:
        if (count($_REQUEST['cat_id']) >= 1):
            $conn->osc_dbExec("DELETE FROM `%st_user_themes` WHERE `user_id` = %s", DB_TABLE_PREFIX, $user_id);
            foreach ($_REQUEST['cat_id'] as $k => $v):
                $conn->osc_dbExec("INSERT INTO %st_user_themes ( user_id, theme_id) VALUES (%s,'%s' )", DB_TABLE_PREFIX, $user_id, $v);
            endforeach;
            osc_add_flash_info_message(_m('Theme updated successfully'));
            header('Location: ' . osc_static_page_url());
        else:
            osc_add_flash_error_message(_m('You must select at least one theme'));
            header("Location: " . $_SERVER['REQUEST_URI']);
        endif;
    endif;
endif;

?>

<div id="columns" class="user-interest">
    <h3 class="col-md-9">Centre d'intérêt</h3>
    <div class="col-md-3 pull-right">
        <input class="btn btn-blue btn-flat update_theme" type="submit" name="submit" value="Enregistrer" />
    </div>
    <div class="clearfix"></div>
    <div class="theme-interest-container">
        <ul class="nav">
            <li class="theme-interest-tab <?php echo $active == '1' ? 'active' : '' ?>"><a href="<?php echo osc_static_page_url(); ?>"> Themes</a></li>
            <li class="theme-interest-tab <?php echo $active == '2' ? 'active' : '' ?>"><a href="<?php echo osc_static_page_url() . '&type=interest'; ?>">Rubriques</a></li>            
        </ul> 
    </div>
    <?php if (isset($_GET['type']) && $_GET['type'] == 'interest'): ?>
        <form action="" method="post"  class="user_theme_form">       
            <div class="container">
                <div class="row">                 
                    <div class="col-md-12 col-sm-12">
                        <div class="row">                         
                            <?php foreach ($interest as $k => $i): ?>
                                <div class="col-md-2 col-sm-2 margin-bottom-20">
                                    <div title="<?php echo $i['s_name']; ?>" class="category_box <?php echo in_array($i['fk_i_category_id'], $selected_rubric_arr) ? 'selected' : '' ?>">
                                        <div class="category_image">
                                            <?php
                                            if ($i['bs_image_name']) :
                                                $img_path = UPLOAD_PATH . $i['bs_image_name'];
                                            else:
                                                $img_path = osc_current_web_theme_url() . 'images/no-photo.jpg';
                                            endif;
                                            ?>
                                            <img src="<?php echo $img_path; ?>" class="img img-responsive cat-image"/>   
                                            <div class="add_box">
                                                <span class="add_icon"></span>
                                            </div>
                                            <div class="overlay"></div>
                                            <input type="checkbox" name="cat_id[]" value="<?php echo $i['fk_i_category_id'] ?>" class="cat_checkbox" <?php echo in_array($i['fk_i_category_id'], $selected_rubric_arr) ? 'checked="checked"' : '' ?> style="display: none">
                                        </div>
                                        <div class="category_title">
                                            <?php echo osc_highlight($i['s_name'], 10); ?>                                            
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                </div>            
            </div>
        </form>
    <?php else: ?>    
        <form action="<?php echo osc_static_page_url(); ?>" method="post"  class="user_theme_form">       
            <div class="container">
                <div class="row">                 
                    <div class="col-md-12 col-sm-12">
                        <div class="row">                         
                            <?php foreach ($themes as $k => $theme): ?>
                                <div class="col-md-2 col-sm-2 margin-bottom-20">
                                    <div title="<?php echo $theme['s_name']; ?>" class="category_box <?php echo in_array($theme['pk_i_id'], $selected_themes_arr) ? 'selected' : '' ?>" data-id="<?php echo $theme['pk_i_id'] ?>">
                                        <div class="category_image">
                                            <?php
                                            if ($theme['bs_image_name']) :
                                                $img_path = UPLOAD_PATH . $theme['bs_image_name'];
                                            else:
                                                $img_path = osc_current_web_theme_url() . 'images/no-photo.jpg';
                                            endif;
                                            ?>
                                            <img src="<?php echo $img_path; ?>" class="img img-responsive cat-image"/>   
                                            <div class="add_box">
                                                <span class="add_icon"></span>
                                            </div>
                                            <div class="overlay"></div>
                                            <input type="checkbox" name="cat_id[]" value="<?php echo $theme['pk_i_id'] ?>" class="cat_checkbox" <?php echo in_array($theme['pk_i_id'], $selected_themes_arr) ? 'checked="checked"' : '' ?> style="display: none">
                                        </div>
                                        <div class="category_title">
                                            <?php echo osc_highlight($theme['s_name'], 13); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                </div>            
            </div>            
        </form>
    <?php endif; ?>
</div>
<?php

function new_footer() {
    ?>
    <script>
        $(document).ready(function () {
            $('.category_box').click(function () {
                $(this).toggleClass('selected');
                var checkbox = $(this).find('.cat_checkbox');
                checkbox.attr("checked", !checkbox.attr("checked"));
            });
            $('.update_theme').click(function (e) {
                $('.user_theme_form').submit();
            });
        });
    </script>
    <?php
}

//osc_add_hook('footer', 'ex_load_scripts');
osc_add_hook('footer', 'new_footer');
?>

<?php osc_current_web_theme_path('footer.php'); ?>