<?php

class Vehiculos_model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    public function cargar(){
        $this->db->select('ve.id, num_serie, nom_marca, modelo, nom_color, nom_tipo, ve.fecha_registro');
        $this->db->from('vehiculos ve');
        $this->db->join('marcas mar','ve.marcas_id = mar.id','inner');
        $this->db->join('colores col','ve.colores_id = col.id','inner');
        $this->db->join('tipo','ve.tipo_id = tipo.id','inner');
        $this->db->where('ve.eliminado', 0);

        $query = $this->db->get();
        
        return $query->result();
    }

    public function agregar($campo, $datos){
        $row = $this->db->get_where('vehiculos', array('eliminado' => 0, 'num_serie' => $campo));
        if($row->num_rows() == 0){
            $id = $this->db->insert('vehiculos', $datos);
            return 1;
        }
        else{
            return 0;
        }
    }

    public function traer_catalogos($tabla){
        $query = $this->db->get_where($tabla, array('eliminado' => 0));
        return $query->result();
    }

}