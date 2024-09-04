<?php

class Colores_model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function cargar(){
        $query = $this->db->get_where('colores', array('borrado' => 0));
        return $query->result();
    }

    public function agregar($datos, $nom_color){
        $row = $this->db->get_where('colores', array('borrado' => 0, 'nom_color' => $nom_color));
        if($row->num_rows() == 0){
            $id = $this->db->insert('colores', $datos);
            return 1;
        }
        else{
            return 0;
        }
    }

    public function eliminar($id){
        $this->db->where('id', $id);
        $this->db->update('colores', array('borrado' => 1));
        return $this->db->affected_rows();
    }
}

?>