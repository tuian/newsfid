<?php
require '../../../oc-load.php';
require 'functions.php';

$search_newsfid = $_REQUEST['search_newsfid_text'];


$user_search_data = new DAO();
$user_search_data->dao->select('user.pk_i_id as user_id, user.s_name as user_name, user.s_email, user.fk_i_city_id, user.fk_c_country_code');
$user_search_data->dao->from(sprintf('%st_user AS user', DB_TABLE_PREFIX));
$user_search_data->dao->where(sprintf("user.s_name LIKE '%s'", '%' . $search_newsfid . '%'));
$user_search_data->dao->orderBy('user.s_name', 'ASC');
//$user_search_data->dao->join(sprintf('%st_user_resource AS user_resource', DB_TABLE_PREFIX), 'user.pk_i_id = user_resource.fk_i_user_id', 'LEFT');

$user_search_result = $user_search_data->dao->get();
$user_search_array = $user_search_result->result();
//print_r($user_search_array);
//die();
?>

<div id="newsfid-search" class="modal fade" role="dialog">
    <div class="modal-dialog search-popup">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" style="right: 200px;top: 65px;position: absolute;background-color: grey;color: white;border-radius: 50%;width: 25px;padding-bottom: 3px; padding-left: 1px">&times;</button>
                <h5><b style="font-weight: 600;margin-left: 8px;">Search Newsfid</b></h5>
                <input type="text" class="search-modal-textbox search_newsfid_text" value="<?php echo $search_newsfid; ?>" placeholder="Start typing...">
                <h1><b style="font-size: 70px; font-weight: 700;"><?php echo $search_newsfid; ?></b></h1>
                <?php if (!$user_search_array): ?>
                    <h5> Your Search did not return any results. Please try again. </h5>

                <?php endif; ?>
            </div>
            <div class="modal-body col-md-offset-2 ">
                <div class="col-md-12">
                    <label  class="col-md-4  search-list">User</label>
                    <label class="col-md-4 search-list">Articles</label>
                </div>
                <?php if ($user_search_array): ?>
                    <div class="search-height col-md-12 padding-0">
                        <div class="col-md-4">
                            <?php foreach ($user_search_array as $user) : ?>
                                <div class="col-md-12"><?php echo $user['user_name']; ?></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="col-md-4">
                            <?php foreach ($user_search_array as $user) : ?>
                                <div class="col-md-12"><?php echo $user['user_name']; ?></div>
                            <?php endforeach; ?> 
                        </div>
                    </div>   
                <?php endif; ?>
            </div>

        </div>

    </div>

</div>  

<script>
    $(document).ready(function () {
        $("#newsfid-search").click(function () {
            $("input").val("");
        });
    });
</script>
