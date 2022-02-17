<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('email');
    }

    public function index() {
        return;
    }

    public function send_mail($data) {
        $params = $this->parametre();
        $html = $this->load->view('mail', $data, TRUE); // Récuperation des données
        $this->email->initialize($params['psettings']);
        $this->email->to("support@aveolys.com");
        $this->email->from($params['mailsender'], $params['mailappname']);
        $this->email->subject("Feedback tickets BMS");
        $this->email->message($html); // chargement du template
        $this->email->send();
    }

    public function parametre() {
        $psettings = array( // Configuration de base de l'envoi de mail
            'mailtype' => "html",
            'protocol' => "smtp",
            'smtp_host' => "mail.iris.re",
            'smtp_user' => "support@aveolys.com",
            'smtp_pass' => "Sup0rt@veo",
            'smtp_port' => "587",
            'smtp_crypto' => "tls",
            'priority' => "1",
            'charset' => "utf-8",
        );
        return $data = array(
            "mailsender" => "bms@aveolys.com",
            "mailappname" => "Appli BMS",
            "psettings" => $psettings,
        );
    }
}