<?php

class Colores_model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function cargar($limit, $offset){
        /* $query = $this->db->get_where('colores', array('borrado' => 0));
        return $query->result(); */

        $this->db->where('borrado', 0);
        $total = $this->db->count_all_results('colores');

        $this->db->select('c.id, c.nom_color, c.fecha_registro, ve.id as vehiculos_id');
        $this->db->from('colores c');
        $this->db->join('(SELECT * FROM vehiculos  where borrado = 0 GROUP BY colores_id) AS ve', 'c.id = ve.colores_id', 'left');
        $this->db->where('c.borrado', 0);

        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        $data['total'] = $total;
        $data['rows'] = $query->result();
        return $data;
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