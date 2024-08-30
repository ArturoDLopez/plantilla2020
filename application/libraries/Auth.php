<?php

use GuzzleHttp\Client;

class Auth
{
    #region "Atributos"

    public $ci;
    public $id;
    public $token;
    public $suu_id;
    public $username;
    public $persona;
    public $empresa;
    public $usuario_local;
    public $roles;
    public $domicilios_empresa;
    public $domicilios_persona;
    public $empleado;
    public $puesto;
    public $area_administrativa;
    public $direccion_general;
    public $sistema_actual;

    //Estos atributos se incluyen para poder acceder ellos via SESSION creada en sign_in
    public $persona_id;
    public $empresa_id;
    public $nombre;
    public $primer_apellido;
    public $segundo_apellido;
    public $correo_electronico;

    public $info;
    public $error;
    public $base_url;
    public $base_url_fake;
    public $cookie_token;
    private $ws_url;

    // Agregado Ing.Jesús Aguirre 14-Feb-19
    protected $vista;

    public function getVista()
    {
        return $this->vista;
    }

    public function setVista($vista)
    {
        $this->vista = $vista;
    }

    // *************************************

    public function getCi()
    {
        return $this->ci;
    }

    public function setCi($ci)
    {
        $this->ci = $ci;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSuuId()
    {
        return $this->suu_id;
    }

    public function setSuuId($suu_id)
    {
        $this->suu_id = $suu_id;
    }


    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPersona()
    {
        return $this->persona;
    }

    public function setPersona($persona)
    {
        $this->persona = $persona;
    }

    public function getPersonaId()
    {
        return $this->persona_id;
    }

    public function setPersonaId($persona_id)
    {
        $this->persona_id = $persona_id;
    }

    public function getEmpresaId()
    {
        return $this->empresa_id;
    }

    public function setEmpresaId($empresa_id)
    {
        $this->empresa_id = $empresa_id;
    }


    public function getEmpresa()
    {
        return $this->empresa;
    }

    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
    }

    public function getUsuarioLocal()
    {
        //die(json_encode($this->usuario_local));
        return $this->usuario_local;
    }

