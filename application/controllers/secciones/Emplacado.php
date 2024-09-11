<?php

class Emplacado extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('secciones/Emplacado_model');
    }

    public function index() {
        $data = new stdClass();
		$login = true;
		$data->login = $login;
        $this->load->view('template/header', $data);
        $this->load->view('secciones/re_emplacado');
        $this->load->view('template/footer');
    }

    public function cargar_emplacado() {
        $limit = $this->input->get('limit', TRUE);
        $offset = $this->input->get('offset', TRUE);
        $emplacado = $this->Emplacado_model->cargar($limit, $offset);
        foreach($emplacado['rows'] as $dueno){
            $dueno->id = encriptar($dueno->id);
        }
        return $this->response($emplacado);
    }

    public function datos_num_serie() {
        $id = $this->input->post('vehiculos_id', TRUE);

        if (empty($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID de vehículo requerido'], 400);
        }

        $condiciones = ['borrado' => 0, 'actual' => 1, 'vehiculos_id' => $id];
        $datos = $this->Emplacado_model->traer_catalogos2('emplacado', $condiciones);
        return $this->response(['status' => 'success', 'data' => $datos]);
    }

    public function cargar_placas_sin_asignar() {
        $condiciones = ['borrado' => 0, 'asignado' => null];
        $placas = $this->Emplacado_model->traer_catalogos('placas', $condiciones);
        return $this->response(['status' => 'success', 'data' => $placas]);
    }

    public function cargar_numero_serie() {
        $condiciones = ['borrado' => 0];
        $numeros_serie = $this->Emplacado_model->traer_catalogos('vehiculos', $condiciones);
        return $this->response(['status' => 'success', 'data' => $numeros_serie]);
    }

    public function cargar_placas_sin_asignar_excepto() {
        $id = $this->input->post('id', TRUE);

        if (empty($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID requerido'], 400);
        }

        $placas = $this->Emplacado_model->cargar_placas_sin_asignar_excepto($id);
        return $this->response(['status' => 'success', 'data' => $placas]);
    }

    public function consultar_emplacado() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (empty($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID requerido'], 400);
        }

        $emplacado = $this->Emplacado_model->get_by_id('emplacado', ['id' => $id]);
        if (empty($emplacado)) {
            return $this->response(['status' => 'error', 'message' => 'Emplacado no encontrado'], 404);
        }

        return $this->response(['status' => 'success', 'data' => $emplacado]);
    }

    public function agregar_emplacado() {
        $datos = [
            'vehiculos_id' => $this->input->post('num_serie', TRUE),
            'placas_id' => $this->input->post('placa', TRUE),
            'actual' => $this->input->post('actual', TRUE),
            'fecha_inicio' => $this->input->post('fecha_i', TRUE),
            'fecha_termino' => $this->input->post('fecha_t', TRUE),
        ];

        if (empty($datos['vehiculos_id']) || empty($datos['placas_id']) || empty($datos['fecha_inicio'])) {
            return $this->response(['status' => 'error', 'message' => 'Todos los campos son requeridos'], 400);
        }

        $emplacado_id = $this->Emplacado_model->agregar($datos);
        if (!$emplacado_id) {
            return $this->response(['status' => 'error', 'message' => 'Error al agregar emplacado'], 500);
        }

        $actualizado = $this->Emplacado_model->actualizar_placa($datos['placas_id'], 'placas', $emplacado_id);
        if (!$actualizado) {
            return $this->response(['status' => 'error', 'message' => 'Error al actualizar placa'], 500);
        }

        return $this->response(['status' => 'success', 'message' => 'Emplacado agregado exitosamente', 'id' => $emplacado_id], 201);
    }

    public function editar_emplacado() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);
        $placa_id = $this->input->post('placa', TRUE);
        $anterior_id = $this->input->post('anterior_id', TRUE);

        if (empty($id) || empty($placa_id) || empty($anterior_id)) {
            return $this->response(['status' => 'error', 'message' => 'ID, placa y anterior_id son requeridos'], 400);
        }

        $datos = [
            'vehiculos_id' => $this->input->post('num_serie', TRUE),
            'placas_id' => $placa_id,
            'actual' => $this->input->post('actual', TRUE),
            'fecha_inicio' => $this->input->post('fecha_i', TRUE),
            'fecha_termino' => $this->input->post('fecha_t', TRUE),
        ];

        $emplacado_id = $this->Emplacado_model->actualizar('emplacado', $datos, $id);
        if ($emplacado_id == 0) {
            return $this->response(['status' => 'error', 'message' => 'Error al actualizar emplacado'], 500);
        }

        if($id == $anterior_id){
            $actualizado_placa = $this->Emplacado_model->actualizar_placa($placa_id, 'placas', $id);
            $actualizado_anterior = $this->Emplacado_model->actualizar_placa($anterior_id, 'placas', null);
            if ($actualizado_placa == 0|| $actualizado_anterior == 0) {
                return $this->response(['status' => 'error', 'message' => 'Error al actualizar placas'], 500);
            }
        }
    
        return $this->response(['status' => 'success', 'message' => 'Emplacado actualizado exitosamente']);
    }

    public function eliminar_emplacado() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);
        $anterior_id = $this->input->post('anterior_id', TRUE);

        if (empty($id) || empty($anterior_id)) {
            return $this->response(['status' => 'error', 'message' => 'ID y anterior_id son requeridos'], 400);
        }

        $borrado = $this->Emplacado_model->borrado_logico($id, 'emplacado');
        if ($borrado != 1) {
            return $this->response(['status' => 'error', 'message' => 'No fue posible eliminar el registro'], 500);
        }

        $actualizado = $this->Emplacado_model->actualizar_placa($anterior_id, 'placas', null);
        if (!$actualizado) {
            return $this->response(['status' => 'error', 'message' => 'Error al actualizar placa'], 500);
        }

        return $this->response(['status' => 'success', 'message' => 'Registro eliminado correctamente']);
    }

    private function response($data, $status_code = 200) {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header($status_code)
            ->set_output(json_encode($data));
    }
}
?>
