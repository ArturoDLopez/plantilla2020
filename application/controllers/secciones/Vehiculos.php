<?php

class Vehiculos extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('secciones/Vehiculos_model');
    }

    public function index() {
        $data = new stdClass();
		$login = true;
		$data->login = $login;
        $this->load->view('template/header', $data);
        $this->load->view('secciones/re_vehiculos');
        $this->load->view('template/footer');
    }

    public function cargar_vehiculos() {
        $limit = (int)$this->input->get('limit', TRUE);
        $offset = (int)$this->input->get('offset', TRUE);

        $total = $this->Vehiculos_model->contar_vehiculos();
        $vehiculos = $this->Vehiculos_model->obtener_vehiculos($limit, $offset);
        foreach($vehiculos as $ve){
            $ve->id = encriptar($ve->id);
        }
        $response = [
            'total' => $total,
            'rows' => $vehiculos
        ];

        return $this->response($response);
    }

    public function consultar_auto() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $auto = $this->Vehiculos_model->get_by_id('vehiculos', ['id' => $id]);

        if (empty($auto)) {
            return $this->response(['status' => 'error', 'message' => 'Auto no encontrado'], 404);
        }

        return $this->response(['status' => 'success', 'data' => $auto]);
    }

    public function agregar_vehiculos() {
        $datos = [
            'num_serie' => $this->input->post('num_serie', TRUE),
            'marcas_id' => $this->input->post('marca', TRUE),
            'modelo' => $this->input->post('modelo', TRUE),
            'colores_id' => $this->input->post('color', TRUE),
            'tipo_id' => $this->input->post('tipo', TRUE),
        ];

        if (empty($datos['num_serie']) || empty($datos['marcas_id']) || empty($datos['modelo'])) {
            return $this->response(['status' => 'error', 'message' => 'Todos los campos son requeridos'], 400);
        }

        $resultado = $this->Vehiculos_model->agregar($datos, $datos['num_serie']);

        if (!$resultado) {
            return $this->response(['status' => 'error', 'message' => 'Error al agregar vehículo'], 500);
        }

        return $this->response(['status' => 'success', 'message' => 'Vehículo agregado exitosamente', 'id' => $resultado], 201);
    }

    public function cargar_marcas() {
        $marcas = $this->Vehiculos_model->traer_catalogos('marcas');
        return $this->response(['status' => 'success', 'data' => $marcas]);
    }

    public function cargar_colores() {
        $colores = $this->Vehiculos_model->traer_catalogos('colores');
        return $this->response(['status' => 'success', 'data' => $colores]);
    }

    public function cargar_tipos() {
        $tipos = $this->Vehiculos_model->traer_catalogos('tipo');
        return $this->response(['status' => 'success', 'data' => $tipos]);
    }

    public function editar_auto() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $datos = [
            'num_serie' => $this->input->post('num_serie', TRUE),
            'marcas_id' => $this->input->post('marca', TRUE),
            'modelo' => $this->input->post('modelo', TRUE),
            'colores_id' => $this->input->post('color', TRUE),
            'tipo_id' => $this->input->post('tipo', TRUE),
        ];

        $resultado = $this->Vehiculos_model->actualizar('vehiculos', $datos, $id);

        if (!$resultado) {
            return $this->response(['status' => 'error', 'message' => 'Error al actualizar vehículo'], 500);
        }

        return $this->response(['status' => 'success', 'message' => 'Vehículo actualizado exitosamente']);
    }

    public function eliminar_auto() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $borrado = $this->Vehiculos_model->borrado_logico($id, 'vehiculos');

        if ($borrado != 1) {
            return $this->response(['status' => 'error', 'message' => 'No fue posible eliminar el registro'], 500);
        }

        return $this->response(['status' => 'success', 'message' => 'Registro eliminado correctamente']);
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
