<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class ApiMP extends RestController
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Mexico_City');

	}

	function notification_post() {
		try {
			$request = $this->post();

			MercadoPago\SDK::setAccessToken(MP_EXAM_TOKEN);

			$requestObj = (object) $request;

			$requestPayStatus = $requestObj -> action;

			$response = array(
				'jsonMp' => $request,
				'payStatus' => $requestPayStatus
			);

			$this->response( $response, 200);

		} catch (Exception $exception){
			$response = $exception->getMessage();

			$this->response( $response, 500 );
		}
	}

}


