<?php
require '../../../oc-load.php';
require 'functions.php';
?>
<?php
osc_current_web_theme_path('header.php');
$user_info = get_user_data(osc_logged_user_id());
$roles = get_user_roles_array();
?>
<div id="setting" class="row margin-0"> 
    <div class="col-md-12 padding-bottom-6per">
        <!--        <div class="user-search">
                    <ul class="vertical-row">
                        <li class="people-search col-md-11">
                            <input class="search_name" type="text" placeholder="Search for someone or a band">
                        </li>
                        <li class="search-button">
                            <button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </li>
                    </ul>
                </div>-->
        <div class="col-md-offset-1 col-md-9 main-contant margin-top-20 border-box bg-white padding-0">
            <div class="col-md-12 padding-0">      
                <ul class="nav nav-tabs settings-li">
                    <span class="set bold font-30px font-color-black">Settings</span>
                    <li ><a data-toggle="tab" href="#securite">Sécurité</a></li>
                    <li ><a data-toggle="tab" href="#social">Social</a></li>
                    <li class="active" ><a data-toggle="tab" href="#general">Général</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div id="general" class="tab-pane fade in active">
                    <div class="col-md-12 vertical-row padding-bottom-20 border-left-orange border-bottom-gray padding-bottom-10">
                        <div class='col-md-3'>
                            <h2 class="bold blue_text">Général</h2>
                        </div>

                    </div>
                    <div class="col-md-12 padding-0">
                        <div class="row user_info_row success-border margin-0">
                            <div class="col-md-4 col-sm-4">
                                <span class="user_info_header">A propos de moi</span>
                            </div>
                            <div class="col-md-8 col-sm-8 user_info">
                                <span class="user_info_text info_text" data_text="<?php echo $user_data['s_name']; ?>">
                                    <?php echo $user_data['s_name']; ?>
                                </span>

                                <span class="edit_user_detail edit-color-blue pointer user_info_edit">
                                    <i class="fa fa-pencil-square-o"></i> Edit
                                </span>

                            </div>
                        </div>

                        <div class="row user_info_row  margin-0">
                            <div class="col-md-4 col-sm-4">
                                <span class="user_info_header">Type de compte</span>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <span class="user_type_text info_text" data_role_id="<?php echo $user_info['role_id'] ?>">
                                    <span class="user_role_selector_container">
                                        <span class="user_role_name">
                                            <?php echo $user_info['role_name']; ?>
                                        </span>
                                        <select name="user_role_selector" id="user_role_selector" class="user_role_selector">
                                            <?php foreach ($roles as $k => $role): ?>
                                                <option <?php if ($role['id'] == $user_info['role_id']) echo 'selected'; ?> value="<?php echo $role['id'] ?>"><?php echo $role['role_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </span>
                                </span>

                                <span class="edit_user_detail edit-color-blue pointer user_type_edit">
                                    <i class="fa fa-pencil-square-o"></i> Edit
                                </span>

                            </div>
                        </div>

                        <div class="row user_info_row  margin-0">
                            <div class="col-md-4 col-sm-4">
                                <span class="user_info_header">Website</span>
                            </div>
                            <div class="col-md-8 col-sm-8 user_website">
                                <span class="user_website_text info_text" data_text="<?php echo osc_user_website(); ?>">
                                    <?php echo osc_user_website(); ?>
                                </span>        

                                <span class="edit_user_detail edit-color-blue pointer user_website_edit">
                                    <i class="fa fa-pencil-square-o"></i> Edit
                                </span>

                            </div>
                        </div>

                        <div class="row user_info_row  margin-0">
                            <div class="col-md-4 col-sm-4">
                                <span class="user_info_header">Localisation</span>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <span class="user_address_text"><?php echo $address; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="social" class="tab-pane fade in ">
                    <div class="row margin-0">
                        <div class="col-md-12 vertical-row padding-bottom-20 border-left-orange border-bottom-gray">
                            <div class='col-md-3'>
                                <h2 class="bold blue_text">Social</h2>
                            </div>
                            <div id="edit-social" class="col-md-offset-7 col-md-2 col-sm-2 edit-color-blue pointer text-right padding-20 margin-top-20">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 padding-top-4per vertical-row">
                            <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                                Facebook
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                                <input type="text" id="facebook" name="facebook" class="facebook disabled" value="<?php echo $user_info['facebook']; ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 padding-top-4per vertical-row">
                            <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                                Twitter
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                                <input type="text" id="twitter" name="twitter" class="twitter disabled" value="<?php echo $user_info['twitter']; ?>" disabled>
                            </div>
                        </div>

                        <div class="col-md-offset-4 col-md-4">
                            <div class="red_text alert_text"></div>
                        </div>
                        <div class="col-md-offset-5 col-md-7 padding-top-4per">
                            <div class="col-md-4 none" id="save-social">
                                <button type="submit" id="change-social" class="btn btn-lg button-blue-box">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="securite" class="tab-pane fade in">
                    <div class="col-md-12 menu-tabs padding-0 ">      
                        <ul class="nav nav-tabs padding-top-4per padding-bottom-20">
                            <li class="col-md-offset-1"><a href="#compte">Compte</a></li>
                            <li><a href="#contenu">Contenu</a></li>
                            <li><a href="#moyen_de_paiement">Moyen de Paiment</a></li>
                            <li><a href="#compte_bloques">Compte bloqués</a></li>
                            <li><a href="#verouillage">Verrouillage</a></li>
                            <li><a href="#audio">Audio</a></li>
                        </ul>
                    </div>
                    <div id="compte">
                        <div class="col-md-12 vertical-row padding-bottom-20 border-left-orange">
                            <div class='col-md-3'>
                                <h1 class="bold blue_text">Compte</h1>
                            </div>
                            <div id="edit" class="col-md-offset-7 col-md-2 col-sm-2 edit-color-blue pointer text-right padding-20 margin-top-20">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit
                            </div>
                        </div>
                        <div class="border-bottom-gray col-md-12"></div>
                        <div class="row margin-0">
                            <div class="col-md-12 col-sm-12 padding-top-4per vertical-row">
                                <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                                    Nom d'utilisateur
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row user">

                                    <input type="text" name="up_name" id="" class="user_name_textbox disabled" value="<?php echo $user_info['user_name']; ?>" disabled>

                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-1">
                                    <i class="fa fa-globe"></i>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 padding-top-4per vertical-row">
                                <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                                    Adresse email
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                                    <input type="text" name="up_email" class="user_email_textbox disabled" value="<?php echo $user_info['s_email']; ?>" disabled>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-1">
                                    <i class="fa fa-lock"></i>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 padding-top-4per vertical-row">
                                <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                                    Numero de telephone
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-6 grey-border-box vertical-row">
                                    <div class="input-group code-box">
                                        <span class="input-group-addon" id="basic-addon1">+33</span>
                                        <input type="text" name="up_mobile" class="user_mobile_textbox form-control disabled" value="<?php echo $user_info['phone_number'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-1">
                                    <i class="fa fa-lock"></i>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 padding-top-4per vertical-row">
                                <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                                    Reseaux Defaut
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                                    <select id="country_Id" class="user_country_textbox disabled" name="up_country" disabled>
                                        <?php
                                        $counrtry_db = osc_get_countries();
                                        foreach ($counrtry_db as $key => $country) :
                                            ?>
                                            <option <?php if ($country['pk_c_code'] == $user_info['fk_c_country_code']) echo 'selected'; ?> value="<?php echo $country['pk_c_code'] ?>"><?php echo $country['s_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 padding-top-4per vertical-row">
                                <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                                    Ville
                                </div>
                                <?php
                                $city_data = City::newInstance()->findByPrimaryKey($user_info['fk_i_city_id']);
                                ?>
                                <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                                    <input type="text" name="s_city" class="user_city_textbox form-control disabled" name="up_city" id="s_city" placeholder="" value="<?php echo $city_data['s_name'] ?>" disabled>
                                    <input type="hidden" name="cityId" class="form-control" id="cityId">
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-1">
                                    <i class="fa fa-globe"></i>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom-gray padding-top-4per"></div>
                        <div class="row margin-0">
                            <div class="col-md-12 col-sm-12 padding-top-4per vertical-row">
                                <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                                    User type
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                                    <select name="user_role_selector" id="user_role_selector" class="user_type_textbox disabled" disabled>
                                        <?php foreach ($roles as $k => $role): ?>
                                            <option <?php if ($role['id'] == $user_info['role_id']) echo 'selected'; ?> value="<?php echo $role['id'] ?>"><?php echo $role['role_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-1">
                                    <i class="fa fa-globe"></i>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom-gray padding-top-4per"></div>
                        <div class="row margin-0">
                            <div class="col-md-12 col-sm-12 padding-top-4per vertical-row">
                                <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                                    Current Password<span class="red star-alert">*</span>
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                                    <input type="password" id="pass" name="pass" class="pass disabled" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 padding-top-4per vertical-row">
                                <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                                    New Password<span class="red star-alert">*</span>
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                                    <input type="password" id="npass" name="npass" class="npass disabled" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 padding-top-4per vertical-row">
                                <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                                    Confirm Password<span class="red star-alert">*</span>
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                                    <input type="password" id="cpass" name="cpass" class="cpass disabled" disabled>
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-4">
                                <div class="red_text alert_text"></div>
                            </div>
                            <div class="col-md-offset-5 col-md-7 padding-top-4per">
                                <div class="col-md-4 none" id="save">
                                    <button type="submit" id="change-pass" class="btn btn-lg button-blue-box">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="breack-line"></div>
                    <div id="contenu" class="col-md-offset-1 col-md-9 main-contant border-radius-10 border-box bg-white  padding-0">
                        <div class="col-md-12 vertical-row padding-bottom-10">
                            <div class='col-md-3'>
                                <h1 class="bold blue_text">Contenu</h1>
                            </div>
                        </div>
                        <div class="border-bottom-gray  col-md-12"></div>
                        <div class="col-md-offset-1 col-md-12 padding-top-4per vertical-row">
                            <div class="col-md-2 font-color-black">
                                Medias
                            </div>
                            <div class="col-md-7 font-color-black">
                                Tout le monde peut voir ce que je publie
                            </div>
                        </div>
                        <div class="col-md-offset-1 col-md-12 padding-top-4per vertical-row">
                            <div class="col-md-2">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="media" class="onoffswitch-checkbox" data_post_type="media" id="media" checked="" value="media">
                                    <label class="onoffswitch-label" for="media"></label>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="padding-left-10 font-light-gray">
                                    dans le cas contraire seui vos aboness pourront consulter votre contenu
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="breack-line"></div>
                    <div id="moyen_de_paiement" class="col-md-offset-1 col-md-9 main-contant border-radius-10 border-box bg-white  padding-0">
                        <div class="col-md-12 vertical-row">
                            <div class='col-md-7'>
                                <h1 class="bold blue_text">Moyen de paiement</h1>
                            </div>
                            <div class="col-md-offset-3 col-md-2 col-sm-2 edit-color-blue pointer text-right padding-20 margin-top-20">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit
                            </div>
                        </div>
                        <div class="border-bottom-gray col-md-12 padding-top-10"></div>
                        <div class="col-md-12">
                            <div class="col-md-6  padding-20 pointer vertical-row">
                                <div class="col-md-1 font-color-black">
                                    <i class="fa fa-credit-card fa-2x"></i>
                                </div>
                                <div class="col-md-offset-1 col-md-9">
                                    Ajouter une carte de paiement
                                </div>

                            </div>
                            <div class="col-md-6  padding-20 pointer border-left-gray vertical-row">
                                <div class="col-md-1 font-color-black">
                                    <i class="fa fa-credit-card fa-2x"></i>
                                </div>
                                <div class="col-md-offset-1 col-md-9 font-light-gray">
                                    Modifier ma carte de paiement
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom-gray col-md-12"></div>
                        <div class="col-md-12 padding-top-4per">
                            <div class="col-md-offset-1 col-md-10" id="payment-card">
                                <div class="col-md-12">
                                    <div class="blue_text bold">Mode de paiement</div>
                                </div>
                                <div class="col-md-12 margin-top-20 grey-border">
                                    <input type="text" placeholder="Namero de Carte" required class="card_number">
                                    <span class="card-icon"></span>
                                </div>
                                <div class="col-md-12">                                           
                                    <div class="margin-top-20">
                                        <div class="col-md-5 col-sm-5">
                                            Expiration
                                        </div>
                                        <div class="col-md-offset-4 col-md-3 col-sm-offset-5 col-sm-2">
                                            CVV<span class="circle-border">?</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 margin-top-20 padding-0 vertical-row">
                                    <div class="col-md-3 col-sm-3 grey-border">
                                        <input type="text" placeholder="MM" required class="expiry_month">

                                    </div>
                                    <div class="col-md-1 col-sm-1">
                                        /
                                    </div>
                                    <div class="col-md-3 col-sm-3 grey-border">
                                        <input type="text" placeholder="AA" required class="expiry_year">
                                    </div>
                                    <div class="col-md-offset-1 col-md-4 col-sm-3 grey-border">
                                        <input type="text" placeholder="Code" required class="card_cvv_code">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12 margin-top-20 grey-border">
                                    <?php UserForm::country_select(osc_get_countries()); ?>
                                </div>
                                <div class="col-md-12 margin-top-20 grey-border">
                                    <input type="text" placeholder="Ligne d'address 1">
                                </div>
                                <div class="col-md-12 margin-top-20 grey-border" >
                                    <input type="text">
                                </div>
                                <div class="col-md-12 margin-top-20 grey-border">
                                    <input type="text" placeholder="Code Postal">
                                </div>
                                <div class="col-md-12 margin-top-20 grey-border">
                                    <input type="text" placeholder="Ville">
                                </div>
                                <div class="col-md-12 margin-top-20 grey-border">
                                    <input type="text" placeholder="CEDEX">
                                </div>
                            </div>

                        </div>
                        <div class="border-bottom-gray col-md-12 padding-top-4per"></div>
                        <div class="col-md-12 margin-top-20">
                            <div class="col-md-offset-2 col-md-8">
                                En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les <span class="blue_text"> Conditions d'utilisation </span>et de <span class="blue_text"> confidentialite </span>des services Newsfid.  
                            </div>
                            <div class="col-md-offset-2 col-md-8 padding-top-4per">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="accept" class="onoffswitch-checkbox" data_post_type="accept" id="accept" value="accept">
                                    <label class="onoffswitch-label" for="accept"></label>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom-gray col-md-12 padding-top-4per"></div>
                        <!--            <div class="col-md-12 margin-top-20">
                                        <div class="col-md-offset-2 col-md-8 font-light-gray">
                                            En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les Conditions d'utilisation et de confidentialite des services Newsfid.  
                                        </div>
                                        <div class="col-md-offset-2 col-md-8 padding-top-4per">
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="accept2" class="onoffswitch-checkbox" data_post_type="accept2" checked="" id="accept2" value="accept2">
                                                <label class="onoffswitch-label" for="accept2"></label>
                                            </div>
                                        </div>
                                    </div>-->
                        <div class="border-bottom-gray col-md-12 padding-top-4per"></div>
                        <div class="col-md-12 padding-top-4per">
                            <div class="col-md-offset-3">
                                <button type="submit" class="btn btn-lg button-blue">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                    <div class="breack-line"></div>
                    <div id="compte_bloques" class="col-md-offset-1 col-md-9 main-contant border-radius-10 border-box white-bg padding-0">
                        <div class="col-md-12 vertical-row">
                            <div class='col-md-7'>
                                <h1 class="bold blue_text">Compte bloqués</h1>
                            </div>
                            <div class="col-md-offset-3 col-md-2 col-sm-2 edit-color-blue pointer text-right padding-20 margin-top-20">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit
                            </div>
                        </div>
                        <div class="border-bottom-gray col-md-12"></div>
                        <div class="col-md-12 padding-top-8per padding-bottom-13per">
                            <div class="col-md-11 font-light-gray ">
                                <!--                    En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les Conditions d'utilisation et de confidentialite des services Newsfid.  -->
                            </div>
                        </div>
                        <div class="border-bottom-gray col-md-12"></div>
                        <div class="col-md-12 vertical-row padding-bottom-20">
                            <div class="col-md-2 padding-top-4per">
                                <img src="images/user1-128x128.jpg" class="img img-responsive">
                            </div>
                            <div class="col-md-5">
                                <h3 class="font-color-black bold"> Alex Crawford Sky</h3>
                            </div>
                            <div class="col-md-offset-2 col-md-3">
                                <button class="btn btn-disabled">Bloqués</button>
                            </div>
                        </div>
                    </div>
                    <div class="breack-line"></div>
                    <div id="verouillage" class="col-md-offset-1 col-md-9 main-contant border-radius-10 border-box white-bg padding-0 padding-bottom-20 ">
                        <div class="col-md-12 vertical-row">
                            <div class='col-md-7'>
                                <h1 class="bold blue_text">Verrouillage</h1>
                            </div>
                        </div>
                        <div class="col-md-offset-1 col-md-10 font-light-gray padding-3per">
                            <!--En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les Conditions d'utilisation et de confidentialite des services Newsfid.-->  
                        </div>
                        <div class="border-bottom-gray col-md-12 padding-top-8per"></div>
                        <div class="col-md-12 padding-3per">
                            <div class="col-md-offset-1 col-md-8 padding-3per bold">
                                Verrouiller mes paramétres

                            </div>
                            <div class="col-md-2 padding-3per">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="parameter" class="onoffswitch-checkbox" data_post_type="parameter" checked="" id="parameter" value="parameter">
                                    <label class="onoffswitch-label" for="parameter"></label>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom-gray col-md-12"></div>
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="padding-3per">
                                    Confirmer votre mot de passe
                                </div>
                            </div>
                            <div class="col-md-8 padding-left-8per">
                                <div class="input-text-area left-border box-shadow-none margin-0">
                                    <input type="text" placeholder="Mot de passe" name="p_title">
                                </div>
                            </div>
                            <div class="col-md-4 padding-3per">
                                <button type="submit" class="btn btn-lg button-blue-box">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                    <div class="breack-line"></div>
                    <div id="audio" class="col-md-offset-1 col-md-9 main-contant border-radius-10 border-box white-bg padding-0">
                        <div class="col-md-12 vertical-row">
                            <div class='col-md-7'>
                                <h1 class="bold blue_text">Audio</h1>
                            </div>
                        </div>
                        <div class="border-bottom-gray col-md-12"></div>
                        <div class="col-md-12">
                            <div class="col-md-offset-3 padding-7per">
                                <!--En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les Conditions d'utilisation et de confidentialite des services Newsfid.-->  
                            </div>
                        </div>
                        <div class="border-bottom-gray col-md-12"></div>
                        <div class="col-md-12">
                            <div class="col-md-3 padding-3per font-color-black">
                                Confidentialite
                            </div>
                            <div class="col-md-9 padding-3per padding-left-7per font-color-black">
                                Tout le monde peut voir
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-3 padding-3per font-color-black">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="cnfrm" class="onoffswitch-checkbox" data_post_type="cnfrm" checked="" id="cnfrm" value="cnfrm">
                                    <label class="onoffswitch-label" for="cnfrm"></label>
                                </div>
                            </div>
                            <div class="col-md-9 padding-3per padding-left-7per font-light-gray">
                                <!--En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les Conditions d'utilisation et de confidentialite des services Newsfid.-->  
                            </div>
                        </div>
                    </div>
                    <div class="breack-line"></div>
                    <div id="delete-account" class="col-md-offset-1 col-md-9 main-contant border-radius-10 border-box white-bg padding-0">
                        <div class="col-md-12 vertical-row">
                            <div class='col-md-7'>
                                <h1 class="bold blue_text">Delete Account</h1>
                            </div>
                        </div>
                        <div class="col-md-12 border-bottom-gray"></div>
                        <div class="col-md-12 vertical-row">
                            <div class="col-md-3 text-right padding-top-4per font-light-gray">
                                <i class="fa fa-minus-circle fa-2x" aria-hidden="true"></i>
                            </div>
                            <div class="col-md-7">
                                <h2 class="bold">Voulez vous vraiment deja nous quitter?</h2>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-offset-3 col-md-8 font-light-gray padding-top-4per">
                                <!--En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les Conditions d'utilisation et de confidentialite des services Newsfid.-->  
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-offset-3 col-md-8 font-light-gray padding-top-8per padding-bottom-6per">
                                <button class="en-savoir-plus-button-gry">Supprimer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('#edit').click(function () {
            if ($('.disabled').prop('disabled'))
            {
                $('.disabled').removeAttr('disabled');
            }
            else {
                $('.disabled').attr('disabled', 'disabled')
            }
        });
        $('#edit').click(function () {
            $('#save').show();
            $('#edit').hide();
        });
        $('#save').click(function () {
            $('#save').hide();
            $('#edit').show();
            $('.disabled').attr('disabled', 'disabled');
        });
        
        $('#edit-social').click(function () {
            if ($('.disabled').prop('disabled'))
            {
                $('.disabled').removeAttr('disabled');
            }
            else {
                $('.disabled').attr('disabled', 'disabled')
            }
        });
        $('#edit-social').click(function () {
            $('#save-social').show();
            $('#edit-social').hide();
        });
        $('#save-social').click(function () {
            $('#save-social').hide();
            $('#edit-social').show();
            $('.disabled').attr('disabled', 'disabled');
        });
        // Add smooth scrolling to all links
        $("#setting .nav-tabs a").on('click', function (event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();
                // Store hash
                var hash = this.hash;
                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 1200, function () {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });
        $('#s_city').typeahead({
            source: function (query, process) {
                var $items = new Array;
                var c_id = $('#country_Id').val();
                console.log(c_id);
                if (c_id) {
                    $items = [""];
                    $.ajax({
                        url: "<?php echo osc_current_web_theme_url('city_ajax.php') ?>",
                        dataType: "json",
                        type: "POST",
                        data: {city_name: query, country_id: c_id},
                        success: function (data) {
                            $.map(data, function (data) {
                                var group;
                                group = {
                                    id: data.pk_i_id,
                                    name: data.s_name,
                                };
                                $items.push(group);
                            });
                            process($items);
                        }
                    });
                } else {
                    alert('Please select country first');
                }
            },
            afterSelect: function (obj) {
                $('#cityId').val(obj.id);
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url('setting_ajax.php'); ?>",
                    data: {
                        action: 'change-city',
                        id: obj.id,
                        name: obj.name,
                    },
                    success: function (data, textStatus, jqXHR) {
                    }
                });
            },
        });
    });</script>
