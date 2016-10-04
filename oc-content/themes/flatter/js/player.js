var dicts = dicts || {};
dicts["fr"] = {"":{"project-id-version":"","pot-creation-date":"","po-revision-date":"","last-translator":"","language-team":"","language":"fr","mime-version":"1.0","content-type":"text/plain; charset=UTF-8","content-transfer-encoding":"8bit","x-generator":"Poedit 1.8.5","plural-forms":"nplurals=2; plural=(n > 1);","x-poedit-keywordslist":"translate_rk","x-poedit-basepath":"../player","x-poedit-sourcecharset":"UTF-8","x-poedit-searchpath-0":"."},"This radio has no any artist for the moment.":[null,"Cette radio nâ€™a aucun artiste pour le moment."],"Discover":[null,"DÃ©couvrir"],"on Radio King":[null,"sur Radio King"],"I'm listening \"{0}\" on {1}":[null,"Jâ€™Ã©coute \"{0}\" en ce moment sur {1}"],"This radio has no any track for the moment.":[null,"Cette radio nâ€™a aucun titre pour le moment."],"Date":[null,"Date"],"Hour":[null,"Heure"],"Title":[null,"Titre"],"Buy":[null,"Acheter"],"<strong>Right</strong><br><strong>now</strong>":[null,"<strong>En</strong><br><strong>ce moment</strong>"],"Open in a pop-up":[null,"Ouvrir dans une pop-up"],"Download this track":[null,"TÃ©lÃ©charger ce titre"],"Download":[null,"TÃ©lÃ©charger"],"Share this track":[null,"Partager ce titre"],"Share":[null,"Partager"],"SHARE THIS TRACK":[null,"PARTAGER CE TITRE"],"Share on Facebook":[null,"Partager sur Facebook"],"Share on Twitter":[null,"Partager sur Twitter"],"Share on Google Plus":[null,"Partager sur Google Plus"],"Code to embed":[null,"Code Ã  intÃ©grer"],"Error with player settings":[null,"Erreur avec la configuration du player"],"The player has been successfully added. Reload the page to see the result.":[null,"Le player a bien Ã©tÃ© ajoutÃ©. Rechargez la page pour voir le rÃ©sultat."],"To add your Player on this page, please provide the Player key (given in Widgets menu of your Radio Manager)":[null,"Pour ajouter le Player sur cette page, merci de renseigner la clef du Player (fourni dans la partie Widgets de votre Manager Radio)."],"Code of your player :":[null,"Clef de votre Player :"]};
if (!String.prototype.format) {
  String.prototype.format = function() {
    var args = arguments;
    return this.replace(/{(\d+)}/g, function(match, number) {
      return typeof args[number] != 'undefined'
        ? args[number]
        : match
      ;
    });
  };
}

function translate_rk(term, lang) {
    // return translated term or term if no dict is available

    if(dicts[lang] && dicts[lang][term] && dicts[lang][term][1] != '')
        return dicts[lang][term][1];

    return term;
}

