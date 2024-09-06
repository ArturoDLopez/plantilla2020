<?php

class Propietarios extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('secciones/Propietarios_model');
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view('secciones/re_propietarios');
        $this->load->view('template/footer');
    }

    public function cargar_propietarios(){
        $limit =  $this->input->get('limit');
        $offset = $this->input->get('offset');
        echo json_encode($this->Propietarios_model->cargar($limit, $offset));
    }

    public function cargar_num_serie(){
        $condiciones = array('borrado' => 0);
        echo json_encode($this->Propietarios_model->traer_catalogos('vehiculos', $condiciones));
    }

    public function cargar_curp(){
        $condiciones = array('borrado' => 0);
        echo json_encode($this->Propietarios_model->traer_catalogos('duenos', $condiciones));
    }

    public function datos_num_serie(){
        $id = $this->input->post('vehiculos_id');
        $condiciones = array('borrado' => 0, 'actual' => 1, 'vehiculos_id' => $id);
        echo json_encode($this->Propietarios_model->traer_catalogos2('propietario', $condiciones));
    }

    public function consultar_propietario(){
        $id = array('id' => $this->input->post('id'));
        echo json_encode($this->Propietarios_model->get_by_id('propietario', $id));
    }

    public function agregar_propietario(){
        $datos = array(
            'vehiculos_id' => $this->input->post('num_serie'),
            'duenos_id' => $this->input->post('dueno'),
            'actual' => $this->input->post('actual'),
            'fecha_inicio' => $this->input->post('fecha_i'),
            'fecha_termino' => $this->input->post('fecha_t'),
        );
        echo $propietario_id = $this->Propietarios_model->agregar($datos);
    }

    public function editar_propietario(){
        $id = $this->input->post('id');
        $placa_id = $this->input->post('placa');
        $anterior_id = $this->input->post('anterior_id');
        $datos = array(
            'vehiculos_id' => $this->input->post('num_serie'),
            'duenos_id' => $this->input->post('dueno'),
            'actual' => $this->input->post('actual'),
            'fecha_inicio' => $this->input->post('fecha_i'),
            'fecha_termino' => $this->input->post('fecha_t'),
        );
        $propietario_id = $this->Propietarios_model->actualizar('propietario', $datos, $id);
        echo $propietario_id;
    }

    public function eliminar_propietario(){
        $id = $this->input->post('id');
        echo $this->Propietarios_model->borrado_logico($id, 'propietario');
    }
}