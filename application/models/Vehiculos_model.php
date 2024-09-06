<?php
class Vehiculos_model extends CI_Model{
    function __construct(){
        $this->load->database();
    }

    public function buscar_vehiculo($placa){
        //$data = $this->db->get_where('placas', array('placa' => $placa));
        $this->db->select('ve.num_serie, ma.nom_marca, ve.modelo, ti.nom_tipo, co.nom_color, pl.placa, du.nombre, du.apellido_p, ro.descripcion, ro.fecha_registro, ro.id AS ro_id');
        $this->db->from('vehiculos ve');
        $this->db->join('marcas ma', 've.marcas_id = ma.id', 'inner');
        $this->db->join('tipo ti', 've.tipo_id = ti.id', 'inner');
        $this->db->join('colores co', 've.colores_id = co.id', 'inner');
        $this->db->join('emplacado emp', 've.id = emp.vehiculos_id', 'inner');
        $this->db->join('placas pl', 'emp.placas_id = pl.id', 'inner');
        $this->db->join('propietario pro', 've.id = pro.vehiculos_id', 'inner');
        $this->db->join('duenos du', 'pro.duenos_id = du.id', 'inner');
        $this->db->join('(SELECT * FROM robos GROUP BY vehiculos_id ORDER BY fecha_registro ASC) AS ro', 've.id = ro.vehiculos_id', 'left');
        $this->db->where('pl.placa LIKE "%'.$placa.'%" OR ve.num_serie LIKE "%'.$placa.'%"');
        
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