    public function setUsuarioLocal($usuario_local)
    {
        $this->usuario_local = $usuario_local;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getSistemaActual()
    {
        return $this->sistema_actual;
    }

    public function setSistemaActual($sistema_actual)
    {
        $this->sistema_actual = $sistema_actual;
    }


    public function getDomicilios()
    {
        if (!is_null($this->persona_id)) {
            return $this->domicilios_persona;
        }
        if (!is_null($this->empresa_id)) {
            return $this->domicilios_empresa;
        }

        return null;
    }

    public function getDomiciliosEmpresa()
    {
        return $this->domicilios_empresa;
    }

    public function setDomiciliosEmpresa($domicilios_empresa)
    {
        $this->domicilios_empresa = $domicilios_empresa;
    }

    public function getDomiciliosPersona()
    {
        return $this->domicilios_persona;
    }

    public function setDomiciliosPersona($domicilios_persona)
    {
        $this->domicilios_persona = $domicilios_persona;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function getWsUrl()
    {
        return $this->ws_url;
    }

    public function setWsUrl($ws_url)
    {
        $this->ws_url = $ws_url;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getPrimerApellido()
    {
        return $this->primer_apellido;
    }

    public function setPrimerApellido($primer_apellido)
    {
        $this->primer_apellido = $primer_apellido;
    }

    public function getSegundoApellido()
    {
        return $this->segundo_apellido;
    }

    public function setSegundoApellido($segundo_apellido)
    {
        $this->segundo_apellido = $segundo_apellido;
    }

    public function getCorreoElectronico()
    {
        return $this->correo_electronico;
    }

    public function setCorreoElectronico($correo_electronico)
    {
        $this->correo_electronico = $correo_electronico;
    }

    public function getEmpleado()
    {
        return $this->empleado;
    }

    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;
    }

    public function getPuesto()
    {
        return $this->puesto;
    }

    public function setPuesto($puesto)
    {
        $this->puesto = $puesto;
    }

    public function getAreaAdministrativa()
    {
        return $this->area_administrativa;
    }

    public function setAreaAdministrativa($area_administrativa)
    {
        $this->area_administrativa = $area_administrativa;
    }

    public function getDireccionGeneral()
    {
        return $this->direccion_general;
    }

    public function setDireccionGeneral($direccion_general)
    {
        $this->direccion_general = $direccion_general;
    }


    #endregion

    #region "Métodos"


    public function logout()
    {
        try {


            //eliminar sesiones
            session_unset();

            $atributos = (get_object_vars($this));

            foreach ($atributos as $key => $value) {

                if ($key != "ci") {
                    $this->$key = null;
                }

            }

            $this->ci->load->helper('cookie');
            delete_cookie(COOKIE_TOKEN, $this->ci->config->item('cookie_domain'));

            return true;
        } catch (Exception $e) {
            //die(json_encode($e));
            return false;
        }
    }

    public function is_signed()
    {
        //Verificar cookie o session

        $cookie = null;
        $respuesta = false;

        //die(json_encode($_COOKIE));

        if (count($_COOKIE) > 0) {
            if (isset($_COOKIE[$this->cookie_token])) {
                $cookie = $_COOKIE[$this->cookie_token];
                $respuesta = true;
            }
        }
        if (count($_SESSION) > 0) {
            if (isset($_SESSION[$this->cookie_token])) {
                $cookie = $_SESSION[$this->cookie_token];
                $respuesta = true;
            }
        }

        if (!$respuesta) {
            return $respuesta;
        }

        //Validar cookie

        $client = new Client();
        $url = $this->ws_url . 'api/acceso/get';
        $params = array();
        $request = array();
        $params['token'] = $cookie;
        $request['form_params'] = $params;

        $this->sistema_actual = null;

        $token_valido = null;

        try {

            //die(json_encode($request));

            $response = $client->request('POST', $url, $request);

            $code = $response->getStatusCode();
            $body = $response->getBody();
            $reason = $response->getReasonPhrase();
            $hasHeader = $response->hasHeader('Content-Length');
            $header = $response->getHeader('Content-Length');

            $token_valido = json_decode($body->getContents());

        } catch (Exception $e) {
            $mensaje_error = $e->getMessage();
        }

        if (is_null($token_valido)) {
            return false;
        }

        if ($token_valido->success) {
            $this->token = $cookie;
            $respuesta = true;
        } else {
            $respuesta = false;
        }

        return $respuesta;

    }

    public function crear_datos_default()
    {
        $resultado = true;

        if (!is_null($this->cookie_token)) {

            $sistema_existe = false;
            $es_usuario_local = false;
            $es_ciudadano = false;
            $es_ciudadano_sistema_actual = false;
            $tiene_rol_en_sistema_actual = false;
            $mensaje_error = "";

            $info = $this->get_info();

            //### VERIFICAR BASE_URL INICIO

            $client = new Client();
            $url = $this->ws_url . 'api/sistema/select';
            $params = array();
            $request = array();
            $params['base_url'] = $this->base_url;
            $request['form_params'] = $params;

            $this->sistema_actual = null;

            try {

                //die(json_encode($request));
                $response = $client->request('POST', $url, $request);

                $code = $response->getStatusCode();
                $body = $response->getBody();
                $reason = $response->getReasonPhrase();
                $hasHeader = $response->hasHeader('Content-Length');
                $header = $response->getHeader('Content-Length');

                $datos = json_decode($body->getContents());


                if (count($datos) > 0) {
                    $this->sistema_actual = $datos;
                    $sistema_existe = true;
                } else {
                    $resultado = false;
                }

            } catch (Exception $e) {
                $mensaje_error = $e->getMessage();
                $resultado = false;
            }

            //### VERIFICAR BASE_URL FIN

            //die(json_encode($info));

            $recargar_datos = false;

            if ($sistema_existe) {

                //### INSERTAR CIUDADANO INICIO

                foreach ($info->roles AS $rol) {

                    //ROL ciudadano
                    if ($rol->p_id == 4) {
                        $es_ciudadano = true;

                        if ($rol->s_base_url == $this->base_url) {
                            $es_ciudadano_sistema_actual = true;
                        }
                    }

                    if ($rol->s_base_url == $this->base_url) {
                        $tiene_rol_en_sistema_actual = true;
                    }

                }

                if (!$tiene_rol_en_sistema_actual) {

                    //Enviar datos para insertar usuario

                    $rol_creado = false;

                    $client = new Client();
                    $url = $this->ws_url . 'api/usuario_perfil_sistema/insert';
                    $params = array();
                    $params['sistema_base_url'] = $this->base_url;
                    $params['usuario_id'] = $info->id;
                    $params['perfil_id'] = 4;
                    //$params['format'] = 'json';
                    $request = array();
                    $request['form_params'] = $params;

                    try {

                        $response = $client->request('POST', $url, $request);

                        $code = $response->getStatusCode();
                        $body = $response->getBody();
                        $reason = $response->getReasonPhrase();
                        $hasHeader = $response->hasHeader('Content-Length');
                        $header = $response->getHeader('Content-Length');

                        $datos = json_decode($body->getContents());

                        if (count($datos) > 0) {
                            $rol_creado = true;
                            //$info = $this->get_info();
                            $recargar_datos = true;
                        }

                    } catch (Exception $e) {

                        $resultado = false;
                        $mensaje_error = $e->getMessage();
                        $mensaje_custom = explode('{"success":false,"mensaje":"', $mensaje_error);

                        if (count($mensaje_custom) > 0) {
                            $mensaje_custom = explode('"}', $mensaje_custom[1]);
                            $mensaje_custom = $mensaje_custom[0];
                            $this->error = $mensaje_custom;
                        } else {
                            $this->error = $e->getMessage();
                        }
                    }
                }

                //### INSERTAR CIUDADANO FIN

                //### INSERTAR USUARIO LOCAL INICIO


                if (isset($info->usuario_local)) {

                    if (!is_null($info->usuario_local)) {
                        if (count($info->usuario_local) > 0) {
                            $es_usuario_local = true;
                        }
                    }
                }

                if (!$es_usuario_local) {

                    if ($this->sistema_actual->usuario_local == 1) {


                        $usuario_local_creado = false;

                        $client = new Client();
                        $url = $this->ws_url . 'api/usuario_local/insert';

                        $params = array();
                        $params['sistema_base_url'] = $this->base_url;
                        $params['suu_id'] = $info->id;

                        $request = array();
                        $request['form_params'] = $params;

                        try {
                            $response = $client->request('POST', $url, $request);

                            $code = $response->getStatusCode();
                            $body = $response->getBody();
                            $reason = $response->getReasonPhrase();
                            $hasHeader = $response->hasHeader('Content-Length');
                            $header = $response->getHeader('Content-Length');

                            $datos = json_decode($body->getContents());

                            if (count($datos) > 0) {
                                $usuario_local_creado = true;
                                $recargar_datos = true;
                                $resultado = false;
                            }

                        } catch (Exception $e) {

                            $mensaje_error = $e->getMessage();

                            $mensaje_custom = explode('{"error_code":"CUSTOM_ERROR","error_message":"', $mensaje_error);

                            if (count($mensaje_custom) > 0) {


                                $mensaje_custom = explode('"', $mensaje_custom[1]);
                                $mensaje_custom = $mensaje_custom[0];
                                $this->error = $mensaje_custom;
                            } else {
                                $this->error = $e->getMessage();
                            }

                        }
                    }
                }

                //### INSERTAR USUARIO LOCAL FIN

            } else {

            }

            if ($recargar_datos) {
                $info = $this->get_info();
            }

            $this->update_session_data($info);
            $this->update_data();

            $this->info = $info;

            return $resultado;
        } else {


            /*            $url = SUU_URL . "api/usuario/is_signed?base_url=" . urlencode(base_url());

                        //  die($url);
                        header('Location: ' . $url);*/
            return false;
        }
    }

    public function check_access()
    {
        // return true;
        if (is_null($this->vista)) {
            return false;
        }
        if ($this->vista == "") {
            return false;
        }

        $client = new Client();
        $url = $this->ws_url . 'api/usuario/select_vw_usuario_vista';
        $params = array();
        $params['token'] = $this->token;
        $params['vista'] = $this->vista;
        //$params['format'] = 'json';
        $request = array();
        $request['form_params'] = $params;
        $response = $client->request('POST', $url, $request);

        $code = $response->getStatusCode();
        $body = $response->getBody();
        $reason = $response->getReasonPhrase();
        $hasHeader = $response->hasHeader('Content-Length');
        $header = $response->getHeader('Content-Length');

        $datos = json_decode($body->getContents());

        if (count($datos) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_info()
    {

        $cookie = null;

        if (count($_COOKIE) == 0) {

        } else {

            if (!isset($_COOKIE[$this->cookie_token])) {

            } else {
                $cookie = $_COOKIE[$this->cookie_token];
            }
        }

        if (count($_SESSION) == 0) {

        } else {

            if (!isset($_SESSION[$this->cookie_token])) {

            } else {
                $cookie = $_SESSION[$this->cookie_token];
            }
        }

        if (is_null($cookie)) {
            return null;
        }

        $this->token = $cookie;


        //### VERIFICAR BASE_URL INICIO


        if ($this->base_url != "") {


            $client = new Client();
            $url = $this->ws_url . 'api/sistema/select';
            $params = array();
            $request = array();
            $params['base_url'] = $this->base_url;
            $request['form_params'] = $params;

            $this->sistema_actual = null;

            try {

                // die(json_encode($request));
                $response = $client->request('POST', $url, $request);

                $code = $response->getStatusCode();
                $body = $response->getBody();
                $reason = $response->getReasonPhrase();
                $hasHeader = $response->hasHeader('Content-Length');
                $header = $response->getHeader('Content-Length');

                $datos = json_decode($body->getContents());


                if (count($datos) > 0) {
                    $this->sistema_actual = $datos;
                    $sistema_existe = true;
                }

            } catch (Exception $e) {
                $mensaje_error = $e->getMessage();
            }

        }
        //### VERIFICAR BASE_URL FIN

        $client = new Client();

        $url = $this->ws_url . 'api/usuario/get_info';

        $params = array();
        $params['token'] = $this->token;
        $request = array();
        $request['form_params'] = $params;

        //die(json_encode($request));

        $response = $client->request('POST', $url, $request);

        $code = $response->getStatusCode();
        $body = $response->getBody();
        $reason = $response->getReasonPhrase();
        $hasHeader = $response->hasHeader('Content-Length');
        $header = $response->getHeader('Content-Length');

        $resultado = null;


        if (!is_null($body)) {

            $data = json_decode($body);


            if (count($data) > 0) {

                $data = $data[0];

                $data->sistema_actual = $this->sistema_actual;

                $data->usuario_local = null;

                //****************************************************************die(json_encode($data));

                if (!is_null($this->sistema_actual)) {

                    if ($this->sistema_actual->usuario_local == 1) {
                        $data->usuario_local = $this->get_local_user($data->id);
                    }
                }

                $resultado = $data;

                $this->update_session_data($resultado);
                $this->update_data();

            } else {
                die("sistema invalido.");
                //return null;
            }

        } else {

        }

        return $resultado;
    }

    private function get_local_user($id)
    {

        $resultado = null;
        $client = new Client();

        $url = $this->ws_url . 'api/usuario_local/select';

        $params = array();
        $params['sistema_base_url'] = $this->base_url;

        $params['suu_id'] = $id;
        $request = array();
        $request['form_params'] = $params;

        try {

            //die(json_encode($url));

            $response = $client->request('POST', $url, $request);

            $code = $response->getStatusCode();
            $body = $response->getBody();
            $reason = $response->getReasonPhrase();
            $hasHeader = $response->hasHeader('Content-Length');
            $header = $response->getHeader('Content-Length');

            $resultado = null;


            if (!is_null($body)) {

                $data = json_decode($body);
                $resultado = $data;


            } else {


            }
        } catch (Exception $e) {

            die($e);

        }
        return $resultado;
    }

    public function update_data()
    {

        foreach ($_SESSION as $key => $value) {

            switch ($key) {
                case 'id':
                    $this->id = $value;
                    break;
                case 'token':
                    //$this->token = $value;
                    break;
                case 'username':
                    $this->username = $value;
                    break;
                case 'persona_id':
                    $this->persona_id = (int)$value;
                    break;
                case 'empresa_id':
                    $this->empresa_id = (int)$value;
                    break;
                case 'nombre':
                    $this->nombre = $value;
                    break;
                case 'primer_apellido':
                    $this->primer_apellido = $value;
                    break;
                case 'segundo_apellido':
                    $this->segundo_apellido = $value;
                    break;
                case 'correo_electronico':
                    $this->correo_electronico = $value;
                    break;
                case 'usuario_local':
                    $this->usuario_local = $value;
                    break;
                case 'roles':
                    $this->roles = $value;
                    break;
                case 'domicilios_empresa':
                    $this->domicilios_empresa = $value;
                    break;
                case 'domicilios_persona':
                    $this->domicilios_persona = $value;
                    break;
                case 'empresa':
                    $this->empresa = $value;
                    break;
                case 'empleado':
                    $this->empleado = $value;
                    break;
                case 'puesto':
                    $this->puesto = $value;
                    break;
                case 'area_administrativa':
                    $this->area_administrativa = $value;
                    break;
                case 'direccion_general':
                    $this->direccion_general = $value;
                    break;
            }

        }
    }

    public function update_session_data($data = null)
    {

        if (is_null($data)) {
            return null;
        }

        if (!isset($data)) {
            return null;
        }

        foreach ($data as $key => $value) {

            switch ($key) {
                case 'id':
                    $_SESSION['id'] = $value;
                    break;

                case 'token':
                    //$_SESSION['token'] = $value;
                    break;

                case 'username':

                    $_SESSION['username'] = $value;

                    break;

                case 'persona':

                    if (!is_null($value)) {
                        $_SESSION['persona_id'] = $value->id;
                        $_SESSION['nombre'] = $value->nombre;
                        $_SESSION['primer_apellido'] = $value->primer_apellido;
                        $_SESSION['segundo_apellido'] = $value->segundo_apellido;
                        $_SESSION['correo_electronico'] = $value->correo_electronico;

                    }

                    break;

                case 'empresa':

                    if (!is_null($value)) {

                        //die(json_encode($value));

                        $_SESSION['empresa_id'] = $value->id;
                        $_SESSION['nombre'] = $value->razon_social;
                        $_SESSION['empresa'] = $value->razon_social;
                    }

                    break;

                case 'usuario_local':
                    $_SESSION['usuario_local'] = $value;

                    break;

                case 'roles':

                    if (!is_null($value)) {

                        $roles = array();
                        foreach ($value as $rol) {
                            array_push($roles, $rol->ps_id);
                        }
                        $_SESSION['roles'] = $roles;

                    }
                    break;

                case 'domicilio_empresa':

                    if (!is_null($value)) {

                        $rows_domicilios_empresa = array();
                        foreach ($value as $row) {
                            array_push($rows_domicilios_empresa, $row);
                        }
                        $this->ci->session->domicilios_empresa = $rows_domicilios_empresa;
                    }
                    break;

                case 'domicilio_persona':

                    if (!is_null($value)) {

                        //die(json_encode($value));

                        $rows_domicilios_persona = array();
                        foreach ($value as $row) {
                            array_push($rows_domicilios_persona, $row);
                        }
                        $_SESSION['domicilios_persona'] = $rows_domicilios_persona;
                    }
                    break;

                case 'empleado':

                    //die(json_encode($value));

                    if (!is_null($value)) {

                        $empleado = new stdClass();
                        $empleado->id = $value->id;
                        $empleado->numero_empleado = $value->numero_empleado;
                        $_SESSION['empleado'] = $empleado;
                    }
                    break;
                case 'puesto':

                    if (!is_null($value)) {
                        $puesto = new stdClass();
                        $puesto->id = $value->id;
                        $puesto->clave = $value->clave;
                        $puesto->nombre = $value->nombre;

                        $_SESSION['puesto'] = $puesto;
                    }
                    break;

                case 'area_administrativa':

                    if (!is_null($value)) {
                        $area_administrativa = new stdClass();
                        $area_administrativa->id = $value->id;
                        $area_administrativa->clave = $value->clave;
                        $area_administrativa->nombre = $value->nombre;
                        $_SESSION['area_administrativa'] = $area_administrativa;

                    }
                    break;
                case 'direccion_general':

                    if (!is_null($value)) {
                        $direccion_general = new stdClass();
                        $direccion_general->id = $value->id;
                        $direccion_general->nombre = $value->nombre;
                        //$this->ci->session->direccion_general = $direccion_general;

                        $_SESSION['direccion_general'] = $direccion_general;
                    }
                    break;
            }

        }

    }

    public function insertar_persona()
    {

        try {
            $url = $this->ci->config->item('url_webservice') . "api/Persona/";

            if (isset($_POST["token"])) {
                $this->token = $_POST["token"];
            }

            $_POST["action"] = "insert";

            $campos = http_build_query($_POST);


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $campos);

            // Recibir respuesta
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $respuestaServidor = curl_exec($ch);
            curl_close($ch);


            $data_respuesta = $respuestaServidor;

            if (!is_null($data_respuesta)) {
                $this->ci->session->personaId = $data_respuesta['inserted_id'];
            }

            $respuestaServidor = json_decode($respuestaServidor);

            if ($respuestaServidor->success) {
                return true;
            } else {

                $this->error = $respuestaServidor->mensaje;
                if (isset($respuestaServidor->code)) {
                    $this->errorCode = $respuestaServidor->code;
                }
                return false;
            }

        } catch (Exception $e) {
            return false;
        }
    }

    public function get_usuarios_sistema($usuario_id = null)
    {

        $cookie = null;

        if (count($_COOKIE) == 0) {

        } else {

            if (!isset($_COOKIE[$this->cookie_token])) {

            } else {
                $cookie = $_COOKIE[$this->cookie_token];
            }
        }

        if (count($_SESSION) == 0) {

        } else {

            if (!isset($_SESSION[$this->cookie_token])) {

            } else {
                $cookie = $_SESSION[$this->cookie_token];
            }
        }

        if (is_null($cookie)) {
            return null;
        }

        $this->token = $cookie;

        $datos = null;

        $client = new Client();
        $url = $this->ws_url . 'api/usuario/select_vw2';
        $params = array();
        $request = array();

        $params["sistema_id"] = $this->sistema_actual->id;

        if (!is_null($usuario_id)) {
            $params["id"] = $usuario_id;
        }

        $request['form_params'] = $params;

        try {

            $response = $client->request('POST', $url, $request);

            $code = $response->getStatusCode();
            $body = $response->getBody();
            $reason = $response->getReasonPhrase();
            $hasHeader = $response->hasHeader('Content-Length');
            $header = $response->getHeader('Content-Length');

            $datos = json_decode($body->getContents());

        } catch (Exception $e) {
            $mensaje_error = $e->getMessage();
        }

        return $datos;

    }

    public function get_persona($persona_id = null)
    {

        $cookie = null;

        if (count($_COOKIE) == 0) {
        } else {
            if (!isset($_COOKIE[$this->cookie_token])) {
            } else {
                $cookie = $_COOKIE[$this->cookie_token];
            }
        }

        if (count($_SESSION) == 0) {
        } else {
            if (!isset($_SESSION[$this->cookie_token])) {
            } else {
                $cookie = $_SESSION[$this->cookie_token];
            }
        }

        if (is_null($cookie)) {
            return null;
        }

        $this->token = $cookie;

        $datos = null;

        $client = new Client();
        $url = $this->ws_url . 'api/usuario/select_vw2';
        $params = array();
        $request = array();

        $params["sistema_id"] = $this->sistema_actual->id;

        if (!is_null($persona_id)) {
            $params["persona_id"] = $persona_id;
        }

        $request['form_params'] = $params;

        try {

            $response = $client->request('POST', $url, $request);

            $code = $response->getStatusCode();
            $body = $response->getBody();
            $reason = $response->getReasonPhrase();
            $hasHeader = $response->hasHeader('Content-Length');
            $header = $response->getHeader('Content-Length');

            $datos = json_decode($body->getContents());

        } catch (Exception $e) {
            $mensaje_error = $e->getMessage();
        }


        return $datos;

    }

    public function get_empresa($empresa_id = null)
    {

        $cookie = null;

        if (count($_COOKIE) == 0) {
        } else {
            if (!isset($_COOKIE[$this->cookie_token])) {
            } else {
                $cookie = $_COOKIE[$this->cookie_token];
            }
        }

        if (count($_SESSION) == 0) {
        } else {
            if (!isset($_SESSION[$this->cookie_token])) {
            } else {
                $cookie = $_SESSION[$this->cookie_token];
            }
        }

        if (is_null($cookie)) {
            return null;
        }

        $this->token = $cookie;

        $datos = null;

        $client = new Client();
        $url = $this->ws_url . 'api/usuario/select_vw2_empresa';
        $params = array();
        $request = array();

        $params["sistema_id"] = $this->sistema_actual->id;

        if (!is_null($empresa_id)) {
            $params["empresa_id"] = $empresa_id;
        }

        $request['form_params'] = $params;

        try {

            //die(json_encode($request));

            $response = $client->request('POST', $url, $request);

            $code = $response->getStatusCode();
            $body = $response->getBody();
            $reason = $response->getReasonPhrase();
            $hasHeader = $response->hasHeader('Content-Length');
            $header = $response->getHeader('Content-Length');

            $datos = json_decode($body->getContents());

        } catch (Exception $e) {
            $mensaje_error = $e->getMessage();
        }


        return $datos;

    }

    #endregion

    #region "Constructor"

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->library('session');

        $this->ws_url = URL_WEBSERVICE;
        $this->cookie_token = COOKIE_TOKEN;

        if ($this->is_signed())
        {
            $this->base_url = base_url();

            if ( ! is_null(BASE_URL_FAKE))
            {
                $this->base_url = BASE_URL_FAKE;
            }

            if ($this->crear_datos_default()) {

            }
            else
            {
                die("<p style='color:red;'>base_url() del sistema no configurada correctamente en BD del SUU.</p>");
            }
        }

    }

    #endregion
}

?>