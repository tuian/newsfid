<?php

require '../../../oc-load.php';
require 'functions.php';

Braintree_Configuration::environment(osc_get_preference('braintree_sandbox', 'payment_pro'));
Braintree_Configuration::merchantId(payment_pro_decrypt(osc_get_preference('braintree_merchant_id', 'payment_pro')));
Braintree_Configuration::publicKey(payment_pro_decrypt(osc_get_preference('braintree_public_key', 'payment_pro')));
Braintree_Configuration::privateKey(payment_pro_decrypt(osc_get_preference('braintree_private_key', 'payment_pro')));

$data = payment_pro_get_custom(Params::getParam('extra'));

//if (!isset($data['items']) || !isset($data['amount']) || $data['amount'] <= 0) {
//    return PAYMENT_PRO_FAILED;
//}
//$status = payment_pro_check_items($data['items'], $data['amount']);

$result = Braintree_Transaction::sale(array(
            'amount' => Params::getParam('amount'),
            'creditCard' => array(
                'number' => Params::getParam('braintree_number'),
                'cvv' => Params::getParam('braintree_cvv'),
                'expirationMonth' => Params::getParam('braintree_month'),
                'expirationYear' => Params::getParam('braintree_year'),
            ),
//            'options' => array(
//                'submitForSettlement' => true
//            )
        ));
if ($result->success == 1) {

    Params::setParam('braintree_transaction_id', $result->transaction->id);
    $exists = ModelPaymentPro::newInstance()->getPaymentByCode($result->transaction->id, 'BRAINTREE', PAYMENT_PRO_COMPLETED);
    if (isset($exists['pk_i_id'])) {
        return PAYMENT_PRO_ALREADY_PAID;
    }
    // SAVE TRANSACTION LOG
//    $invoiceId = ModelPaymentPro::newInstance()->saveInvoice(
//            $result->transaction->id, // transaction code
//            $result->transaction->amount, //amount
//            $status, $result->transaction->currencyIsoCode, //currency
//            $data['email'], // payer's email
//            $data['user'], //user
//            'BRAINTREE', $data['items']); //source
//
//    if ($status == PAYMENT_PRO_COMPLETED) {
//        foreach ($data['items'] as $item) {
//            $tmp = explode("-", $item['id']);
//            $item['item_id'] = $tmp[count($tmp) - 1];
//            osc_run_hook('payment_pro_item_paid', $item, $data, $invoiceId);
//        }
//    }


    echo 1;
} else {
    echo 0;
}
?>