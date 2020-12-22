<?php
class Investm extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function get_spesific_user_investment($user_id, $is_active){
        $this->db->select('*');
        $this->db->from('tbui_user_investment');
        $this->db->where('tbu_user_id', $user_id);
        if($is_active){
            $this->db->where('tbui_start <= now()');
            $this->db->where('tbui_end >= now()');
        }else{
            $this->db->where('tbui_end <= now()');
        }
        $result_spesific_user_investment = $this->db->get()->result_array();

        return $result_spesific_user_investment;
    }

    public function withdraw_earning_to_wallet(){
        $this->db->select('*');
        $this->db->from('tbui_user_investment');
        $result_user_investment = $this->db->get()->result_array();

        
    }

    public function get_plan_investment(){
        $this->db->select('*');
        $this->db->from('tbpi_plan_investment');
        $result_plan_investment = $this->db->get()->result_array();

        return $result_plan_investment;
    }
    public function get_specific_plan_investment($plan_investment_id){
        $this->db->select('*');
        $this->db->from('tbpi_plan_investment');
        $this->db->where('tbpi_id', $plan_investment_id);
        $result_specific_plan_investment = $this->db->get()->row_array();

        return $result_specific_plan_investment;
    }
    public function start_user_invest($invest_plan_id, $capital_amount, $user_id){
        $this->db->select('tbpi_name, tbpi_day_contract, tbpi_profit_share');
        $this->db->from('tbpi_plan_investment');
        $this->db->where('tbpi_id', $invest_plan_id);
        $data_plan_investment = $this->db->get()->row_array();
        $date_calc = strtotime("+3 day");
        $start_date = date("Y-m-d", time());
        $end_date = date("Y-m-d",$date_calc);
        $max_profit = $data_plan_investment['tbpi_profit_share']*$data_plan_investment['tbpi_day_contract']*$capital_amount;
        $data_user_invest = array(
            'tbui_label_id' => $data_plan_investment['tbpi_name'].'-'.$user_id.'-'.$capital_amount,
            'tbui_capital' => $capital_amount,
            'tbui_maxprofit' => $max_profit,
            'tbui_start' => $start_date,
            'tbui_end' => $end_date,
            'tbu_user_id' => 1
        );
        $this->db->insert('tbui_user_investment', $data_user_invest);
    }
}
?>