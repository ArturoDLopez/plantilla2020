<?php

class Colores extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('catalogos/Colores_model');
        $this->load->model('comunes/Comunes_model');
        $this->load->library('encryption');
    }

    public function index() {
        $data = new stdClass();
		$login = true;
		$data->login = $login;
        $this->load->view('template/header', $data);
        $this->load->view('catalogos/re_colores');
        $this->load->view('template/footer');
    }

    public function cargar_colores() {
        $limit = (int)$this->input->get('limit', TRUE);
        $offset = (int)$this->input->get('offset', TRUE);
        
        $colores = $this->Colores_model->cargar($limit, $offset);
        foreach($colores['rows'] as $color){
            $color->id = encriptar($color->id);
        }
        return $this->response($colores);
    }

    public function agregar_colores() {
        $nom_color = $this->input->post('color', TRUE);

        if (empty($nom_color) || !is_string($nom_color)) {
            return $this->response(['status' => 'error', 'message' => 'Color no proporcionado o inválido'], 400);  
        }

        $datos = ['nom_color' => $nom_color];
        $result = $this->Colores_model->agregar($datos, $nom_color);

        if ($result === 0) {
            return $this->response(['status' => 'error', 'message' => 'Error al agregar el color, posible repeticion de color'], 400);
        }

        return $this->response(['status' => 'success', 'message' => 'Color agregado correctamente']);
    }

    public function ver_vehiculos_colores() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);
        

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $vehiculos = $this->Comunes_model->cargar_uso('vehiculos', 'colores_id', $id);
        return $this->response(['status' => 'success', 'data' => $vehiculos]);
    }

    public function eliminar_colores() {
        $id = $this->input->post('id', TRUE);

        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $result = $this->Colores_model->eliminar($id);

        if ($result === 0) {
            return $this->response(['status' => 'error', 'message' => 'Error al eliminar el color o color no encontrado'], 400);
        }

        return $this->response(['status' => 'success', 'message' => 'Color eliminado correctamente']);
    }
    
    private function validar_id($id) {
        if (empty($id) || !is_numeric($id) || (int)$id <= 0) {
            return false;
        }
        return true;
    }

    private function response($data, $status_code = 200) {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header($status_code)
            ->set_output(json_encode($data));
    }


}
?>
