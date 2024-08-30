<?php

class Dashboard extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->model('Catalogos_model');
    }

    public function enter_to_app(){
        $this->load->view('seccion/login');
    }

    public function index(){

        if($this->session->userdata('is_logged')){
            $this->load->view('template/header');
			$this->load->view('seccion/tabla_vehiculos');
		    $this->load->view('template/footer');
        }
        else{
            redirect('');
        }
        
    }

    public function buscar_datos(){
        $serie = $_POST['serie'];
        
        $data = new stdClass();
        $placa = array('placa' => $this->Catalogos_model->serie_placa($serie));
        $registro = $this->Catalogos_model->serie_placa($serie);
        $data->placa = $placa;
        //echo($placa);
        //print_r(json_encode($registro));
        echo(json_encode($registro));
        //var_dump($data);
        //echo ($registro);
        /* {
            ["placa"]=>
            string(5) "99999"
            ["nombre"]=>
            string(6) "Arturo"
            ["apellido_p"]=>
            string(5) "Duran"
          } */
    }

    //---------------- Vistas ---------------------

    public function registrar_duenos(){

        $data = new stdClass();
        $duenos = array('duenos' => $this->Catalogos_model->cat_duenos());
        $data->duenos = $duenos;
        
        $this->load->view('template/header');
        $this->load->view('seccion/re_duenos', $data);
        $this->load->view('template/footer');
    }

    public function registrar_autos(){

        $data = new stdClass();

        $marcas = array('marcas' => $this->Catalogos_model->cat_marcas());
        $colores = array('colores' => $this->Catalogos_model->cat_colores(),);
        $tipos = array('tipos' => $this->Catalogos_model->cat_tipos(),);
        
        $vehiculos = array('vehiculos' => $this->Catalogos_model->cat_vehiculos());

        $data->vehiculos = $vehiculos;
        $data->marcas = $marcas;
        $data->colores = $colores;
        $data->tipos = $tipos;

        /* var_dump('estas son las marcas: ');
        var_dump($marcas); */
        //var_dump($colores);//

        $this->load->view('template/header');
        $this->load->view('seccion/re_autos', $data);
        $this->load->view('template/footer');
    }

    public function registrar_placas(){

        $data = new stdClass();
        $placas = array('placas' => $this->Catalogos_model->cat_placas());
        $data->placas = $placas;
        
        $this->load->view('template/header');
        $this->load->view('seccion/re_placas', $data);
        $this->load->view('template/footer');
    }
    
    public function registrar_propietarios(){

        $data = new stdClass();

        $duenos = array('duenos' => $this->Catalogos_model->cat_duenos());
        $data->duenos = $duenos;
        $vehiculos = array('vehiculos' => $this->Catalogos_model->cat_vehiculos());
        $data->vehiculos = $vehiculos;
        $propietarios = array('pro' => $this->Catalogos_model->cat_propietarios());
        $data->propietarios = $propietarios;
        

        $this->load->view('template/header');
        $this->load->view('seccion/re_propietarios', $data);
        $this->load->view('template/footer');
    }


    public function registrar_emplacado(){
        $data = new stdClass();

        $vehiculos = array('vehiculos' => $this->Catalogos_model->cat_vehiculos());
        $data->vehiculos = $vehiculos;
        $placas = array('placas' => $this->Catalogos_model->cat_placas());
        $data->placas = $placas;
        $emplacado = array('emplacado' => $this->Catalogos_model->cat_emplacado());
        $data->emplacado = $emplacado;

        $this->load->view('template/header');
        $this->load->view('seccion/re_emplacado', $data);
        $this->load->view('template/footer');
    }

    public function registro_catalogos(){

        $data = new stdClass();

        $marcas = array('marcas' => $this->Catalogos_model->cat_marcas());
        $colores = array('colores' => $this->Catalogos_model->cat_colores());
        $tipos = array('tipos' => $this->Catalogos_model->cat_tipos());

        $data->marcas = $marcas;
        $data->colores = $colores;
        $data->tipos = $tipos;

        $this->load->view('template/header');
        $this->load->view('seccion/re_marcas', $data);
        $this->load->view('template/footer');
    }

    public function registrar_robos(){
        $data = new stdClass();

        $vehiculos = array('vehiculos' => $this->Catalogos_model->cat_vehiculos());
        $data->vehiculos = $vehiculos;
        $placas = array('placas' => $this->Catalogos_model->cat_placas());
        $data->placas = $placas;
        $robos = array('robos' => $this->Catalogos_model->cat_robos());
        $data->robos = $robos;
        $duenos = array('duenos' => $this->Catalogos_model->cat_duenos());
        $data->duenos = $duenos;

        $this->load->view('template/header');
        $this->load->view('seccion/re_robos', $data);
        $this->load->view('template/footer');
    }

    //---------------- Agregar ------------------------

    public function agregar($nombre, $valor = FALSE, $datos, $tabla){
        if($valor != FALSE){
            $datos = array(
                $nombre => $valor,
                'fecha_registro' => date('Y-m-d H:i:s'),
                'eliminado' => 0
            );
        }
        
        $numero = $this->llamar_catalogo($tabla, $datos, $nombre);
        if ($numero == 1){
            $data = 0;
            if($tabla == 'marcas'){
                $data = $this->Catalogos_model->cat_marcas();
            }
            if($tabla == 'colores'){
                $data = $this->Catalogos_model->cat_colores();
            }
            if($tabla == 'tipo'){
                $data = $this->Catalogos_model->cat_tipos();
            }
            if($tabla == 'vehiculos'){
                $data = $this->Catalogos_model->cat_vehiculos();
            }            
            if($tabla == 'placas'){
                $data = $this->Catalogos_model->cat_placas();
            }            
            if($tabla == 'tipo'){
                $data = $this->Catalogos_model->cat_tipos();
            }
            echo json_encode($data);
        }else{
            echo $numero;
        }
    }
    
    public function agregar_marcas(){
        $valor = $this->input->post('nombre');
        $this->agregar('nom_marca', $valor, '', 'marcas');
    }

    public function agregar_colores(){
        $valor = $this->input->post('nombre');
        $this->agregar('nom_color', $valor, '', 'colores');
    }

    public function agregar_tipos(){
        $valor = $this->input->post('nombre');
        $this->agregar('nom_tipo', $valor, '', 'tipo');
    }

    public function agregar_duenos(){
        $datos = array(
            'nombre' => $this->input->post('nombre'),
            'apellido_p' => $this->input->post('ap'),
            'apellido_m' => $this->input->post('am'),
            'fecha_registro' => date('Y-m-d H:i:s'),
            'eliminado' => 0

        );
        $this->Catalogos_model->agregar_catalogo('dueños', $datos);
        echo json_encode($this->Catalogos_model->cat_duenos());
        //$this->registrar_duenos();
    }

    public function agregar_placas(){
        $datos = array(
            'placa' => $this->input->post('placa'),
            'fecha_registro' => date('Y-m-d H:i:s'),
            'eliminado' => 0
        );
        $this->agregar('placa', FALSE, $datos, 'placas');
        //echo json_encode($this->Catalogos_model->cat_placas());
    }

    public function agregar_vehiculos(){
        $datos = array(
            'num_serie' => $this->input->post('num_serie'),
            'marcas_id' => $this->input->post('marca'),
            'modelo' => $this->input->post('modelo'),
            'colores_id' => $this->input->post('color'),
            'tipo_id' => $this->input->post('tipo'),
            'fecha_registro' => date('Y-m-d H:i:s'),
            'eliminado' => 0
        );
        $this->agregar('num_serie', FALSE, $datos,'vehiculos');
        //echo json_encode($this->Catalogos_model->cat_vehiculos());
        //$this->registrar_autos();
    }

    public function agregar_propietarios(){
        $datos = array(
            'vehiculos_id' => $this->input->post('num_serie'),
            'duenos_id' => $this->input->post('dueno'),
            'actual' => $this->input->post('actual'),
            'fecha_inicio' => $this->input->post('fecha_i'),
            'fecha_termino' => $this->input->post('fecha_t'),
            'fecha_registro' => date('Y-m-d H:i:s'),
            'eliminado' => 0

        );
        $this->Catalogos_model->agregar_catalogo('propietario', $datos);
        echo json_encode($this->Catalogos_model->cat_propietarios());
    }

    public function agregar_emplacado(){
        $datos = array(
            'vehiculos_id' => $this->input->post('num_serie'),
            'placas_id' => $this->input->post('placa'),
            'actual' => $this->input->post('actual'),
            'fecha_inicio' => $this->input->post('fecha_i'),
            'fecha_termino' => $this->input->post('fecha_t'),
            'fecha_registro' => date('Y-m-d H:i:s'),
            'eliminado' => 0
        );
        $this->Catalogos_model->agregar_catalogo('emplacado', $datos);
        echo json_encode($this->Catalogos_model->cat_emplacado());
    }

    public function agregar_robo(){

        $datos = array(
            'vehiculos_id' => $this->input->post('num_serie'),
            'placas_id' => $this->input->post('placas_id'),
            'duenos_id' => $this->input->post('duenos_id'),
            'descripcion' => $this->input->post('descripcion'),
            'fecha' => $this->input->post('fecha_r'),
            'fecha_registro' => date('Y-m-d H:i:s'),
            'eliminado' => 0

        );

        $this->Catalogos_model->agregar_catalogo('robos', $datos);
        $robos = $this->Catalogos_model->cat_robos();
        echo (json_encode($robos));
        //$this->registrar_robos();
    }

    //--------------- Consultar ------------------------------
    public function consultar_dueno(){
        $tabla = 'dueños';
        $id = array('id' => $this->input->post('id'));
        echo json_encode($this->Catalogos_model->get_by_id($tabla, $id));
    }

    public function consultar_propietario(){
        $tabla = 'propietario';
        $id = array('id' => $this->input->post('id'));
        echo json_encode($this->Catalogos_model->get_by_id($tabla, $id));
    }

    public function consultar_emplacado(){
        $tabla = 'emplacado';
        $id = array('id' => $this->input->post('id'));
        echo json_encode($this->Catalogos_model->get_by_id($tabla, $id));
    }

    public function consultar_auto(){
        $tabla = 'vehiculos';
        $id = array('id' => $this->input->post('id'));
        echo json_encode($this->Catalogos_model->get_by_id($tabla, $id));
    }

    public function consultar_robo(){
        $tabla = 'robos';
        $id = array('id' => $this->input->post('id'));
        echo json_encode($this->Catalogos_model->get_by_id($tabla, $id));
    }

    //--------------- Cargar solo datos iniciales--------------

    public function cargar_robos(){
        $robos = $this->Catalogos_model->cat_robos();
        echo (json_encode($robos));
    }

    public function cargar_marcas(){
        $datos = $this->Catalogos_model->cat_marcas();
        echo (json_encode($datos));
    }

    public function cargar_colores(){
        $datos = $this->Catalogos_model->cat_colores();
        echo (json_encode($datos));
    }

    public function cargar_tipos(){
        $datos = $this->Catalogos_model->cat_tipos();
        echo (json_encode($datos));
    }

    public function cargar_propietarios(){
        echo (json_encode($this->Catalogos_model->cat_propietarios()));
    }

    public function cargar_duenos(){
        echo (json_encode($this->Catalogos_model->cat_duenos()));
    }

    public function cargar_autos(){
        echo (json_encode($this->Catalogos_model->cat_vehiculos()));
    }

    public function cargar_placas(){
        echo (json_encode($this->Catalogos_model->cat_placas()));
    }

    public function cargar_emplacado(){
        echo (json_encode($this->Catalogos_model->cat_emplacado()));
    }

    //--------------- Edicion -------------------------

    public function editar_robo(){
        $id = $this->input->post('id');
        $datos = array(
            'vehiculos_id' => $this->input->post('num_serie'),
            'placas_id' => $this->input->post('placas_id'),
            'duenos_id' => $this->input->post('duenos_id'),
            'descripcion' => $this->input->post('descripcion'),
            'fecha' => $this->input->post('fecha_r'),
        );
        $this->Catalogos_model->actualizar('robos', $datos, $id);
        $robos = $this->Catalogos_model->cat_robos();
        echo json_encode($robos);
    }

    public function editar_emplacado(){
        $id = $this->input->post('id');
        $datos = array(
            'vehiculos_id' => $this->input->post('num_serie'),
            'placas_id' => $this->input->post('placa'),
            'actual' => $this->input->post('actual'),
            'fecha_inicio' => $this->input->post('fecha_i'),
            'fecha_termino' => $this->input->post('fecha_t'),
        );
        $this->Catalogos_model->actualizar('emplacado', $datos, $id);
        echo json_encode($this->Catalogos_model->cat_emplacado());
    }

    public function editar_dueno(){

        $id = $this->input->post('id');
        $dueno['nombre'] = $this->input->post('nombre');
        $dueno['apellido_p'] = $this->input->post('ap');
        $dueno['apellido_m'] = $this->input->post('am');
        $this->Catalogos_model->actualizar('dueños', $dueno, $id);
        echo json_encode($this->Catalogos_model->cat_duenos());
    }

    public function editar_propietario(){
        $id = $this->input->post('id');
        $datos = array(
            'vehiculos_id' => $this->input->post('num_serie'),
            'duenos_id' => $this->input->post('dueno'),
            'actual' => $this->input->post('actual'),
            'fecha_inicio' => $this->input->post('fecha_i'),
            'fecha_termino' => $this->input->post('fecha_t')

        );
        $this->Catalogos_model->actualizar('propietario', $datos, $id);
        echo json_encode($this->Catalogos_model->cat_propietarios());
    }

    public function editar_auto(){
        $id = $this->input->post('id');
        $datos = array(
            'num_serie' => $this->input->post('num_serie'),
            'marcas_id' => $this->input->post('marca'),
            'modelo' => $this->input->post('modelo'),
            'colores_id' => $this->input->post('color'),
            'tipo_id' => $this->input->post('tipo'),
            'fecha_registro' => date('Y-m-d H:i:s'),
            'eliminado' => 0

        );
        $this->Catalogos_model->actualizar('vehiculos', $datos, $id);
        echo json_encode($this->Catalogos_model->cat_vehiculos());
    }

    //--------------- Eliminacion ----------------------
    public function eliminar_marcas(){
        $id = $this->input->post('id');
        $this->Catalogos_model->eliminado_logico($id, 'marcas');
        echo $this->cargar_marcas();
    }
    public function eliminar_colores(){
        $id = $this->input->post('id');
        $this->Catalogos_model->eliminado_logico($id, 'colores');
        echo $this->cargar_colores();
    }
    public function eliminar_tipos(){
        $id = $this->input->post('id');
        $this->Catalogos_model->eliminado_logico($id, 'tipo');
        echo $this->cargar_tipos();
    }

    public function eliminar_emplacado(){
        $id = $this->input->post('id');
        $this->Catalogos_model->eliminado_logico($id, 'emplacado');
        echo $this->cargar_emplacado();
    }

    public function eliminar_propietario(){
        $id = $this->input->post('id');
        $this->Catalogos_model->eliminado_logico($id, 'propietario');
        echo $this->cargar_propietarios();
    }

    public function eliminar_dueno(){
        $id = $this->input->post('id');
        $this->Catalogos_model->eliminado_logico($id, 'dueños');
        echo $this->cargar_duenos();
    }

    public function eliminar_placas(){
        echo $this->Catalogos_model->eliminado_logico($this->input->post('id'), 'placas');
    }

    public function eliminar_auto(){
        $id = $this->input->post('id');
        echo $this->Catalogos_model->eliminado_logico($id, 'vehiculos');
    }

    public function eliminar_robo(){
        echo $this->Catalogos_model->eliminado_logico($this->input->post('id'), 'robos');
    }

    //-------------- Llamado ---------------------------

    public function llamar_catalogo($tabla, $datos, $unique){
        return $this->Catalogos_model->agregar_catalogo($tabla, $datos, $unique);
        //$this->registro_catalogos();
    }


}