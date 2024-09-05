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
    
}