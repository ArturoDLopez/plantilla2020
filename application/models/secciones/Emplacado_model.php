<?php

class Emplacado_model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    public function cargar(){
        $this->db->select('emp.id, ve.num_serie, pl.placa, emp.actual, emp.fecha_inicio, emp.fecha_termino, emp.fecha_registro');
        $this->db->from('emplacado emp');
        $this->db->join('vehiculos ve', 'emp.vehiculos_id = ve.id', 'inner');
        $this->db->join('placas pl', 'emp.placas_id = pl.id', 'inner');
        $this->db->where('emp.eliminado', 0);
        $query = $this->db->get();
        
        return $query->result();
    }

    public function agregar($datos){
        $this->db->insert('emplacado', $datos);
        if($this->db->insert_id() > 0){
            return $this->db->insert_id();
        }
            return 0;
    }

    public function actualizar_placa($id, $tabla, $emp_id){
        if($emp_id == null || $emp_id == ""){
            $this->db->where('id', $id);
            $this->db->update($tabla, array('asignado' => null));
            return $this->db->affected_rows();
        }
        else{
            $this->db->where('id', $id);
            $this->db->update($tabla, array('asignado' => $emp_id));
            return $this->db->affected_rows();
        }
        
    }

    public function traer_catalogos($tabla, $array){
        $query = $this->db->get_where($tabla, $array);
        return $query->result();
    }

    public function cargar_placas_sin_asignar_excepto($id){
        $this->db->select('*');
        $this->db->from('placas');
        $this->db->where('placas.asignado IS NULL AND placas.eliminado LIKE "0%" OR placas.id = '.$id);
        $query = $this->db->get();
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
            return 0;
        }
    }

}