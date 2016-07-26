<?php

function payment_pro_item_paid($item, $data, $invoiceId) {
    if(isset($item['id']) && (!isset($item['item_id']) || trim($item['item_id'])=='')) {
        $tmp = explode("-", $item['id']);
        if(count($tmp)>1) {
            $item['item_id'] = $tmp[1];
        }
    }
    if (substr($item['id'], 0, 3) == 'PUB') {
        ModelPaymentPro::newInstance()->payPublishFee($item['item_id'], $invoiceId);
    } else if (substr($item['id'], 0, 3) == 'PRM') {
        ModelPaymentPro::newInstance()->payPremiumFee($item['item_id'], $invoiceId);
    } else if (substr($item['id'], 0, 3) == 'TOP') {
        Item::newInstance()->update(array('dt_pub_date' => date('Y-m-d H:i:s')), array('pk_i_id' => $item['item_id']));
    } else if (substr($item['id'], 0, 3) == 'HLT') {
        ModelPaymentPro::newInstance()->payHighlightFee($item['item_id'], $invoiceId);
    } else if (substr($item['id'], 0, 3) == 'WLT') {
        $pack = ModelPaymentPro::newInstance()->pack(substr($item['id'], 4));
        if(isset($pack['i_amount'])) {
            ModelPaymentPro::newInstance()->addWallet($data['user'], $pack['i_amount']/1000000);
        }
    }
}
osc_add_hook('payment_pro_item_paid', 'payment_pro_item_paid');

function payment_pro_item_unpaid($item, $data, $invoiceId) {
    if(isset($item['id']) && (!isset($item['item_id']) || trim($item['item_id'])=='')) {
        $tmp = explode("-", $item['id']);
        if(count($tmp)>1) {
            $item['item_id'] = $tmp[1];
        }
    }
    if (substr($item['id'], 0, 3) == 'PUB') {
        ModelPaymentPro::newInstance()->unpayPublishFee($item['item_id'], $invoiceId);
    } else if (substr($item['id'], 0, 3) == 'PRM') {
        ModelPaymentPro::newInstance()->premiumOff($item['item_id']);
    } else if (substr($item['id'], 0, 3) == 'TOP') {
        //Item::newInstance()->update(array('dt_pub_date' => date('Y-m-d H:i:s')), array('pk_i_id' => $item['item_id']));
    } else if (substr($item['id'], 0, 3) == 'HLT') {
        ModelPaymentPro::newInstance()->unpayHighlightFee($item['item_id'], $invoiceId);
    } else if (substr($item['id'], 0, 3) == 'WLT') {
        $pack = ModelPaymentPro::newInstance()->pack(substr($item['id'], 4));
        if(isset($pack['i_amount'])) {
            ModelPaymentPro::newInstance()->addWallet($data['user'], -$pack['i_amount']/1000000);
        }
    }
}
osc_add_hook('payment_pro_item_unpaid', 'payment_pro_item_unpaid');

function payment_pro_cart_add_filter($item) {
    $str = substr($item['id'], 0, 3);
    if($str=='PRM' || $str=='PUB' || $str=='TOP') {
        $item['quantity'] = 1;
    }
    return $item;
}
osc_add_filter('payment_pro_add_to_cart', 'payment_pro_cart_add_filter');

function payment_pro_cart_quantity_filter($quantity, $item) {
    $str = substr($item['id'], 0, 3);
    if($str=='PRM' || $str=='PUB' || $str=='TOP') {
        $quantity = 1;
    }
    return $quantity;
}
osc_add_filter('payment_pro_add_quantity', 'payment_pro_cart_quantity_filter');
