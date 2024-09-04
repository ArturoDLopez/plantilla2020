<?php

class Marcas extends CI_Controller{
    public function __construct(){
        parent::__construct();
        //$this->load->model('Catalogos_model');
        $this->load->model('catalogos/Marcas_model');
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view('catalogos/re_marcas');
        $this->load->view('template/footer');
    }

    public function cargar_marcas(){
        echo json_encode($this->Marcas_model->cargar());
    }

    public function agregar_marcas(){
        $nom_marca = $this->input->post('marca');
        $datos = array(
            'nom_marca' => $this->input->post('marca')
        );
        echo $this->Marcas_model->agregar($datos, $nom_marca);
    }

    public function eliminar_marcas(){
        $id = $this->input->post('id');
        echo $this->Marcas_model->eliminar($id);
    }

   /*  public function index(){

        $data = new stdClass();

        $marcas = array('marcas' => $this->Marcas_model->cat_marcas());

        $data->marcas = $marcas;

        $this->load->view('template/header');
        $this->load->view('seccion/re_marcas', $data);
        $this->load->view('template/footer');
    }

    public function cargar_marcas(){
        $datos = $this->Marcas_model->cat_marcas();
        echo (json_encode($datos));
    }

    public function agregar_marcas(){
        $valor = $this->input->post('nombre');
        $datos = array(
            'nom_marca' => $valor,
            'fecha_registro' => date('Y-m-d H:i:s'),
            'borrado' => 0
        );
        $num_row = $this->Marcas_model->buscar_registro($valor);
        if($num_row == 0){
            $insert_id = $this->Marcas_model->registrar_marca($datos);
            echo $insert_id;
        }
        else{
            echo 0;
        }
    }

 */
}

?>