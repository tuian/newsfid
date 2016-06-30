// variable to hold request
var request;
var productList = 'div.ad_list';
var $productList = $(productList);

var paginate = 'div.paginate';
var $paginate = $(paginate);

var filterForm = 'div.filters form';
var $filterForm = $(filterForm);

var breadcrumbs = 'div.breadcrumb';
var $breadcrumbs = $('div.breadcrumb');

// url, that way is the simpliest?
var home = $(breadcrumbs+' ul li:first-child a').attr('href');
var divPlug = 'div#plug';

var categoryCheckboxes = 'div.chbx';

var sortBy = 'p.see_by a';

$(document).ready(function () {
	// add loader
	addPlug();
	
	// when form inputs and selcets changes values (looses focus)
	$(filterForm+' input, '+filterForm+' select, input[name="sPattern"]').live('change' , function(event){
		ajaxSearch($filterForm, 1, event);
	});
	
	// click on pagination
	$(paginate+' a').live('click', function (event) {
		var iPage = getIPage($(this));
		ajaxSearch($filterForm, iPage, event);
	});
	
	// click on category checkboxes
	$(categoryCheckboxes).live('click', function(event) {
		ajaxSearch($filterForm, 1, event);
	});
	
	$( "[id$='range']" ).on( "slidechange", function( event, ui ) {
		ajaxSearch($filterForm, 1, event);
	});
	
	// click on sort
	$(sortBy).live('click', function (e) {
		var href = $(this).attr('href');
		var found = href.indexOf('sOrder');
		var params = href.substring(found, found.length);
		
		// non friendly urls
		if(params.indexOf('&') >= 0){
			var vars = params.split('&');
			var sOrder = vars[0].replace('sOrder=', '');
			var iOrderType = vars[1].replace('iOrderType=', '');
		}
		else if(params.indexOf('/') >= 0){
			var vars = params.split('/');
			var sOrder = vars[0].replace('sOrder,', '');
			var iOrderType = vars[1].replace('iOrderType,', '');
		}
		if(typeof vars !== 'undefined'){
		
			var sOrderInput = $('input[name="sOrder"]');
			var iOrderTypeInput = $('input[name="iOrderType"]');
		
			sOrderInput.val(sOrder);
			iOrderTypeInput.val(iOrderType);
			
			ajaxSearch($filterForm, 1, event);
			
			//prevent default action on link
			return false;
		}
		
	});
	
	//hide filter button
	$(filterForm+' button[type="submit"]').parent().parent().hide();
});

$(document).ajaxSuccess(function () {
	// add loader
	addPlug();
});

function ajaxSearch(form, pagination, event){
	if (request) {
		request.abort();
	}
	//show preloader
	$(divPlug).fadeIn();
	
	// prevent default posting of form
	event.preventDefault();
		
	// setup some local variables
	var $form = form;
	// let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");
	// serialize the data in the form
	var serializedData = $form.serialize();
	serializedData += '&iPage='+pagination;
	
	// let's disable the inputs for the duration of the ajax request
	$inputs.attr("disabled", "disabled");
	
	// fire off the request to /form.php
	var request = $.ajax({
		//url: "<?php echo osc_base_url(true); ?>",
		url: $form.attr('action'),
		type: "get",
		data: serializedData,
		dataType: "html"
	});

	// callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
	
		var results = $(response).find(productList).html();
		var pagination = $(response).find(paginate).html();
		$productList.html(results);
		$(paginate).html(pagination);
	});

	// callback handler that will be called on failure
	// also, when search return 0 results, osclass return 404, so this will display info that there is no listings
	request.fail(function (jqXHR, textStatus, errorThrown){
		$productList.html('<p id="noresults">There are no results</p>');
		$paginate.html(' ');
	});

	// callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// reenable the inputs
		$inputs.prop("disabled", false);
		
		//scroll to top
		$('html, body').animate({
			scrollTop: $breadcrumbs.offset().top
		}, 1000, function () {$(divPlug).fadeOut();});
	});
}

function addPlug(){
	$('<div/>', {
		id: 'plug',
		html: '<img src="'+home+'oc-content/plugins/ajax_search/ajax-loader.gif">'
	}).prependTo(productList);
}

function getIPage(a){

	var iPage = a.text();
	if(isNaN(iPage)){
		var current = $(paginate+' > ul > li > span').text();
		if(iPage == '<')
			return parseInt(current)-1;
		return parseInt(current)+1;
	}else
		return iPage;
}