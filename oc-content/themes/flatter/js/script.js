// convert bytes into friendly format
function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0)
        return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
}
;

// check for selected crop region
function checkForm() {
    if (parseInt($('#w').val()))
        return true;
    $('.error').html('Please select a crop region and then press Upload').show();
    return false;
}
;

// update info by cropping (onChange and onSelect events handler)
function updateInfo(e) {
    $('#x').val(e.x);
    $('#y').val(e.y);
    $('#x2').val(e.x2);
    $('#y2').val(e.y2);
    $('#w').val(e.w);
    $('#h').val(e.h);
}
;

// clear info by cropping (onRelease event handler)
function clearInfo() {
    $('.info_img #w').val('');
    $('.info_img #h').val('');
}

// Create variables (in this scope) to hold the Jcrop API and image size
var jcrop_api, boundx, boundy;

function fileSelectHandler() {

    // get selected file
    var oFile = $('#image_file')[0].files[0];

    // hide all errors
    $('.error').hide();

    // check for image type (jpg and png are allowed)
    var rFilter = /^(image\/jpeg|image\/png)$/i;
    if (!rFilter.test(oFile.type)) {
        $('.error').html('Please select a valid image file (jpg and png are allowed)').show();
        return;
    }

    // check for file size
    if (oFile.size > 2500 * 10240) {
        $('.error').html('You have selected too big file, please select a one smaller image file').show();
        return;
    }

    // preview element
    var oImage = document.getElementById('preview');

    // prepare HTML5 FileReader
    var oReader = new FileReader();
    oReader.onload = function (e) {

        // e.target.result contains the DataURL which we can use as a source of the image
        oImage.src = e.target.result;
        oImage.onload = function () { // onload event handler
            $('#loader-icon').show();
            $('.step2').addClass('preview-img');
            // display step 2
            $('.step2').fadeIn(500);

            // display some basic image info
            var sResultFileSize = bytesToSize(oFile.size);
            $('#filesize').val(sResultFileSize);
            $('#filetype').val(oFile.type);
            $('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);

            // destroy Jcrop if it is existed
            if (typeof jcrop_api != 'undefined') {
                jcrop_api.destroy();
                jcrop_api = null;
                $('#preview').width(oImage.naturalWidth);
                $('#preview').height(oImage.naturalHeight);
            }

            setTimeout(function () {
                // initialize Jcrop
                $('#preview').Jcrop({
                    minSize: [16, 16], // min crop size
                    aspectRatio: 1, // keep aspect ratio 1:1
                    bgFade: true, // use fade effect
                    bgOpacity: .3, // fade opacity
                    onChange: updateInfo,
                    onSelect: updateInfo,
                    onRelease: clearInfo
                }, function () {

                    // use the Jcrop API to get the real image size
                    var bounds = this.getBounds();
                    boundx = bounds[0];
                    boundy = bounds[1];

                    // Store the Jcrop API in the jcrop_api variable
                    jcrop_api = this;
                });
                $('#loader-icon').hide();
                $('.step2').removeClass('preview-img');
            }, 3000);

        };

    };

    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
}
function checkFormCover() {
    if (parseInt($('#w_cover').val()))
        return true;
    $('.error').html('Please select a crop region and then press Upload').show();
    return false;
}
;
function updateInfoCover(e) {
    $('#x1_cover').val(e.x);
    $('#y1_cover').val(e.y);
    $('#x2_cover').val(e.x2);
    $('#y2_cover').val(e.y2);
    $('#w_cover').val(e.w);
    $('#h_cover').val(e.h);
}
;
function clearInfoCover() {
    $('.info #w_cover').val('');
    $('.info #h_cover').val('');
}
;
function fileSelectHandlerCover() {

    // get selected file
    var oFile = $('#image_file_cover')[0].files[0];

    // hide all errors
    $('.error').hide();

    // check for image type (jpg and png are allowed)
    var rFilter = /^(image\/jpeg|image\/png)$/i;
    if (!rFilter.test(oFile.type)) {
        $('.error').html('Please select a valid image file (jpg and png are allowed)').show();
        return;
    }

    // check for file size
    if (oFile.size > 2500 * 10240) {
        $('.error').html('You have selected too big file, please select a one smaller image file').show();
        return;
    }

    // preview element
    var oImage = document.getElementById('preview_cover');

    // prepare HTML5 FileReader
    var oReader = new FileReader();
    oReader.onload = function (e) {

        // e.target.result contains the DataURL which we can use as a source of the image
        oImage.src = e.target.result;
        oImage.onload = function () { // onload event handler
            $('#loader-icon_cover').show();
            $('.step2').addClass('preview-img');
            // display step 2
            $('.step2').fadeIn(500);

            // display some basic image info
            var sResultFileSize = bytesToSize(oFile.size);
            $('#filesize_cover').val(sResultFileSize);
            $('#filetype_cover').val(oFile.type);
            $('#filedim_cover').val(oImage.naturalWidth + ' x ' + (2 * (oImage.naturalHeight)));

            // destroy Jcrop if it is existed
            if (typeof jcrop_api != 'undefined') {
                jcrop_api.destroy();
                jcrop_api = null;
                $('#preview_cover').width(oImage.naturalWidth);
                $('#preview_cover').height(oImage.naturalHeight);
            }

            setTimeout(function () {
                // initialize Jcrop
                $('#preview_cover').Jcrop({
                    minSize: [600, 300], // min crop size
                    aspectRatio: 2, // keep aspect ratio 1:1
                    bgFade: true, // use fade effect
                    bgOpacity: .3, // fade opacity
                    onChange: updateInfoCover,
                    onSelect: updateInfoCover,
                    onRelease: clearInfoCover
                }, function () {

                    // use the Jcrop API to get the real image size
                    var bounds = this.getBounds();
                    boundx = bounds[0];
                    boundy = bounds[1];

                    // Store the Jcrop API in the jcrop_api variable
                    jcrop_api = this;
                });
                $('#loader-icon_cover').hide();
                $('.step2').removeClass('preview-img');
            }, 3000);

        };

    };

    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
}