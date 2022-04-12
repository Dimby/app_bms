<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Admin_model', 'admin_model');
		$this->load->module('security/security');
		$this->load->model('tickets/Tickets_model', 'tickets_model');
		$this->year = date('Y');
	}
	
	public function index()
	{
		$year_sess = $this->session->userdata('year');
		$y = $year_sess != NULL ? $year_sess['date'] : $this->year;
		if($this->session->userdata('tickets') == NULL) {
			$this->session->set_userdata('tickets', array('active_ticket' => "active"));
		}
		// NULL : Variable (type array)
		$clients = $this->admin_model->get_name_clients();
		$all_tickets_by_clients = $this->admin_model->get_all_tickets_by_clients($this->tickets_model->get_all_client());

		$list_valeur = $this->admin_model->get_list_value();
		$all_tickets = $this->admin_model->get_data_between($this->admin_model->get_date('min', strval($y))->date_min, $this->admin_model->get_date('max', strval($y))->date_max);
		// $all_tickets = $this->admin_model->get_all_tickets();
		
		$content = $this->load->view('admin',
									array(
										'list_tickets' => $this->load->view('navs/list_tickets', array(
											'clients' => $clients
										), TRUE),
										'statistiques' => $this->load->view('navs/statistiques', array(
											'year' => $y,
											'clients' => $clients,
											'list_value' => $list_valeur,
											'all_tickets' => json_encode((array)$all_tickets)
										), TRUE),
										'all_tickets_by_clients' => $all_tickets_by_clients,
										
										'max_date' => $this->admin_model->get_date('max', $y),
										'min_date' => $this->admin_model->get_date('min', $y),
										'all_tickets' => json_encode((array)$all_tickets)), TRUE);
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

	public function change_year() {
		$this->session->set_userdata('year', array('date' => $this->input->post('year')));
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