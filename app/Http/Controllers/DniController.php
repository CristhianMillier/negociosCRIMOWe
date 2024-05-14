<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Exception;

class DniController extends Controller
{
    public function consultarDni($dni)
    {
        $token = 'apis-token-7224.qa55ToBUPdjC2MtIECj8bMCF7i8vpbFa';

        $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://apis.net.pe/api-consulta-dni',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'query' => ['numero' => $dni],
        ];

        try {
            $response = $client->request('GET', '/v2/reniec/dni', $parameters);
            $data = json_decode($response->getBody()->getContents(), true);
                   
            $nombre = $data['nombres'];
            $apellido_paterno = $data['apellidoPaterno'];
            $apellido_materno = $data['apellidoMaterno'];

            return response()->json([
                'nombre' => $nombre,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al consultar el DNI']);
        }
    }
}