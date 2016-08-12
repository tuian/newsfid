<?php
require '../../../oc-load.php';
require 'functions.php';
?>
<?php osc_current_web_theme_path('header.php'); ?>

<div class="col-md-12 bg-tchat">
    <div class="border-box ">
        <div class="row margin-0 padding-top-3per ">
            <div class="col-md-4 padding-0">
                <div class="col-md-12 border-top-gray background-white border-box-right border-bottom-gray tchat_tab">
                    <ul class="nav margin-top-20 nav-font">
                        <li id="message" class="col-md-7 pointer active_tab">
                            <div class="msg msg_tab">Nouveaux messages</div>
                        </li>
                        <li id="archive" class="col-md-5 pointer">
                            <div class="msg msg_tab  text-center">Archives</div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-12 background-white border-box-right padding-top-4per padding-bottom-13per vertical-row search-box_tchat">
                    <input type="text" name="q" class="form-control search-tchat-text" placeholder="Search...">
                    <i class="fa fa-search search_icon pointer padding-10"></i>                 
                </div>
                <div class="col-md-12 background-white border-box-right t_chat_overflow">
                    <ul class="padding-0">
                        <li class="col-md-12 vertical-row padding-0 border-bottom-gray">
                            <img src="images/57a33438c216c.png" class="img img-responsive" style="width:25%; padding: 5px">
                            <div>
                                <label class="margin-0 bold font-color-black">abc</label>
                                <div class="icon-size"><i class="fa fa-reply" aria-hidden="true"></i> knfjds</div>
                            </div>
                        </li>
                        <li class="col-md-12 vertical-row padding-0 border-bottom-gray">
                            <img src="images/57a87e9cbf530.jpg" class="img img-responsive" style="width:25%; padding: 5px">
                            <div>
                                <label class="margin-0 bold font-color-black">abc</label>
                                <div class="icon-size"> <i class="fa fa-check" aria-hidden="true"></i> dgknvdfo odijfg </div>
                            </div>
                        </li>
                        <li class="col-md-12 vertical-row padding-0 border-bottom-gray">
                            <img src="images/57a32e12ca74a.png" class="img img-responsive" style="width:25%; padding: 5px">
                            <div>
                                <label class="margin-0 bold font-color-black">abc</label>
                                <div class="icon-size"><i class="fa fa-reply" aria-hidden="true"></i> knfjds</div>
                            </div>
                        </li>
                        <li class="col-md-12 vertical-row padding-0 border-bottom-gray">
                            <img src="images/57a32e12ca74a.png" class="img img-responsive" style="width:25%; padding: 5px">
                            <div>
                                <label class="margin-0 bold font-color-black">abc</label>
                                <div class="icon-size"> <i class="fa fa-check" aria-hidden="true"></i> dgknvdfo odijfg </div>
                            </div>
                        </li>
                        <li class="col-md-12 vertical-row padding-0 border-bottom-gray">
                            <img src="images/57a32e12ca74a.png" class="img img-responsive" style="width:25%; padding: 5px">
                            <div>
                                d
                            </div>
                        </li>
                        <li class="col-md-12 vertical-row padding-0 border-bottom-gray">
                            <img src="images/57a32e12ca74a.png" class="img img-responsive" style="width:25%; padding: 5px">
                            <div>
                                d
                            </div>
                        </li>
                        <li class="col-md-12 vertical-row padding-0 border-bottom-gray">
                            <img src="images/57a32e12ca74a.png" class="img img-responsive" style="width:25%; padding: 5px">
                            <div>
                                d
                            </div>
                        </li>
                        <li class="col-md-12 vertical-row padding-0 border-bottom-gray">
                            <img src="images/57a3365f589e0.png" class="img img-responsive" style="width:25%; padding: 5px">
                            <div>
                                d
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 border-top-gray border-bottom-gray background-white">
                <div class="col-md-12 padding-top-3per">
                    <div class="border-bottom-gray padding-top-4per"></div>
                    <div class="border-bottom-gray padding-0 col-md-12">
                        <div class="col-md-12 padding-0 vertical-row">
                            <div class="col-md-1 padding-0 padding-top-4per">
                                <img src="images/57a33438c216c.png" class="img img-responsive" style="">
                            </div>
                            <div class="col-md-11 padding-top-4per">
                                <label class="bold font-color-black margin-0">abc</label>
                                <div class="icon-size"><i class="fa fa-reply" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="col-md-10 col-md-offset-2 padding-0">
                            A man has been charged with four counts of attempted murder after four women were stabbed in a Read More
                        </div>
                        <div class="col-md-12 padding-0 padding-top-13per">
                            <textarea class="t_chat_textarea" placeholder="Write a Replay...."></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 padding-0 padding-bottom-13per padding-top-4per">
                        <button class="btn btn-default">Send</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $('.nav').on('click', 'li', function () {
        $('.nav li.active_tab').removeClass('active_tab');
        $(this).addClass('active_tab');
    });
</script>
<?php osc_current_web_theme_path('footer.php'); ?>