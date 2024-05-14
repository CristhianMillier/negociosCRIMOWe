<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Exception;

class RucController extends Controller
{
    public function consultarRuc($ruc)
    {
        $token = 'apis-token-7224.qa55ToBUPdjC2MtIECj8bMCF7i8vpbFa';

        $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Referer' => 'https://apis.net.pe/api-consulta-ruc',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'query' => ['numero' => $ruc]
        ];

        try {
            $response = $client->request('GET', '/v2/sunat/ruc', $parameters);
            $data = json_decode($response->getBody()->getContents(), true);

            $razonSocial = $data['razonSocial'];
            $direccion = $data['direccion'];

            return response()->json([
                'razonSocial' => $razonSocial,
                'direccion' => $direccion,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al consultar el RUC']);
        }
    }
}