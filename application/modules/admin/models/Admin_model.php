<?php

class Admin_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->feedback = "feedback";
		$this->cron = "cron";
		$this->list_valeur = "list_valeur";
		$this->client = "client";
	}

	// Recuperer un seul utilisateur
	public function get_ticket($id_ticket) {
		$this->db->where('id_ticket', $id_ticket);
		$this->db->select('*');
		$this->db->from($this->feedback);
		$query = $this->db->get();
        return $query->row(); // Ligne 1
        // return $query->result(); // Plusieurs lignes
	}

	public function get_all_tickets() {
		$this->db->select('*');
		$this->db->from($this->feedback);
		$query = $this->db->get();
        return $query->result(); // Ligne 1
	}

	public function delete_ticket($id) {
		$this->db->where('id_ticket', $id);
		$this->db->delete($this->feedback);
	}

	public function get_tickets_by_client($client) {
		$this->db->where('client_name', $client);
		$this->db->select('*');
		$this->db->from($this->feedback);
		$query = $this->db->get();
        return $query->result(); // Ligne 1
	}

	public function get_count_backups() {
		$this->db->select('*');
		$this->db->from($this->cron);
		$this->db->order_by('id_cron', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}

	public function get_last_value() {
		$this->db->select('last_value');
		$this->db->from($this->cron);
		$this->db->order_by('id_cron', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
        return $query->row();
	}

	public function get_all_tickets_by_clients($clients) {
		$data = array();
		foreach($clients as $item) {
			$this->db->where('client_name', $item->nom);
			$this->db->select('*');
			$this->db->from($this->feedback);
			$query = $this->db->get();
			$temp = array(
				'nom_client' => $item->nom,
				'somme' => $query->num_rows(),
				'feedbacks' => $this->get_all_feedback_by_client($item->nom)
			);
			array_push($data, $temp);
		}
		return $data;
	}

	public function get_all_feedback_by_client($client) {
		$val = array();
		for($i=0; $i<count($this->get_list_value()); $i++) {
			$this->db->where('client_name', $client);
			$this->db->where('valeur', $i);
			$this->db->select('*');
			$this->db->from($this->feedback);
			array_push($val, $this->db->get()->num_rows());
		}
		return $val;
	}

	public function get_date($test, $year) {
		switch($test) {
			case 'max':
				// $this->db->select_max('date_feedback');
				$this->db->select('MAX(date_feedback) as date_max, YEAR(date_feedback) as date_year');
				break;
			case 'min':
				// $this->db->select_min('date_feedback');
				$this->db->select('MIN(date_feedback) as date_min, YEAR(date_feedback) as date_year');
				break;
			default:
				break;
		}
		// $this->db->select_min('date_feedback');
		$this->db->where('YEAR(date_feedback)', $year);
		$this->db->from($this->feedback);
		$query = $this->db->get();
		return $query->row();
	}

	public function get_data_between($d1, $d2) {
		$this->db->where('date_feedback >=', $d1);
		$this->db->where('date_feedback <=', $d2);
		$this->db->select('*');
		$this->db->from($this->feedback);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_name_clients() {
		$this->db->select('nom as nom_client');
		$this->db->from($this->client);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_list_value() {
		$this->db->select('*');
		$this->db->from($this->list_valeur);
		$query = $this->db->get();
		return $query->result();
	}
		
}