$(document).ready(function() {
	var usedMemLimit = true;
	var usedMemLimitVal = 500;

	var pochetteWidth = 100;
	var pochetteHeight = 100;

	if ($typeplayer == "big") {
		pochetteWidth = 194;
		pochetteHeight = 194;
	}

	var pochetteUrl = "images/cover.png";

	if (coverimg != "") {
		pochetteUrl = apiURL + '/track/cover/' + coverimg;
	}

	$('#pochette').append('<img src="' + pochetteUrl + '" width="' + pochetteWidth + '"></img>');
	$('#pochette_circle').append('<img src="' + pochetteUrl + '"></img>');

	$('#artiste').text(radioName);
	$('#titre').text("");

	$('#nomRadio').text(radioName);

	$('#linkFacebook').fadeTo(500, 0.5);
	$('#linkTwitter').fadeTo(500, 0.5);
	$('#linkGoogle').fadeTo(500, 0.5);

	var mobileStream, defaultStream, hdStream;
	for (var i = 0; i < streams.length; i++) {
		switch (streams[i].type) {
			case 1:
				defaultStream = streams[i];
				break;
			case 2:
				if (streams[i].status === 'active') {
					mobileStream = streams[i];

					if (isMobile()) {
						$('.hd').show();
						$('.eq').hide();
					}
				}
				break;
			case 3:
				if (streams[i].status === 'active') {
					hdStream = streams[i];
					$('.hd').show();
					$('.eq').hide();
				}
				break;
		}
	}

	var stream;
	var resultContainer = $('#pochette');
	var resultContainerCircle = $('#pochette_circle');
	var goDown = true;
	var songMem = new Array();
	var saveFirstSong = true;
	var historyIS = false;
	var musicLink;
	var currentSong;
	var artistSong;
	var titleSong;
	var errorTitle = 0;
	var isStart = false;
	var volumeStream = 50;
	var radioInfoInterval = undefined;
	var tries = 0;
	var hd = false;

	///////////////////////////////

	$("#radioStream").jPlayer({
		swfPath: "/widgets/player/js/jquery.jplayer.swf",
		supplied: "mp3",
		autohide: false,
		solution: "html,flash",
		volume: $("#volume").text() / 100,
		ready: function() {
			$(this).jPlayer("setMedia", {
				mp3: getStreamLink()
			});

			if (AutoPlay == "1" && !isMobile()) {
				startRadio();
			}
		},
		error: function(e) {
			// 3 tries if error on mobile
			if (e.jPlayer.error.type === 'e_url' && tries++ < 3)
				stream.jPlayer('play');
		}
	});

	stream = $("#radioStream");
	stream.bind($.jPlayer.event.pause, function(event) {
		stopPlayer();
	});
	stream.bind($.jPlayer.event.playing, function(event) {
		playPlayer();
	});

	// Player start Volume 50
	$("#volume").text(50);
	$("#volume").hide();
	$("#stopBtn").hide();
	$('#slider').slider({
		orientation: "vertical",
		range: "min",
		min: 0,
		max: 100,
		step: 5,
		value: 50,
		slide: function(event, ui) {
			if (volumeStream != ui.value) {
				volumeStream = ui.value;
				stream.jPlayer("volume", ui.value / 100);
				$("#volume").text(ui.value);
			}
		}
	});

	var cookie = readCookie('player_hd');
	if (cookie === 'active' || (!cookie && !isMobile())) {
		hd = true;
		$('.hd').addClass('on');
		$('.hd').removeClass('off');
	}

	function getStreamLink() {
		var url = $urlflux + '/';

		if (hd && hdStream)
			url += hdStream.idstream;
		else if (hd && isMobile() && !hdStream && mobileStream)
			url = $urlflux;
		else if (isMobile() && mobileStream)
			url += mobileStream.idstream;
		else
			url = $urlflux;

		return url;
	}

	function startRadio() {
		window.addEventListener("unhandledrejection", function(err) {
			if (err.reason.name == 'NotAllowedError')
				stopPlayer();
		});

		showLoader();
		stream.jPlayer("setMedia", {
			mp3: getStreamLink()
		});

		stream.jPlayer('play');

		getTitrage();
		clearInterval(radioInfoInterval);
		radioInfoInterval = setInterval(getTitrage, 20000);
	}

	// Player Stop Button
	$("#btnStop").click(function() {
		stream.jPlayer('clearMedia');
		clearInterval(radioInfoInterval);
		songMem = null;
		stream.jPlayer('pause');
		stopPlayer();
	})

	$("#btnPlay").click(function() {
		startRadio();
	})

	function playPlayer() {
		$("#btnStop").fadeIn();
		$("#btnPlay").hide();
		$('#loading').hide();
	}

	function showLoader() {
		$("#btnStop").hide();
		$("#btnPlay").hide();
		$('#loading').fadeIn();
	}

	function stopPlayer() {
		$("#btnStop").fadeOut();
		$('#loading').fadeOut();
		$("#btnPlay").fadeIn();
		$('#pochette').empty();
		$('#pochette').append('<img src="' + pochetteUrl + '" style="width:' + pochetteWidth + '%; height:' + pochetteHeight + '%"></img>');
		$('#artiste').text(radioName);
		$('#titre').text("");

		if ($itunes != 0) {
			$('#btnDownload').attr('href', "javascript:void(0)");
			$('#btnDownload').css('cursor', 'default');
		}

		/* SHARE PANEL */
		if ($partage != 0) {
			$('#linkFacebook').fadeTo(500, 0.5);

			$('#linkTwitter').fadeTo(500, 0.5);
			$('#linkTwitter').attr('href', "javascript:void(0)");

			$('#linkGoogle').fadeTo(500, 0.5);
			$('#linkGoogle').attr('href', "javascript:void(0)");
		}
	}

	function getTitrage() {

		$.ajaxSetup({
			cache: false
		});

		$.ajax({
			url: apiURL + '/radio/' + $idradio + '/track/live',
			success: function(data) {
				if (data.status == "success") {

					var track = data.data;

					if (track.title == "" || track.title == "null" || track.title == null) {
						$('#artiste').text(radioName);
						errorTitle += 1;

						if (errorTitle > 3) {
							clearInterval(radioInfoInterval);

						}
						return;

					} else {
						errorTitle = 0;
					}

					$('#titrage').hide();

					currentSong = track.artist + ' - ' + track.title;
					artistSong = track.artist;
					titleSong = track.title;

					var urlcover = "/widgets/player/images/cover.png";

					if (track.cover) {
						urlcover = apiURL + '/track/cover/' + track.cover;
					} else {
						urlcover = pochetteUrl;
					}

					$('#artiste').text(artistSong);
					$('#titre').text(titleSong);

					$('#titrage').fadeIn();

					if (currentSong != songMem) {
						songMem = currentSong;
						/* SHARE */

						if ($partage != 0) {
							if (currentSong != "") {
								$('#linkFacebook').fadeTo(500, 1);

								$('#linkTwitter').attr('href', 'https://twitter.com/share?text=' + encodeURIComponent(translate_rk('I\'m listening "{0}" on {1}').format(currentSong, radioName)) + '&url=' + radioSite);
								$('#linkTwitter').fadeTo(500, 1);

								$('#linkGoogle').attr('href', 'https://plus.google.com/share?url=' + encodeURIComponent(radioSite));
								$('#linkGoogle').fadeTo(500, 1);
							} else {
								$('#linkFacebook').fadeTo(500, 0.5);

								$('#linkTwitter').fadeTo(500, 0.5);
								$('#linkTwitter').attr('href', "javascript:void(0)");

								$('#linkGoogle').fadeTo(500, 0.5);
								$('#linkGoogle').attr('href', "javascript:void(0)");
							}
						}

						if ($itunes != 0) {
							if (track.buy_link && track.buy_link != "null") {
								var link = track.buy_link;
								if ($iditunes && track.buy_link.indexOf('itunes.apple.com') >= 0)
									link += "&at=" + $iditunes;

								$('#btnDownload').attr('href', link);
								$('#btnDownload').css('cursor', 'pointer');
							} else {
								$('#btnDownload').attr('href', "javascript:void(0)");
								$('#btnDownload').css('cursor', 'default');
							}
						}

						if (urlcover !== null && $pochette != "0" && $typeplayer != "mini") {

							resultContainer.empty();
							resultContainer.hide();
							resultContainerCircle.empty();
							resultContainerCircle.hide();

							var curCover = '<img src="' + urlcover + '"  style="width:' + pochetteWidth + '%; height:' + pochetteHeight + '%" />';
							var curCoverCircle = '<img src="' + urlcover + '"/>';

							resultContainer.append(curCover);
							resultContainer.fadeIn();
							resultContainerCircle.append(curCoverCircle);
							resultContainerCircle.fadeIn();
						}
					}
				}
			},
			dataType: 'json'
		});

		return false;
	}

	function strpos(haystack, needle, offset) {
		var i = (haystack + '').indexOf(needle, (offset || 0));
		return i === -1 ?
			false :
			i;
	}

	$("#btnPopup").click(function() {
		openPopup();
	})

	function openPopup() {
		stream.jPlayer('clearMedia');
		if (radioInfoInterval !== undefined) {
			clearInterval(radioInfoInterval);
		}
		songMem = null;
		stream.jPlayer('pause');
		stopPlayer();
		popupWindows = window.open(document.URL + "&a=1", 'popupplayer', 'width=' + $taillePlayerW + ',height=' + $taillePlayerH + ',left=' + (Math.round((screen.width - $taillePlayerW) / 2)) + ',top=' + (Math.round((screen.height - $taillePlayerH) / 2)) + ',scrollbars=no,location=no,menubar=no, resizable=no, toolbar=no');
		popupWindows.focus();

		return false;
	}

	$('.tooltip-left').tooltip({
		position: {
			my: "left+10 center",
			at: "right center"
		}
	});

	$('.tooltip-right').tooltip({
		position: {
			my: "right-10 center",
			at: "left center"
		}
	});

	if(!isMobile()) {
		// find the div.fade elements and hook the hover event
		$('.fadeThis').hover(function() {
			// on hovering over find the element we want to fade *up*
			var fade = $('> .hover', this);
			var libelle = $('> .libelle', this);

			if (libelle.is(':animated')) {
				libelle.stop().fadeTo(500, 1);
			} else {
				libelle.fadeTo(500, 1);
			}

			// if the element is currently being animated (to fadeOut)...
			if (fade.is(':animated')) {
				// ...stop the current animation, and fade it to 1 from current position
				fade.stop().fadeTo(500, 1);
			} else {
				fade.fadeIn(500);
			}
		}, function() {
			var fade = $('> .hover', this);
			var libelle = $('> .libelle', this);

			if (fade.is(':animated')) {
				fade.stop().fadeTo(500, 0);
			} else {
				fade.fadeOut(500);
			}

			if (libelle.is(':animated')) {
				libelle.stop().fadeTo(500, 0.5);
			} else {
				libelle.fadeTo(500, 0.5);
			}
		});
	}

	$('.hd').click(function() {
		if (!hdStream && !mobileStream)
			return;

		if (hd) {
			hd = false;
			$('.hd').addClass('off');
			$('.hd').removeClass('on');
			startRadio();
		} else {
			hd = true;
			$('.hd').addClass('on');
			$('.hd').removeClass('off');
			startRadio();
		}

		createCookie('player_hd', hd ? 'active' : 'inactive', 30);
	});

	// get rid of the text
	$('.fadeThis > .hover').empty();

	if ($typeplayer == "big" || $typeplayer == "mini") {

		$("#closeShare").click(function() {

			$("#effectTitrage").animate({
				top: 0
			}, 500, function() {
				$("#mainTitrage").removeClass('on');
			});

		});

		$("#btnShare").click(function() {
			if ($("#mainTitrage").hasClass('on')) {
				$("#effectTitrage").animate({
					top: 0
				}, 500, function() {
					$("#mainTitrage").removeClass('on');
				});
			} else {
				$("#effectTitrage").animate({
					top: -128
				}, 500, function() {
					$("#mainTitrage").addClass('on');
				});
			}

		});

	} else {
		//VERSION MEDIUM

		$("#closeShare").click(function() {

			$("#mainTitrage").animate({
				height: 53,
				top: 224
			}, 500, function() {
				$("#mainTitrage").removeClass('on');
			});

		});

		
	}

	function isMobile() {
		var check = false;
		(function(a) {
			if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4)))
				check = true;
		})(navigator.userAgent || navigator.vendor || window.opera);
		return check;
	}

	if ($equalizer !== "0") {
		$(".bar").each(function(i) {
			fluctuate($(this));
		});
	}

});

