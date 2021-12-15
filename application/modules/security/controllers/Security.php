<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Login_model', 'login');
		$this->load->module('admin/admin');
	}
	
	public function index()
	{	
		$content = $this->load->view('login', NULL, TRUE);
		$this->display($content);
	}

	public function login() {
		Modules::load('admin')->display($this->load->view('login', NULL, TRUE));
	}
	
	public function authentification() {
		$data = array(
			"user_email" => $this->input->post("user_email"),
			"user_password" => $this->input->post("user_password")
		);

		$reponse = $this->login->get_if_user_exist($data);
		if($reponse) {
			$user = $this->login->get_user_by_name($this->input->post("user_email"));
			$session_user = array(
				"id_user" => $user->id_user,
				"user_email" => $user->user_email,
			);
			
			$this->session->set_userdata('logged_in', $session_user);
		

			// $this->load->view('admin/admin', $session);
	
			// $this->main->load_view($session);
			Modules::load('admin')->load_view($this->session->userdata('logged_in'));

		} else {
			$this->session->set_flashdata('message', 'NOTE : Email ou mot de passe incorrect');
		}
	}
}

?>