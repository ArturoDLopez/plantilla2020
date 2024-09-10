<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
		$this->load->model('Login_model');
        if(!$this->session->userdata("is_logged")){
			redirect(base_url()."seccion");
		}
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
				'borrado' => $res->borrado,
				'roles_id' => $res->roles_id,
				'is_logged' => TRUE,
			);
			$this->session->set_userdata($data);

			echo json_encode(array('url' => base_url('seccion/buscar_vehiculo')));
		}

	}

	public function logout(){
		$vars = array('id', 'borrado', 'nombre', 'roles_id', 'is_logged');
		$this->session->unset_userdata($vars);
		$this->session->sess_destroy();
	
		redirect('');
	}

}