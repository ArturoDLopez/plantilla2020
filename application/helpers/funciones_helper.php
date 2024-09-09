<?php

function desencriptar($dato){
    $CI = &get_instance();
    $CI->load->library('encryption');
    return $CI->encryption->decrypt(str_replace(array('-', '_', '.'), array('+', '/', '='), $dato));
}

function encriptar($dato){
    $CI = &get_instance();
    $CI->load->library('encryption');
    return str_replace(array('+', '/', '='), array('-', '_', '.'), $CI->encryption->encrypt($dato));
}