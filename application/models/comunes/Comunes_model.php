<?php

class Comunes_model extends CI_model{
    public function __construct(){
        $this->load->database();

    }
    public function cargar_uso($tabla, $campo, $id){
        $this->db->select('*');
        $this->db->from($tabla);
        $this->db->where(array($tabla.'.'.$campo => $id, 'borrado' => 0));
        $query = $this->db->get();
        return $query->result();
    }

    public function get_marcas(){
        $this->db->where('borrado', 0);
        $total = $this->db->count_all_results('marcas');

        $this->db->select('m.id, m.nom_marca, m.fecha_registro, ve.id as vehiculos_id');
        $this->db->from('marcas m');
        $this->db->join('(SELECT * FROM vehiculos  where borrado = 0 GROUP BY marcas_id) AS ve', 'm.id = ve.marcas_id', 'left');
        $this->db->where('m.borrado', 0);

        $query = $this->db->get();

        $data['total'] = $total;
        $data['rows'] = $query->result();
        return $data;
    }
    
}