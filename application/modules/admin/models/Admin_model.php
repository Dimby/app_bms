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
		
}