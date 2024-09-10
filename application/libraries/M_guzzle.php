<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_guzzle
{
    function __construct()
    {
        $archivo = APPPATH . 'third_party/guzzle/vendor/autoload.php';

        include_once $archivo;
    }

    function puzzle()
    {
        $CI = &get_instance();
        log_message('Debug', 'guzzle class is loaded.');
    }

    function load()
    {
        return new Guzzle\Http\Client;
    }
}