<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {
    public function primary_deposit(){
        $usd_amount = $_POST['depo_amount'];
        $coin_type = $_POST['depo_coin'];

        $this->load->model('walletm', '',TRUE);
        $create_payment = $this->walletm->deposit($usd_amount, $coin_type);
        //header("$this->walletm->deposit($usd_amount, $coin_type)['status_url']");
        //print_r($create_payment);
        redirect('user/mywallet');
    }
}

?>