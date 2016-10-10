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
$data1->dao->select(" a.*, a.pk_i_id as cat_pk_id, b.*, d.*");
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
?>

<div id="columns" class="user-interest">
    <h3 class="col-md-9"><?php _e("Center of interest", 'flatter') ?></h3>    
    <div class="clearfix"></div>
    <div class="theme-interest-container">
        <ul class="nav">
            <li class="theme-interest-tab <?php echo $active == '1' ? 'active' : '' ?>"><a href="<?php echo osc_static_page_url(); ?>"><?php _e("Themes", 'flatter') ?> </a></li>
            <li class="theme-interest-tab <?php echo $active == '2' ? 'active' : '' ?>"><a href="<?php echo osc_static_page_url() . '&type=interest'; ?>"><?php _e("Rubrics", 'flatter') ?></a></li>            
        </ul> 
    </div>
    <?php if (isset($_GET['type']) && $_GET['type'] == 'interest'): ?>
        <form action="" method="post"  class="user_theme_form">       
            <div class="container">
                <div class="row">                 
                    <div class="col-md-12 col-sm-12">
                        <div class="row">                         
                            <?php foreach ($interest as $k => $i): ?>
                                <div class="col-md-3 col-sm-3 margin-bottom-20">
                                    <div title="<?php echo $i['s_name']; ?>" class="category_box <?php echo in_array($i['fk_i_category_id'], $selected_rubric_arr) ? 'selected' : '' ?>" cat-id='<?php echo $i['fk_i_category_id'] ?>' check-type='interest'>
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
                                <div class="col-md-3 col-sm-3 margin-bottom-20">
                                    <div title="<?php echo $theme['s_name']; ?>" class="category_box <?php echo in_array($theme['cat_pk_id'], $selected_themes_arr) ? 'selected' : '' ?>" cat-id="<?php echo $theme['cat_pk_id'] ?>" check-type='theme'>
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
                                            <input type="checkbox" name="cat_id[]" value="<?php echo $theme['cat_pk_id'] ?>" class="cat_checkbox" <?php echo in_array($theme['cat_pk_id'], $selected_themes_arr) ? 'checked="checked"' : '' ?> style="display: none">
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
                
                var cat_id = $(this).attr('cat-id');
                var check_type = $(this).attr('check-type');
                $(this).toggleClass('selected');
                var checkbox = $(this).find('.cat_checkbox');
                checkbox.attr("checked", !checkbox.attr("checked"));
                //                $('.user_theme_form').submit();
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url('theme-rubrics-ajax.php') ?>",
                    type: 'post',
                    data: {
                        action: 'theme-rubrics',
                        cat_id: cat_id,
                        check_type: check_type,
                    }
                });
            });
        });
    </script>
    <?php
}

//osc_add_hook('footer', 'ex_load_scripts');
osc_add_hook('footer', 'new_footer');
?>

<?php osc_current_web_theme_path('footer.php'); ?>