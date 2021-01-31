<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//use MercadoPago;

class Productos extends CI_Controller
{

    public function index()
	{
        //Pedir token y almacenarlo en $token
        $token = MercadoPago\SDK::setAccessToken(MP_TEST_TOKEN);

        //Crear objeto de preferencia y almacenarlo en $preference
        $preference = new MercadoPago\Preference();

        //Creamos ítem
        $item = new MercadoPago\Item();

        //Información del ítem
        $item->id= 12345;
        $item->title = 'Doriproducto';
        $item->description = 'Un doriproducto super padriuris';
        $item->category_id = "others";
        $item->quantity = 1;
        $item->currency_id="MXN";
        $item->unit_price = 390;

        //Guardamos la info del item en la preferencia
        $preference -> items = array($item);

        //Creamos payer
        $payer = new MercadoPago\Payer();
        
        //Payer info
        $payer->name = "Joge";
        $payer->surname = "Pérez";
        $payer->email = "joge@hotmail.com";
        $payer->date_created = "2021-01-02T12:58:41.425-04:00";
        $payer->phone = array(
            "area_code" => "+52",
            "number" => "5513944520"
        );
        
        $payer->address = array(
            "street_name" => "Naranjo",
            "street_number" => 284,
            "zip_code" => "06450"
        );

        //Guardamos la payer info en la preferencia
        $preference -> payers = array($payer);

        // Pasamos items a string
        $itemString = implode(',', (array)$item);

        //Establecemos las backurls en urls
        $urls = array(
            "failure" => site_url('pago/error?item_data=' . $itemString),
            "pending" => site_url('pago/pendiente?item_id='.$item->id),
            "success" => site_url('pago/exitoso?item_id='.$item->id)
        );

        //Guardamos las backurls
        $preference -> back_urls = $urls;

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
