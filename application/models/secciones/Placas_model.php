<?php

class Placas_model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    public function cargar(){
        $query = $this->db->get_where('placas', array('eliminado' => 0));
        return $query->result();
    }

    public function agregar($datos, $campo){
        $row = $this->db->get_where('placas', array('eliminado' => 0, 'placa' => $campo));
        if($row->num_rows() == 0){
            $this->db->insert('placas', $datos);
            if($this->db->insert_id() > 0){
                return 1;
            }
            return 0;
        }
        else{
            return 0;
        }
    }

    public function traer_catalogos($tabla){
        $query = $this->db->get_where($tabla, array('eliminado' => 0));
        return $query->result();
    }

    public function eliminado_logico($id, $tabla){
        $this->db->where('id', $id);
        $this->db->update($tabla, array('eliminado' => 1));
		if ($this->db->affected_rows() == 1){
            return 1;
        }
        else{
            return 0;
        }
    }

    public function get_by_id($tabla, $id){
        $query = $this->db->get_where($tabla, $id);
        return $query->row();
    }

    public function actualizar($tabla, $datos, $id, $campo){
        $row = $this->db->get_where('placas', array('eliminado' => 0, 'placa' => $campo));
        if($row->num_rows() == 0){
            $this->db->where('id', $id);
            $this->db->update($tabla, $datos);
            if ($this->db->affected_rows() == 1){
                return 1;
            }
            else{
                return 3;
            }
        }
        else{
            return 0;
        }
    }

}