<?php

class Tickets_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->feedback = "feedback";
		$this->client = "client";
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

	public function insert_client($data) {
		$this->db->where('nom', $data);
		$this->db->select('*');
		$this->db->from($this->client);
		$query = $this->db->get();
		if($query->num_rows() == 0) {
			$this->db->insert($this->client, array('nom' => $data));
		}
	}

	public function get_all_client() {
		$this->db->select('*');
		$this->db->from($this->client);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_client_by_name($name) {
		$this->db->where('nom', $name);
		$this->db->select('*');
		$this->db->from($this->client);
		$query = $this->db->get();
		return $query->row();
	}
		
}
?>