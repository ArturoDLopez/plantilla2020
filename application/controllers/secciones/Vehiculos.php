<?php

class Vehiculos extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('secciones/Vehiculos_model');
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view('secciones/re_vehiculos');
        $this->load->view('template/footer');
    }

    public function cargar_vehiculos(){
        echo json_encode($this->Vehiculos_model->cargar());
    }

    public function agregar_vehiculos(){
        $nom_marca = $this->input->post('num_serie');
        $datos = array(
            'num_serie' => $this->input->post('num_serie'),
            'marcas_id' => $this->input->post('marca'),
            'modelo' => $this->input->post('modelo'),
            'colores_id' => $this->input->post('color'),
            'tipo_id' => $this->input->post('tipo'),
        );
        $this->Vehiculos_model->agregar($nom_marca, $datos);
    }

    public function cargar_marcas(){
        echo json_encode($this->Vehiculos_model->traer_catalogos('marcas'));
    }
    public function cargar_colores(){
        echo json_encode($this->Vehiculos_model->traer_catalogos('colores'));
    }
    public function cargar_tipos(){
        echo json_encode($this->Vehiculos_model->traer_catalogos('tipo'));
    }
}