<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Cron_model', 'cron_model');
	}
	
	public function index(){}

    // This method is launched by the cron
    public function insert_backup() {
        $date_now = date('Y-m-d H:i:s');
        $date_prev = $this->cron_model->get_date_prev()->date_insert;
        $this->cron_model->insert_data_between($date_prev, $date_now, $this->cron_model->get_date_prev()->last_value);
    }
}