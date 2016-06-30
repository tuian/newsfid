<script type="text/javascript">
    $(document).ready(function() {
        $(".js-confirm").on("click", function(e) {
            var link = this;

            e.preventDefault();

            $("<div>Are you sure you want to continue and remove this profile picture? This can't be undone.</div>").dialog({
                buttons: {
                    "Ok": function() {
                        window.location = link.href;
                    },
                    "Cancel": function() {
                        $(this).dialog("close");
                    }
                }
            });
        });
    });
</script>

<style type="text/css">
.box {
    padding: 10px;
    background-color: #efefef;
}

.pull-right {
    float: left !important;
}

.edit-photo {
    width:530px;
}
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $("form[name='register']").attr("enctype", "multipart/form-data");
    });
</script>
<div class="form-row"></div>
<div class="form-row box pull-right">
    <div> <img src="<?php echo mdh_avatar_preview_url(Params::getParam("id")) ?>"></div>
    <a href="<?php echo mdh_avatar_delete_resource_url(Params::getParam("id")); ?>" class="delete js-confirm" >Delete this profile picture</a>
</div>
<div class="clear"></div>
<div class="form-row">
</div>
<div class="form-row">
    <div class="edit-photo box">
        <h2>Edit the profile picture</h2>
        <input type="file" name="user_photo[]">
    </div>
</div>