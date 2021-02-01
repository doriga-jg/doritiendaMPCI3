<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pago extends CI_Controller
{
    
    public function error()
    {
		$this->load->view('pago/error', $dataToView);
    }
    
    public function pendiente()
    {
		$getData = (object) $_GET;
		/*
		 * Variable GET trae el item_id de la preferecia pero parece que con solo eso, incluye los siguientes valores:
		 *	item_id, collection_id, payment_id, status, external_reference, payment_type, merchant_order_id,
		 *  preference_id, site_id, processing_mode, merchant_account_id
		*/

		$externalRef = $getData ->external_reference;

		$dataToView = array(
			'external_reference' => $externalRef
		);

		$this->load->view('pago/pendiente', $dataToView);
    }
    
    public function exitoso()
    {

		$token = MercadoPago\SDK::setAccessToken(MP_EXAM_TOKEN);

		$getData = (object) $_GET;
		/*
		 * Variable GET trae el item_id de la preferecia pero parece que con solo eso, incluye los siguientes valores:
		 *	item_id, collection_id, payment_id, status, external_reference, payment_type, merchant_order_id,
		 *  preference_id, site_id, processing_mode, merchant_account_id
		*/

		$paymentId = $getData ->payment_id;
		$externalRef = $getData ->external_reference;

		$payment = MercadoPago\Payment::get($paymentId);

		$dataToView = array(
			'payment_status' => $payment->status,
			'payment_status_detail' => $payment->status_detail,
			'payment_id' => $payment->id,
			'payment_method_id' => $payment-> payment_method_id,
			'external_reference' => $externalRef
		);

		$this->load->view('pago/exitoso', $dataToView);
    }

}
