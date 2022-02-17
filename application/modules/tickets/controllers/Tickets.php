<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('tickets_model', 'tickets_model');
		$this->load->module('security/security');
		$this->load->module('mail/mail');
        $this->load->library('email');
	}

	public function index(){
		$client_name = isset($_GET["client"]) ? htmlspecialchars($_GET["client"]) : NULL ;
		if($client_name != NULL) {
			$this->tickets_model->insert_client($client_name);
		}
		$client_flag = $this->tickets_model->get_client_by_name($client_name);
		$data = array(
			'id_ticket' => isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : NULL,
			'ticket_title' => isset($_GET["title"]) ? htmlspecialchars($_GET["title"]) : NULL,
			'client_name' => isset($_GET["client"]) ? $client_flag->nom : NULL,
			'ticket_type' => isset($_GET["type"]) ? htmlspecialchars($_GET["type"]) : NULL,
			'issue_type' => isset($_GET["issuetype"]) ? htmlspecialchars($_GET["issuetype"]) : NULL,
			'issue_subtype' => isset($_GET["issuesubtype"]) ? htmlspecialchars($_GET["issuesubtype"]) : NULL,
			'valeur' => isset($_GET["value"]) ? htmlspecialchars($_GET["value"]) : NULL,
		);

		if($data['id_ticket'] != NULL && $data['valeur'] != NULL) {
			$this->upload($data);
		} else {
			$body['content'] = $this->load->view('admin', NULL, TRUE);
			$this->load->view('index', $body);
		}
		
	}
	
	private function getValueParameter($url, $params) {
		$data = explode("&", $url);
	}
	
	public function upload($data){
		$ql = $this->tickets_model->get_ticket($data['id_ticket']);
		if( $ql ) {
			$body['content'] = $this->load->view('tickets_exist', NULL, TRUE);
			$this->load->view('index', $body);
		} else {
			$this->session->set_userdata("logged_in", $data);
			$this->tickets_model->insert_ticket($data);
			$body['content'] = $this->load->view('tickets', NULL, TRUE);
			$this->load->view('index', $body);
			$this->mail->send_mail($data);
		}		
	}

	public function register_success() {
		$body['content'] = $this->load->view('register_success', NULL, TRUE);
		$this->load->view('index', $body);
	}

	public function add_ticket() {
		$data = array(
			"commentaire" => $this->input->post('commentaire')
		);
		$session = $this->session->userdata("logged_in");
		// var_dump($session);
		$id = $session['id_ticket'];
		$this->tickets_model->update_ticket_by_id($id, $data);
		$this->session->sess_destroy();
		$this->register_success();
	}

	// public function _remap($method) {
	// 	if ($this->session->userdata('logged_in') != NULL) {
	// 		$this->$method();
	// 	} else {
	// 		$this->security->login();
	// 	}
	// }

}
?>

