<?php
require_once(APPPATH.'libraries/cpapi.php');
class Walletm extends CI_Model {

    public $usd_amount;
    public $coin_type;

    function __construct()
    {
        parent::__construct();
    }
    
    public function get_primary_wallet_balance($user_id){
        //get credit trx
        $this->db->select('SUM(tbpw_amount) as TotalCreditBalance');
        $this->db->from('tbpw_primary_wallet');
        $this->db->where('tbpw_type', 0);
        $this->db->where('tbu_user_id', $user_id);
        $result_credit = $this->db->get()->row_array();

        $this->db->select('SUM(tbpw_amount) as TotalDebitBalance');
        $this->db->from('tbpw_primary_wallet');
        $this->db->where('tbpw_type', -1);
        $this->db->where('tbu_user_id', $user_id);
        $result_debit = $this->db->get()->row_array();

        $balance = $result_credit['TotalCreditBalance']-$result_debit['TotalDebitBalance'];

        return $balance;
    }

    public function get_mutation_primary_wallet($user_id){
        $this->db->select('*');
        $this->db->from('tbpw_primary_wallet');
        $this->db->where('tbu_user_id', $user_id);
        $this->db->order_by('tbpw_time DESC');
        $result_mutation = $this->db->get()->result_array();

        return $result_mutation;
    }

    public function add_to_primary_wallet($txn_id, $amount){
        $data_add_to_primary = array(
            'tbpw_tnxid' => $txn_id,
            'tbpw_amount' => $amount,
            'tbpw_type' => 0,
            'tbu_user_id' => 1
        );
        $this->db->insert('tbpw_primary_wallet', $data_add_to_primary);
    }

    public function get_deposit_activity($user_id){
        $this->db->select('*');
        $this->db->from('tbdr_deposit_request');
        $this->db->where('tbu_user_id', $user_id);
        $this->db->order_by('tbdr_time_start DESC');
        $result_query = $this->db->get()->result_array();

        return $result_query;
    }

    public function get_specific_deposit($txn_id){
        $this->db->select('*');
        $this->db->from('tbdr_deposit_request');
        $this->db->where('tbdr_depoid', $txn_id);
        $result_query = $this->db->get()->row_array();

        return $result_query;
    }

    public function set_deposit_status($txn_id, $status_new){
        $this->db->set('tbdr_status', $status_new);
        $this->db->where('tbdr_depoid', $txn_id);
        $this->db->update('tbdr_deposit_request');
    }

    

    //Coin Payment API
    public function deposit($amount, $coin){
        
       
        $this->usd_amount = $amount;
        $this->coin_type = $coin;

        $create_payment = [
            'amount' => $this->usd_amount,
            'currency1' => "USD",
            'currency2' => $this->coin_type,
            'buyer_email' => "abirutama@gmail.com",
            'item' => "Test Pembayaran Model",
            'address' => "",
            'ipn_url' => "localhost/cp/webhook.php"
        ];
        $result = coinpayments_api_call('create_transaction',$create_payment);

        if($result['error']=='ok'){
            $data_save_payment = array(
                'tbdr_amount_usd' => $this->usd_amount,
                'tbdr_amount_coin' => $result['result']['amount'],
                'tbdr_coin_type' => $this->coin_type,
                'tbdr_depoto' => $result['result']['address'],
                'tbdr_depoid' => $result['result']['txn_id'],
                'tbdr_status' => 0,
                'tbdr_statusurl' => $result['result']['status_url'],
                'tbu_user_id' => 1
            );
            $this->db->insert('tbdr_deposit_request', $data_save_payment);
            return print_r($result);
        }
    }

    public function cp_get_tx_info($txn_id){
        $this->txn_id = $txn_id;
        $check_txn = [
            'txid' => $this->txn_id,
            'full' => 0
        ];
        $result = coinpayments_api_call('get_tx_info',$check_txn);
        return $result;
    }
      
}

?>