<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webhook extends CI_Controller {
    public function post(){
        ?>
        <form action="<?=base_url('webhook/check');?>" method="POST">
            <input class="input" type="text" name="txn_id">
            <button>submit</button>
        </form>
        <?php
    }
    public function check(){
        require_once(APPPATH.'libraries/cpapi.php');
        $txn_id = $_POST['txn_id'];

        $this->load->model('walletm', '',TRUE);
        $update_payment = $this->walletm->get_spesific_deposit($txn_id);
        $order_currency = $update_payment['tbdr_coin_type'];
        $order_total = $update_payment['tbdr_amount_coin'];
 
        // Fill these in with the information from your CoinPayments.net account.
        $cp_merchant_id = 'e9e2519f51bdf3eccee4d30ecccc461d';
        $cp_ipn_secret = 'rupakarawdipnsecret';
        $cp_debug_email = 'recover.null@gmail.com';

        //These would normally be loaded from your database, the most common way is to pass the Order ID through the 'custom' POST field.
        

        function errorAndDie($error_msg) {
            global $cp_debug_email;
            if (!empty($cp_debug_email)) {
                $report = 'Error: '.$error_msg."\n\n";
                $report .= "POST Data\n\n";
                foreach ($_POST as $k => $v) {
                    $report .= "|$k| = |$v|\n";
                }
                mail($cp_debug_email, 'CoinPayments IPN Error', $report);
            }
            die('IPN Error: '.$error_msg);
        }

        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
            errorAndDie('IPN Mode is not HMAC');
        }

        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            errorAndDie('No HMAC signature sent.');
        }

        $request = file_get_contents('php://input');
        if ($request === FALSE || empty($request)) {
            errorAndDie('Error reading POST data');
        }

        if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) {
            errorAndDie('No or incorrect Merchant ID passed');
        }

        $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret));
        if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
        //if ($hmac != $_SERVER['HTTP_HMAC']) { <-- Use this if you are running a version of PHP below 5.6.0 without the hash_equals function
            errorAndDie('HMAC signature does not match');
        }

        // HMAC Signature verified at this point, load some variables.

        $ipn_type = $_POST['ipn_type'];
        $amount1 = floatval($_POST['amount1']);
        $amount2 = floatval($_POST['amount2']);
        $currency1 = $_POST['currency1'];
        $currency2 = $_POST['currency2'];
        $status = intval($_POST['status']);
        $status_text = $_POST['status_text'];

        if ($ipn_type != 'button') { // Advanced Button payment
            die("IPN OK: Not a button payment");
        }

        //depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point

        // Check the original currency to make sure the buyer didn't change it.
        if ($currency1 != $order_currency) {
            errorAndDie('Original currency mismatch!');
        }

        // Check amount against order total
        if ($amount1 < $order_total) {
            errorAndDie('Amount is less than order total!');
        }
    
        if ($status >= 100 || $status == 2) {
            // payment is complete or queued for nightly payout, success
            $this->walletm->set_status_webhook($txn_id, 100);
            echo '100';
        } else if ($status < 0) {
            //payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent
            $this->walletm->set_status_webhook($txn_id, -1);
            echo '-1';
        } else {
            //payment is pending, you can optionally add a note to the order page
            $this->walletm->set_status_webhook($txn_id, 0);
            echo '0';
        }
        die('IPN OK');
    }
}
?>