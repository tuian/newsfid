<?php
require '../../../oc-load.php';
require 'functions.php';
?>
<?php osc_current_web_theme_path('header.php'); ?>
<div id="setting" class="row margin-0"> 
    <div class="col-md-12 padding-bottom-6per">
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
        <div class="col-md-offset-1 col-md-9 main-contant margin-top-20 border-box bg-white padding-0">
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
            <div class="col-md-12 vertical-row padding-bottom-20 border-left-orange">
                <div class='col-md-3'>
                    <h1 class="bold blue_text">Compte</h1>
                </div>
                <div class="col-md-offset-7 col-md-2 col-sm-2 edit-color-blue pointer text-right padding-20 margin-top-20">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit
                </div>
            </div>
            <div class="border-bottom-gray col-md-12"></div>
            <div class="row margin-0">
                <div class="col-md-12 col-sm-12 padding-top-4per vertical-row">
                    <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                        Nom d'utilisateur
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                        <input type="text" name="name" class="name">
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
                        <input type="text" name="email" class="email">
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
                            <input type="text" name="mobile" class="mobile form-control">
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
                        <?php UserForm::country_select(osc_get_countries()); ?>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 padding-top-4per vertical-row">
                    <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                        Ville
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                        <input type="text" name="s_city" class="form-control" id="s_city" placeholder="">
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
                        <input type="text" name="utype" class="utype">
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
                        Current Password<span class="red">&nbsp;&nbsp;&nbsp;&nbsp;*</span>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                        <input type="text" name="cpass" class="cpass">
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 padding-top-4per vertical-row">
                    <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                        New Password<span class="red">&nbsp;&nbsp;&nbsp;&nbsp;*</span>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                        <input type="text" name="npass" class="npass">
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 padding-top-4per vertical-row">
                    <div class="col-md-3 col-sm-3 col-xs-5 text-right">
                        Confirm Password<span class="red">&nbsp;&nbsp;&nbsp;&nbsp;*</span>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-6 grey-border vertical-row">
                        <input type="text" name="copass" class="copass">
                    </div>
                </div>
            </div>
        </div>
        <div class="breack-line"></div>
        <div class="col-md-offset-1 col-md-9 main-contant border-radius-10 border-box bg-white  padding-0">
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
        <div class="col-md-offset-1 col-md-9 main-contant border-radius-10 border-box bg-white  padding-0">
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
            <div class="col-md-12 margin-top-20">
                <div class="col-md-offset-2 col-md-8 font-light-gray">
                    En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les Conditions d'utilisation et de confidentialite des services Newsfid.  
                </div>
                <div class="col-md-offset-2 col-md-8 padding-top-4per">
                    <div class="onoffswitch">
                        <input type="checkbox" name="accept2" class="onoffswitch-checkbox" data_post_type="accept2" checked="" id="accept2" value="accept2">
                        <label class="onoffswitch-label" for="accept2"></label>
                    </div>
                </div>
            </div>
            <div class="border-bottom-gray col-md-12 padding-top-4per"></div>
            <div class="col-md-12 padding-top-4per">
                <div class="col-md-offset-3">
                    <button type="submit" class="btn btn-lg button-blue">Enregistrer</button>
                </div>
            </div>
        </div>
        <div class="breack-line"></div>
        <div class="col-md-offset-1 col-md-9 main-contant border-radius-10 border-box white-bg padding-0">
            <div class="col-md-12 vertical-row">
                <div class='col-md-7'>
                    <h1 class="bold blue_text">Compte bloques</h1>
                </div>
                <div class="col-md-offset-3 col-md-2 col-sm-2 edit-color-blue pointer text-right padding-20 margin-top-20">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit
                </div>
            </div>
            <div class="border-bottom-gray col-md-12"></div>
            <div class="col-md-12 padding-top-8per padding-bottom-13per">
                <div class="col-md-11 font-light-gray ">
                    En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les Conditions d'utilisation et de confidentialite des services Newsfid.  
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
                <div class="col-md-offset-2 col-md-3 block-dropdown">
                    <select class="font-light-gray">
                        <option>Bloque</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="breack-line"></div>
        <div class="col-md-offset-1 col-md-9 main-contant border-radius-10 border-box white-bg padding-0 padding-bottom-20 ">
            <div class="col-md-12 vertical-row">
                <div class='col-md-7'>
                    <h1 class="bold blue_text">Verouillage</h1>
                </div>
            </div>
            <div class="col-md-offset-1 col-md-10 font-light-gray padding-3per">
                En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les Conditions d'utilisation et de confidentialite des services Newsfid.  
            </div>
            <div class="border-bottom-gray col-md-12 padding-top-8per"></div>
            <div class="col-md-12 padding-3per">
                <div class="col-md-offset-1 col-md-8 padding-3per bold">
                    Verouiller mes parametres
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
        <div class="col-md-offset-1 col-md-9 main-contant border-radius-10 border-box white-bg padding-0">
            <div class="col-md-12 vertical-row">
                <div class='col-md-7'>
                    <h1 class="bold blue_text">Audio</h1>
                </div>
            </div>
            <div class="border-bottom-gray col-md-12"></div>
            <div class="col-md-12">
                <div class="col-md-offset-3 padding-7per">
                    En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les Conditions d'utilisation et de confidentialite des services Newsfid.  
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
                    En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les Conditions d'utilisation et de confidentialite des services Newsfid.  
                </div>
            </div>
        </div>
        <div class="breack-line"></div>
        <div class="col-md-offset-1 col-md-9 main-contant border-radius-10 border-box white-bg padding-0">
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
                   En continuant, vous ajoutez ce mode de paiement a votre compte Newsfid et acceptez les Conditions d'utilisation et de confidentialite des services Newsfid.  
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
<script>
    $(document).ready(function () {
        $('#s_city').typeahead({
            source: function (query, process) {
                var $items = new Array;
                var c_id = $('#countryId').val();
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
            },
        });
    });
</script>

<?php osc_current_web_theme_path('footer.php'); ?>