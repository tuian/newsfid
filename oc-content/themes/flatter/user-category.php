<?php
error_reporting(0);
// meta tag robots
osc_add_hook('header', 'flatter_nofollow_construct');

flatter_add_body_class('register');
osc_enqueue_script('jquery-validate');
osc_current_web_theme_path('header.php');
?>


<form action="" method="post">
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
                            <?php _e("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus imperdiet, justo et auctor posuere, diam enim ultrices libero, ut blandit erat ipsum in orci. Nulla elementum leo ac justo luctus, non vehicula sapien faucibus.", 'flatter') ?>                            
                            <br/>
                            <br/>
                            <?php _e("In viverra arcu vitae laoreet iaculis. Proin justo erat, dictum id molestie sed, commodo non erat.", 'flatter') ?>
                            
                        </span>
                    </div>

                    <div class="separate-30"></div>

                    <div class="col-md-12 padding-10 background-white">
                        <div class="pull-right">
                            <input class="btn btn-blue btn-flat add_category" type="submit" name="submit" />
                        </div>
                    </div>

                </div>
                <div class="col-md-8 col-sm-8">
                    <div class="row">
                        <?php while (osc_has_categories()) : ?>
                            <div class="col-md-3 col-sm-3 margin-bottom-20">
                                <div class="category_box" data-id="<?php echo osc_category_id() ?>">
                                    <div class="category_image">
                                        <?php if (get_category_icon(osc_category_id())) : ?>
                                            <img src="<?php echo get_category_icon(osc_category_id()); ?>" class="img img-responsive cat-image"/>    
                                        <?php endif; ?>
                                        <div class="add_box">
                                            <span class="add_icon"></span>
                                        </div>
                                        <div class="overlay"></div>
                                        <input type="checkbox" name="cat_id[]" value="<?php echo osc_category_id() ?>" class="cat_checkbox" style="display: none">
                                    </div>
                                    <div class="category_title">
                                        <?php echo osc_category_name(); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<style>
    .cat-image{
        height: 100px;
        display: inline-block;
    }
    .category_title {
        padding: 10px;
        color: #000;
        font-weight: bold;
        background-color: #fff;
        text-align: center;
        text-transform: uppercase;
    }
    .category_box {
        border: 1px solid #e3e3e5;
        background-color: #eee;
        cursor: pointer;
    }
    .add_box{
        position: absolute;
        top: 25%;
        left: 35%;
        background-color: rgba(0,0,0,0.5);
        height: 50px;
        width: 50px;
        border-radius: 50%;
        z-index: 2;
    }
    .add_box::after {
        position: absolute;
        left: 25%;
        font-family: FontAwesome;
        content: '\f067';
        font-size: 30px;
        color: #fff;
        z-index: 2;
        top: 7%;
    }
    .category_box.selected  .add_box::after {
        content: "\f00c";
    }
    /*    .add_icon {
            position: absolute;
            top: -25%;
            color: #fff;
            font-weight: bold;
            font-size: 50px;
            left: 25%;
        }*/
    .category_image{
        position: relative;
        text-align: center;
    }
    .category_box{
        transition: all 0.5s 0.5s ease-in-out;        
    }
    .overlay{
        height: 100%;
        width: 100%;
        background-color: rgba(28, 125, 193, 0.8);
        z-index: 1;
        top: 0;
        left: 0;
        position: absolute;
        display: none;
    }
    .category_box.selected .overlay{
        display: block;
    }
</style>
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
            $('.add_category').click(function () {
                var category_array = [];
                var checked_cat = $('.category_box.selected');
                checked_cat.each(function (i, k) {
                    category_array[i] = $(this).attr('data-id');
                });
            });
        });
    </script>
    <?php
}

//osc_add_hook('footer', 'ex_load_scripts');
osc_add_hook('footer', 'new_footer');
?>

<?php osc_current_web_theme_path('footer.php');