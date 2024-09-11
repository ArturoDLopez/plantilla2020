<?php

class Duenos extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('secciones/Duenos_model');
    }

    public function index() {
        $data = new stdClass();
		$login = true;
		$data->login = $login;
        $this->load->view('template/header', $data);
        $this->load->view('secciones/re_duenos');
        $this->load->view('template/footer');
    }

    private function get_dueno_data() {
        return array(
            'curp' => $this->input->post('curp', TRUE),
            'nombre' => $this->input->post('nombre', TRUE),
            'apellido_p' => $this->input->post('ap', TRUE),
            'apellido_m' => $this->input->post('am', TRUE),
        );
    }

    public function cargar_duenos() {
        $limit = (int)$this->input->get('limit', TRUE);
        $offset = (int)$this->input->get('offset', TRUE);

        $duenos = $this->Duenos_model->cargar($limit, $offset);
        foreach($duenos['rows'] as $dueno){
            $dueno->id = encriptar($dueno->id);
        }
        return $this->response($duenos);
    }

    public function consultar_dueno() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $dueno = $this->Duenos_model->get_by_id('duenos', ['id' => $id]);

        if (empty($dueno)) {
            return $this->response(['status' => 'error', 'message' => 'Dueño no encontrado'], 404);
        }

        return $this->response(['status' => 'success', 'data' => $dueno]);
    }

    public function agregar_dueno() {
        $datos = $this->get_dueno_data();

        if (empty($datos['curp']) || empty($datos['nombre']) || empty($datos['apellido_p']) || empty($datos['apellido_m'])) {
            return $this->response(['status' => 'error', 'message' => 'Todos los campos son requeridos'], 400);
        }
        $datos['suu_id'] = $this->auth->getId();
        $insert_id = $this->Duenos_model->agregar($datos, $datos['curp']);
        if ($insert_id == 0) {
            return $this->response(['status' => 'error', 'message' => 'Error al agregar dueño'], 500);
        } elseif($insert_id == 3){
            return $this->response(['status' => 'error', 'message' => 'La CURP ya ha sido registrada'], 406);
        }

        return $this->response(['status' => 'success', 'message' => 'Dueño agregado exitosamente', 'id' => $insert_id], 201);
    }

    public function editar_dueno() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);
        $datos = $this->get_dueno_data();

        if (!$this->validar_id($id) || empty($datos['curp']) || empty($datos['nombre']) || empty($datos['apellido_p']) || empty($datos['apellido_m'])) {
            return $this->response(['status' => 'error', 'message' => 'Todos los campos son requeridos'], 400);
        }

        $dueno_exists = $this->Duenos_model->get_by_id('duenos', ['id' => $id]);
        if (!$dueno_exists) {
            return $this->response(['status' => 'error', 'message' => 'Dueño no encontrado'], 404);
        }

        $updated = $this->Duenos_model->actualizar('duenos', $datos, $id, $datos['curp']);
        
        if (!$updated) {
            return $this->response(['status' => 'error', 'message' => 'Error al actualizar dueño, posible dato duplicado'], 500);
        }

        return $this->response(['status' => 'success', 'message' => 'Dueño actualizado exitosamente']);
    }

    public function eliminar_dueno() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $dueno_exists = $this->Duenos_model->get_by_id('duenos', ['id' => $id]);
        if (!$dueno_exists) {
            return $this->response(['status' => 'error', 'message' => 'Dueño no encontrado'], 404);
        }

        $borrado = $this->Duenos_model->borrado_logico($id, 'duenos');
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
