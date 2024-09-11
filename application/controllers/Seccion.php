<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seccion extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->model('Vehiculos_model');
    }

	public function index()
    {
		
        if ($this->auth->is_signed()) {
			
            redirect(base_url()."seccion/tabla_vehiculos");
        } else {
			
			$data = new stdClass();
			$login = false;
			$data->login = $login;
			$this->load->view('template/header', $data);
			$this->load->view('secciones/ver');
			$this->load->view('template/footer');
        }
    }

	public function validate(){
		return $this->auth->is_signed();
	}

	public function logout(){
		$this->auth->logout();
		redirect(base_url());
	}

	public function tabla_vehiculos(){
		$data = new stdClass();
		$login = true;
		$data->login = $login;
		$this->load->view('template/header', $data);
        $this->load->view('secciones/tabla_vehiculos');
		$this->load->view('template/footer');
	}

	public function buscar_vehiculo_ajax(){
		$placa = $this->input->post('placa');
		$data = $this->Vehiculos_model->buscar_vehiculo($placa);
		$response['msj'] = "No se encontraron vehiculos con esas placas o numero de serie";
		if(!$data){
			return $this->output
				->set_status_header(404)
				->set_content_type("application/json")
            	->set_output(json_encode($response));
		}
		echo json_encode($data);
	}

}