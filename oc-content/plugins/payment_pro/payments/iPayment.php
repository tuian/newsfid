<?php

interface iPayment
{
    public static function button($products, $extra);
    public static function processPayment();
}