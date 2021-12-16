<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Admin_model', 'admin_model');
		$this->load->module('security/security');
		$this->load->model('tickets/Tickets_model', 'tickets_model');
	}
	
	public function index()
	{
		// NULL : Variable (type array)
		$clients = $this->tickets_model->get_all_client();
		$content = $this->load->view('admin', array('clients' => $clients), TRUE);
		$this->display($content);
	}

	public function load_view($data)
	{
		$content = $this->load->view('admin', $data, TRUE);
		$this->display($content);
	}
	
	public function display($content) {
		
		if(!is_null($content) && $content != "") {
			$body['content'] = $content;
		}

		$body['title'] = "Page d'administration";

		$this->load->view('index', $body);
	}

	public function list_tickets() {
		$tickets = $this->admin_model->get_all_tickets();
		$data['data'] = $tickets;
		$this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}

	public function logout() {
		$this->session->sess_destroy();
        redirect('/');
	}

	public function delete_ticket() {
		var_dump($this->input->post('id_ticket'));
		$this->admin_model->delete_ticket($this->input->post('id_ticket'));
	}

	public function _remap($method) {
		if($this->session->userdata('logged_in') != NULL) {
			$this->$method();
		} else {
			$this->security->login();
		}
	}

}
?>