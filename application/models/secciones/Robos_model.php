<?php

class Robos_model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    public function cargar(){
        $this->db->select('rob.id, ve.num_serie, pl.placa, rob.descripcion, rob.fecha, rob.fecha_registro, du.nombre, du.apellido_p');
        $this->db->from('robos rob');
        $this->db->join('vehiculos ve', 'rob.vehiculos_id = ve.id', 'inner');
        $this->db->join('placas pl', 'rob.placas_id = pl.id', 'inner');
        $this->db->join('duenos du', 'rob.duenos_id = du.id', 'inner');
        $this->db->where('rob.borrado', 0);
        $query = $this->db->get();

        return $query->result();
    }

    public function agregar($datos){
        $this->db->insert('robos', $datos);
        if($this->db->insert_id() > 0){
            return 1;
        }
        return 0;
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
        if ($this->db->affected_rows() == 1){
            return 1;
        }
        else{
            return 0;
        }
    }

    public function serie_placa($serie){
        $this->db->select('pl.placa, du.nombre, du.apellido_p, du.apellido_m, pl.id as placa_id, du.id as dueno_id');
        $this->db->from('vehiculos ve');
        $this->db->join('propietario pro', 've.id = pro.vehiculos_id AND pro.actual = 1', 'inner');
        $this->db->join('duenos du', 'du.id = pro.duenos_id', 'inner');
        $this->db->join('emplacado emp', 've.id = emp.vehiculos_id AND emp.actual = 1', 'inner');
        $this->db->join('placas pl', 'pl.id = emp.placas_id', 'inner');
        $this->db->where('ve.num_serie', $serie);

        $query = $this->db->get();
        return $query->row();
    }

}