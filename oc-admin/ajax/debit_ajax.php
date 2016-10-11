
<?php

require '../../oc-load.php';
require '../../oc-content/themes/flatter/functions.php';

if ($_REQUEST['action'] == 'debit' || $_REQUEST['user_id'] || $_REQUEST['amount']):
    $amount = (int) ($_REQUEST['amount']);
    $user = $_REQUEST['user_id'];
    $user_data = new DAO();
    $user_data->dao->select('*');
    $user_data->dao->from('oc_t_user_pack');
    $user_data->dao->where('user_id', $user);
    $result = $user_data->dao->get();
    $user_result = $result->row();
    $user_debit = $user_result['remaining_post'] - $amount;
    $user_data->dao->update('oc_t_user_pack', array('remaining_post' => $user_debit), array('user_id' => $user));
    echo 'success';
else:
    echo 'fail';
endif;