function changeSize(targetWidth, targetHeight) {
	if (window.innerWidth || window.innerHeight) {
		var innerWidth = window.innerWidth,
			innerHeight = window.innerHeight;
	} else {
		var innerWidth = window.document.documentElement.clientWidth || window.document.body.clientWidth,
			innerHeight = window.document.documentElement.clientHeight || window.document.body.clientHeight;
	}

	if (innerWidth != targetWidth && innerHeight != targetHeight) {
		if (window.outerWidth || window.outerHeight) {
			var outerWidth = window.outerWidth,
				outerHeight = window.outerHeight,
				fixedwidth = targetWidth + outerWidth - innerWidth,
				fixedheight = targetHeight + outerHeight - innerHeight;
		} else {
			window.resizeTo(300, 300);

			var outerWidth = window.document.documentElement.clientWidth || window.document.body.clientWidth,
				outerHeight = window.document.documentElement.clientHeight || window.document.body.clientHeight,
				fixedwidth = targetWidth + 300 - outerWidth,
				fixedheight = targetHeight + 300 - outerHeight;
		}

		window.resizeTo(fixedwidth, fixedheight);
	}
}

function createCookie(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		var expires = "; expires=" + date.toGMTString();
	} else var expires = "";
	document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
}

function fluctuate(bar) {
	var hgt = Math.random() * 10;
	hgt += 1;
	var t = hgt * 30;

	bar.animate({
		height: hgt
	}, t, function() {
		fluctuate($(this));
	});
}