<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seccion extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->library(array('session'));
		$this->load->model('Login_model');
		$this->load->model('Vehiculos_model');
    }

	/**
	 * index
	 */
	public function index()
	{
		//validar si el usaurio esta logueado
		$this->load->view('seccion/login');
	}

	public function validate(){
		//guardar variables que vienen en el post
		$usr = $this->input->post('email');
		$pass = $this->input->post('password');


		//Llamar a la funcion en el model del login, enviando los datos email y password, guardar la respuesta
		$res = $this->Login_model->login($usr, $pass);
		//Si respuesta es negativo, no esta bien la informacion.
		if(!$res){
			exit;
		} //en caso de que mande true hay que guardar la informacion para poder guardar la sesion.
		else{
			$data = array(
				'id' => $res->id,
				'nombre' => $res->nombre,
				'eliminado' => $res->eliminado,
				'roles_id' => $res->roles_id,
				'is_logged' => TRUE,
			);
			$this->session->set_userdata($data);

			echo json_encode(array('url' => base_url('seccion/buscar_vehiculo')));
		}

	}

	/**
	 * ver
	 * 
	 * @param string $string
	 */
	public function ver($string = NULL)
	{
		$data = [];
		$data['enlace'] = $string;

		$this->load->view('template/header', $data);
			$this->load->view('seccion/ver');
		$this->load->view('template/footer');
	}

	public function logout(){
		$vars = array('id', 'eliminado', 'nombre', 'roles_id', 'is_logged');
		$this->session->unset_userdata($vars);
		$this->session->sess_destroy();
	
		redirect('');
	}

	public function buscar_vehiculo(){
		/* $placa = $this->input->post('placa');
		$datos = [];
		$datos['vehiculo'] = $this->Vehiculos_model->buscar_vehiculo($placa);
		$data = $this->Vehiculos_model->buscar_vehiculo($placa);
 */
		$this->load->view('template/header');
        $this->load->view('seccion/tabla_vehiculos');
		$this->load->view('template/footer');
	}

	public function buscar_vehiculo_ajax(){
		$placa = $this->input->post('placa');
		$data = $this->Vehiculos_model->buscar_vehiculo($placa);
		echo json_encode($data);
	}

}