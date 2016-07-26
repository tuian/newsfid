<?php
require '../../../oc-load.php';
require 'functions.php';
?>
<?php osc_current_web_theme_path('header.php'); ?>
<div id="setting" class="row margin-0"> 
    <div class="col-md-12">
        <div class="user-search">
            <ul class="vertical-row">
                <li class="people-search col-md-11">
                    <input class="search_name" type="text" placeholder="Search for someone or a band">
                </li>
                <li class="search-button">
                    <button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                </li>
            </ul>
        </div>
        <div class="col-md-offset-1 col-md-9 main-contant margin-top-20 border-box bg-white  padding-0">
            <div class="col-md-12 padding-0">      
                <ul class="nav nav-tabs settings-li">
                    <span class="set bold font-30px font-color-black">Settings</span>
                    <li><a href="#">Securite</a></li>
                    <li class="active"><a href="#">Social</a></li>
                    <li><a href="#">General</a></li>
                </ul>
            </div>
            <div class="col-md-12 menu-tabs padding-0 ">      
                <ul class="nav nav-tabs padding-top-4per padding-bottom-20">
                    <li class="col-md-offset-1"><a href="#">Compte</a></li>
                    <li><a href="#">Contenu</a></li>
                    <li><a href="#">Moyen de Paiment</a></li>
                    <li><a href="#">Compte bloques</a></li>
                    <li><a href="#">Verouillage</a></li>
                    <li><a href="#">Audio</a></li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class='col-md-3'>
                    <h1 class="bold blue_text">Compte</h1>
                </div>
                <div class="col-md-offset-7 col-md-2 col-sm-2 blue_text text-right padding-20">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit
                </div>
            </div>
        </div>
    </div>
</div>


<?php osc_current_web_theme_path('footer.php'); ?>