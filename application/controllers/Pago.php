<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pago extends CI_Controller
{
	public function index()
    { return; }
    
    public function error()
    {
        $articleData = $_GET['item_data'];

        $articleDataArray = explode(',',$articleData);

        $dataToView = array(
            'articulo' => $articleDataArray
        );

		$this->load->view('pago/error', $dataToView);
    }
    
    public function pendiente()
    {
		$this->load->view('pago/pendiente');
    }
    
    public function exitoso()
    {
		$this->load->view('pago/exitoso');
    }
    
	//--------------------------------------------------------------------
}
