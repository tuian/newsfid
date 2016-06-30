
<?php
osc_add_hook(osc_ajax_test1, 'test1');
function test1() {

    print_r($_REQUEST);
    print_r($_SESSION);
}
