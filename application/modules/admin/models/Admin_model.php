<?php

class Admin_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->feedback = "feedback";
		$this->cron = "cron";
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
		
}