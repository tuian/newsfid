<?php
// meta tag robots
error_reporting(0);
osc_add_hook('header', 'flatter_nofollow_construct');

flatter_add_body_class('register');
osc_enqueue_script('jquery-validate');
osc_current_web_theme_path('header.php');
?>
<?php
if ($_REQUEST['submit']):
    if (count($_REQUEST['cat_id']) >= 4):
        $user_id = $_SESSION['user_id'];
        $conn = getConnection();
        foreach ($_REQUEST['cat_id'] as $k => $v):
            $conn->osc_dbExec("INSERT INTO %st_user_rubrics ( user_id, rubric_id) VALUES (%s,'%s' )", DB_TABLE_PREFIX, $user_id, $v);
        endforeach;
        osc_reset_static_pages();

        $user = User::newInstance()->findByPrimaryKey($user_id);
        Session::newInstance()->_set('userId', $user['pk_i_id']);
        Session::newInstance()->_set('userName', $user['s_name']);
        Session::newInstance()->_set('userEmail', $user['s_email']);
        $phone = ($user['s_phone_mobile']) ? $user['s_phone_mobile'] : $user['s_phone_land'];
        Session::newInstance()->_set('userPhone', $phone);
        header('Location: ' . osc_base_url());
        die;
    else:
        osc_add_flash_error_message(_e("You must select at least four rubrics", 'flatter') );
        header("Location: " . $_SERVER['REQUEST_URI']);
    endif;
endif;
?>

<form action="" method="post"  class="user_rubric_form">
    <div class="registerbox">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="titlebox background-white padding-10">
                        <h2><?php _e("Center of interest", 'flatter') ?></h2>
                        <!--<h2>Centre d'intérêt</h2>-->
                        <h1>
                            <?php _e("Choose one or more topics that interest you", 'flatter') ?>
                            <!--Choisissez un ou plusieurs sujets qui vous intéressent-->
                        </h1>
                        <span>
                            <?php _e("What kind of topics interest you? You must select at least four of them. This will allow us to connect to people and organization that have the same interests as you center.", 'flatter') ?>
                            <!--Quel genre de sujets vous intéresse? Vous devez en sélectionner au moins un d'entre eux. Cela nous permettra de vous connecter à personnes et l'organisation qu ont les même centre d'intérêts que vous.-->
                        </span>
                    </div>

                    <div class="separate-30"></div>

                    <div class="col-md-12 padding-10 background-white">
                        <div class="pull-right">
                            <!--<input class="btn btn-blue btn-flat add_rubric" type="submit" name="submit" value="Poursuivre" />-->
                            <input class="btn btn-blue btn-flat add_rubric" type="submit" name="submit" value="<?php _e("Continue", 'flatter') ?>" />
                        </div>
                    </div>

                </div>
                <div class="col-md-8 col-sm-8 scroll-content">
                    <div class="row">
                        <?php
                        $current_l = osc_current_user_locale();
                        $data = new DAO();
                        $data->dao->select("a.*, b.*, c.i_num_items, d.bs_image_name"); // i take bs_image_name coz pk_i_id ambigues with icon table
                        $data->dao->from(DB_TABLE_PREFIX . 't_category as a');
                        $data->dao->join(DB_TABLE_PREFIX . 't_category_description as b', 'a.pk_i_id = b.fk_i_category_id', 'INNER');
                        $data->dao->join(DB_TABLE_PREFIX . 't_category_stats  as c ', 'a.pk_i_id = c.fk_i_category_id', 'LEFT');
                        $data->dao->join(DB_TABLE_PREFIX . 'bs_theme_category_icon  as d ', 'a.pk_i_id = d.pk_i_id', 'LEFT');
                        //$data->dao->where(sprintf("a.fk_i_parent_id in (%s)", $_SESSION['theme_ids']));
                        $data->dao->whereIn("a.fk_i_parent_id", $_SESSION['theme_ids']);
                        $data->dao->where("b.fk_c_locale_code = '{$current_l}'");
                        $data->dao->orderBy('a.pk_i_id', 'ASC');
                        $result1 = $data->dao->get();
                        $themes = $result1->result();                       
                        ?>
                        <?php foreach ($themes as $k => $theme): ?>
                            <div class="col-md-3 col-sm-3 margin-bottom-20">
                                <div class="category_box" data-id="<?php echo $theme['pk_i_id'] ?>">
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
                                        <input type="checkbox" name="cat_id[]" value="<?php echo $theme['pk_i_id'] ?>" class="cat_checkbox" style="display: none">
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
            $('.add_rubric').click(function (e) {
                var checked_cat = $('.category_box.selected');
                if (checked_cat.length >= 4) {
                    $('.user_rubric_form').submit();
                } else {
                    alert('<?php _e("Please select at least four rubrics", 'flatter') ?>');
                    e.preventDefault();
                }
            });
        });
    </script>
    <?php
}

//osc_add_hook('footer', 'ex_load_scripts');
osc_add_hook('footer', 'new_footer');
?>

<?php osc_current_web_theme_path('footer.php'); ?>