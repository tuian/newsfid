<?php
// meta tag robots
require_once '../../../oc-load.php';
require_once 'functions.php';
if (!osc_logged_user_id()):
    osc_add_flash_error_message('Please login to continue.');
    osc_redirect_to(osc_base_url());
endif;

function sidebar() {
    osc_current_web_theme_path('user-public-sidebar.php');
}
?>
<?php osc_current_web_theme_path('header.php'); ?>

<?php
$user = get_user_data(osc_logged_user_id());
$pack = get_item_premium_pack();
?>
<!-- profil cover -->
<?php
if ($user['cover_picture_user_id']):
    $cover_image_path = osc_base_url() . 'oc-content/plugins/profile_picture/images/profile' . $user['cover_picture_user_id'] . '.' . $user['cover_pic_ext'];
else:
    $cover_image_path = osc_current_web_theme_url() . "/images/cover-image.png";
endif;
?>
<!-- end profil cover -->

<div id="sections">
    <div class="user_area">

        <div class="row wrap">
            <div class="">
                <div class="col-md-4 premium-fix"  id="wrap">
                    <div class=" bg-white col-md-12 padding-0 premium">
                        <?php
                        if ($user['cover_picture_user_id']):
                            $cover_image_path = osc_base_url() . 'oc-content/plugins/profile_picture/images/profile' . $user['cover_picture_user_id'] . '.' . $user['cover_pic_ext'];
                        else:
                            $cover_image_path = osc_current_web_theme_url() . "/images/cover-image.png";
                        endif;
                        ?>
                        <div class="box box-widget widget-user">
                            <div class="widget-user-header bg-black" style="background: url('<?php echo $cover_image_path ?>') center center; max-height: 500px;">
                                <h3 class="widget-user-username">
                                    <?php echo $user['user_name'] ?>
                                </h3>
                                <h5 class="widget-user-desc">
                                    <?php echo $user['role_name'] ?>
                                </h5>      
                                <?php if (osc_user_id() == osc_logged_user_id()): ?>



                                    <!--                                    <form class="cover_image_upload" method="post" enctype="multipart/form-data">
                                                                            <span class="icon">
                                                                                <i class="fa fa-camera"></i>
                                                                            </span>
                                                                            <input type="file" name="file" class="file user_cover_img">
                                                                        </form>-->

                                <?php endif; ?>
                            </div>
                            <div class="widget-user-image">
                                <?php
                                if (!empty($user['s_path'])):
                                    $img_path = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
                                else:
                                    $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                                endif;
                                ?>
                                <?php get_user_profile_picture($user['user_id']) ?>
                            </div>

                            <div class="box-footer">
                                <div class="col-md-12 padding-0">
                                    <div class="col-sm-6 border-right padding-left-0">
                                        <div class="description-block">
                                            <h5 class="description-header">
                                                <?php
                                                $inprogress = get_item_inprogress($user['user_id']);
                                                if ($inprogress):
                                                    echo count($inprogress);
                                                else:
                                                    echo 0;
                                                endif;
                                                ?>
                                            </h5>
                                            <span class="description-text">
                                                Running 
                                            </span>
                                        </div>
                                    </div>
                                    <!--                                    <div class="col-sm-4 col-md-5 border-right">
                                                                            <div class="description-block">
                                                                                <h5 class="description-header">
                                    <?php
                                    if ($user_followers):
                                        echo count($user_followers);
                                    else:
                                        echo 0;
                                    endif;
                                    ?>
                                                                                </h5>
                                                                                <span class="description-text">
                                                                                    Followers
                                                                                </span>
                                                                            </div>
                                                                        </div>-->
                                    <div class="col-sm-6 col-md-6">
                                        <div class="description-block">
                                            <h5 class="description-header">
                                                <?php
                                                $completed = get_item_completed($user['user_id']);
                                                if ($completed):
                                                    echo count($completed);
                                                else:
                                                    echo 0;
                                                endif;
                                                ?>
                                            </h5>
                                            <span class="description-text"><?php _e("Finish", 'flatter') ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="box box-default">
                            <div class="box-header">
                                <div class="box-tools plus pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <?php
                            $user_pack = get_user_pack_details(osc_logged_user_id());
                            if (!empty($user_pack)):
                                $pack_name = get_user_pack_name($user_pack['pack_id']);
                                $premium_user = get_item_premium();
                                $remain_pack = ($user_pack['remaining_post'] * 100) / $user_pack['premium_post'];
                            endif;
                            ?>
                            <div class="box-body" style="display: block;">
                                <div class="progressDiv">
                                    <div class="statChartHolder">
                                        <div class="progress-pie-chart" data-percent="<?php
                                        if (!empty($user_pack)): echo $remain_pack;
                                        else: echo'0';
                                        endif;
                                        ?>"><!--Pie Chart -->
                                            <div class="ppc-progress">
                                                <div class="ppc-progress-fill"></div>
                                            </div>
                                            <div class="balance bold">
                                                <div>Balance</div>
                                                <h1 class="margin-0 text-center"><?php
                                                    if (!empty($user_pack)): echo $user_pack['remaining_post'];
                                                    else: echo'0';
                                                    endif;
                                                    ?></h1>
                                            </div>
                                            <div class="ppc-percents">
                                                <div class="pcc-percents-wrapper">
                                                    <span style="display: none"></span>
                                                </div>
                                            </div>
                                        </div><!--End Chart -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 border-bottom-gray"></div>
                            <div class="copyright_box_post">
                                <span class="bold"><?php _e("Pack", 'flatter') ?>  : </span> <?php echo $pack_name['s_name']; ?>
                            </div>
                            <div class="col-md-12 border-bottom-gray"></div>
                            <div class="box-default copyright_box_post">                                
                                <?php _e("Copyright Newsfid", 'flatter') ?> - <span class="bold"> Gaël Eustache & Gwinel Madisse </span> (E&M) &copy; <?php echo date('Y') ?>
                            </div>
                        </div>
                        <!-- /.box -->                 
                    </div>
                </div>
            </div>
            <div class="premium_post">
                <div class="col-md-8 padding-left-0">
                    <ul class="nav nav-tabs user_profile_navigation bg-white premium_nav_fix">
                        <li class="active user_posts"><a data-toggle="tab" data-target="#en_cours" href="javascript:void(0)"><?php _e("Running campaign", 'flatter') ?></a></li>
                        <li class="user_info"><a data-toggle="tab" data-target="#top_up_now" href="javascript:void(0)"><?php _e("Top up now", 'flatter') ?></a></li>
                    </ul>  
                    <?php // endif;       ?>
                    <div class="col-md-12 padding-0 search-box success-border">
                    </div>
                    <div class="user_content col-md-12 padding-0 tab-content scroll-content premium_post_fix background-white">
                        <div class="tab-pane fade in active" id="en_cours">
                            <?php
                            $inprog = get_item_inprogress(osc_logged_user_id());
                            if (empty($inprog)):
                                ?>
                                <div class="padding-top-13per padding-bottom-13per user_posts_area user_details">
                                    <div class="padding-7per vertical-row">
                                        <div class="">
                                            <img src="<?php echo osc_current_web_theme_url() ?>images/poster.png" width="150px">
                                        </div>
                                        <div class="padding-left-7per">
                                            <div class="light_gray bold"><?php _e("No running campaign", 'flatter') ?> </div>
                                            <div class="col-md-7 padding-0"><?php _e("No campaign is running for now. Top up your credit or start one at anytime.", 'flatter') ?> </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <input type="hidden" value="0" name="abc" class="user_post_page_number"> 
                                <div class="user_posts_container"></div>
                                <div class="result_text_message"></div> 
                                <div class="loading text-center">
                                    <div class="cs-loader">
                                        <div class="cs-loader-inner">
                                            <label>	●</label>
                                            <label>	●</label>
                                            <label>	●</label>
                                            <label>	●</label>
                                            <label>	●</label>
                                            <label>	●</label>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="user_info_container user_details tab-pane fade bg-white" id="top_up_now">
                            <div class="col-md-12 padding-3per">
                                <div class="col-md-1 padding-0">
                                    <img src="<?php echo osc_current_web_theme_url() ?>images/Shopping.ico" width="45px">
                                </div>
                                <div class="col-md-11">
                                    <div class="bold"><?php _e("Select the pack you wish to up with", 'flatter') ?></div>
                                    <div class="font-12 light_gray padding-top-5"><?php _e("Once you balance will be aible to top up with a new pack but not before", 'flatter') ?></div>
                                </div>
                            </div>
                            <div class="border-bottom-gray col-md-12"></div>
                            <div class="col-md-12 padding-7per">
                                <div class="col-md-1 padding-0">
                                    <img src="<?php echo osc_current_web_theme_url() ?>images/information.png" width="20px">
                                </div>
                                <div class="col-md-11 padding-0">
                                    <!--<div class="bold light_gray">Votre publication sponsorisee apparaita en tete de publication.</div>-->
                                    <div class="bold light_gray"><?php _e("Your publication will appear at the top of publication's window.", 'flatter') ?></div>
                                    <!--<div class="light_gray">C'est a dire que lorsqu'un utilisateur consulte un post il voit votre post dans l'entete de la publication qu'il consulte.</div>-->
                                    <div class="light_gray"><?php _e("it means that when a user is consulting a post he sees your publication in the header of the publication.", 'flatter') ?></div>
                                </div>
                            </div>
                            <div class="border-bottom-gray-2px col-md-12"></div>
                            <?php foreach ($pack as $p): ?>
                                <div class="col-md-12 padding-7per">
                                    <div class="col-md-12 orange bold-600 font-12 padding-bottom-10"><?php echo $p['s_name']; ?></div>
                                    <div class="col-md-12 padding-0 padding-bottom-6per">
                                        <div class="col-md-6">                                        
                                            <div class="blue_text bold font-12"> <?php _e("Pack", 'flatter') ?>  <?php echo $p['i_amount'] / 1000000; ?> <?php _e("promoted posts", 'flatter') ?></div>
                                            <div>  <?php _e("Price", 'flatter') ?> :<span class="font-12 orange"> <?php echo $p['i_amount_cost'] / 1000000; ?> <?php _e("USD", 'flatter') ?></span> </div>                                      
                                        </div>
                                        <div class="col-md-6 padding-0">
                                            <button data-toggle="modal" data-target="#myModal" class="btn button-orng-box buy_pack pull-right" item-id='<?php echo $_REQUEST['item_id']; ?>' name='<?php echo $p['s_name']; ?>' pack-id='<?php echo $p['pk_i_id']; ?>' post='<?php echo $p['i_amount'] / 1000000; ?>' amount='<?php echo $p['i_amount_cost'] / 1000000; ?>'><?php _e("Buy this pack", 'flatter') ?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-bottom-gray col-md-12"></div>

                            <?php endforeach; ?>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="popup"></div>
