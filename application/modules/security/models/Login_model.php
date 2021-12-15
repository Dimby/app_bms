<?php

class Login_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->user = "user";
	}

	// $data = array("user_email", "user_pawword");

	public function get_if_user_exist($user)
	{
		// Select $ FROM user WHERE user_email = Data.user_email;
		$this->db->where('user_email', $user['user_email']);
		$this->db->where('user_password', $user['user_password']);
		$this->db->select('*');
		$this->db->from($this->user);
		$query = $this->db->get();
        return $query->row();
	}

	// Recuperer un seul utilisateur
	public function get_user_by_name($email_user) {
		$this->db->where('user_email', $email_user);
		$this->db->select('*');
		$this->db->from($this->user);
		$query = $this->db->get();
        return $query->row(); // Ligne 1
        // return $query->result(); // Plusieurs lignes
	}
		
}
?>