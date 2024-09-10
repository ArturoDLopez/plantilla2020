<?php

class Login_checker
{
    #region "Atributos"
    private $CI;
    private $url_view_invalida;
    #endregion

    #region "Métodos"
    function check()
    {
        /* $this->url_view_invalida = base_url();

        if (!$this->CI->auth->is_signed()) {
            $this->CI->load->helper('url');
            if (current_url() != $this->url_view_invalida) {
                redirect($this->url_view_invalida, 'refresh');
            }
        } */

    }
    #endregion

    #region "Constructor"
    function __construct()
    {
        $this->CI = &get_instance();
    }
    #endregion
}