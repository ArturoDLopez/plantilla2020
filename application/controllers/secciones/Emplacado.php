<?php

class Emplacado extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('secciones/Emplacado_model');
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view('secciones/re_emplacado');
        $this->load->view('template/footer');
    }

    public function cargar_emplacado(){
        echo json_encode($this->Emplacado_model->cargar());
    }

    public function datos_num_serie(){
        $id = $this->input->post('vehiculos_id');
        $condiciones = array('borrado' => 0, 'actual' => 1, 'vehiculos_id' => $id);
        echo json_encode($this->Emplacado_model->traer_catalogos2('emplacado', $condiciones));
    }

    public function cargar_placas_sin_asignar(){
        $condiciones = array('borrado' => 0, 'asignado' => null);
        echo json_encode($this->Emplacado_model->traer_catalogos('placas', $condiciones));
    }

    public function cargar_numero_serie(){
        $condiciones = array('borrado' => 0);
        echo json_encode($this->Emplacado_model->traer_catalogos('vehiculos', $condiciones));
    }

    public function cargar_placas_sin_asignar_excepto(){
        $id = $this->input->post('id');
        echo json_encode($this->Emplacado_model->cargar_placas_sin_asignar_excepto($id));
    }

    public function consultar_emplacado(){
        $id = array('id' => $this->input->post('id'));
        echo json_encode($this->Emplacado_model->get_by_id('emplacado', $id));
    }

    public function agregar_emplacado(){
        $id = $this->input->post('placa');
        $datos = array(
            'vehiculos_id' => $this->input->post('num_serie'),
            'placas_id' => $this->input->post('placa'),
            'actual' => $this->input->post('actual'),
            'fecha_inicio' => $this->input->post('fecha_i'),
            'fecha_termino' => $this->input->post('fecha_t'),
        );
        $emplacado_id = $this->Emplacado_model->agregar($datos);
        echo $this->Emplacado_model->actualizar_placa($id, 'placas', $emplacado_id);
    }

    public function editar_emplacado(){
        $id = $this->input->post('id');
        $placa_id = $this->input->post('placa');
        $anterior_id = $this->input->post('anterior_id');
        $datos = array(
            'vehiculos_id' => $this->input->post('num_serie'),
            'placas_id' => $this->input->post('placa'),
            'actual' => $this->input->post('actual'),
            'fecha_inicio' => $this->input->post('fecha_i'),
            'fecha_termino' => $this->input->post('fecha_t'),
        );
        $emplacado_id = $this->Emplacado_model->actualizar('emplacado', $datos, $id);    
        echo $this->Emplacado_model->actualizar_placa($placa_id, 'placas', $id);
        $this->Emplacado_model->actualizar_placa($anterior_id, 'placas', null);
    }

    public function eliminar_emplacado(){
        $id = $this->input->post('id');
        $anterior_id = $this->input->post('anterior_id');
        echo $this->Emplacado_model->borrado_logico($id, 'emplacado');
        $this->Emplacado_model->actualizar_placa($anterior_id, 'placas', null);
    }
}