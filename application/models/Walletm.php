<?php

class Walletm extends CI_Model {

    public $usd_amount;
    public $coin_type;

    function __construct()
    {
        parent::__construct();
    }

    public function deposit($amount, $coin){
        require_once(APPPATH.'libraries/cpapi.php');
       
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
                'tbdr_status' => 1,
                'tbdr_statusurl' => $result['result']['status_url'],
                'tbu_user_id' => 1
            );
            $this->db->insert('tbdr_deposit_request', $data_save_payment);
            return print_r($result);
        }
    }

    public function get_deposit_activity($user_id){
        $this->db->select('*');
        $this->db->from('tbdr_deposit_request');
        $this->db->where('tbu_user_id', $user_id);
        $this->db->order_by('tbdr_time_start DESC');
        $result_query = $this->db->get()->result_array();

        return $result_query;
    }

    public function get_spesific_deposit($txn_id){
        $this->db->select('*');
        $this->db->from('tbdr_deposit_request');
        $this->db->where('tbdr_depoid', $txn_id);
        $result_query = $this->db->get()->row_array();

        return $result_query;
    }
}

?>