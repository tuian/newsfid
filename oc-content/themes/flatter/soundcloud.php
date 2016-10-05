
<?php
require '../../../oc-load.php';
require 'functions.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

    <head>
        <title>Player SoundPass</title>
        <meta name="description" content="Radio King propose des services Internet pour les Radios! Créez facilement votre Radio sur Internet, concevez le Site de votre Radio ou développez votre propre Application Mobile Radio!" />
        <meta name="keywords" content="créer site radio, hébergement radio, créer webradio, créer radio, radio, radios, player, radio fm, webradio, création de site, site internet, développement, développeur, radioking, radio king, streaming, shoutcast, cms radio, radio sur le web, cloud dj, radio broadcast, playlist radio, diffusion radio, application mobile, application radio, application radio iphone, application radio android, créer application iphone, site en ligne, radio sur internet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Content-Language" content="fr-FR" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="js/system.min.js"></script>
        <script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
        <script type="text/javascript" src="js/player.js"></script>

        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.min.css"/>

        <link rel="stylesheet" type="text/css" href="css/player.css" />
        <link rel="stylesheet" type="text/css" href="css/fonts.css" />
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />

        <?php
        $language = isset($_SESSION['userLocale']) ? $_SESSION['userLocale'] : osc_locale_code();
        if ($language == "fr_FR"):
            ?>
            <script type="text/javascript">
                $typeplayer = "small";
                $urlflux = "https://www.radioking.com/play/soundpass-europe";
                $idradio = "29479";
                var radioName = "SoundPass Europe";
                var coverimg = "1b28e225-e9ac-4d08-8312-5288c470bcaa";
                $itunes = "1";
            </script>
            <style>
                #pochette_circle {
                    position: absolute;
                    top: 22%;
                    left: 22%;
                    width: 50%;
                    height: 50%;
                }
                #btnPlay {
                    top: 40%;
                    left: 43%;
                }
                #btnStop {
                    top: 40%;
                    left: 41%
                }
                #loading {
                    top: 41%;
                    left: 38%;
                }
            </style>
        <?php else: ?>
            <script type="text/javascript">
                $typeplayer = "medium";
                $urlflux = "https://www.radioking.com/play/soundpass";
                $idradio = "28600";
                var radioName = "SoundPass";
                var coverimg = "d34bff7d-86a1-42f2-bdba-b18b9aeb5239";
                $itunes = "0";
            </script>
        <?php endif;
        ?>

        <script type="text/javascript">

            var AutoPlay = "1";            
            var radioSite = "https://newsfid.com/";
            var apiURL = "https://www.radioking.com/api";
            var streams = [{"idstream": 64519, "idradio": 28600, "idprimary": 2, "format": "MP3", "bitrate": 128, "frequency": 44100, "status": "active", "type": 1}];
            $couleur = "#071019";
            $iditunes = "";
            $partage = "1";
            $popup = "1";
            $pochette = "1";
            $equalizer = "1";
            $host = "www.radioking.com";
            $port = "80";
            $taillePlayerW = 300;
            $taillePlayerH = 300;
        </script>
        <style>
            #global, .ui-slider .ui-slider-range, #titrageBgColor
            {
                background-color: #071019;
            }
        </style>
    </head>
    <body>

        <div id="global">
            <div id="main">
                <div id="header">
                    <!--<a href="http://https://newsfid.com/" target="_blank" title="SoundPass"><div="nomRadio">SoundPass</div></a>-->
                </div>                
                <div id="pochetteHolder"></div>
                <div id="pochette">
                </div>
                <div id="pochette_circle" class="img-circle">
                </div>

                <div id="mainTitrage">
                    <div id="effectTitrage">
                        <div id="titrage">
                            <span id="titre" class="titre"></span>
                            <span id="artiste" class="artiste"></span>
                        </div>
                        <div id="titrageBg">
                        </div>
                        <div id="titrageBgColor">
                        </div>


                    </div>
                </div>
                <div id="btnPlay"><i class="fa fa-2x fa-play" aria-hidden="true"></i></div>
                <div id="loading"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                    <span class="sr-only"></span></div>
                <div id="btnStop"><i class="fa fa-2x fa-pause" aria-hidden="true"></i></div>
                <div id="slider"></div>
                <div id="memoire"></div>
                <div id="volume">50</div>
                <div id="radioStream"></div>
                <div id="volume-icon"><i class="fa fa-volume-up" aria-hidden="true"></i></div>

            </div>
        </div>
        <script type="text/javascript">
            changeSize($taillePlayerW, $taillePlayerH);
        </script>
    </body>

</html>

