<?php

class Tipos extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('catalogos/Tipos_model');
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view('catalogos/re_tipos');
        $this->load->view('template/footer');
    }

    public function cargar_tipos(){
        echo json_encode($this->Tipos_model->cargar());
    }

    public function agregar_tipos(){
        $nom_tipo = $this->input->post('tipo');
        $datos = array(
            'nom_tipo' => $this->input->post('tipo')
        );
        echo $this->Tipos_model->agregar($datos, $nom_tipo);
    }

    public function eliminar_tipos(){
        $id = $this->input->post('id');
        echo $this->Tipos_model->eliminar($id);
    }

}

?>