<script>

    jQuery(document).ready(function ($) {
        /*name update start*/
        $(document).on('blur', '.user_name_textbox', function () {
            var new_text = $(this).val();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('setting_ajax.php'); ?>",
                data: {
                    action: 'user_name',
                    up_name: new_text,
                },
                success: function (data, textStatus, jqXHR) {
                }
            });
            // $('.name').html(new_text).val('up_name', new_text);
        });
        /*name update end*/
        /*email update start*/
        $(document).on('blur', '.user_email_textbox', function () {
            var new_text = $(this).val();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('setting_ajax.php'); ?>",
                data: {
                    action: 's_email',
                    up_email: new_text,
                },
                success: function (data, textStatus, jqXHR) {
                }
            });
            // $('.name').html(new_text).val('name', new_text);
        });
        /*email update end */
        $(document).on('blur', '.user_mobile_textbox', function () {
            var new_text = $(this).val();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('setting_ajax.php'); ?>",
                data: {
                    action: 's_phone_mobile',
                    up_mobile: new_text,
                },
                success: function (data, textStatus, jqXHR) {
                }
            });
            // $('.name').html(new_text).val('name', new_text);
        });
        $(document).on('change', '.user_country_textbox', function () {
            var country_name = $('.user_country_textbox option:selected').text();
            var country_code = $(this).val();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('setting_ajax.php'); ?>",
                data: {
                    action: 'fk_c_country_code',
                    up_country: country_code,
                    up_country_name: country_name,
                },
                success: function (data, textStatus, jqXHR) {
                }
            });
            // $('.name').html(new_text).val('name', new_text);
        });
        $(document).on('blur', '.user_city_textbox', function () {
            var city_name = $(this).text();
            var city_code = $(this).val();
            console.log(city_code);
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('setting_ajax.php'); ?>",
                data: {
                    action: 'fk_i_city_id',
                    up_city_name: city_name,
                    up_city_code: city_code,
                },
                success: function (data, textStatus, jqXHR) {
                }
            });
            // $('.name').html(new_text).val('name', new_text);
        });

        $(document).on('change', '.user_type_textbox', function () {
            var role_id = $(this).val();
            var role_name = $('.user_type_textbox option:selected').text();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('setting_ajax.php'); ?>",
                data: {
                    action: 'user_role',
                    user_role_id: role_id,
                },
                success: function (data, textStatus, jqXHR) {
                }
            });
        });
        $(document).on('blur', '.facebook', function () {
            var new_text = $(this).val();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('setting_ajax.php'); ?>",
                data: {
                    action: 'facebook',
                    facebook: new_text,
                },
                success: function (data, textStatus, jqXHR) {
                }
            });
            // $('.name').html(new_text).val('name', new_text);
        });
        $(document).on('blur', '.twitter', function () {
            var new_text = $(this).val();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('setting_ajax.php'); ?>",
                data: {
                    action: 'twitter',
                    twitter: new_text,
                },
                success: function (data, textStatus, jqXHR) {
                }
            });
            // $('.name').html(new_text).val('name', new_text);
        });
        $(document).on('click', '#change-pass', function () {

            var password = $('.pass').val();
            var new_password = $('.npass').val();
            var confirm_password = $('.cpass').val();
            if (password != "" && new_password != "" && confirm_password != "") {
                if (new_password == confirm_password) {
                    $.ajax({
                        url: '<?php echo osc_current_web_theme_url() . 'change-password.php' ?>',
                        data: {
                            action: 'password-change',
                            password: password,
                            new_passowrd: new_password,
                        },
                        success: function (data) {
                            if (data == 1) {

                                window.location.href = '<?php echo osc_current_web_theme_url() . 'setting.php' ?>'
                            } else {
                                $('#setting_loader').addClass('hidden');
                                $('.alert_text').html('password is not correct');
                            }
                        }
                    });
                } else {
                    $('.alert_text').html('password does not match');
                }
            }
            else {
<?php osc_add_flash_ok_message('Data Updated Succsessfully'); ?>
                window.location.href = '<?php echo osc_current_web_theme_url() . 'setting.php' ?>'
            }
        });
        //        $('.settings-li li a').click(function (e) {
        //            var $this = $(this);
        //            console.log($this);
        //            $($this).addClass('active');
        //            e.preventDefault();
        //        });
    });
