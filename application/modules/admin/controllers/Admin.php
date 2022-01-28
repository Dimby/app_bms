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
		if($this->session->userdata('tickets') == NULL) {
			$this->session->set_userdata('tickets', array('active_ticket' => "active"));
		}
		// NULL : Variable (type array)
		$clients = $this->tickets_model->get_all_client();
		$all_tickets_by_clients = $this->admin_model->get_all_tickets_by_clients($this->tickets_model->get_all_client());
		$backups = $this->admin_model->get_count_backups();
		$all_backups = array();
		foreach($backups as $item ){
			array_push($all_backups, explode(';', $item->last_value));
		}
		$data_chart = array();
		for($i=0; $i<count($all_backups[0]); $i++) {
			$temp = array();
			for($j=0; $j<count($all_backups); $j++) {
				array_push($temp, $all_backups[$j][$i]);
			}
			array_push($data_chart, $temp);
		}
		// var_dump($backups);
		// var_dump($all_backups);
		// var_dump($data_chart);
		// var_dump($all_backups[1][0]+$all_backups[1][1]+$all_backups[1][3]);
		// var_dump(array_sum($all_backups[1]));
		$content = $this->load->view('admin',
									array(
										'all_tickets_by_clients' => $all_tickets_by_clients,
										'clients' => $clients,
										'data_chart' => $data_chart,
										'last_value' => $this->admin_model->get_last_value()->last_value), TRUE);
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
		if($this->input->post('client') != '') {
			$tickets = $this->admin_model->get_tickets_by_client($this->input->post('client'));
		} else {
			$tickets = $this->admin_model->get_all_tickets();
		}
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
		// var_dump($this->input->post('id_ticket'));
		$this->admin_model->delete_ticket($this->input->post('id_ticket'));
	}

	public function _remap($method) {
		if($this->session->userdata('logged_in') != NULL) {
			$this->$method();
		} else {
			$this->security->login();
		}
	}

	public function set_session_client() {
		$client = $this->input->post('client') != NULL ? $this->input->post('client') : '';
		$this->session->set_userdata('client', array('client' => $client));
	}

	public function set_session_tickets() {
		switch($this->input->post('tab')) {
			case 'list-ticket':
				$this->session->set_userdata('tickets', array('active_ticket' => "active"));
				break;
			case 'stat':
				$this->session->set_userdata('tickets', array('active_stat' => "active"));
				break;
			default:
			break;
		}
	}

}
?>