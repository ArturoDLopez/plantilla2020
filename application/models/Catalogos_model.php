<?php
class Catalogos_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function cat_marcas(){
        $this->db->where('borrado', '0');
        $this->db->select('id, nom_marca, fecha_registro');
        $query = $this->db->get('marcas');
        return $query->result();
    }

    public function cat_colores(){
        $this->db->where('borrado', '0');
        $this->db->select('id, nom_color, fecha_registro');
        $query = $this->db->get('colores');
        return $query->result();
    }

    public function cat_duenos(){
        $query = $this->db->get_where('dueños', array('borrado' => 0));
        return $query->result();
    }

    public function cat_placas(){
        $query = $this->db->get_where('placas', array('borrado' => 0));
        return $query->result();
    }

    public function cat_placas_asignadas(){
        $this->db->select('*');
        $this->db->from('placas');
        $this->db->where('placas.asignado IS null AND placas.borrado LIKE "0%"');
        $query = $this->db->get();
        return $query->result();
    }

    public function cat_tipos(){
        $color = $this->db->get_where('tipo', array('borrado' => 0));
        return $color->result();
    }

    public function cat_vehiculos(){
        $this->db->select('ve.id, num_serie, nom_marca, modelo, nom_color, nom_tipo, ve.fecha_registro');
        $this->db->from('vehiculos ve');
        $this->db->join('marcas mar','ve.marcas_id = mar.id','inner');
        $this->db->join('colores col','ve.colores_id = col.id','inner');
        $this->db->join('tipo','ve.tipo_id = tipo.id','inner');
        $this->db->where('ve.borrado', 0);

        $query = $this->db->get();
        
        return $query->result();
    }

    public function cat_propietarios(){
        $this->db->select('pro.id, ve.num_serie, du.nombre, du.apellido_p, du.apellido_m, pro.actual, pro.fecha_inicio, pro.fecha_termino, pro.fecha_registro');
        $this->db->from('propietario pro');
        $this->db->join('vehiculos ve','pro.vehiculos_id = ve.id','inner');
        $this->db->join('dueños du','pro.duenos_id = du.id','inner');
        $this->db->where('pro.borrado', 0);

        $query = $this->db->get();
        return $query->result();
    }

    public function cat_emplacado(){
        $this->db->select('emp.id, ve.num_serie, pl.placa, emp.actual, emp.fecha_inicio, emp.fecha_termino, emp.fecha_registro');
        $this->db->from('emplacado emp');
        $this->db->join('vehiculos ve', 'emp.vehiculos_id = ve.id', 'inner');
        $this->db->join('placas pl', 'emp.placas_id = pl.id', 'inner');
        $this->db->where('emp.borrado', 0);
        $query = $this->db->get();
        
        return $query->result();
    }

    public function cat_robos(){
        
        $this->db->select('rob.id, ve.num_serie, pl.placa, rob.descripcion, rob.fecha, rob.fecha_registro, du.nombre, du.apellido_p');
        $this->db->from('robos rob');
        $this->db->join('vehiculos ve', 'rob.vehiculos_id = ve.id', 'inner');
        $this->db->join('placas pl', 'rob.placas_id = pl.id', 'inner');
        $this->db->join('dueños du', 'rob.duenos_id = du.id', 'inner');
        $this->db->where('rob.borrado', 0);
        $query = $this->db->get();

        return $query->result();
    }

    public function agregar_catalogo($catalogo, $datos, $unique = FALSE){
        if($unique){
            //$dup = $this->db->get_where('marcas', array('nom_marca' => 'Nissan2'));
            $dup = $this->db->get_where($catalogo, array($unique => $datos[$unique]));
            if($dup->num_rows() > 0){
                return 0;
            }
        }
        
        $this->db->insert($catalogo, $datos);

        return 1;
        
    }

    public function agregar_catalogo_emplacado($catalogo, $datos, $unique = FALSE){
        if($unique){
            //$dup = $this->db->get_where('marcas', array('nom_marca' => 'Nissan2'));
            $dup = $this->db->get_where($catalogo, array($unique => $datos[$unique]));
            if($dup->num_rows() > 0){
                return 0;
            }
        }
        
        $this->db->insert($catalogo, $datos);

        return $this->db->insert_id();
        
    }

    /* public function agregar_catalogo($catalogo, $datos, $unique = FALSE) {
        // Verifica si se debe hacer la validación de unicidad
        if ($unique) {
            // Construye el array para la consulta de unicidad
            $where = array($unique => $datos[$unique]);
            
            // Realiza la consulta para verificar si ya existe el registro
            $this->db->where($where);
            $query = $this->db->get($catalogo);
            
            // Verifica si se encontró algún registro
            if ($query->num_rows() > 0) {
                switch ($unique) {
                    case 'nom_marca':
                        echo $query->num_rows();
                        return 'Esta marca ya está registrada';
                    case 'nom_color':
                        return 'Este color ya está registrado';
                    case 'nom_tipo':
                        return 'Este tipo ya está registrado';
                    default:
                        return 'Este dato ya está registrado';
                }
            }
        }
        
        // Si no hay problemas de unicidad, inserta el nuevo registro
        $this->db->insert($catalogo, $datos);
        return 1; // Retorna 1 para indicar éxito
    } */
    
    public function actualizar_un_parametro($id, $tabla, $emp_id){
        if($emp_id == null || $emp_id == ""){
            $this->db->where('id', $id);
            $this->db->update($tabla, array('asignado' => null));
        }
        else{
            $this->db->where('id', $id);
            $this->db->update($tabla, array('asignado' => $emp_id));
        }
        
    }
    
    public function eliminar_catalogo($id, $tabla){
        $this->db->where('id', $id);
        $this->db->delete($tabla);
    }

    public function borrado_logico($id, $tabla){
        $this->db->where('id', $id);
        $this->db->update($tabla, array('borrado' => 1));
		if ($this->db->affected_rows() == 1){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function actualizar($tabla, $datos, $id){
        $this->db->where('id', $id);
        $this->db->update($tabla, $datos);
    }

    public function actualizar_emplacado($tabla, $datos, $id){
        $this->db->where('id', $id);
        $this->db->update($tabla, $datos);
    }

    public function serie_placa($serie){
        $this->db->select('pl.placa, du.nombre, du.apellido_p, du.apellido_m, pl.id as placa_id, du.id as dueno_id');
        $this->db->from('vehiculos ve');
        $this->db->join('propietario pro', 've.id = pro.vehiculos_id AND pro.actual = 1', 'inner');
        $this->db->join('dueños du', 'du.id = pro.duenos_id', 'inner');
        $this->db->join('emplacado emp', 've.id = emp.vehiculos_id AND emp.actual = 1', 'inner');
        $this->db->join('placas pl', 'pl.id = emp.placas_id', 'inner');
        $this->db->where('ve.num_serie', $serie);

        $query = $this->db->get();
        return $query->row();
        /* $query = ' SELECT pl.placa, du.nombre, du.apellido_p, pl.id as placa_id, du.id as dueno_id FROM vehiculos AS ve
                                    INNER JOIN propietario AS pro
                                    ON ve.id = pro.vehiculos_id AND pro.actual = 1
                                    INNER JOIN dueños AS du
                                    ON du.id = pro.dueños_id 
                                    INNER JOIN emplacado AS emp
                                    ON ve.id = emp.vehiculos_id AND emp.actual = 1
                                    INNER JOIN placas AS pl
                                    ON pl.id = emp.placas_id
                                    WHERE ve.num_serie = ?';
        $busqueda = $this->db->query($query, $serie);
        return $busqueda->row(0); */
        
    }

    /* public function serie_placa($serie) {
        // Cargar el Query Builder de CodeIgniter
        $this->db->select('pl.placa, du.nombre, du.apellido_p, pl.id as placa_id, du.id as dueno_id');
        $this->db->from('vehiculos ve');
        $this->db->join('propietario pro', 've.id = pro.vehiculos_id AND pro.actual = 1', 'inner');
        $this->db->join('dueños du', 'du.id = pro.dueños_id', 'inner');
        $this->db->join('emplacado emp', 've.id = emp.vehiculos_id AND emp.actual = 1', 'inner');
        $this->db->join('placas pl', 'pl.id = emp.placas_id', 'inner');
        $this->db->where('ve.num_serie', $serie);
        
        $query = $this->db->get();
        return $query->row(0);
    } */
    

    public function get_by_id($tabla, $id){
        $query = $this->db->get_where($tabla, $id);
        return $query->row();
    }

    public function get_by_id_emplacado($tabla, $id){
        $this->db->select('e.id, e.vehiculos_id, e.placas_id, e.fecha_registro, e.actual, e.fecha_inicio, e.fecha_termino, e.borrado, p.placa');
        $this->db->from('emplacado e');
        $this->db->join('placas p', 'p.id = e.placas_id', 'inner');
        $this->db->where('e.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function cat_placas_asignadas_excepto($id){
        $this->db->select('*');
        $this->db->from('placas');
        $this->db->where('placas.asignado IS NULL AND placas.borrado LIKE "0%" OR placas.id = '.$id);
        $query = $this->db->get();
        return $query->result();
    }

}
?>