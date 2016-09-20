<?php

require '../../../oc-load.php';
require 'functions.php';

$db_prefix = DB_TABLE_PREFIX;
$user = get_user_data(osc_logged_user_id());
Braintree_Configuration::environment(osc_get_preference('braintree_sandbox', 'payment_pro'));
Braintree_Configuration::merchantId(payment_pro_decrypt(osc_get_preference('braintree_merchant_id', 'payment_pro')));
Braintree_Configuration::publicKey(payment_pro_decrypt(osc_get_preference('braintree_public_key', 'payment_pro')));
Braintree_Configuration::privateKey(payment_pro_decrypt(osc_get_preference('braintree_private_key', 'payment_pro')));

//$status = payment_pro_check_items($data['items'], $data['amount']);

$result = Braintree_Transaction::sale(array(
            'amount' => Params::getParam('amount'),
            'creditCard' => array(
                'number' => Params::getParam('braintree_number'),
                'cvv' => Params::getParam('braintree_cvv'),
                'expirationMonth' => Params::getParam('braintree_month'),
                'expirationYear' => Params::getParam('braintree_year'),
            ),
            'options' => array(
                'submitForSettlement' => true
            )
        ));
if (Params::getParam('subscribe')):
    if ($result->success) {
        $transaction_array['dt_date'] = date("Y-m-d H:i:s");
        $transaction_array['s_code'] = $result->transaction->id;
        $transaction_array['i_amount'] = $result->transaction->amount;
        $transaction_array['s_currency_code'] = $result->transaction->currencyIsoCode;
        $transaction_array['s_email'] = $user['s_email'];
        $transaction_array['fk_i_user_id'] = $user['user_id'];
        $transaction_array['s_source'] = 'BRAINTREE';
        $transaction_array['i_status'] = '1';

        $transaction_data = new DAO();
        $transaction_data->dao->insert("{$db_prefix}t_payment_pro_invoice", $transaction_array);

        $user_data = new DAO();
        $user_data->dao->update("{$db_prefix}t_user", array('user_type' => '1', 'valid_date' => date('d/m/Y', strtotime("+1 months", strtotime("NOW")))), array('pk_i_id' => $user['user_id']));

        echo 1;
    } else {
        echo $result->_attributes[message];
    }
endif;
if (Params::getParam('premium') == 'premium'):
    if ($result->success) {
        $transaction_array['dt_date'] = date("Y-m-d H:i:s");
        $transaction_array['s_code'] = $result->transaction->id;
        $transaction_array['i_amount'] = $result->transaction->amount;
        $transaction_array['s_currency_code'] = $result->transaction->currencyIsoCode;
        $transaction_array['s_email'] = $user['s_email'];
        $transaction_array['fk_i_user_id'] = $user['user_id'];
        $transaction_array['s_source'] = 'BRAINTREE';
        $transaction_array['i_status'] = '1';

        $transaction_data = new DAO();
        $transaction_data->dao->insert("{$db_prefix}t_payment_pro_invoice", $transaction_array);

        $user_premium_array['pack_id'] = Params::getParam('pack_id');
        $user_premium_array['user_id'] = Params::getParam('user_id');
        $user_premium_array['premium_post'] = Params::getParam('posts');
        $user_premium_array['created'] = date("Y-m-d H:i:s");
        $user_premium_array['remaining_post'] = Params::getParam('posts');

        $premium_user = new DAO();
        $premium_user->dao->insert("{$db_prefix}t_user_pack", $user_premium_array);

        echo 1;
    } else {
        echo $result->_attributes[message];
    }
endif;
?>