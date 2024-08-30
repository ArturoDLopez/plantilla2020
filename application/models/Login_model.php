<?php
class Login_model extends CI_Model{
    function __construct(){
        $this->load->database();
    }


    public function login($email, $password){
        
        $data = $this->db->get_where('usuarios', array('email' => $email, 'contrasena' => $password));
        if(!$data->result()){
            return false;
        }
        return $data->row();
    }
}