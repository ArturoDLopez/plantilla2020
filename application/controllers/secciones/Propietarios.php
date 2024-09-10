<?php

class Propietarios extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('secciones/Propietarios_model');
    }

    public function index() {
        $data = new stdClass();
		$login = true;
		$data->login = $login;
        $this->load->view('template/header', $data);
        $this->load->view('secciones/re_propietarios');
        $this->load->view('template/footer');
    }

    public function cargar_propietarios() {
        $limit = (int)$this->input->get('limit', TRUE);
        $offset = (int)$this->input->get('offset', TRUE);

        $propietarios = $this->Propietarios_model->cargar($limit, $offset);
        foreach($propietarios['rows'] as $pro){
            $pro->id = encriptar($pro->id);
        }
        return $this->response($propietarios);
    }

    public function cargar_num_serie() {
        $condiciones = ['borrado' => 0];
        $numeros_serie = $this->Propietarios_model->traer_catalogos('vehiculos', $condiciones);
        return $this->response(['status' => 'success', 'data' => $numeros_serie]);
    }

    public function cargar_curp() {
        $condiciones = ['borrado' => 0];
        $curps = $this->Propietarios_model->traer_catalogos('duenos', $condiciones);
        return $this->response(['status' => 'success', 'data' => $curps]);
    }

    public function datos_num_serie() {
        $id = $this->input->post('vehiculos_id', TRUE);

        if (empty($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID de vehículo requerido'], 400);
        }

        $condiciones = ['borrado' => 0, 'actual' => 1, 'vehiculos_id' => $id];
        $datos = $this->Propietarios_model->traer_catalogos2('propietario', $condiciones);
        return $this->response(['status' => 'success', 'data' => $datos]);
    }

    public function consultar_propietario() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $propietario = $this->Propietarios_model->get_by_id('propietario', ['id' => $id]);

        if (empty($propietario)) {
            return $this->response(['status' => 'error', 'message' => 'Propietario no encontrado'], 404);
        }

        return $this->response(['status' => 'success', 'data' => $propietario]);
    }

    public function agregar_propietario() {
        $datos = [
            'vehiculos_id' => $this->input->post('num_serie', TRUE),
            'duenos_id' => $this->input->post('dueno', TRUE),
            'actual' => $this->input->post('actual', TRUE),
            'fecha_inicio' => $this->input->post('fecha_i', TRUE),
            'fecha_termino' => $this->input->post('fecha_t', TRUE),
        ];

        if (empty($datos['vehiculos_id']) || empty($datos['duenos_id']) || empty($datos['fecha_inicio'])) {
            return $this->response(['status' => 'error', 'message' => 'Todos los campos son requeridos'], 400);
        }

        $propietario_id = $this->Propietarios_model->agregar($datos);

        if (!$propietario_id) {
            return $this->response(['status' => 'error', 'message' => 'Error al agregar propietario'], 500);
        }

        return $this->response(['status' => 'success', 'message' => 'Propietario agregado exitosamente', 'id' => $propietario_id], 201);
    }

    public function editar_propietario() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $datos = [
            'vehiculos_id' => $this->input->post('num_serie', TRUE),
            'duenos_id' => $this->input->post('dueno', TRUE),
            'actual' => $this->input->post('actual', TRUE),
            'fecha_inicio' => $this->input->post('fecha_i', TRUE),
            'fecha_termino' => $this->input->post('fecha_t', TRUE),
        ];

        $resultado = $this->Propietarios_model->actualizar('propietario', $datos, $id);

        if (!$resultado) {
            return $this->response(['status' => 'error', 'message' => 'Error al actualizar propietario'], 500);
        }

        return $this->response(['status' => 'success', 'message' => 'Propietario actualizado exitosamente']);
    }

    public function eliminar_propietario() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $borrado = $this->Propietarios_model->borrado_logico($id, 'propietario');

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
