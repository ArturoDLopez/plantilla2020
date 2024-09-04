<?php

class Propietarios_model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    public function cargar(){
        $this->db->select('pro.id, ve.num_serie, du.nombre, du.apellido_p, du.apellido_m, pro.actual, pro.fecha_inicio, pro.fecha_termino, pro.fecha_registro');
        $this->db->from('propietario pro');
        $this->db->join('vehiculos ve','pro.vehiculos_id = ve.id','inner');
        $this->db->join('duenos du','pro.duenos_id = du.id','inner');
        $this->db->where('pro.eliminado', 0);

        $query = $this->db->get();
        return $query->result();
    }

    public function agregar($datos){
        $this->db->insert('propietario', $datos);
        if($this->db->insert_id() > 0){
            return 1;
        }
        return 0;
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

    public function actualizar($tabla, $datos, $id){
        $this->db->where('id', $id);
        $this->db->update($tabla, $datos);
        if ($this->db->affected_rows() == 1){
            return 1;
        }
        else{
            return 3;
        }
    }

}