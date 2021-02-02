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

			$requestPayId = $requestObj -> id;
			$requestPayStatus = $requestObj -> action;

			$response = array(
				'json_mp' => $request,
				'pay_id' => $requestPayId,
				'pay_status' => $requestPayStatus
			);

			$filename = APPPATH.'writable/requestlog.txt';

			$file = fopen($filename, 'w+') or die('file not open');

			$requestStr = strval($request);

			fputs($file, $requestStr) or die('Data not write');

			fclose($file);

			//chmod($file, 777);





			$this->response( $response, 200);

		} catch (Exception $exception){
			$response = $exception->getMessage();

			$this->response( $response, 500 );
		}
	}

}


