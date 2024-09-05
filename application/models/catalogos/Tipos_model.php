<?php

class Tipos_model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function cargar(){
        /* $query = $this->db->get_where('tipo', array('borrado' => 0));
        return $query->result(); */
        $this->db->select('t.id, t.nom_tipo, t.fecha_registro, ve.id as vehiculos_id');
        $this->db->from('tipo t');
        $this->db->join('(SELECT * FROM vehiculos  where borrado = 0 GROUP BY tipo_id) AS ve', 't.id = ve.tipo_id', 'left');
        $this->db->where('t.borrado', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function agregar($datos, $nom_tipo){
        $row = $this->db->get_where('tipo', array('borrado' => 0, 'nom_tipo' => $nom_tipo));
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
        $this->db->update('tipo', array('borrado' => 1));
        return $this->db->affected_rows();
    }
}

?>