<?php

class Robos extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('secciones/Robos_model');
    }

    public function index() {
        if ($this->auth->is_signed()) {
			
            redirect(base_url()."secciones/robos/cargar_vistas");
        } else {
			
            redirect(base_url()."seccion/vista_denegada");
        }

    }

    public function cargar_vistas(){
        $data = new stdClass();
		$login = true;
		$data->login = $login;
        $this->load->view('template/header', $data);
        $this->load->view('secciones/re_robos');
        $this->load->view('template/footer');
    }

    public function cargar_robos() {
        $limit = (int)$this->input->get('limit', TRUE);
        $offset = (int)$this->input->get('offset', TRUE);

        $robos = $this->Robos_model->cargar($limit, $offset);
        foreach($robos['rows'] as $robo){
            $robo->id = encriptar($robo->id);
        }
        return $this->response($robos);
    }

    public function cargar_num_serie() {
        $condiciones = ['borrado' => 0];
        $numeros_serie = $this->Robos_model->traer_num_serie('vehiculos', $condiciones);
        return $this->response(['status' => 'success', 'data' => $numeros_serie]);
    }

    public function consultar_robo() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $robo = $this->Robos_model->get_by_id('robos', ['id' => $id]);
        //$robo->id = encriptar($robo->id);

        if (empty($robo)) {
            return $this->response(['status' => 'error', 'message' => 'Robo no encontrado'], 404);
        }

        return $this->response(['status' => 'success', 'data' => $robo]);
    }

    public function buscar_datos() {
        $serie = $this->input->post('serie', TRUE);

        if (empty($serie)) {
            return $this->response(['status' => 'error', 'message' => 'Número de serie requerido'], 400);
        }

        $registro = $this->Robos_model->serie_placa($serie);
        return $this->response(['status' => 'success', 'data' => $registro]);
    }

    public function agregar_robo() {
        $datos = [
            'vehiculos_id' => $this->input->post('num_serie', TRUE),
            'placas_id' => $this->input->post('placas_id', TRUE),
            'duenos_id' => $this->input->post('duenos_id', TRUE),
            'descripcion' => $this->input->post('descripcion', TRUE),
            'fecha' => $this->input->post('fecha_r', TRUE),
        ];

        if (empty($datos['vehiculos_id']) || empty($datos['placas_id']) || empty($datos['descripcion']) || empty($datos['fecha'])) {
            return $this->response(['status' => 'error', 'message' => 'Todos los campos son requeridos'], 400);
        }

        $robo_id = $this->Robos_model->agregar($datos);

        if (!$robo_id) {
            return $this->response(['status' => 'error', 'message' => 'Error al agregar el robo'], 500);
        }

        return $this->response(['status' => 'success', 'message' => 'Robo agregado exitosamente', 'id' => $robo_id], 201);
    }

    public function editar_robo() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $datos = [
            'vehiculos_id' => $this->input->post('num_serie', TRUE),
            'placas_id' => $this->input->post('placas_id', TRUE),
            'duenos_id' => $this->input->post('duenos_id', TRUE),
            'descripcion' => $this->input->post('descripcion', TRUE),
            'fecha' => $this->input->post('fecha_r', TRUE),
        ];

        $resultado = $this->Robos_model->actualizar('robos', $datos, $id);

        if (!$resultado) {
            return $this->response(['status' => 'error', 'message' => 'Error al actualizar el robo'], 500);
        }

        return $this->response(['status' => 'success', 'message' => 'Robo actualizado exitosamente']);
    }

    public function eliminar_robo() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $borrado = $this->Robos_model->borrado_logico($id, 'robos');

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
