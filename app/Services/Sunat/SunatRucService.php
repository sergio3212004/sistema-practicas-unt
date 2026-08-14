<?php

namespace App\Services\Sunat;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class SunatRucService
{
    public function lookup(string $ruc): RucCompanyData
    {
        $url = config('services.sunat.ruc_lookup_url');
        $token = config('services.sunat.ruc_api_token');

        if (! is_string($url) || $url === '' || ! is_string($token) || $token === '') {
            throw new SunatServiceUnavailableException('La consulta RUC no está configurada.');
        }

        try {
            $response = Http::acceptJson()
                ->withToken($token)
                ->connectTimeout((int) config('services.sunat.connect_timeout', 3))
                ->timeout((int) config('services.sunat.timeout', 8))
                ->retry(2, 200, throw: false)
                ->get($url, ['numero' => $ruc]);
        } catch (ConnectionException $exception) {
            throw new SunatServiceUnavailableException('No se pudo conectar con el proveedor de SUNAT.', previous: $exception);
        }

        if ($response->notFound() || $response->status() === 422) {
            throw new RucNotFoundException('SUNAT no encontró el RUC indicado.');
        }

        if (! $response->successful()) {
            throw new SunatServiceUnavailableException("El proveedor de SUNAT respondió con estado {$response->status()}.");
        }

        $payload = $response->json();

        if (! is_array($payload)) {
            throw new SunatServiceUnavailableException('El proveedor de SUNAT devolvió una respuesta inválida.');
        }

        return RucCompanyData::fromProvider($ruc, $payload);
    }
}
