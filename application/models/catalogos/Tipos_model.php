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

    public function cargar_tipos_paginado($limit, $offset) {
        // Obtener el número total de registros
        $this->db->where('borrado', 0);
        $total = $this->db->count_all_results('tipo');
        
        // Obtener los registros paginados
        $this->db->select('t.id, t.nom_tipo, t.fecha_registro, ve.id as vehiculos_id');
        $this->db->from('tipo t');
        $this->db->join('vehiculos ve', 't.id = ve.tipo_id AND ve.borrado = 0', 'left');
        $this->db->where('t.borrado', 0);
        
        // Aplicar el límite y el desplazamiento
        $this->db->limit($limit, $offset); 
        
        // Si deseas agrupar resultados, lo haces aquí (aunque puede no ser necesario si no hay duplicados)
        $this->db->group_by('t.id');  // Agrupar por `tipo` para evitar duplicados si corresponde
        
        // Ejecutar la consulta
        $query = $this->db->get();
        
        // Mostrar la consulta generada
        // echo $this->db->last_query();
        
        return array(
            'total' => $total,          // Número total de registros
            'rows' => $query->result()  // Registros de la página actual
        );
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