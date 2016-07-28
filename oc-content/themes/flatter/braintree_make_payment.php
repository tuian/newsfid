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
    echo 1;
} else {
    echo $result->_attributes[message];
}
?>