<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Rules\Ruc;
use App\Services\Companies\CompanyRegistrationLookup;
use App\Services\Sunat\RucNotFoundException;
use App\Services\Sunat\SunatServiceUnavailableException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RucLookupController extends Controller
{
    public function __invoke(Request $request, CompanyRegistrationLookup $lookup): JsonResponse
    {
        $validated = $request->validate([
            'ruc' => ['bail', 'required', 'string', new Ruc],
        ]);

        try {
            $result = $lookup->lookup($validated['ruc']);
        } catch (RucNotFoundException) {
            return response()->json([
                'message' => 'No encontramos ese RUC en el padrón de SUNAT. Verifica el número ingresado.',
            ], 404);
        } catch (SunatServiceUnavailableException $exception) {
            Log::warning('No fue posible consultar el padrón RUC.', [
                'reason' => $exception->getMessage(),
            ]);

            $lookup->allowManualFallback($validated['ruc']);

            return response()->json([
                'message' => 'SUNAT no está disponible en este momento. Puedes completar los datos de la empresa manualmente o volver a intentarlo.',
                'allow_manual' => true,
            ], 503);
        }

        $missingFields = $result['missing_fields'];

        return response()->json([
            'status' => $missingFields === [] ? 'complete' : 'incomplete',
            'message' => $missingFields === []
                ? 'Datos de la empresa encontrados en SUNAT.'
                : 'SUNAT devolvió información incompleta. Completa únicamente los campos habilitados.',
            'data' => $result['data'],
            'readonly_fields' => $result['readonly_fields'],
            'missing_fields' => $missingFields,
        ]);
    }
}
