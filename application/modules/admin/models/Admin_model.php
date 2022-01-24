<?php

class Admin_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->feedback = "feedback";
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
		$backups = array();
		$this->db->where('valeur', 0);
		$value_1 = $this->db->get($this->feedback);
		$this->db->where('valeur', 1);
		$value_2 = $this->db->get($this->feedback);
		$this->db->where('valeur', 2);
		$value_3 = $this->db->get($this->feedback);
		$this->db->where('valeur', 3);
		$value_4 = $this->db->get($this->feedback);
		$backups = array($value_1->num_rows(), $value_2->num_rows(), $value_3->num_rows(), $value_4->num_rows());
        return $backups;
	}
		
}