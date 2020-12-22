<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function investment(){
        $this->load->model('investm', '',TRUE);
        $get_plan_investment = $this->investm->get_plan_investment();
        $get_user_invest_running = $this->investm->get_spesific_user_investment(1,true);
        $get_user_invest_past = $this->investm->get_spesific_user_investment(1,false);

        $data['plan_investment'] = $get_plan_investment;
        $data['user_investment'] = $get_user_invest_running;
        $data['user_investment_past'] = $get_user_invest_past;

        $this->load->view('user/user_header');
        $this->load->view('user/index',$data);
        $this->load->view('user/user_footer');
    }

    public function mywallet(){
        $this->load->model('walletm', '',TRUE);
        $deposit_history = $this->walletm->get_deposit_activity(1);
        $get_primary_wallet_balance = $this->walletm->get_primary_wallet_balance(1);
        $get_mutation_primary_wallet = $this->walletm->get_mutation_primary_wallet(1);
        //print_r($deposit_history);
        $data['deposit_history'] = $deposit_history;
        $data['wallet_balance'] = $get_primary_wallet_balance;
        $data['wallet_mutation'] = $get_mutation_primary_wallet;

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