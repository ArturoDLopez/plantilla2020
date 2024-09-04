<?php

class Vehiculos_model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    public function cargar(){
        $this->db->select('ve.id, num_serie, nom_marca, modelo, nom_color, nom_tipo, ve.fecha_registro');
        $this->db->from('vehiculos ve');
        $this->db->join('marcas mar','ve.marcas_id = mar.id','inner');
        $this->db->join('colores col','ve.colores_id = col.id','inner');
        $this->db->join('tipo','ve.tipo_id = tipo.id','inner');
        $this->db->where('ve.borrado', 0);

        $query = $this->db->get();
        
        return $query->result();
    }

    public function agregar($datos, $campo){
        $row = $this->db->get_where('vehiculos', array('borrado' => 0, 'num_serie' => $campo));
        if($row->num_rows() == 0){
            $this->db->insert('vehiculos', $datos);
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
        $query = $this->db->get_where($tabla, array('borrado' => 0));
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
        return $this->db->last_query();
        if ($this->db->affected_rows() == 1){
            return 1;
        }
        else{
            return 0;
        }
    }

}