<?php
require_once '../../../oc-load.php';
require_once 'functions.php';
?>
<!------Pop-up user start---->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <div class="popup">
                <span class="follow-user" ><i class="fa fa-user-plus" aria-hidden="true"></i></span>
                <div class="user-block">	
                    <img class="img-circle" src="<?php echo osc_current_web_theme_url() . '/images/user1-128x128.jpg' ?>" alt="User Image">
                    <span class="username" data-toggle="modal" data-target="#myModal"><?php echo $user[0]['user_name'] ?></span>	
                </div>
            </div>
            <div class="box-body">
                <img class="modal-image" src="<?php echo osc_current_web_theme_url() . '/images/photo2.png' ?>" alt="Photo">

                <p>I took this photo this morning. What do you guys think?</p>
                <div class="popup-social">
                    <?php echo '127' ?> &nbsp;
                    <a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;
                    <?php echo 'Like' ?>
                    &nbsp;&nbsp;
                    <?php echo '' ?> &nbsp;
                    <a href="#"><i class="fa fa-retweet"></i></a>&nbsp;
                    <?php echo 'Share' ?>

                    &nbsp;&nbsp;
                    <?php echo '' ?> &nbsp;
                    <a href="#"><i class="fa fa-comments"></i></a>&nbsp;
                    <?php echo 'Comment' ?>

                    &nbsp;&nbsp;
                    <a href="#"><?php echo 'Tchat' ?></a>&nbsp;

                    &nbsp;&nbsp;
                    <a href="#"><?php echo 'Watchlist' ?></a>&nbsp;
                </div>
                <div class="clear"></div>
                <div class="box-comment">
                    <!-- User image -->
                    <img class="img-circle img-sm" src="<?php echo osc_current_web_theme_url() . '/images/user4-128x128.jpg' ?>" alt="User Image">

                    <div class="comment-text">
                        <span class="username">
                            Luna Stark
                            <span class="text-muted pull-right popup-muted">8:03 PM Today</span>
                        </span><!-- /.username -->
                        It is a long established fact that a reader will be distracted
                        by the readable content of a page when looking at its layout.
                    </div>
                    <!-- /.comment-text -->
                </div>
                <div class="box-comment">
                    <!-- User image -->
                    <img class="img-circle img-sm" src="<?php echo osc_current_web_theme_url() . '/images/user4-128x128.jpg' ?>" alt="User Image">

                    <div class="comment-text">
                        <span class="username">
                            Luna Stark
                            <span class="text-muted pull-right popup-muted">8:03 PM Today</span>
                        </span><!-- /.username -->
                        It is a long established fact that a reader will be distracted
                        by the readable content of a page when looking at its layout.
                    </div>
                    <!-- /.comment-text -->
                </div>
                <div class="box-comment">
                    <!-- User image -->
                    <img class="img-circle img-sm" src="<?php echo osc_current_web_theme_url() . '/images/user4-128x128.jpg' ?>" alt="User Image">

                    <div class="comment-text">
                        <span class="username">
                            Luna Stark
                            <span class="text-muted pull-right popup-muted">8:03 PM Today</span>
                        </span><!-- /.username -->
                        It is a long established fact that a reader will be distracted
                        by the readable content of a page when looking at its layout.
                    </div>
                    <!-- /.comment-text -->
                </div>
            </div>
            <!-- /.box-footer -->
            <div class="box-footer">
                <form action="#" method="post">
                    <img class="img-responsive img-circle img-sm" src="<?php echo osc_current_web_theme_url() . '/images/user4-128x128.jpg' ?>" alt="Alt Text">
                    <!-- .img-push is used to add margin to elements next to floating images -->
                    <div class="img-push">
                        <input type="text" class="form-control input-sm" placeholder="Press enter to post comment">
                    </div>
                </form>
            </div>
            <!-- /.box-footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<!------Pop-up user end---->