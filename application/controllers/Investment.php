<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Investment extends CI_Controller {
    public function start_investment($invest_plan_id){
        $this->load->model('investm', '',TRUE);
        //get detail data from (invest_plan_id)
        $choosed_plan = $this->investm->get_specific_plan_investment($invest_plan_id);
        if($choosed_plan){
            $this->load->model('walletm', '',TRUE);
            //user input to start invest
            $input_capital = $_POST['capital_invest'];
            //get from (user_id) available balance
            $avail_balance = $this->walletm->get_primary_wallet_balance(1);
            if($avail_balance >= $input_capital){
                echo 'balance enough!';
                if($input_capital >= $choosed_plan['tbpi_min_deposit'] && $input_capital <= $choosed_plan['tbpi_max_deposit']){
                    $this->investm->start_user_invest($choosed_plan['tbpi_id'], $input_capital, 1);
                    $this->session->set_flashdata('success_message', 'Investment Plan Started Successfully!');
                    redirect('user/investment#my-investment');
                }else{
                    echo 'Capital Missmatch with Plan Rules';
                }
            }else{
                echo 'balance not enough!';
            }
        }else{
            echo 'Investment Plan Does Not Exist';
        }
        



    }
}

?>