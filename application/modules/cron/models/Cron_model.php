<?php

class Cron_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->cron = "cron";
		$this->feedback = "feedback";
	}

    public function get_date_prev() {
        $this->db->order_by('id_cron', 'DESC');
        $this->db->limit(1);
        $this->db->select("date_insert, last_value");
        $this->db->from($this->cron);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function insert_data_between($date_prev, $date_now, $last_value) {
        $this->db->where('date_feedback >=', $date_prev);
        $this->db->where('date_feedback <=', $date_now);
        $this->db->select("*");
        $this->db->from($this->feedback);
        $query = $this->db->get();
        $value = $this->retrieve_data($query->result());
        $data = array(
            "backup" => $value,
            "last_value" => $this->sum_value(explode(";", $value), explode(";", $last_value)),
            "date_insert" => $date_now
        );
        $this->db->insert($this->cron, $data);
    }

    private function retrieve_data($data) {
        $count_0 = 0;
        $count_1 = 0;
        $count_2 = 0;
        $count_3 = 0;
        foreach ($data as $item) {
            switch($item->valeur) {
                case '0':
                    $count_0++;
                    break;
                case '1':
                    $count_1++;
                    break;
                case '2':
                    $count_2++;
                    break;
                case '3':
                    $count_3++;
                    break;
                default:
                break;
            }
        }
        return $count_0.";".$count_1.";".$count_2.";".$count_3;
    }

    private function sum_value($a1, $a2) {
        $sums = array();
        foreach (array_keys($a1 + $a2) as $key) {
            $sums[$key] = (isset($a1[$key]) ? $a1[$key] : 0) + (isset($a2[$key]) ? $a2[$key] : 0);
        }
        return implode(";", $sums);
    }
		
}
?>