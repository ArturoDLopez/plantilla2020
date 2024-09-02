<?php

class Tipos_model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function cargar(){
        $query = $this->db->get_where('tipo', array('eliminado' => 0));
        return $query->result();
    }

    public function agregar($datos, $nom_tipo){
        $row = $this->db->get_where('tipo', array('eliminado' => 0, 'nom_tipo' => $nom_tipo));
        if($row->num_rows() == 0){
            $id = $this->db->insert('tipo', $datos);
            return 1;
        }
        else{
            return 0;
        }
    }

    public function eliminar($id){
        $this->db->where('id', $id);
        $this->db->update('tipo', array('eliminado' => 1));
        return $this->db->affected_rows();
    }
}

?>