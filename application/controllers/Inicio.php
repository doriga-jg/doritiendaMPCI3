<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller
{

	function __construct()
	{
		date_default_timezone_set('America/Mexico_City');
		parent::__construct();
	}

	public function index() {
        $this->load->view('inicio');
    }

    public function catcherMP() {
		MercadoPago\SDK::setAccessToken("ENV_ACCESS_TOKEN");

		$request= $this->post();

		$http_status = parent::HTTP_OK;


		switch($request["type"]) {
			case "payment":
				$payment = MercadoPago\Payment.find_by_id($request["id"]);


				break;
			case "plan":
				$plan = MercadoPago\Plan.find_by_id($request["id"]);
				break;
			case "subscription":
				$plan = MercadoPago\Subscription.find_by_id($request["id"]);
				break;
			case "invoice":
				$plan = MercadoPago\Invoice.find_by_id($request["id"]);
				break;
		}
	}

}