</script>
<script>
    jQuery(document).ready(function ($) {
        $(document).on('click', '.user_info_edit', function () {
            var text = $('.user_info .user_info_text').attr('data_text');
            var input_box = '<input type="text" class="user_info_textbox" value="' + text + '">';
            $('.user_info_text').html(input_box);
            $('.user_info_textbox').keypress(function (e) {
                if (e.which == 13) {//Enter key pressed
                    $('.user_info_textbox').focusout();
                }
            });
        });
        $(document).on('blur', '.user_info_textbox', function () {
            var new_text = $(this).val();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('user_info_ajax.php'); ?>",
                data: {
                    action: 'user_info',
                    user_info_text: new_text,
                },
                success: function (data, textStatus, jqXHR) {
                }
            });
            $('.user_info_text').html(new_text).attr('data_text', new_text);
        });
        $(document).on('click', '.user_website_edit', function () {
            var text = $('.user_website .user_website_text').attr('data_text');
            var input_box = '<input type="text" class="user_website_textbox" value="' + text + '">';
            $('.user_website_text').html(input_box);
            $('.user_website_textbox').keypress(function (e) {
                if (e.which == 13) {//Enter key pressed
                    $('.user_website_textbox').focusout();
                }
            });
        });
        $(document).on('blur', '.user_website_textbox', function () {
            var new_text = $(this).val();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('user_info_ajax.php'); ?>",
                data: {
                    action: 'user_website',
                    user_website_text: new_text,
                },
                success: function (data, textStatus, jqXHR) {
                }
            });
            $('.user_website_text').html(new_text).attr('data_text', new_text);
        });
        $(document).on('click', '.user_type_edit', function () {
            $('.user_role_selector').show();
            $('.user_role_name').hide();
            //                var text = $('.user_website .user_website_text').attr('data_text');
            //                var input_box = '<input type="text" class="user_website_textbox" value="' + text + '">';
            //                $('.user_website_text').html(input_box);
        });

        $(document).on('change', '.user_role_selector', function () {
            var role_id = $(this).val();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('user_info_ajax.php'); ?>",
                data: {
                    action: 'user_role',
                    user_role_id: role_id,
                },
                success: function (data, textStatus, jqXHR) {
                    if (data != 0) {
                        $('.user_role_name').text(data);
                    }
                    $('.user_role_selector').hide();
                    $('.user_role_name').show();
                }
            });
        });
    });
</script>

<?php osc_current_web_theme_path('footer.php'); ?>