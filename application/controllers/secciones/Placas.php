<?php

class Placas extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('secciones/Placas_model');
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view('secciones/re_placas');
        $this->load->view('template/footer');
    }

    public function cargar_placas(){
        echo json_encode($this->Placas_model->cargar());
    }

    public function consultar_placa(){
        $id = array('id' => $this->input->post('id'));
        echo json_encode($this->Placas_model->get_by_id('placas', $id));
    }

    public function agregar_placa(){
        $placa = $this->input->post('placa');
        $datos = array(
            'placa' => $this->input->post('placa'),
        );
        echo $this->Placas_model->agregar($datos, $placa);
    }

    public function editar_placa(){
        $id = $this->input->post('id');
        $placa = $this->input->post('placa');
        $datos = array(
            'placa' => $this->input->post('placa'),
        );
        echo $this->Placas_model->actualizar('placas', $datos, $id, $placa);
    }

    public function eliminar_placa(){
        $id = $this->input->post('id');
        echo $this->Placas_model->eliminado_logico($id, 'placas');
    }
}