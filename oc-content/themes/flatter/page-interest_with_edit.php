<?php
//error_reporting(0);
// meta tag robots
osc_add_hook('header', 'flatter_nofollow_construct');

flatter_add_body_class('register');
osc_enqueue_script('jquery-validate');
osc_current_web_theme_path('header.php');
?>

<?php //if ($_SESSION['after_register'] && $_SESSION['after_register'] == 'yes'): ?>
<?php if (1): ?>
    <?php
    if ($_REQUEST['submit']):
        $user_id = $_SESSION['user_id'];
        $conn = getConnection();
        if (count($_REQUEST['cat_id']) >= 1):
            $theme_id_array = implode(',', $_REQUEST['cat_id']);
            foreach ($_REQUEST['cat_id'] as $k => $v):
                $conn->osc_dbExec("INSERT INTO %st_user_themes ( user_id, theme_id) VALUES (%s,'%s' )", DB_TABLE_PREFIX, $user_id, $v);
            endforeach;
            unset($_SESSION['after_register']);
            Session::newInstance()->_set('theme_ids', $theme_id_array);
            //unset($_SESSION['user_id']);
            osc_reset_static_pages();
            osc_get_static_page('rubric');
            header('Location: ' . osc_static_page_url());
            die;
        else:
            osc_add_flash_error_message(_e("You must select at least one theme", 'flatter'));
            header("Location: " . $_SERVER['REQUEST_URI']);
        endif;
    endif;
    ?>

    <form action="" method="post" class="user_theme_form">
        <div class="registerbox">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="titlebox background-white padding-10">
                            <h2><?php _e("Center of interest", 'flatter') ?></h2>
                            <h1>
                                <?php _e("Choose one or more themes", 'flatter') ?>
                            </h1>
                            <span>
                                <?php _e("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus imperdiet, justo posuere auctor and, diam ultrices libero enim ut erat blandit ipsum in orci. Nulla justo ac leo elementum luctus not faucibus vehicula sapien.", 'flatter') ?>
                                <br/>
                                <?php _e("In viverra arcu laoreet vitae iaculis. Proin erat justo, molestie sed dictum id, commodo non erat.", 'flatter') ?>
                                <br/>

                            </span>
                        </div>

                        <div class="separate-30"></div>

                        <div class="col-md-12 padding-10 background-white">
                            <div class="pull-right">
                                <input class="btn btn-blue btn-flat add_theme" type="submit" name="submit" value="<?php _e("Continue", 'flatter') ?>" />
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="row">
                            <?php
                            $data = new DAO();
                            $data->dao->select("a.*, b.*, c.i_num_items, d.*");
                            $data->dao->from(DB_TABLE_PREFIX . 't_category as a');
                            $data->dao->join(DB_TABLE_PREFIX . 't_category_description as b', 'a.pk_i_id = b.fk_i_category_id', 'INNER');
                            $data->dao->join(DB_TABLE_PREFIX . 't_category_stats  as c ', 'a.pk_i_id = c.fk_i_category_id', 'LEFT');
                            $data->dao->join(DB_TABLE_PREFIX . 'bs_theme_category_icon  as d ', 'a.pk_i_id = d.pk_i_id', 'LEFT');
                            $data->dao->where("a.fk_i_parent_id IS NULL");
                            $data->dao->where("b.fk_c_locale_code = 'en_US'");
                            $data->dao->orderBy('a.pk_i_id', 'ASC');
                            $result1 = $data->dao->get();
                            $themes = $result1->result();
                            if (osc_is_web_user_logged_in()):
                                $user_theme = get_user_themes(87);
                            endif;
                            ?>
                            <?php foreach ($themes as $k => $theme): ?>
                                <div class="col-md-3 col-sm-3 margin-bottom-20">
                                    <?php
                                    $selected = '';
                                    $checked = '';
                                    if ($user_theme):
                                        if (in_array($theme['pk_i_id'], $user_theme)):
                                            $selected = 'selected';
                                            $checked = 'checked';
                                        endif;
                                    endif;
                                    ?>
                                    <div class="category_box <?php echo $selected ?>" data-id="<?php echo $theme['pk_i_id'] ?>">
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
                                            <input type="checkbox" <?php echo $checked ?> name="cat_id[]" value="<?php echo $theme['pk_i_id'] ?>" class="cat_checkbox" style="display: none">
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
        </div>
    </form>

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
                $('.add_theme').click(function (e) {
                    var checked_cat = $('.category_box.selected');
                    if (checked_cat.length >= 1) {
                        $('.user_theme_form').submit();
                    } else {
                        alert(<?php _e("Please select at least one theme", 'flatter') ?>);
                        e.preventDefault();
                    }
                });
            });
        </script>
        <?php
    }

    osc_add_hook('footer', 'new_footer');
    ?>
<?php else: ?>
    <h2><?php echo __("You can't use this page direct") ?></h2>
<?php endif; ?>

<?php osc_current_web_theme_path('footer.php'); ?>