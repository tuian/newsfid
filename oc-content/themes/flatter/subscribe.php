<?php
require '../../../oc-load.php';
require 'functions.php';
?>
<?php osc_current_web_theme_path('header.php'); ?>

<!-- profile cover -->
<div class="subscribe-page">
    <div class="cover-img">


        <div class="container">
            <div class="col-md-8">
                <h3 class="font-color-white bold-600 margin-0">Decouvrez l'offre</h3>
                <h1 class="font-color-white bold-600 font-65px margin-0">NEWSFID PRO</h1>
                <div class="col-md-8 border-bottom"></div>
                <h2 class="font-color-white bold-600">Liberte, Notoriete, diffrence et simplicite</h2>
                <div class="col-md-offset-1 margin-top-20">
                    <button type="submit" class="btn btn-lg button-orng" data-toggle="modal" data-target="#payment">Passez a Newsfid Premium gratuit pendant 30 jours</button>
                    <!-- Payment modal start -->
                    <div id="payment" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content bg-transperent">
                                <div class="modal-header bg-white">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="payment-section-1 bg-white">
                                    <div class="container">
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <img class="img img-responsive" src="../flatter/images/balance.png">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="col-md-12">
                                                    <h1 class="bold font-color-light-blue">Newsfid Premium</h1>
                                                    <h3 class="bold font-color-royal-blue margin-0">Ameliorez votre experience</h3>
                                                </div>
                                                <div class="col-md-12 padding-top-13per">
                                                    I accept the terms of use and additional requirements related to the use of newsfid service. One case of conflict with my content I agree to be solely responsible for and agree that newsfid and its partners 
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="breack-line"></div>
                                <div class="payment-section-2 bg-white col-md-12 border-radius-10 padding-0">
                                    <div class="col-md-12 theme-modal-header">
                                        <div class="col-md-offset-1">
                                            <h2 class="bold margin-0"> Selectionnez votre mode de paiement </h2>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="col-md-12 margin-top-20">
                                            <table class="table margin-0">
                                                <thead>
                                                    <tr class="bg-blue-light">
                                                        <th class="border-right-white font-color-black">Date</th>
                                                        <th class="border-right-white font-color-black">Description</th>
                                                        <th class="border-right-white font-color-black">Quantity</th>
                                                        <th class="border-right-white font-color-black">Unit Price</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-bottom">
                                                        <td class="font-color-black">1/25/2012</td>
                                                        <td class="font-color-black">Newsfid Premium (12 month Payment) 1 Month for free</td>
                                                        <td class="font-color-black">1</td>
                                                        <td class="font-color-black">$4.99</td>
                                                        <td class="font-color-black">4.99$</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-color-black"><h1 class="bold">TOTAL</h1></td>
                                                        <td class="font-color-black"></td>
                                                        <td class="font-color-black"></td>
                                                        <td class="font-color-black"></td>
                                                        <td class="font-color-black">4.99$</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="theme-modal-footer"></div> 
                                    <div class="col-md-12 bg-white">
                                        <div class="col-md-offset-1 col-md-2 text-center">
                                            <div class="payment-img">
                                                <img class="img img-responsive" src="../flatter/images/CreditCards.png">
                                            </div>
                                            <input type="radio" name="payment" checked="true">
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <div class="payment-img">
                                                <img class="img img-responsive" src="../flatter/images/paypal.png">
                                            </div>
                                            <input type="radio" name="payment" checked="true">
                                        </div>
                                        <div class="col-md-6 padding-3per bg-green-light">
                                            I accept the terms of use and additional requirements related to the use of newsfid service. One case of conflict with my content I agree to b I accept the terms of use 
                                        </div>

                                    </div>
                                    <div class="col-md-offset-3 col-md-6">
                                        <div class="col-md-12">
                                            <div class="blue_text bold">Mode de Paiement</div>
                                        </div>
                                        <div class="col-md-12 margin-top-20 grey-border">
                                            <input type="text" placeholder="Name de Carte">
                                        </div>
                                        <div class="col-md-12">
                                            <div class="margin-top-20">
                                                <div class="col-md-5">
                                                    Expiration
                                                </div>
                                                <div class="col-md-offset-5 col-md-2">
                                                    CVV ?
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 margin-top-20 vertical-row">
                                            <div class="col-md-3 grey-border">
                                                <input type="text" placeholder="MM">
                                            </div>
                                            <div class="col-md-1">
                                                /
                                            </div>
                                            <div class="col-md-3 grey-border">
                                                <input type="text" placeholder="AA">
                                            </div>
                                            <div class="col-md-offset-2 col-md-3 grey-border">
                                                <input type="text" placeholder="Code">
                                            </div>
                                        </div>
                                        <div class="col-md-12 margin-top-20 grey-border">
                                            <select>
                                                <option>Select Country</option>
                                            </select>
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
                                <div class="breack-line"></div>
                                <div class="col-md-12 padding-0 bg-white border-radius-10 padding-top-4per">
                                    <div class="col-md-12 theme-modal-header">
                                        <div class="col-md-offset-2 col-md-1">
                                            <div class="onoffswitch margin-top-10">
                                                <input type="checkbox" name="accept" class="onoffswitch-checkbox post_type_switch" data_post_type="accept" id="accept" value="accept">
                                                <label class="onoffswitch-label" for="accept"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-8"><h4 class=" bold">Je Confirme avoir lu et accepte les Conditions Generales d'Utilision</h4> </div>
                                    </div>
                                    <div class="col-md-offset-2 col-md-10 theme-modal-header">
                                       
                                            <div class="col-md-9">
                                                I accept the terms of use and additional requirements related to the use of newsfid service. One case of conflict with my content I agree to b I accept the terms of use
                                            </div>
                                            <div class="col-md-9 margin-top-20">Je Confirme avoir lu et accepte les Conditions Generales d'Utilision </div>
                                            <div class="col-md-9 margin-top-20">
                                                <button type="submit" class="btn btn-lg button-orng" data-toggle="modal" data-target="#payment">Activer mes 30 jours gartuit</button>
                                                <div class="margin-top-20">Je Confirme avoir lu et accepte les Conditions Generales d'Utilision</div>
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!----------payment modal end-->
                    </div>
                </div>
            </div>

        </div>
        <div class="contant bg-white col-md-12">

            <div class="col-md-12 text-center padding-top-4per ">
                <h4 class="bold-600 margin-0 font-color-black">Beneficiez du service Newsfid incluant un essai gratuit pendent 30 jour</h4>
            </div>
            <div class="sub-info col-md-12   margin-top-20">
                <div class="col-md-5">
                    <img class="img img-responsive" src="../flatter/images/responsivei-img.png">
                </div>
                <!------------table title Start-------------->
                <div class="col-md-7">
                    <div class="col-md-12 border-bottom  vertical-row">
                        <div class="col-md-8 col-sm-8 col-xs-6">
                            <div class="font-color-black">Fonctionalites</div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3">
                            <div class="font-color-black bold">Gratuit</div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3">
                            <div class="font-color-black bold">Premium</div>
                        </div>
                    </div>
                    <!--------------Table title End----------------->
                    <!------------------Table row Start-------1--------->
                    <div class="col-md-12 border-bottom  vertical-row">
                        <div class="col-md-8 col-sm-8 col-xs-6">
                            <div class="orange bold padding-top-4per">Public de media audio(format MP3)</div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                            <div class="white-round margin-left-15"></div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                            <div class="green-round margin-left-15"></div>
                        </div>
                    </div>
                    <!---------------Table Row End---------1-------->
                    <!------------------Table row Start-------2--------->
                    <div class="col-md-12 border-bottom  vertical-row">
                        <div class="col-md-8 col-sm-8 col-xs-6">
                            <div class="orange bold padding-top-4per">Publication d'image au format GIF</div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                            <div class="green-round margin-left-15"></div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                            <div class="green-round margin-left-15"></div>
                        </div>
                    </div>
                    <!------------------Table row End-------2--------->
                    <!------------------Table row Start-------3--------->
                    <div class="col-md-12 border-bottom  vertical-row">
                        <div class="col-md-8 col-sm-8 col-xs-6">
                            <div class="orange bold padding-top-4per">Publication sponsorisee gratuit</div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                            <div class="white-round margin-left-15"></div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                            <div class="green-round margin-left-15"></div>
                        </div>
                    </div>
                    <!------------------Table row End-------3--------->
                    <!------------------Table row Start-------4--------->
                    <div class="col-md-12 border-bottom  vertical-row">
                        <div class="col-md-8 col-sm-8 col-xs-6">
                            <div class="orange bold padding-top-4per">Publication video(liens youtube / Vimeo...)</div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                            <div class="green-round margin-left-15"></div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                            <div class="green-round margin-left-15"></div>
                        </div>
                    </div>
                    <!------------------Table row End-------4--------->
                    <!------------------Table row Start-------5--------->
                    <div class="col-md-12 border-bottom  vertical-row">
                        <div class="col-md-8 col-sm-8 col-xs-6">
                            <div class="orange bold padding-top-4per">Une mention (complete professionel) pour marquer vorte diffrence avec les autres utilisateurs</div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                            <div class="white-round margin-left-15"></div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                            <div class="green-round margin-left-15"></div>
                        </div>
                    </div>
                    <!------------------Table row end-------5--------->
                </div>
            </div>
        </div>
        <!-- end profil cover -->
        <?php osc_current_web_theme_path('footer.php'); ?>