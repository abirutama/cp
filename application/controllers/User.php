<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function investment(){
        $this->load->view('user/user_header');
        $this->load->view('user/index');
        $this->load->view('user/user_footer');
    }

    public function mywallet(){
        $this->load->model('walletm', '',TRUE);
        $deposit_history = $this->walletm->get_deposit_activity(1);
        //print_r($deposit_history);
        $data['deposit_history'] = $deposit_history;

        $this->load->view('user/user_header');
        $this->load->view('user/mywallet', $data);
        $this->load->view('user/user_footer');
    }

	public function pay()
	{
        require_once(APPPATH.'libraries/cpapi.php');
        //$this->load->view('welcome_message');
        
    $create_payment = [
        'amount' => 0.1,
        'currency1' => "USD",
        'currency2' => "LTCT",
        'buyer_email' => "abirutama@gmail.com",
        'item' => "Test Pembayaran",
        'address' => "",
        'ipn_url' => "https://rupakara.com/cp/webhook/check"
    ];

    $check_transaction = [
        'txid' => "CPEL321CUQQNTTTLORZIP6KO1W"
    ];
    //Get current coin exchange rates
    //print_r(coinpayments_api_call('create_transaction',$create_payment));
    print_r(coinpayments_api_call('get_tx_info',$check_transaction));

	}
}
