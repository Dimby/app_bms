<?php

class Tickets_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->feedback = "feedback";
	}

	public function get_ticket($id) {
		$this->db->select("*");
		$this->db->from($this->feedback);
		$this->db->where('id_ticket', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function insert_ticket($data) {
		$this->db->set('date_feedback', 'NOW()', FALSE);
		$this->db->insert($this->feedback, $data);
	}

	public function update_ticket_by_id($id, $data) {
		$this->db->where('id_ticket', $id);
		$this->db->update($this->feedback, $data);
	}
		
}
?>