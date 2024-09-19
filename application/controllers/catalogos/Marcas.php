<?php

class Marcas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('catalogos/Marcas_model');
        $this->load->model('comunes/Comunes_model');
        $this->load->library('Pdf');
    }

    public function index() {
        $data = new stdClass();
		$login = true;
		$data->login = $login;
        $this->load->view('template/header', $data);
        $this->load->view('catalogos/re_marcas');
        $this->load->view('template/footer');
    }

    public function cargar_marcas() {
        $limit = (int)$this->input->get('limit', TRUE);
        $offset = (int)$this->input->get('offset', TRUE);

        $marcas = $this->Marcas_model->cargar($limit, $offset);
        foreach($marcas['rows'] as $marca){
            $marca->id = encriptar($marca->id);
        }
        return $this->response($marcas);
    }

    public function agregar_marcas() {
        $nom_marca = $this->input->post('marca', TRUE);

        if (empty($nom_marca) || !is_string($nom_marca)) {
            return $this->response(['status' => 'error', 'message' => 'Marca no proporcionada o inválida'], 400);
        }

        $datos = ['nom_marca' => $nom_marca];
        $datos['suu_id'] = $this->auth->getId();
        $result = $this->Marcas_model->agregar($datos, $nom_marca);

        if ($result === 0) {
            return $this->response(['status' => 'error', 'message' => 'Error al agregar la marca, posible repeticion de datos'], 400);
        }

        return $this->response(['status' => 'success', 'message' => 'Marca agregada correctamente']);
    }

    public function ver_vehiculos_marcas() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $vehiculos = $this->Comunes_model->cargar_uso('vehiculos', 'marcas_id', $id);
        return $this->response(['status' => 'success', 'data' => $vehiculos]);
    }

    public function eliminar_marcas() {
        $id = $this->input->post('id', TRUE);
        $id = desencriptar($id);

        if (!$this->validar_id($id)) {
            return $this->response(['status' => 'error', 'message' => 'ID inválido'], 400);
        }

        $result = $this->Marcas_model->eliminar($id);

        if ($result === 0) {
            return $this->response(['status' => 'error', 'message' => 'Error al eliminar la marca o marca no encontrada'], 400);
        }

        return $this->response(['status' => 'success', 'message' => 'Marca eliminada correctamente']);
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

    public function print_pdf(){
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetTitle('TCPDF Example 002');
        // remove default header/footer
        $pdf->AddPage();

        $html = '<h2>HOLA</h2>';

        // print a block of text using Write()
        $pdf->writeHTML($html);

        //Close and output PDF document
        $pdf->Output('example_002.pdf', 'I');
    }
}
?>
