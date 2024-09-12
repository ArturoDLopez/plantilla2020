<?php
class Vehiculos_model extends CI_Model{
    function __construct(){
        $this->load->database();
    }

    public function buscar_robo($vehiculo_id){
        
        $this->db->select('ro.fecha, ro.fecha_registro, ro.descripcion, pl.placa');
        $this->db->from('robos ro');
        $this->db->join('placas pl', 'pl.id = ro.placas_id', 'inner');
        $this->db->where('ro.vehiculos_id', $vehiculo_id);
        $query = $this->db->get();

        return $query->result();    
    }

    public function buscar_duenos($vehiculo_id){
        
        $this->db->select('pro.fecha_inicio, pro.fecha_termino, pro.fecha_registro, CONCAT(du.nombre, " ", du.apellido_p, " ", apellido_m) as nombre, actual');
        $this->db->from('propietario pro');
        $this->db->join('duenos du', 'du.id = pro.duenos_id', 'inner');
        $this->db->where('pro.vehiculos_id', $vehiculo_id);
        $query = $this->db->get();

        return $query->result();    
    }

    public function buscar_placas($vehiculo_id){
        
        $this->db->select('emp.fecha_inicio, emp.fecha_termino, emp.fecha_registro, pl.placa, emp.actual');
        $this->db->from('emplacado emp');
        $this->db->join('placas pl', 'pl.id = emp.placas_id', 'inner');
        $this->db->where('emp.vehiculos_id', $vehiculo_id);
        $query = $this->db->get();

        return $query->result();    
    }

    public function buscar_vehiculo($placa){
        //$data = $this->db->get_where('placas', array('placa' => $placa));
        $this->db->select('ve.id as ve_id, ve.num_serie, ma.nom_marca, ve.modelo, ti.nom_tipo, co.nom_color, pl.placa, 
                CONCAT (du.nombre, " ", du.apellido_p) as nombre, 
                (SELECT COUNT(*) FROM propietario WHERE vehiculos_id = pro.vehiculos_id) as numero_duenos, 
                (SELECT COUNT(*) FROM emplacado WHERE vehiculos_id = emp.vehiculos_id) as numero_placas, 
                ro.descripcion, ve.fecha_registro, ro.id AS ro_id');
        $this->db->from('vehiculos ve');
        $this->db->join('marcas ma', 've.marcas_id = ma.id', 'left');
        $this->db->join('tipo ti', 've.tipo_id = ti.id', 'left');
        $this->db->join('colores co', 've.colores_id = co.id', 'left');
        $this->db->join('(SELECT * FROM emplacado GROUP BY vehiculos_id ORDER BY actual DESC) as emp', 've.id = emp.vehiculos_id', 'left');
        $this->db->join('placas pl', 'emp.placas_id = pl.id', 'left');
        $this->db->join('(SELECT * FROM propietario GROUP BY vehiculos_id ORDER BY actual DESC) as pro', 've.id = pro.vehiculos_id', 'left');
        $this->db->join('duenos du', 'pro.duenos_id = du.id', 'left');
        $this->db->join('(SELECT * FROM robos GROUP BY vehiculos_id ORDER BY fecha_registro ASC) AS ro', 've.id = ro.vehiculos_id', 'left');
        $this->db->where('pl.placa = "'.$placa.'" OR ve.num_serie = "'.$placa.'"');
        
        $busqueda = $this->db->get();
        
        return  $busqueda->result();

        /* $query = 'SELECT ve.num_serie, ma.nom_marca, ve.modelo, ti.nom_tipo, co.nom_color, pl.placa, du.nombre, du.apellido_p, ro.descripcion, ro.fecha_registro, ro.id AS ro_id
                                    FROM vehiculos AS ve 
                                    INNER JOIN marcas AS ma
                                    ON ve.marcas_id = ma.id
                                    INNER JOIN tipo AS ti
                                    ON ve.tipo_id = ti.id
                                    INNER JOIN colores AS co
                                    ON ve.colores_id = co.id
                                    INNER JOIN emplacado AS emp
                                    ON ve.id = emp.vehiculos_id
                                    INNER JOIN placas AS pl
                                    ON emp.placas_id = pl.id
                                    INNER JOIN propietario AS pro
                                    ON ve.id = pro.vehiculos_id
                                    INNER JOIN dueños AS du
                                    ON pro.dueños_id = du.id 
                                    LEFT JOIN (
                                       select * from robos group by vehiculos_id  order by fec
                                       ha_registro asc 
                                    ) AS ro
                                    ON ve.id = ro.vehiculos_id WHERE 
                                     pl.placa = ?'; */
        }
        
    

    /* public function buscar_vehiculo($placa) {
        // Definir el nombre de la tabla principal
        $this->db->from('vehiculos ve');
    
        // Seleccionar los campos necesarios
        $this->db->select('ve.num_serie, ma.nom_marca, ve.modelo, ti.nom_tipo, co.nom_color, pl.placa, du.nombre, du.apellido_p, ro.descripcion, ro.fecha_registro, ro.id AS ro_id');
    
        // Agregar los INNER JOINs
        $this->db->join('marcas ma', 've.marcas_id = ma.id', 'inner');
        $this->db->join('tipo ti', 've.tipo_id = ti.id', 'inner');
        $this->db->join('colores co', 've.colores_id = co.id', 'inner');
        $this->db->join('emplacado emp', 've.id = emp.vehiculos_id', 'inner');
        $this->db->join('placas pl', 'emp.placas_id = pl.id', 'inner');
        $this->db->join('propietario pro', 've.id = pro.vehiculos_id', 'inner');
        $this->db->join('dueños du', 'pro.dueños_id = du.id', 'inner');
    
        // Agregar el LEFT JOIN con subconsulta
        $subquery = $this->db->select('*')
                             ->from('robos')
                             ->group_by('vehiculos_id')
                             ->order_by('fec_ha_registro', 'asc')
                             ->get_compiled_select();
    
        $this->db->join("($subquery) ro", 've.id = ro.vehiculos_id', 'left');
    
        // Agregar la cláusula WHERE
        $this->db->where('pl.placa', $placa);
    
        // Ejecutar la consulta
        $query = $this->db->get();
    
        // Retornar los resultados
        return $query->result();
    } */
    

    
}