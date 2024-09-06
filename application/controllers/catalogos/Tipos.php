<?php

class Tipos extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('catalogos/Tipos_model');
        $this->load->model('comunes/Comunes_model');
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view('catalogos/re_tipos');
        $this->load->view('template/footer');
    }

    public function cargar_tipos() {
        $limit = $this->input->get('limit'); // Tamaño de la página
        $offset = $this->input->get('offset'); // Desplazamiento de registros
    
        // Obtener los datos paginados desde el modelo
        $data = $this->Tipos_model->cargar_tipos_paginado($limit, $offset);
    
        // Devolver el número total de registros y los datos de la página actual
        echo json_encode(array(
            'total' => $data['total'], // Número total de registros
            'rows' => $data['rows']    // Registros para la página actual
        ));
    }

    public function agregar_tipos(){
        $nom_tipo = $this->input->post('tipo');
        $datos = array(
            'nom_tipo' => $this->input->post('tipo')
        );
        echo $this->Tipos_model->agregar($datos, $nom_tipo);
    }

    public function ver_vehiculos_tipos(){
        $id = $this->input->post('id');
        echo json_encode($this->Comunes_model->cargar_uso('vehiculos', 'tipo_id', $id));
    }

    public function eliminar_tipos(){
        $id = $this->input->post('id');
        echo $this->Tipos_model->eliminar($id);
    }

}

?>