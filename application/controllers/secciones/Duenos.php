<?php

class Duenos extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('secciones/Duenos_model');
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view('secciones/re_duenos');
        $this->load->view('template/footer');
    }

    public function cargar_duenos(){
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        echo json_encode($this->Duenos_model->cargar($limit, $offset));
    }

    public function consultar_dueno(){
        $id = array('id' => $this->input->post('id'));
        echo json_encode($this->Duenos_model->get_by_id('duenos', $id));
    }

    public function agregar_dueno(){
        $curp = $this->input->post('curp');
        $datos = array(
            'curp' => $this->input->post('curp'),
            'nombre' => $this->input->post('nombre'),
            'apellido_p' => $this->input->post('ap'),
            'apellido_m' => $this->input->post('am'),
        );
        echo $this->Duenos_model->agregar($datos, $curp);
    }

    public function editar_dueno(){
        $id = $this->input->post('id');
        $curp = $this->input->post('curp');
        $datos = array(
            'curp' => $this->input->post('curp'),
            'nombre' => $this->input->post('nombre'),
            'apellido_p' => $this->input->post('ap'),
            'apellido_m' => $this->input->post('am'),
        );
        echo $this->Duenos_model->actualizar('duenos', $datos, $id, $curp);
    }

    public function eliminar_dueno(){

        $response = [
            'error' => false,
            'msj' => ""
        ];

        $id = $this->input->post('id');

        if(empty($id)){
            $response["error"] = true;
            $response["msj"] = 'No llego el id';
            return $this->output->set_output(json_encode($response));
        }

        $borrado = $this->Duenos_model->borrado_logico($id, 'duenos');
        if($borrado != 1){
            $response['error'] = true;
            $response['msj'] = "No fue posible eliminar el registro";
            return $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode($response));
        }  else {
            $response['msj'] = 'Registro eliminado correctamente';
        }
        return $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($response));
    }
}