<?php

class Robos extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('secciones/Robos_model');
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view('secciones/re_robos');
        $this->load->view('template/footer');
    }

    public function cargar_robos(){
        echo json_encode($this->Robos_model->cargar());
    }

    public function cargar_num_serie(){
        $condiciones = array('borrado' => 0);
        echo json_encode($this->Robos_model->traer_num_serie('vehiculos', $condiciones));
    }

    public function consultar_robo(){
        $id = array('id' => $this->input->post('id'));
        echo json_encode($this->Robos_model->get_by_id('robos', $id));
    }

    public function buscar_datos(){
        $serie = $this->input->post('serie');
        $registro = $this->Robos_model->serie_placa($serie);
        echo json_encode($registro);
    }

    public function agregar_robo(){
        $datos = array(
            'vehiculos_id' => $this->input->post('num_serie'),
            'placas_id' => $this->input->post('placas_id'),
            'duenos_id' => $this->input->post('duenos_id'),
            'descripcion' => $this->input->post('descripcion'),
            'fecha' => $this->input->post('fecha_r'),

        );
        echo $this->Robos_model->agregar($datos);
    }

    public function editar_robo(){
        $id = $this->input->post('id');
        $datos = array(
            'vehiculos_id' => $this->input->post('num_serie'),
            'placas_id' => $this->input->post('placas_id'),
            'duenos_id' => $this->input->post('duenos_id'),
            'descripcion' => $this->input->post('descripcion'),
            'fecha' => $this->input->post('fecha_r'),

        );
        echo $this->Robos_model->actualizar('robos', $datos, $id);
    }

    public function eliminar_robo(){
        $id = $this->input->post('id');
        echo $this->Robos_model->borrado_logico($id, 'robos');
    }
}