<?php

class Colores extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('catalogos/Colores_model');
        $this->load->model('comunes/Comunes_model');
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view('catalogos/re_colores');
        $this->load->view('template/footer');
    }

    public function cargar_colores(){
        echo json_encode($this->Colores_model->cargar());
    }

    public function agregar_colores(){
        $nom_color = $this->input->post('color');
        $datos = array(
            'nom_color' => $this->input->post('color')
        );
        echo $this->Colores_model->agregar($datos, $nom_color);
    }

    public function ver_vehiculos_colores(){
        $id = $this->input->post('id');
        echo json_encode($this->Comunes_model->cargar_uso('vehiculos', 'colores_id', $id));
    }

    public function eliminar_colores(){
        $id = $this->input->post('id');
        echo $this->Colores_model->eliminar($id);
    }

}

?>