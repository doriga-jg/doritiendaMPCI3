<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//use MercadoPago;

class Productos extends CI_Controller
{

    public function index()
	{
        //Token e IntegratorId
        MercadoPago\SDK::setAccessToken(MP_EXAM_TOKEN);
		MercadoPago\SDK::setIntegratorId(MP_EXAM_INTEGRATOR_ID);

        /*
         * Item
         */

        //Creamos ítem
        $item = new MercadoPago\Item();

        //Información del ítem
        $item->id= 1234;
        $item->title = 'Nombre del producto';
        $item->description = 'Dispositivo móvil de Tienda e-commerce';
        $item->category_id = "others";
        $item->quantity = 1;
        $item->currency_id="MXN";
        $item->unit_price = 390;

        /*
         * Preference
         */

		//Crear objeto de preferencia y almacenarlo en $preference
		$preference = new MercadoPago\Preference();

        //Guardamos la info del item en la preferencia
        $preference -> items = array($item);

        /*
         * Payer
         */

        //Creamos payer
        $payer = new MercadoPago\Payer();
        
        //Payer info
        $payer->id = 655253974;
		$payer->name = "Lalo";
        $payer->surname = "Landa";
        $payer->email = "test_user_81131286@testuser.com";
        $payer->date_created = "2021-01-02T12:58:41.425-04:00";
        $payer->phone = array(
            "area_code" => "52",
            "number" => "5549737300"
        );
        
        $payer->address = array(
            "street_name" => "Insurgentes Sur",
            "street_number" => 1602,
            "zip_code" => "03940"
        );

        //Guardamos la payer info en la preferencia
		$preference -> payers = array($payer);

		/*
		 * More data
		 */

        //Add external_reference to the preference
		$personal_e_reference = 'j.gab2803@gmail.com';
		$preference -> external_reference = $personal_e_reference;
		$preference -> auto_return = 'approved';
		$preference -> notification_url = '';
		$preference -> collector_id = 617633181;

        //Info about the payment for the exam client
		$preference->payment_methods = array(
			"excluded_payment_methods" => array(
				array("id" => "amex")
			),
			"excluded_payment_types" => array(
				array("id" => "atm")
			),
			"installments" => 6		//Max number of payments according to the client
		);

		/*
		 * Back URLs
		 */

        // Pasamos items a string
        $itemString = implode(',', (array) $item);

        //Establecemos las backurls en urls
        $urls = array(
            "failure" => site_url('pago/error?item_data=' . $itemString),
            "pending" => site_url('pago/pendiente?item_id='.$item->id),
            "success" => site_url('pago/exitoso?item_id='.$item->id)
        );

        //Guardamos las backurls
        $preference -> back_urls = $urls;

		/*
 		* Saving & sending to View
 		*/

        //Guardamos la preferencia
        $preference -> save();

        $dataToView = array(
            'preference' => $preference, 
            'items' => $preference->items, 
        );

		$this->load->view('productos', $dataToView);
	}

    function preferenceMP(){

    }

    function paymentMP(){
        
        //De nuevo se pide el token de MP
        $token = MercadoPago\SDK::setAccessToken(DORI_TOKEN);

        //Creamos un objeto de pago y asignamos su infomación con valores fijos
        $payment = new MercadoPago\Payment();
        $payment -> transaction_amount = 390;
        $payment -> token = 'CARD_TOKEN';

    }

}
