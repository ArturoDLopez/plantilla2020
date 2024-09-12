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
		foreach($data as $d){
			$d->ve_id = encriptar($d->ve_id);
		}
		echo json_encode($data);
	}

	public function traer_robos(){
		$ve_id = $this->input->post('ve_id');
		if(empty($ve_id)){
			$response = array('msj' => 'No se encuentran robos registrados para este vehiculo');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}
		$id_desencriptado = (int)desencriptar($ve_id);
		if(!($id_desencriptado > 0)){
			$response = array('msj' => 'Mal  id');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}

		$response = $this->Vehiculos_model->buscar_robo($id_desencriptado);
		if(empty($response)){
			$response = array('msj' => 'No se encuentran robos registrados para este vehiculo');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}

		return $this->output
			->set_status_header(200)
			->set_content_type("application/json")
			->set_output(json_encode($response));

	}

	public function traer_duenos(){
		$ve_id = $this->input->post('ve_id');
		if(empty($ve_id)){
			$response = array('msj' => 'No se encuentran dueños registrados para este vehiculo');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}
		$id_desencriptado = (int)desencriptar($ve_id);
		if(!($id_desencriptado > 0)){
			$response = array('msj' => 'Mal  id');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}

		$response = $this->Vehiculos_model->buscar_duenos($id_desencriptado);
		if(empty($response)){
			$response = array('msj' => 'No se encuentran dueños registrados para este vehiculo');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}

		return $this->output
			->set_status_header(200)
			->set_content_type("application/json")
			->set_output(json_encode($response));

	}

	public function traer_placas(){
		$ve_id = $this->input->post('ve_id');
		if(empty($ve_id)){
			$response = array('msj' => 'No se encuentran placas registrados para este vehiculo');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}
		$id_desencriptado = (int)desencriptar($ve_id);
		if(!($id_desencriptado > 0)){
			$response = array('msj' => 'Mal  id');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}

		$response = $this->Vehiculos_model->buscar_placas($id_desencriptado);
		if(empty($response)){
			$response = array('msj' => 'No se encuentran placas registrados para este vehiculo');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}

		return $this->output
			->set_status_header(200)
			->set_content_type("application/json")
			->set_output(json_encode($response));

	}

}