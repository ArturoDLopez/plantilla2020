<?php

class Tipos extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('catalogos/Tipos_model');
        $this->load->model('comunes/Comunes_model');
    }

    public function index() {
        $data = new stdClass();
		$login = true;
		$data->login = $login;
        $this->load->view('template/header', $data);
        $this->load->view('catalogos/re_tipos');
        $this->load->view('template/footer');
    }

    public function cargar_tipos() {
        $limit = (int)$this->input->get('limit', TRUE);
        $offset = (int)$this->input->get('offset', TRUE);

        $data = $this->Tipos_model->cargar_tipos_paginado($limit, $offset);
        foreach($data['rows'] as $tipo){
            $tipo->id = encriptar($tipo->id);
        }
        return $this->response([
            'total' => $data['total'],
            'rows' => $data['rows']
        ]);
    }

    public function agregar_tipos() {
        $nom_tipo = $this->input->post('tipo', TRUE);

        if (empty($nom_tipo) || !is_string($nom_tipo)) {
            return $this->response(['status' => 'error', 'message' => 'Tipo no proporcionado o inválido'], 400);
        }

        $datos = ['nom_tipo' => $nom_tipo];
        $result = $this->Tipos_model->agregar($datos, $nom_tipo);

        if ($result === 0) {
            return $this->response(['status' => 'error', 'message' => 'Error al agregar el tipo, posible repeticion del tipo'], 400);
        }

        return $this->response(['status' => 'success', 'message' => 'Tipo agregado correctamente']);
    }

    public function ver_vehiculos_tipos() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $vehiculos = $this->Comunes_model->cargar_uso('vehiculos', 'tipo_id', $id);
        return $this->response(['status' => 'success', 'data' => $vehiculos]);
    }

    public function eliminar_tipos() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $result = $this->Tipos_model->eliminar($id);

        if ($result === 0) {
            return $this->response(['status' => 'error', 'message' => 'Error al eliminar el tipo o tipo no encontrado'], 400);
        }

        return $this->response(['status' => 'success', 'message' => 'Tipo eliminado correctamente']);
    }

    private function validar_id($id) {
        return !empty($id) && is_numeric($id) && (int)$id > 0;
    }

    private function response($data, $status_code = 200) {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header($status_code)
            ->set_output(json_encode($data));
    }
}

?>
