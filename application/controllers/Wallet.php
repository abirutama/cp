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
    public function check_deposit($txn_id){
        $this->load->model('walletm', '',TRUE);
        $cp_check = $this->walletm->cp_get_tx_info($txn_id);
        
        if($cp_check['error']=="ok"){
            $specific_deposit = $this->walletm->get_specific_deposit($txn_id);

            if(intval($specific_deposit['tbdr_status']) !== intval($cp_check['result']['status'])){
                $this->walletm->set_deposit_status($txn_id, $cp_check['result']['status']);
                if(intval($cp_check['result']['status'])==100){
                    $this->walletm->add_to_primary_wallet($txn_id, $specific_deposit['tbdr_amount_usd']);
                    $this->session->set_flashdata('success_message', 'Deposit Payment is Completed!');
                    redirect('user/mywallet#deposit-withdraw-act');
                }elseif(intval($cp_check['result']['status'])==-1){
                    $this->session->set_flashdata('error_message', 'Payment is Timeout. Deposit Cancelled!');
                    redirect('user/mywallet#deposit-withdraw-act');
                }else{
                    redirect('user/mywallet');
                }
            }else{
                $this->session->set_flashdata('error_message', 'No Update for Deposit Status!');
                redirect('user/mywallet#deposit-withdraw-act');
            }
        }else{
            echo "Transaction Not Found!";
        }
    }
}

?>