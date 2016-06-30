jQuery(document).ready(function($) {
    $(".watchlist").click(function() {
        var id = $(this).attr("id");
        var dataString = 'id='+ id ;
        var parent = $(this);

        $(this).fadeOut(200);
        $.ajax({
            type: "POST",
            url: watchlist_url,
            data: dataString,
            cache: false,

            success: function(html) {
            parent.html(html);
            parent.fadeIn(200);
            }
        });
    });
	
	$(".watchlist2").click(function() {
        var id = $(this).attr("id");
        var dataString = 'id='+ id ;
        var parent = $(this);

        $(this).fadeOut(100);
        $.ajax({
            type: "POST",
            url: watchlist_url2,
            data: dataString,
            cache: false,

            success: function(html) {
            parent.html(html);
            parent.fadeIn(100);
            }
        });
    });
});