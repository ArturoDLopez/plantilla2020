<?php

class Placas extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('secciones/Placas_model');
    }

    public function index() {
        $data = new stdClass();
		$login = true;
		$data->login = $login;
        $this->load->view('template/header', $data);
        $this->load->view('secciones/re_placas');
        $this->load->view('template/footer');
    }

    public function cargar_placas() {
        $limit = (int)$this->input->get('limit', TRUE);
        $offset = (int)$this->input->get('offset', TRUE);
        $duenos = $this->Placas_model->cargar($limit, $offset);
        foreach($duenos['rows'] as $dueno){
            $dueno->id = encriptar($dueno->id);
        }

        return $this->response($duenos);
    }

    public function consultar_placa() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $placa = $this->Placas_model->get_by_id('placas', ['id' => $id]);

        if (empty($placa)) {
            return $this->response(['status' => 'error', 'message' => 'Placa no encontrada'], 404);
        }

        return $this->response(['status' => 'success', 'data' => $placa]);
    }

    public function agregar_placa() {
        $placa = $this->input->post('placa', TRUE);

        if (empty($placa) || !is_string($placa)) {
            return $this->response(['status' => 'error', 'message' => 'Placa no proporcionada o inválida'], 400);
        }

        $datos = ['placa' => $placa];
        $datos['suu_id'] = $this->auth->getId();
        $result = $this->Placas_model->agregar($datos, $placa);

        if ($result === false) {
            return $this->response(['status' => 'error', 'message' => 'Error al agregar la placa'], 400);
        }

        return $this->response(['status' => 'success', 'message' => 'Placa agregada correctamente']);
    }

    public function editar_placa() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);
        $placa = $this->input->post('placa', TRUE);

        if (!$this->validar_id($id) || empty($placa) || !is_string($placa)) {
            return $this->response(['status' => 'error', 'message' => 'ID o placa inválidos'], 400);
        }

        $datos = ['placa' => $placa];
        $result = $this->Placas_model->actualizar('placas', $datos, $id, $placa);

        if ($result === false) {
            return $this->response(['status' => 'error', 'message' => 'Error al actualizar la placa'], 400);
        }

        return $this->response(['status' => 'success', 'message' => 'Placa actualizada correctamente']);
    }

    public function eliminar_placa() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $result = $this->Placas_model->borrado_logico($id, 'placas');

        if ($result === 0) {
            return $this->response(['status' => 'error', 'message' => 'Error al eliminar la placa o placa no encontrada'], 400);
        }

        return $this->response(['status' => 'success', 'message' => 'Placa eliminada correctamente']);
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