<div id="premium-post"></div>
<?php osc_current_web_theme_path('footer.php'); ?>
<script>
    $(document).ready(function () {
        fetch_user_posts();
    });
    $(document).on('click', '.buy_pack', function () {
        var posts = $(this).attr('post');
        var name = $(this).attr('name');
        var amount = $(this).attr('amount');
        var item_id = $(this).attr('item-id');
        var pack_id = $(this).attr('pack-id');
        $.ajax({
            url: '<?php echo osc_current_web_theme_url() . 'promoted_post_ajax.php'; ?>',
            type: 'POST',
            data: {
                action: 'promoted_post',
                posts: posts,
                name: name,
                amount: amount,
                item_id: item_id,
                pack_id: pack_id
            },
            success: function (data) {
                $('#premium-post').html(data);
                $('#premium').modal('show');
            }
        });
    });
    $(function () {
        var $ppc = $('.progress-pie-chart'),
                percent = parseInt($ppc.data('percent')),
                deg = 360 * percent / 100;
        if (percent > 50) {
            $ppc.addClass('gt-50');
        }
        $('.ppc-progress-fill').css('transform', 'rotate(' + deg + 'deg)');
        $('.ppc-percents span').html(percent);
    });
    function fetch_user_posts() {
        var post = $('.user_post_page_number').val();
        var page_number = $('.user_posts_area .user_post_page_number').val();
        var user_id = '<?php echo osc_user_id() ?>';
        $.ajax({
            url: "<?php echo osc_current_web_theme_url() . 'user_premium_post.php' ?>",
            data: {
                user_id: user_id,
                page_number: page_number,
            },
            success: function (data) {
                $('.user_posts_area .loading').fadeOut(1000);
                $('.user_posts_container').css({'opacity': '1'});
                if (data.indexOf("Nothing to show") >= 0) {
                    if (page_number === 1) {
                        $('.result_text_message').html('<h2 class="result_text">'.<?php _e("Ends of results.", 'flatter') ?>'</h2>');
                    } else if ($('.usepost_no_record').size() < 1) {
                        $('.result_text_message').html(data);
                    }
                    is_enable_ajax = false;
                }
                else {
                    loading = false;
                    $(".no-user-post").hide();
                    $(".user_posts_container").append(data);
                    var next_page = parseInt($('.user_posts_area .user_post_page_number').val()) + 1;
                    $('.user_posts_area .user_post_page_number').val(next_page);
                }
            }
        });
    }
</script>
