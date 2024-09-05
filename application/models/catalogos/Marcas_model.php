<?php

class Marcas_model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function cargar(){
        //$query = $this->db->get_where('marcas', array('borrado' => 0));
        //return $query->result();
        $this->db->select('m.id, m.nom_marca, m.fecha_registro, ve.id as vehiculos_id');
        $this->db->from('marcas m');
        $this->db->join('(SELECT * FROM vehiculos  where borrado = 0 GROUP BY marcas_id) AS ve', 'm.id = ve.marcas_id', 'left');
        $this->db->where('m.borrado', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function agregar($datos, $nom_marca){
        $row = $this->db->get_where('marcas', array('borrado' => 0, 'nom_marca' => $nom_marca));
        if($row->num_rows() == 0){
            $id = $this->db->insert('marcas', $datos);
            return 1;
        }
        else{
            return 0;
        }
    }

    public function eliminar($id){
        $this->db->where('id', $id);
        $this->db->update('marcas', array('borrado' => 1));
        return $this->db->affected_rows();
    }
}

/*     public function cat_marcas(){
        $this->db->where('borrado', '0');
        $this->db->select('id, nom_marca, fecha_registro');
        $query = $this->db->get('marcas');
        return $query->result();
    }

    public function buscar_registro($nom_marca){
        $row = $this->db->get_where('marcas', array('borrado' => 0, 'nom_marca' => $nom_marca));
        return $row->num_rows();
    }

    public function registrar_marca($datos){
        $marcas = $this->db->insert('marcas', $datos);
        return $marcas->insert_id();
    } */

?>




