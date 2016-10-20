<?php
//error_reporting(0);
// meta tag robots
osc_add_hook('header', 'flatter_nofollow_construct');

flatter_add_body_class('register');
osc_enqueue_script('jquery-validate');
osc_current_web_theme_path('header.php');
?>

<?php if ($_SESSION['after_register'] && $_SESSION['after_register'] == 'yes'): ?>
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
            osc_add_flash_error_message( _e("You must select at least one theme", 'flatter'));
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
                            <h2><?php _e("Center of interest", 'flatter'); ?></h2>
                            <!--                            <h2>Centre d'intérêt</h2>-->
                            <h1>
                                <?php _e("Choose topics that you are interested", 'flatter'); ?>
                                <!--Choisissez les sujets qui vous intéresse-->
                            </h1>
                            <span>
                                <!--Cette étape nous permet simplement de vous faire des suggestions de sujet auquel vous êtes intéressé(e).-->
                                <?php _e("This step simply allows us to make you suggestions about which you are interested.", 'flatter'); ?>
                                <br/>
                                <br/>
                                <!--                                Prenez le temps de faire votre choix. Vous pourrai le modifier plus tard. -->
                                <?php _e("Take time to make your choice. You could change it later.", 'flatter'); ?>
                            </span>
                        </div>

                        <div class="separate-30"></div>

                        <div class="col-md-12 padding-10 background-white">
                            <div class="pull-right">
                                <!--<input class="btn btn-blue btn-flat add_theme" type="submit" name="submit" value="Poursuivre" />-->
                                <input class="btn btn-blue btn-flat add_theme" type="submit" name="submit" value="<?php _e("Continue", 'flatter'); ?>" />
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8 col-sm-8 scroll-content">
                        <div class="row">
                            <?php
                            $current_l = osc_current_user_locale();
                            $data = new DAO();
                            $data->dao->select("a.*, b.*, c.i_num_items, d.*");
                            $data->dao->from(DB_TABLE_PREFIX . 't_category as a');
                            $data->dao->join(DB_TABLE_PREFIX . 't_category_description as b', 'a.pk_i_id = b.fk_i_category_id', 'INNER');
                            $data->dao->join(DB_TABLE_PREFIX . 't_category_stats  as c ', 'a.pk_i_id = c.fk_i_category_id', 'LEFT');
                            $data->dao->join(DB_TABLE_PREFIX . 'bs_theme_category_icon  as d ', 'a.pk_i_id = d.pk_i_id', 'LEFT');
                            $data->dao->where("a.fk_i_parent_id IS NULL");
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
<div id="popup-free-user-post" class="modal modal-transparent fade" role="dialog">
    <div class="col-md-offset-1 col-sm-offset-1 col-sm-10 col-md-10 post">
        <button type="button" class="close" data-dismiss="modal">&times;</button>-->
        <div class="large-modal">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="col-md-12 publication-loader height-400 padding-0" >
                    <div class="col-md-12 background-white padding-0">                       
                        <div class="col-md-6 padding-10 margin-20 border-right-grey">                       
                            <span class="blue_text bold font-22px"><?php _e('Before to start','flatter') ?></span><br>
                            <span><?php _e('Think to go into your Center of Interest in order To personalize your news feed as you wish at anytime.','flatter') ?></span>
                        </div>
                        <div class="col-md-3 col-md-offset-1">                            
                            <button class="btn orange_line_btn margin-top-50" id="submit-register"><a href="<?php echo osc_base_url()."/index.php?page=login";?>"><?php _e('Thanks, I got it','flatter') ?></a></button>
                        </div>
                    </div>
                    <div class="col-md-12">
                    <style>
                        .publication-loader{
                            background: #372940;
                            height: 300px;
                            width: 60%;
                            left: 18%;
                            top: 30px;
                        }
                        #loader {
                            position: relative;
                            margin: 50px auto;
                            width: 19%;
                            z-index: 9999999;
                            background: #372940;
                            top: 7%;
                        }

                        .loader {
                            position: absolute;
                            opacity: .7;
                        }

                        .loader circle {
                            animation: draw 4s infinite ease-in-out;
                            transform-origin: center;
                            transform: rotate(-90deg);
                        }

                        .loader-2 circle,
                        .loader-6 circle {
                            animation-delay: 1s;
                        }

                        .loader-7 circle {
                            animation-delay: 2s;
                        }

                        .loader-4 circle, 
                        .loader-8 circle {
                            animation-delay: 3s;
                        }

                        .loader-3 {
                            left: -150px;
                            transform: rotateY(180deg);
                        }

                        .loader-6,
                        .loader-7,
                        .loader-8 {
                            left: -150px;
                            transform: rotateX(180deg) rotateY(180deg);
                        }

                        .loader-5 circle {
                            opacity: .2;
                        }

                        @keyframes draw {
                            50% {
                                stroke-dashoffset: 0;
                                transform: scale(.5);
                            }
                        }

                    </style>
                        <div id="loader">
                            <svg class="loader">
                            <filter id="blur">
                                <feGaussianBlur in="SourceGraphic" stdDeviation="2"></feGaussianBlur>
                            </filter>
                            <circle cx="75" cy="75" r="60" fill="transparent" stroke="#F4F519" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
                            </svg>
                            <svg class="loader loader-2">
                            <circle cx="75" cy="75" r="60" fill="transparent" stroke="#DE2FFF" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
                            </svg>
                            <svg class="loader loader-3">
                            <circle cx="75" cy="75" r="60" fill="transparent" stroke="#FF5932" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
                            </svg>
                            <svg class="loader loader-4">
                            <circle cx="75" cy="75" r="60" fill="transparent" stroke="#E97E42" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
                            </svg>
                            <svg class="loader loader-5">
                            <circle cx="75" cy="75" r="60" fill="transparent" stroke="white" stroke-width="6" stroke-linecap="round" filter="url(#blur)"></circle>
                            </svg>
                            <svg class="loader loader-6">
                            <circle cx="75" cy="75" r="60" fill="transparent" stroke="#00DCA3" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
                            </svg>
                            <svg class="loader loader-7">
                            <circle cx="75" cy="75" r="60" fill="transparent" stroke="purple" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
                            </svg>
                            <svg class="loader loader-8">
                            <circle cx="75" cy="75" r="60" fill="transparent" stroke="#AAEA33" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
                            </svg>
                        </div> 
                    </div>
                </div>                 
            </div>
        </div>
    </div>
</div>
    <?php

    function new_footer() {
        ?>
        <script>
            $(document).ready(function () {
                jQuery('#popup-free-user-post').modal('show');                  
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
                        alert('<?php _e("Please select at least one theme", 'flatter'); ?>');
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