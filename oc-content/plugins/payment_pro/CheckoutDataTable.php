<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');


    class CheckoutDataTable extends DataTable
    {

        public function __construct()
        {
            osc_add_filter('datatable_payment_pro_class', array(&$this, 'row_class'));
        }

        public function table($products)
        {
            $this->addTableHeader();
            $this->processData($products);
            return $this->getData();
        }

        private function addTableHeader()
        {

            $this->addColumn('id', __('Code', 'payment_pro'));
            $this->addColumn('description', __('Product', 'payment_pro'));
            $this->addColumn('amount', __('Price', 'payment_pro'));
            $this->addColumn('quantity', __('Quantity', 'payment_pro'));
            $this->addColumn('total', __('Total', 'payment_pro'));
            $this->addColumn('delete', __('Delete', 'payment_pro'));

            $dummy = &$this;
            osc_run_hook("payment_pro_table", $dummy);
        }
        
        private function processData($products)
        {
            if(!empty($products)) {

                $subtotal = 0;
                $taxes = 0;
                $total = 0;
                foreach($products as $aRow) {
                    $row     = array();
                    $row['id'] = $aRow['id'];
                    $row['description'] = $aRow['description'];
                    $row['amount'] = payment_pro_format_price(1000000*$aRow['amount'], osc_get_preference('currency', 'payment_pro'));
                    $row['quantity'] = $aRow['quantity'];
                    $row['total'] = payment_pro_format_price(1000000*$aRow['amount']*$aRow['quantity'], osc_get_preference('currency', 'payment_pro'));
                    $row['delete'] = '<a href="' . osc_route_url('payment-pro-cart-delete', array('id' => $aRow['id'])) . '" >' . __('Delete', 'payment_pro') . '</a>';

                    $row = osc_apply_filter('payment_pro_processing_row', $row, $aRow);

                    $this->addRow($row);
                    $this->rawRows[] = $aRow;
                    $subtotal += $aRow['amount']*$aRow['quantity'];
                    $taxes += $aRow['amount']*$aRow['quantity']*($aRow['tax']/100);
                    $total += $aRow['amount']*$aRow['quantity']*((100+$aRow['tax'])/100);
                }

                if (osc_get_preference('show_taxes', 'payment_pro')==1 || $taxes) {
                    // SUBTOTAL
                    $row = array();
                    $row['id'] = '';
                    $row['description'] = '';
                    $row['amount'] = '';
                    $row['quantity'] = '<b>' . __('Subtotal', 'payment_pro') . '</b>';
                    $row['total'] = '<b>' . payment_pro_format_price(1000000 * $subtotal, osc_get_preference('currency', 'payment_pro')) . '</b>';
                    $row['delete'] = '';
                    $this->addRow($row);

                    // TAXES
                    $row = array();
                    $row['id'] = '';
                    $row['description'] = '';
                    $row['amount'] = '';
                    $row['quantity'] = '<b>' . __('Taxes', 'payment_pro') . '</b>';
                    $row['total'] = '<b>' . payment_pro_format_price(1000000 * $taxes, osc_get_preference('currency', 'payment_pro')) . '</b>';
                    $row['delete'] = '';
                    $this->addRow($row);
                }

                // TOTAL
                $row     = array();
                $row['id'] = '';
                $row['description'] = '';
                $row['amount'] = '';
                $row['quantity'] = '<b>' . __('Total', 'payment_pro') . '</b>';
                $row['total'] = '<b>' . payment_pro_format_price(1000000*$total, osc_get_preference('currency', 'payment_pro')) . '</b>';
                $row['delete'] = '';
                $this->addRow($row);
                //$this->rawRows[] = $row;
            }
        }
        
    }

?>