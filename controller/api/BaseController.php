<?php
class BaseController
{
    /**
     * __call magic method.
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput(404, '', [], 'Recurso no encontrado');
    }

    /**
     * Get URI elements.
     * 
     * @return array
     */
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);

        return $uri;
    }

    /**
     * Get querystring params.
     * 
     * @return array
     */
    protected function getQueryStringParams()
    {
        return parse_str($_SERVER['QUERY_STRING'], $query);
    }

    /**
     * Send API output.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function sendOutput($status = 0, $datos = [], $httpHeaders = [], $info = '')
    {
        header_remove('Set-Cookie');

        if ($status < 200) {
            $respuesta = 'HTTP/2.0 ' . $status . ' La solicitud ha sido recibida, permanece en proceso';
        } else if ($status >= 200 && $status < 300) {
            $respuesta = 'HTTP/2.0 ' . $status . ' La solicitud ha sido procesada exitosamente';
        } else if ($status >= 300 && $status < 400) {
            $respuesta = 'HTTP/2.0 ' . $status . ' La solicitud se redireccionará';
        } else if ($status >= 400 && $status < 500) {
            $respuesta = 'HTTP/2.0 ' . $status . ' La solicitud presenta un error';
        } else if ($status >= 500) {
            $respuesta = 'HTTP/2.0 ' . $status . ' La solicitud no pudo ser procesada con éxito, error del servidor';
        }

        array_push($httpHeaders, $respuesta, 'Content-Type: application/json');

        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }

        $objecto = (object)['respuesta' => $respuesta, 'estado' => $status, 'datos' => $datos, 'info' => $info];

        echo json_encode($objecto);
        exit;
    }
}