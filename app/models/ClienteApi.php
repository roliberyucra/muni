<?php
// app/models/ClienteApi.php
class ClienteApi
{
    private $pdo;
    private $apiUrl;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        // Ajusta el puerto si usas otro (MAMP por defecto 8888)
        $this->apiUrl = "http://localhost:8888/muni/api.php";
    }

    // Enviar petición a la API interna y regresar respuesta decodificada
    public function solicitarApi($tipo, $token, $texto)
    {
        // Validaciones simples
        if (empty($tipo) || empty($token)) {
            return [
                'status' => false,
                'msg' => 'Debe indicar tipo y token.'
            ];
        }

        $postData = [
            'tipo'  => $tipo,
            'token' => $token,
            'data'  => $texto
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        // timeout corto para no colgar la UI
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $resp = curl_exec($ch);

        if ($resp === false) {
            $err = curl_error($ch);
            curl_close($ch);
            return [
                'status' => false,
                'msg' => "Error en la petición cURL: $err"
            ];
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = json_decode($resp, true);

        if ($httpCode >= 400 || $json === null) {
            return [
                'status' => false,
                'msg' => 'Respuesta no válida desde la API.',
                'raw' => $resp
            ];
        }

        return $json;
    }
}
