<?php

class Propietarios_model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    public function cargar($limit, $offset){
        $this->db->where('borrado', 0);
        $total = $this->db->count_all_results('propietario');


        $this->db->select('pro.id, ve.num_serie, du.nombre, du.apellido_p, du.apellido_m, pro.actual, pro.fecha_inicio, pro.fecha_termino, pro.fecha_registro');
        $this->db->from('propietario pro');
        $this->db->join('vehiculos ve','pro.vehiculos_id = ve.id','inner');
        $this->db->join('duenos du','pro.duenos_id = du.id','inner');
        $this->db->where('pro.borrado', 0);
        $this->db->limit($limit, $offset);

        $query = $this->db->get();

        $data['total'] = $total;
        $data['rows'] = $query->result();
        return $data;
    }

    public function agregar($datos){
        $this->db->insert('propietario', $datos);
        if($this->db->insert_id() > 0){
            return 1;
        }
        return 0;
    }

    public function traer_catalogos($tabla, $condiciones){
        $query = $this->db->get_where($tabla, $condiciones);
        return $query->result();
    }

    public function traer_catalogos2($tabla, $condiciones){
        $query = $this->db->get_where($tabla, $condiciones);
        return $query->result();
    }

    public function borrado_logico($id, $tabla){
        $this->db->where('id', $id);
        $this->db->update($tabla, array('borrado' => 1));
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